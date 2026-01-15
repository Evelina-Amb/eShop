<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RandomTest extends TestCase
{
    use RefreshDatabase;

    public function homepage_loads_successfully()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function search_page_works()
    {
        $response = $this->get('/search');
        $response->assertStatus(200);
    }

    public function guest_cannot_access_cart()
    {
        $response = $this->get('/cart');
        $response->assertRedirect('/login');
    }

    public function authenticated_user_can_add_favorite()
    {
        $user = User::factory()->create();
        $category = \App\Models\Category::factory()->create();

        $listing = Listing::factory()->create([
            'category_id' => $category->id
            ]);

        $response = $this->actingAs($user)
            ->postJson('/api/favorite', [
                'listing_id' => $listing->id
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('favorite', [
            'user_id' => $user->id,
            'listing_id' => $listing->id
        ]);
    }

    public function xml_export_returns_xml()
    {
        $response = $this->get('/export/listings.xml');
        $response->assertStatus(200);
        $this->assertTrue(
            str_contains($response->headers->get('Content-Type'), 'application/xml')
        );

    }
}
