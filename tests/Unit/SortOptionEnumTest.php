<?php

use App\Enums\SortOption;

uses()->group('enum', 'sort');

describe('SortOption enum values', function () {
    test('has correct enum values', function () {
        expect(SortOption::Importance->value)->toBe('importance')
            ->and(SortOption::Newest->value)->toBe('newest')
            ->and(SortOption::Oldest->value)->toBe('oldest');
    });

    test('provides all available values', function () {
        $values = SortOption::values();

        expect($values)->toBe(['importance', 'newest', 'oldest']);
    });

    test('provides options array with labels', function () {
        $options = SortOption::options();

        expect($options)->toHaveKey('importance')
            ->and($options)->toHaveKey('newest')
            ->and($options)->toHaveKey('oldest')
            ->and($options['importance'])->toBe('Most Important');
    });
});

describe('SortOption creation methods', function () {
    test('can be created from valid string', function () {
        $option = SortOption::fromString('importance');

        expect($option)->toBe(SortOption::Importance);
    });

    test('tryFromString returns correct option for valid value', function () {
        $option = SortOption::tryFromString('oldest');

        expect($option)->toBe(SortOption::Oldest);
    });

    test('tryFromString returns default for invalid value', function () {
        $option = SortOption::tryFromString('invalid', SortOption::Newest);

        expect($option)->toBe(SortOption::Newest);
    });
});

describe('SortOption labels and descriptions', function () {
    test('has human-readable labels', function () {
        expect(SortOption::Importance->label())->toBe('Most Important')
            ->and(SortOption::Newest->label())->toBe('Newest First')
            ->and(SortOption::Oldest->label())->toBe('Oldest First');
    });

    test('has descriptive text', function () {
        $description = SortOption::Importance->description();

        expect($description)->toBeString()
            ->and($description)->toContain('important');
    });
});
