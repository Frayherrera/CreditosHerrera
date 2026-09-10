<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $category = Category::create(['name' => 'Test']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Product',
            'slug' => 'product',
            'sku' => 'SKU-1',
            'price' => 100,
            'monthly_payment' => 10,
            'stock' => 5,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}