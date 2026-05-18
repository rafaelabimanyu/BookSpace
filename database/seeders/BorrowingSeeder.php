<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run(): void
    {
        $borrower = User::where('email', 'peminjam@bookspace.test')->first();
        if (!$borrower) {
            return;
        }

        $books = Book::all();
        if ($books->isEmpty()) {
            return;
        }

        // We will seed 6 borrowings: 4 historic (returned), 2 active (borrowed)
        $borrowings = [
            [
                'user_id' => $borrower->id,
                'book_id' => $books->skip(0)->first()->id, // Laskar Pelangi
                'borrow_date' => date('Y-m-d', strtotime('-20 days')),
                'return_date' => date('Y-m-d', strtotime('-13 days')),
                'status' => 'returned',
            ],
            [
                'user_id' => $borrower->id,
                'book_id' => $books->skip(1)->first()->id, // Bumi Manusia
                'borrow_date' => date('Y-m-d', strtotime('-15 days')),
                'return_date' => date('Y-m-d', strtotime('-8 days')),
                'status' => 'returned',
            ],
            [
                'user_id' => $borrower->id,
                'book_id' => $books->skip(4)->first()->id, // Sapiens
                'borrow_date' => date('Y-m-d', strtotime('-10 days')),
                'return_date' => date('Y-m-d', strtotime('-3 days')),
                'status' => 'returned',
            ],
            [
                'user_id' => $borrower->id,
                'book_id' => $books->skip(5)->first()->id, // Filosofi Teras
                'borrow_date' => date('Y-m-d', strtotime('-5 days')),
                'return_date' => date('Y-m-d', strtotime('+2 days')),
                'status' => 'borrowed', // Active
            ],
            [
                'user_id' => $borrower->id,
                'book_id' => $books->skip(9)->first()->id, // Cosmos
                'borrow_date' => date('Y-m-d', strtotime('-3 days')),
                'return_date' => date('Y-m-d', strtotime('+4 days')),
                'status' => 'borrowed', // Active
            ],
            [
                'user_id' => $borrower->id,
                'book_id' => $books->skip(12)->first()->id, // Hujan Bulan Juni
                'borrow_date' => date('Y-m-d', strtotime('-30 days')),
                'return_date' => date('Y-m-d', strtotime('-23 days')),
                'status' => 'returned',
            ],
        ];

        foreach ($borrowings as $borrowing) {
            Borrowing::create($borrowing);
        }
    }
}
