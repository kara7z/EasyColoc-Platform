<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Colocation;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $defaultCategories = [
            ['name' => 'Loyer', 'color' => '#EF4444'],
            ['name' => 'Électricité', 'color' => '#F59E0B'],
            ['name' => 'Eau', 'color' => '#3B82F6'],
            ['name' => 'Internet', 'color' => '#8B5CF6'],
            ['name' => 'Courses', 'color' => '#10B981'],
            ['name' => 'Ménage', 'color' => '#6366F1'],
            ['name' => 'Autre', 'color' => '#6B7280'],
        ];

        $colocations = Colocation::all();

        foreach ($colocations as $colocation) {
            foreach ($defaultCategories as $category) {
                Category::firstOrCreate(
                    [
                        'colocation_id' => $colocation->id,
                        'name' => $category['name'],
                    ],
                    [
                        'color' => $category['color'],
                    ]
                );
            }
        }
    }
}
