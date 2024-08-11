<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categories = Category::orderBy('order', 'desc')
            ->orderBy('order', 'desc')
            ->get();

        $categories->each(function ($category, $key) {
            $category->order = $key + 1;

            $category->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->up();
    }
};
