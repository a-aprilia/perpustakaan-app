<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 penulis, masing-masing 10 buku
        Author::factory()->count(5)->hasBooks(10)->create();

        // 8 kategori
        $categories = Category::factory()->count(8)->create();

        // Kategori acak (1-3) untuk setiap buku
        Book::all()->each(function ($book) use ($categories) {
            $book->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        // Data untuk menguji fitur "stok menipis" (stok < 5)
        Book::inRandomOrder()->take(3)->update(['stock' => 0]);
        Book::where('stock', '>', 0)->inRandomOrder()->take(2)->update(['stock' => 3]);
    }
}