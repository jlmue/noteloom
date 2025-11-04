<?php

use App\Enums\SortOption;
use App\Models\Note;
use App\Models\User;
use App\Services\NoteSearchService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)->group('service', 'search', 'sort');

describe('NoteSearchService sort option acceptance', function () {
    test('accepts SortOption enum', function () {
        $user = User::factory()
            ->create();

        Note::factory()
            ->count(3)
            ->create(['user_id' => $user->id]);

        $service = new NoteSearchService;
        $service->forUser($user)->sort(SortOption::Importance);

        expect($service->getSortOption())
            ->toBe(SortOption::Importance)
            ->and($service->getSortBy())
            ->toBe('importance');
    });

    test('accepts string sort option', function () {
        $user = User::factory()->create();

        Note::factory()
            ->count(3)
            ->create(['user_id' => $user->id]);

        $service = new NoteSearchService;

        $service->forUser($user)
            ->sort('newest');

        expect($service->getSortOption())
            ->toBe(SortOption::Newest)
            ->and($service->getSortBy())
            ->toBe('newest');
    });

    test('throws exception for invalid string sort option', function () {
        $user = User::factory()->create();

        $service = new NoteSearchService;

        expect(fn () => $service->forUser($user)
            ->sort('invalid'))
            ->toThrow(ValueError::class);
    });
});

describe('NoteSearchService sorting functionality', function () {
    test('sorts by importance correctly', function () {
        $user = User::factory()->create();

        Note::factory()
            ->create([
                'user_id' => $user->id,
                'title' => 'Regular Note',
                'is_important' => false,
            ]);

        Note::factory()
            ->create([
                'user_id' => $user->id,
                'title' => 'Important Note',
                'is_important' => true,
            ]);

        $service = new NoteSearchService;
        $notes = $service->forUser($user)
            ->sort(SortOption::Importance)
            ->get();

        expect($notes->first()->title)
            ->toBe('Important Note')
            ->and($notes->first()->is_important)
            ->toBeTrue()
            ->and($notes->last()->title)
            ->toBe('Regular Note')
            ->and($notes->last()->is_important)
            ->toBeFalse();
    });
});

describe('NoteSearchService statistics', function () {
    test('returns statistics with correct sort value', function () {
        $user = User::factory()
            ->create();

        Note::factory()
            ->count(5)
            ->create(['user_id' => $user->id]);

        $service = new NoteSearchService;

        $service->forUser($user)
            ->sort(SortOption::Newest);

        $stats = $service->getStatistics();

        expect($stats)->toHaveKey('sortBy')
            ->and($stats['sortBy'])
            ->toBe('newest');
    });
});
