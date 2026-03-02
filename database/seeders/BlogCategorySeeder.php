<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Economic Policy',
                'slug'        => 'economic-policy',
                'description' => 'Fiscal federalism, public finance, employment, and inclusive growth frameworks.',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Constitutional Governance',
                'slug'        => 'constitutional-governance',
                'description' => 'Federal structure, separation of powers, and the evolving architecture of India\'s democracy.',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Digital Governance',
                'slug'        => 'digital-governance',
                'description' => 'DPI, data regulation, AI governance, and technology\'s role in public administration.',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Foreign Affairs',
                'slug'        => 'foreign-affairs',
                'description' => 'India\'s strategic posture, multilateral institutions, and neighbourhood diplomacy.',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Civic Participation',
                'slug'        => 'civic-participation',
                'description' => 'Electoral reforms, decentralisation, and strengthening local self-governance.',
                'sort_order'  => 5,
            ],
        ];

        foreach ($categories as $category) {
            BlogCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
