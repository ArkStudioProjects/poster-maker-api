<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Poster' => [ 'Business', 'Corporate', 'Interior', 'Real Estate', 'Education', 'Fashion', 'Sales and Offer', 'Charity', 'Medical and Health', 'Music', 'Food and Drinks', 'Charity', 'Fitness', 'Travel', 'Car Wash', 'Vintage', 'Abstract', 'Event', 'Fitness', 'NFT', 'Sports', 'Valentines' ],
            'Book Cover' => [ 'Creative', 'Corporate', 'Business', 'Travel', 'Fashion', 'Story', 'Design', 'Vintage' ],
            'Background' => [ 'Abstract', 'Pattern', 'Image', 'Solid Color', 'Gradient', 'Watercolor', 'Wall', 'Creative', 'Vintage', 'Smoke', 'Paper', 'Wood' ],
            'Images' => [ 'Nature', 'Creative', 'Weather', 'Snow', 'Vintage', 'Smoke' ],
            'Story' => [ 'Children', 'Carton', 'Stores' ],
        ];

        foreach ( $categories as $parent_category => $sub_categories ) {
            $category = Category::firstOrCreate([
                'name' => $parent_category,
                'parent_id' => null,
            ]);

            foreach ( $sub_categories as $sub_category_name ) {
                Category::firstOrCreate( [
                    'name' => $sub_category_name,
                    'parent_id' => $category->id
                ] );
            }
        }
    }
}
