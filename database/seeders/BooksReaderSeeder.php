<?php

namespace Database\Seeders;

use App\Models\BooksReader;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BooksReaderSeeder extends Seeder
{
    public function run(): void
    {
        // Data untuk 6 bulan terakhir
        $books = [
            'Harry Potter and the Philosopher\'s Stone',
            'The Lord of the Rings',
            'To Kill a Mockingbird',
            'Pride and Prejudice',
            'The Great Gatsby',
            '1984',
            'The Hobbit',
            'The Catcher in the Rye',
            'Little Women',
            'Brave New World',
        ];

        $names = [
            'John Doe',
            'Jane Smith',
            'Michael Johnson',
            'Sarah Williams',
            'David Brown',
            'Emily Davis',
            'Robert Wilson',
            'Lisa Anderson',
            'James Taylor',
            'Maria Garcia',
        ];

        // Generate data untuk 6 bulan terakhir
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            // Generate 5-10 entries per month
            $entriesCount = rand(5, 10);

            for ($j = 0; $j < $entriesCount; $j++) {
                BooksReader::create([
                    'name' => $names[array_rand($names)],
                    'book' => $books[array_rand($books)],
                    'created_at' => $date->copy()->addDays(rand(1, 28)),
                    'updated_at' => $date->copy()->addDays(rand(1, 28)),
                ]);
            }
        }
    }
}
