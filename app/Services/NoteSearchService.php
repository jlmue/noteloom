<?php

namespace App\Services;

use App\Enums\SortOption;
use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service for building and executing Note queries.
 *
 * Provides a fluent interface for filtering, searching, and sorting notes.
 *
 * Example:
 * ```php
 * $notes = (new NoteSearchService())
 *     ->forUser($user)
 *     ->search('meeting')
 *     ->sort(SortOption::Importance)
 *     ->paginate(10);
 * ```
 */
class NoteSearchService
{
    /** Query builder instance */
    private Builder $query;

    /** User whose notes are being queried */
    private ?User $user = null;

    /** Current search text */
    private string $searchText = '';

    /** Current sort option */
    private SortOption $sortBy = SortOption::Importance;

    /** Whether sorting has been applied */
    private bool $sortingApplied = false;

    public function __construct()
    {
        $this->query = Note::query();
    }

    /**
     * Filter notes for a specific user
     */
    public function forUser(User $user): self
    {
        $this->user = $user;
        $this->query->where('user_id', $user->id);

        return $this;
    }

    /**
     * Search notes by title or content (case-insensitive)
     */
    public function search(string $searchText): self
    {
        $this->searchText = trim($searchText);

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
     * Sort notes (accepts SortOption enum or string)
     *
     * @throws \ValueError If string doesn't match a valid SortOption
     */
    public function sort(SortOption|string $sortBy): self
    {
        $sortOption = $sortBy instanceof SortOption
            ? $sortBy
            : SortOption::fromString($sortBy);

        $this->sortBy = $sortOption;
        $this->sortingApplied = true;

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
     */
    public function onlyImportant(): self
    {
        $this->query->where('is_important', true);

        return $this;
    }

    /**
     * Get the underlying query builder
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }

    /**
     * Execute query and return paginated results
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->query->paginate($perPage);
    }

    /**
     * Execute query and return all matching notes
     */
    public function get(): Collection
    {
        return $this->query->get();
    }

    /**
     * Get count of notes matching current filters
     */
    public function count(): int
    {
        return $this->query->count();
    }

    /**
     * Get count of important notes matching current filters
     */
    public function countImportant(): int
    {
        $query = Note::query()
            ->where('user_id', $this->user->id);

        if ($this->searchText !== '') {
            $searchTerm = '%'.$this->searchText.'%';
            $query->where(function (Builder $q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        return $query->where('is_important', true)->count();
    }

    /**
     * Get total note count for user (ignores search filter)
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
     * Check if search filter is active
     */
    public function hasSearchFilter(): bool
    {
        return $this->searchText !== '';
    }

    /**
     * Get current search text
     */
    public function getSearchText(): string
    {
        return $this->searchText;
    }

    /**
     * Get current sort option as enum
     */
    public function getSortOption(): SortOption
    {
        return $this->sortBy;
    }

    /**
     * Get current sort option as string
     */
    public function getSortBy(): string
    {
        return $this->sortBy->value;
    }

    /**
     * Get statistics about the notes
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
     * Get first note matching current filters
     */
    public function first(): ?Note
    {
        return $this->query->first();
    }
}
