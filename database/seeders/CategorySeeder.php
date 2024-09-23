<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //save(), create(), createMany(), insert()

        $category = new Category;

        $categories = [
            [
                'name' => 'Theatre',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Wellness',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'name' => 'Business',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $category->insert($categories);
    }
}
