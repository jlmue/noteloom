<?php

namespace App\Enums;

/**
 * Sort options for notes
 *
 * Example: $service->sort(SortOption::Importance)
 */
enum SortOption: string
{
    /** Sort by importance, then updated_at desc */
    case Importance = 'importance';

    /** Sort by created_at desc */
    case Newest = 'newest';

    /** Sort by created_at asc */
    case Oldest = 'oldest';

    /**
     * Get human-readable label
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
     * Get description text
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
     * Create from string value
     *
     * @throws \ValueError If value is invalid
     */
    public static function fromString(string $value): self
    {
        return self::from($value);
    }

    /**
     * Try to create from string, return default if invalid
     */
    public static function tryFromString(string $value, self $default = self::Importance): self
    {
        return self::tryFrom($value) ?? $default;
    }

    /**
     * Get all options as value => label array
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
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
