<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertContains;

class ProductTest extends TestCase
{
    public function testProduct()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();
        $this->get("/api/products/$product->id")->assertStatus(200)->assertJson([
            "value" => [
                "name" => $product->name,
                "category" => [
                    "id" => $product->category->id,
                    "name" => $product->category->name,
                ],
                "price" => $product->price,
                'created_at' => $product->created_at->toJSON(),
                'updated_at' => $product->updated_at->toJSON(),
            ]
        ]);
    }

    public function testColWrap()
    {
        $this->seed([CategorySeeder::class,ProductSeeder::class]);
        $response = $this->get('/api/products')->assertStatus(200);
        $names = $response->json("data.*.name");

        for ($i=0; $i < 5; $i++) {
            assertContains("product $i of Food",$names);
        }
        for ($i=0; $i < 5; $i++) {
            assertContains("product $i of Travel",$names);
        }

    }
}
