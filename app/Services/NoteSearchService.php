<?php

namespace App\Services;

use App\Enums\SortOption;
use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * NoteSearchService
 *
 * Service class responsible for building and executing queries for Note models.
 * Provides a fluent interface for filtering, searching, and sorting notes.
 *
 * Usage Example:
 * ```php
 * use App\Enums\SortOption;
 *
 * $service = new NoteSearchService();
 * $notes = $service
 *     ->forUser($user)
 *     ->search('meeting')
 *     ->sort(SortOption::Importance)  // Type-safe enum
 *     ->paginate(10);
 *
 * // Also accepts strings for backward compatibility
 * $service->sort('importance');  // Works too
 * ```
 *
 * Design Philosophy:
 * - Fluent interface: Chainable methods for readability
 * - Lazy execution: Queries executed only when needed
 * - Type safety: Strict types throughout (enums for sort options)
 * - Single Responsibility: Only handles query building
 * - Stateful: Methods modify and return $this for chaining
 *
 * @author Laravel Developer with 100 years of experience
 */
class NoteSearchService
{
    /**
     * The query builder instance
     */
    private Builder $query;

    /**
     * The user whose notes are being queried
     */
    private ?User $user = null;

    /**
     * Current search text filter
     */
    private string $searchText = '';

    /**
     * Current sort option
     */
    private SortOption $sortBy = SortOption::Importance;

    /**
     * Tracks if sorting has been applied to prevent duplicate sorting
     */
    private bool $sortingApplied = false;

    /**
     * Initialize the service with a fresh Note query
     */
    public function __construct()
    {
        $this->query = Note::query();
    }

    /**
     * Filter notes for a specific user
     *
     * This is typically the first method called in the chain to ensure
     * users only see their own notes (security boundary).
     *
     * @param  User  $user  The user whose notes to retrieve
     * @return self Returns $this for method chaining
     */
    public function forUser(User $user): self
    {
        $this->user = $user;
        $this->query->where('user_id', $user->id);

        return $this;
    }

    /**
     * Apply search filter to notes by title or content
     *
     * Searches are case-insensitive and use SQL LIKE with wildcards.
     * Empty search strings are ignored (no filter applied).
     *
     * Performance Note: Database-level filtering is used for better
     * performance with large datasets vs. collection filtering.
     *
     * @param  string  $searchText  The search term to filter by
     * @return self Returns $this for method chaining
     */
    public function search(string $searchText): self
    {
        $this->searchText = trim($searchText);

        // Only apply filter if search text is not empty
        if ($this->searchText !== '') {
            $searchTerm = '%'.$this->searchText.'%';

            $this->query->where(function (Builder $q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        return $this;
    }

    /**
     * Apply sorting to the notes query
     *
     * Accepts either a SortOption enum or string value for backward compatibility.
     * Strings are automatically converted to SortOption enum cases.
     *
     * Supported sort options:
     * - SortOption::Importance or 'importance': Important notes first, then by recently updated
     * - SortOption::Newest or 'newest': Most recently created notes first
     * - SortOption::Oldest or 'oldest': Oldest created notes first
     *
     * @param  SortOption|string  $sortBy  The sort option (enum or string)
     * @return self Returns $this for method chaining
     *
     * @throws \ValueError If string value doesn't match any valid SortOption
     */
    public function sort(SortOption|string $sortBy): self
    {
        // Convert string to enum if needed
        $sortOption = $sortBy instanceof SortOption
            ? $sortBy
            : SortOption::fromString($sortBy);

        $this->sortBy = $sortOption;
        $this->sortingApplied = true;

        // Apply the appropriate sorting strategy
        match ($sortOption) {
            SortOption::Newest => $this->query->orderBy('created_at', 'desc'),
            SortOption::Oldest => $this->query->orderBy('created_at'),
            SortOption::Importance => $this->query
                ->orderBy('is_important', 'desc')
                ->orderBy('updated_at', 'desc'),
        };

        return $this;
    }

    /**
     * Filter to only important notes
     *
     * @return self Returns $this for method chaining
     */
    public function onlyImportant(): self
    {
        $this->query->where('is_important', true);

        return $this;
    }

    /**
     * Get the underlying query builder
     *
     * Useful when you need direct access to the query for custom operations
     * or to pass it to other services/methods that expect a Builder.
     *
     * Note: This returns the actual query builder, so any modifications
     * will affect subsequent operations on this service instance.
     *
     * @return Builder The query builder instance
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }

    /**
     * Execute the query and return paginated results
     *
     * @param  int  $perPage  Number of items per page (default: 15)
     * @return LengthAwarePaginator Paginated results
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->query->paginate($perPage);
    }

    /**
     * Execute the query and return all matching notes
     *
     * Warning: Use with caution on large datasets. Consider pagination instead.
     *
     * @return Collection<int, Note> Collection of notes
     */
    public function get(): Collection
    {
        return $this->query->get();
    }

    /**
     * Get the total count of notes matching current filters
     *
     * @return int Total number of notes
     */
    public function count(): int
    {
        return $this->query->count();
    }

    /**
     * Get the count of important notes matching current filters
     *
     * Creates a separate query to count only important notes.
     *
     * @return int Number of important notes
     */
    public function countImportant(): int
    {
        // Build a separate query with the same filters but add is_important
        $query = Note::query()
            ->where('user_id', $this->user->id);

        // Reapply search filter if present
        if ($this->searchText !== '') {
            $searchTerm = '%'.$this->searchText.'%';
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        return $query->where('is_important', true)
            ->count();
    }

    /**
     * Get the count of notes without any search filter applied
     *
     * Useful for displaying "X of Y notes" when search is active.
     * Returns the total count for the user, ignoring search filters.
     *
     * @return int Total number of notes for the user
     */
    public function countWithoutSearch(): int
    {
        if (! $this->user) {
            return 0;
        }

        return Note::query()
            ->where('user_id', $this->user->id)
            ->count();
    }

    /**
     * Check if a search filter is currently active
     *
     * @return bool True if search text is not empty
     */
    public function hasSearchFilter(): bool
    {
        return $this->searchText !== '';
    }

    /**
     * Get the current search text
     *
     * @return string The current search filter
     */
    public function getSearchText(): string
    {
        return $this->searchText;
    }

    /**
     * Get the current sort option as SortOption enum
     *
     * @return SortOption The current sort option enum
     */
    public function getSortOption(): SortOption
    {
        return $this->sortBy;
    }

    /**
     * Get the current sort option as string value
     *
     * @return string The current sort option value (for backward compatibility)
     */
    public function getSortBy(): string
    {
        return $this->sortBy->value;
    }

    /**
     * Get statistics about the notes
     *
     * Returns an array with useful statistics:
     * - total: Total notes for the user (no filters)
     * - filtered: Notes matching current filters
     * - important: Important notes matching current filters
     * - hasSearch: Whether search filter is active
     * - searchText: Current search term
     * - sortBy: Current sort option (string value)
     *
     * @return array<string, mixed> Statistics array
     */
    public function getStatistics(): array
    {
        return [
            'total' => $this->countWithoutSearch(),
            'filtered' => $this->count(),
            'important' => $this->countImportant(),
            'hasSearch' => $this->hasSearchFilter(),
            'searchText' => $this->searchText,
            'sortBy' => $this->sortBy->value,
        ];
    }

    /**
     * Get the first note matching the current filters
     *
     * @return Note|null The first note or null if none found
     */
    public function first(): ?Note
    {
        return $this->query->first();
    }
}
