<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     * Generates unique realistic notes using Faker.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titlePrefixes = [
            'Meeting Notes',
            'Project Update',
            'Client Call',
            'Team Discussion',
            'Weekly Review',
            'Planning Session',
            'Brainstorming',
            'Feature Request',
            'Bug Report',
            'Code Review',
            'Design Review',
            'Sprint Planning',
            'Retrospective',
            'One-on-One',
            'Task List',
            'Grocery List',
            'Shopping List',
            'Book Notes',
            'Recipe',
            'Travel Plans',
            'Workout Plan',
            'Health Goals',
            'Learning Notes',
            'Research',
            'Ideas',
            'Reminder',
            'To-Do',
            'Quick Note',
            'Important',
            'Follow-up',
        ];

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement($titlePrefixes) . ' - ' . fake()->unique()->words(rand(1, 3), true),
            'content' => fake()->paragraph(rand(3, 6)),
            'is_important' => fake()->boolean(30), // 30% chance of being important
            'created_at' => fake()->dateTimeBetween('-3 months'),
            'updated_at' => fake()->dateTimeBetween('-1 month'),
        ];
    }

    /**
     * Mark note as important
     */
    public function important(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_important' => true,
        ]);
    }

    /**
     * Mark note as not important
     */
    public function notImportant(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_important' => false,
        ]);
    }
}
