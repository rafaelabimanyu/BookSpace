<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $fiksi = Category::where('name', 'Fiksi')->first()->id;
        $nonFiksi = Category::where('name', 'Non-Fiksi')->first()->id;
        $sains = Category::where('name', 'Sains & Teknologi')->first()->id;
        $sastra = Category::where('name', 'Sastra & Seni')->first()->id;

        $books = [
            // Fiksi
            [
                'title' => 'Laskar Pelangi',
                'writer' => 'Andrea Hirata',
                'publisher' => 'Bentang Pustaka',
                'year' => 2005,
                'ISBN' => '979-3062-79-7',
                'stock' => 5,
                'category_id' => $fiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Bumi Manusia',
                'writer' => 'Pramoedya Ananta Toer',
                'publisher' => 'Hasta Mitra',
                'year' => 1980,
                'ISBN' => '979-8659-12-0',
                'stock' => 3,
                'category_id' => $fiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Pulang',
                'writer' => 'Leila S. Chudori',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'year' => 2012,
                'ISBN' => '978-979-91-0515-8',
                'stock' => 0, // Test out-of-stock
                'category_id' => $fiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Cantik Itu Luka',
                'writer' => 'Eka Kurniawan',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2002,
                'ISBN' => '978-602-03-1258-3',
                'stock' => 4,
                'category_id' => $fiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=400&q=80'
            ],

            // Non-Fiksi
            [
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'writer' => 'Yuval Noah Harari',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'year' => 2011,
                'ISBN' => '978-602-424-348-7',
                'stock' => 6,
                'category_id' => $nonFiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1495640388908-05fa85288e61?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Filosofi Teras',
                'writer' => 'Henry Manampiring',
                'publisher' => 'Buku Kompas',
                'year' => 2018,
                'ISBN' => '978-602-412-518-9',
                'stock' => 8,
                'category_id' => $nonFiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Sebuah Seni untuk Bersikap Bodo Amat',
                'writer' => 'Mark Manson',
                'publisher' => 'Grasindo',
                'year' => 2016,
                'ISBN' => '978-602-051-249-5',
                'stock' => 2,
                'category_id' => $nonFiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Atomic Habits',
                'writer' => 'James Clear',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2018,
                'ISBN' => '978-602-06-3317-6',
                'stock' => 0, // Test out of stock
                'category_id' => $nonFiksi,
                'cover_image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&w=400&q=80'
            ],

            // Sains & Teknologi
            [
                'title' => 'A Brief History of Time',
                'writer' => 'Stephen Hawking',
                'publisher' => 'Bantam Books',
                'year' => 1988,
                'ISBN' => '978-0553380163',
                'stock' => 3,
                'category_id' => $sains,
                'cover_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Cosmos',
                'writer' => 'Carl Sagan',
                'publisher' => 'Random House',
                'year' => 1980,
                'ISBN' => '978-0345331359',
                'stock' => 4,
                'category_id' => $sains,
                'cover_image' => 'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'The Selfish Gene',
                'writer' => 'Richard Dawkins',
                'publisher' => 'Oxford University Press',
                'year' => 1976,
                'ISBN' => '978-0198788607',
                'stock' => 2,
                'category_id' => $sains,
                'cover_image' => 'https://images.unsplash.com/photo-1532187643603-ba119ca4109e?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'AI Superpowers',
                'writer' => 'Kai-Fu Lee',
                'publisher' => 'Houghton Mifflin Harcourt',
                'year' => 2018,
                'ISBN' => '978-1328546395',
                'stock' => 5,
                'category_id' => $sains,
                'cover_image' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?auto=format&fit=crop&w=400&q=80'
            ],

            // Sastra & Seni
            [
                'title' => 'Hujan Bulan Juni',
                'writer' => 'Sapardi Djoko Damono',
                'publisher' => 'Grasindo',
                'year' => 1994,
                'ISBN' => '978-602-03-1843-1',
                'stock' => 7,
                'category_id' => $sastra,
                'cover_image' => 'https://images.unsplash.com/photo-1474932430478-367dbb6832c1?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Aku: Berdasarkan Perjalanan Hidup Chairil Anwar',
                'writer' => 'Sjuman Djaya',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 1987,
                'ISBN' => '978-979-22-2432-0',
                'stock' => 3,
                'category_id' => $sastra,
                'cover_image' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'The Story of Art',
                'writer' => 'E.H. Gombrich',
                'publisher' => 'Phaidon Press',
                'year' => 1950,
                'ISBN' => '978-0714832470',
                'stock' => 1,
                'category_id' => $sastra,
                'cover_image' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=400&q=80'
            ],
            [
                'title' => 'Understanding Comics',
                'writer' => 'Scott McCloud',
                'publisher' => 'HarperPerennial',
                'year' => 1993,
                'ISBN' => '978-0060976255',
                'stock' => 2,
                'category_id' => $sastra,
                'cover_image' => 'https://images.unsplash.com/photo-1588580000645-4562a6d2c839?auto=format&fit=crop&w=400&q=80'
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
