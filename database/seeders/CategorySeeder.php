<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\ServiceSubCategory;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        if (Category::count() == 0) {
            $categoriesWithServices = [
                'Hair Care' => ['Haircut', 'Hair Coloring', 'Hair Styling'],
                'Skin Care' => ['Facial', 'Microdermabrasion', 'Chemical Peel'],
                'Nail Care' => ['Manicure', 'Pedicure', 'Gel Polish'],
                'Makeup' => ['Bridal Makeup', 'Party Makeup', 'Airbrush Makeup'],
            ];

            foreach ($categoriesWithServices as $categoryName => $services) {
                $category = Category::create([
                    'name' => $categoryName,
                    'slug' => Str::slug($categoryName),
                    'description' => 'This is the Category description for ' . $categoryName,
                    'status' => 1,
                ]);

                foreach ($services as $service) {
                    $category->services()->create([
                        'name' => $service,
                        'slug' => Str::slug($service),
                        'description' => 'This is the Service description for ' . $service,
                        'price' => rand(30, 100),
                        'status' => 1,
                    ]);
                }
            }
        }
    }
}
