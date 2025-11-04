<?php

namespace App\Enums;

/**
 * SortOption Enum
 *
 * Defines valid sort options for notes with their string values.
 * Using a backed enum provides type safety while maintaining
 * compatibility with URL parameters and form inputs.
 *
 * Usage Example:
 * ```php
 * $service->sort(SortOption::Importance);
 * $service->sort(SortOption::fromString('newest'));
 * ```
 *
 * Benefits:
 * - Type safety: Can't pass invalid sort options
 * - IDE autocomplete: All options visible in IDE
 * - Refactoring safe: Renaming handled by IDE
 * - Self-documenting: Clear enum cases
 */
enum SortOption: string
{
    /**
     * Sort by importance (important notes first), then by updated_at descending
     */
    case Importance = 'importance';

    /**
     * Sort by created_at descending (newest notes first)
     */
    case Newest = 'newest';

    /**
     * Sort by created_at ascending (oldest notes first)
     */
    case Oldest = 'oldest';

    /**
     * Get the human-readable label for this sort option
     *
     * @return string Human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::Importance => 'Most Important',
            self::Newest => 'Newest First',
            self::Oldest => 'Oldest First',
        };
    }

    /**
     * Get the description of what this sort option does
     *
     * @return string Description of the sorting behavior
     */
    public function description(): string
    {
        return match ($this) {
            self::Importance => 'Shows important notes first, then sorted by recently updated',
            self::Newest => 'Shows most recently created notes first',
            self::Oldest => 'Shows oldest notes first',
        };
    }

    /**
     * Create SortOption from string value (for URL parameters and form inputs)
     *
     * This method provides backward compatibility with string-based sort options
     * used in URL parameters (?sort=importance) and Livewire properties.
     *
     * @param  string  $value  The string value ('importance', 'newest', or 'oldest')
     * @return self The corresponding SortOption enum case
     *
     * @throws \ValueError If the string doesn't match any valid option
     */
    public static function fromString(string $value): self
    {
        return self::from($value);
    }

    /**
     * Try to create SortOption from string, returning default if invalid
     *
     * @param  string  $value  The string value to parse
     * @param  self  $default  Default option to return if value is invalid
     * @return self The corresponding SortOption or default
     */
    public static function tryFromString(string $value, self $default = self::Importance): self
    {
        return self::tryFrom($value) ?? $default;
    }

    /**
     * Get all available sort options as array
     *
     * Useful for generating select dropdowns or validation rules.
     *
     * @return array<string, string> Array of value => label pairs
     */
    public static function options(): array
    {
        return array_reduce(
            self::cases(),
            fn (array $carry, self $option) => $carry + [$option->value => $option->label()],
            []
        );
    }

    /**
     * Get all valid string values
     *
     * Useful for validation rules.
     *
     * @return array<int, string> Array of valid string values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
