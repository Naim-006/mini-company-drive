<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_product_catalog_displays_active_products(): void
    {
        $activeProduct = Product::factory()->create([
            'name' => 'Active Business Tool',
            'is_active' => true,
        ]);

        $inactiveProduct = Product::factory()->inactive()->create([
            'name' => 'Secret Draft Project',
        ]);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('Active Business Tool');
        $response->assertDontSee('Secret Draft Project');
    }

    public function test_public_product_detail_page_is_accessible_for_active_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Flagship Software',
            'is_active' => true,
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertSee('Flagship Software');
    }

    public function test_public_product_detail_page_returns_404_for_inactive_product(): void
    {
        $product = Product::factory()->inactive()->create([
            'name' => 'Hidden Draft Item',
        ]);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(404);
    }

    public function test_guest_cannot_access_admin_product_management(): void
    {
        $response = $this->get(route('admin.products.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_product_create_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.products.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New Product');
    }

    public function test_admin_can_create_product_with_valid_data_and_image(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $image = UploadedFile::fake()->image('banner.jpg', 640, 480);

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Novel Analytics Suite',
            'category' => 'Software',
            'price' => 149.99,
            'stock' => 25,
            'short_description' => 'A powerful reporting toolkit.',
            'description' => 'Longer detailed description of features.',
            'image' => $image,
            'is_active' => '1',
            'is_featured' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'name' => 'Novel Analytics Suite',
            'category' => 'Software',
            'price' => 149.99,
            'stock' => 25,
            'is_active' => 1,
            'is_featured' => 1,
        ]);

        $product = Product::where('name', 'Novel Analytics Suite')->first();
        $this->assertNotNull($product->image_path);
        Storage::disk('public')->assertExists($product->image_path);
    }

    public function test_product_creation_validates_required_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), []);

        $response->assertSessionHasErrors(['name', 'category', 'price', 'stock']);
    }

    public function test_product_creation_rejects_executable_or_non_image_files(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        // Attempt to upload a fake php script disguised as an image
        $executableFile = UploadedFile::fake()->create('malicious.php', 10, 'application/x-php');

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'name' => 'Suspicious Product',
            'category' => 'Software',
            'price' => 10.00,
            'stock' => 5,
            'image' => $executableFile,
        ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseMissing('products', ['name' => 'Suspicious Product']);
    }

    public function test_admin_can_update_product(): void
    {
        $admin = User::factory()->admin()->create();
        $product = Product::factory()->create([
            'name' => 'Initial Name',
            'price' => 50.00,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.products.update', $product), [
            'name' => 'Updated Name',
            'category' => 'Hardware',
            'price' => 89.99,
            'stock' => 40,
            'short_description' => 'Updated short summary.',
            'description' => 'Updated full description.',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
            'price' => 89.99,
            'category' => 'Hardware',
        ]);
    }

    public function test_admin_can_delete_product(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $image = UploadedFile::fake()->image('test.jpg');
        $path = $image->store('products', 'public');

        $product = Product::factory()->create([
            'image_path' => $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->actingAs($admin)->delete(route('admin.products.destroy', $product));

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing($path);
    }
}
