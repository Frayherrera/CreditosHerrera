<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Distributor;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockMovementControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::create(['name' => 'Test Category']);
        $this->distributor = Distributor::create(['name' => 'Test Distributor']);
    }

    private function makeProduct(int $stock): Product
    {
        return Product::create([
            'category_id' => $this->category->id,
            'name' => 'Product '.uniqid(),
            'slug' => 'product-'.uniqid(),
            'sku' => 'SKU-'.uniqid(),
            'price' => 100,
            'monthly_payment' => 10,
            'stock' => $stock,
        ]);
    }

    public function test_create_form_renders(): void
    {
        $this->actingAs($this->user)
            ->get(route('inventario.movimientos.create'))
            ->assertOk();
    }

    public function test_edit_form_renders(): void
    {
        $product = $this->makeProduct(10);
        $movement = StockMovement::create([
            'product_id' => $product->id,
            'type' => 'entry',
            'date' => now(),
            'quantity' => 5,
            'previous_stock' => 10,
            'new_stock' => 15,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('inventario.movimientos.edit', $movement))
            ->assertOk();
    }

    public function test_update_recalculates_product_stock(): void
    {
        $product = $this->makeProduct(10);
        $movement = StockMovement::create([
            'product_id' => $product->id,
            'type' => 'entry',
            'date' => now(),
            'quantity' => 5,
            'previous_stock' => 10,
            'new_stock' => 15,
            'user_id' => $this->user->id,
        ]);

        $product->update(['stock' => 15]);

        $this->actingAs($this->user)
            ->put(route('inventario.movimientos.update', $movement), [
                'product_id' => $product->id,
                'type' => 'exit',
                'date' => now()->format('Y-m-d'),
                'quantity' => 2,
                'distributor_id' => $this->distributor->id,
            ])
            ->assertRedirect(route('inventario.movimientos.index'));

        $this->assertSame(8, $product->fresh()->stock);
        $this->assertDatabaseHas('stock_movements', [
            'id' => $movement->id,
            'type' => 'exit',
            'quantity' => 2,
            'previous_stock' => 10,
            'new_stock' => 8,
        ]);
    }

    public function test_destroy_reverts_product_stock(): void
    {
        $product = $this->makeProduct(15);
        $movement = StockMovement::create([
            'product_id' => $product->id,
            'type' => 'entry',
            'date' => now(),
            'quantity' => 5,
            'previous_stock' => 10,
            'new_stock' => 15,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->delete(route('inventario.movimientos.destroy', $movement))
            ->assertRedirect(route('inventario.movimientos.index'));

        $this->assertSame(10, $product->fresh()->stock);
        $this->assertDatabaseMissing('stock_movements', ['id' => $movement->id]);
    }
}
