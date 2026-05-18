<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BorrowerEcosystemTest extends TestCase
{
    use RefreshDatabase;

    private User $peminjam;
    private Book $book;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed basic category and book
        $this->category = Category::create(['name' => 'Fiction', 'slug' => 'fiction']);
        $this->book = Book::create([
            'title' => 'The Great Gatsby',
            'writer' => 'F. Scott Fitzgerald',
            'publisher' => 'Scribner',
            'year' => 1925,
            'ISBN' => '9780743273565',
            'stock' => 5,
            'category_id' => $this->category->id,
        ]);

        $this->peminjam = User::create([
            'name' => 'Borrower John',
            'email' => 'john@bookspace.com',
            'password' => bcrypt('password'),
            'role' => 'peminjam',
        ]);
    }

    public function test_borrower_can_view_book_details_and_reviews(): void
    {
        $response = $this->actingAs($this->peminjam)
            ->get(route('peminjam.books.show', $this->book->id));

        $response->assertStatus(200);
        $response->assertSee('The Great Gatsby');
        $response->assertSee('Fiction');
    }

    public function test_borrower_can_toggle_wishlist(): void
    {
        // Add to Wishlist
        $response = $this->actingAs($this->peminjam)
            ->post(route('peminjam.wishlist.toggle'), [
                'book_id' => $this->book->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertTrue($this->peminjam->wishlistedBooks->contains($this->book->id));

        // Remove from Wishlist
        $response = $this->actingAs($this->peminjam)
            ->post(route('peminjam.wishlist.toggle'), [
                'book_id' => $this->book->id,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->peminjam->refresh();
        $this->assertFalse($this->peminjam->wishlistedBooks->contains($this->book->id));
    }

    public function test_borrower_can_view_wishlist(): void
    {
        $this->peminjam->wishlistedBooks()->attach($this->book->id);

        $response = $this->actingAs($this->peminjam)
            ->get(route('peminjam.wishlist'));

        $response->assertStatus(200);
        $response->assertSee('The Great Gatsby');
    }

    public function test_borrower_can_update_profile_and_picture(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('john_avatar.jpg');

        $response = $this->actingAs($this->peminjam)
            ->post(route('peminjam.profile.update'), [
                'name' => 'John Doe Upgraded',
                'email' => 'john_new@bookspace.com',
                'profile_picture' => $file,
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->peminjam->refresh();
        $this->assertEquals('John Doe Upgraded', $this->peminjam->name);
        $this->assertEquals('john_new@bookspace.com', $this->peminjam->email);
        $this->assertNotNull($this->peminjam->profile_picture);
    }

    public function test_borrower_fines_ledger_displays_active_and_returned_fines(): void
    {
        // 1. Unpaid overdue fine (Active Borrowing past return deadline)
        $overdueBorrowing = Borrowing::create([
            'user_id' => $this->peminjam->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10)->format('Y-m-d'),
            'return_date' => now()->subDays(3)->format('Y-m-d'), // 3 days overdue
            'status' => 'borrowed',
        ]);

        $response = $this->actingAs($this->peminjam)
            ->get(route('peminjam.fines'));

        $response->assertStatus(200);
        $response->assertSee('The Great Gatsby');
        $response->assertSee('3 ' . __('Days')); // Should show 3 days late
        $response->assertSee('3.000'); // Should show calculated fine (3 days * 1,000 = 3,000)
    }

    public function test_borrower_can_simulate_paying_a_fine(): void
    {
        $borrowing = Borrowing::create([
            'user_id' => $this->peminjam->id,
            'book_id' => $this->book->id,
            'borrow_date' => now()->subDays(10)->format('Y-m-d'),
            'return_date' => now()->subDays(3)->format('Y-m-d'),
            'status' => 'borrowed',
            'fine_amount' => 3000.00,
            'fine_status' => 'unpaid',
        ]);

        $response = $this->actingAs($this->peminjam)
            ->post(route('peminjam.fines.pay', $borrowing->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $borrowing->refresh();
        $this->assertEquals('paid', $borrowing->fine_status);
        $this->assertEquals(3000.00, $borrowing->fine_amount);
    }
}
