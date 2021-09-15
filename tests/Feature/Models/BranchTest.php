<?php

namespace Tests\Feature\Models;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BranchTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $branch = new Branch();

        $this->assertEquals([], $branch->getFillable());
        $this->assertEquals(['*'], $branch->getGuarded());
        $this->assertEquals('branches', $branch->getTable());
        $this->assertEquals('id', $branch->getKeyName());
        $this->assertEquals([], $branch->getHidden());
        $this->assertEquals([], $branch->getVisible());
        $this->assertEquals(['id' => 'int'], $branch->getCasts());
        $this->assertEquals(['created_at', 'updated_at'], $branch->getDates());
        $this->assertEquals('Illuminate\Database\Eloquent\Collection', get_class($branch->newCollection()));
    }

    public function test_restaurants_relation_configuration()
    {
        $branch = new Branch();
        $relation = $branch->restaurants();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('branch_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function test_categories_relation_configuration()
    {
        $branch = new Branch();
        $relation = $branch->categories();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('branch_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function test_products_relation_configuration()
    {
        $branch = new Branch();
        $relation = $branch->products();

        $this->assertInstanceOf(hasManyThrough::class, $relation);
        $this->assertEquals('category_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function test_relations()
    {
//        $branches = Branch::factory()->has(
//            Category::factory()->has(
//                Product::factory()->count(3)
//            )->count(3)
//        )->count(3)->create();

        $branch = Branch::factory()->create();
        $category = Category::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $restaurant = Restaurant::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertTrue($branch->restaurants->contains($restaurant));
        $this->assertEquals(1, $branch->restaurants->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $branch->restaurants);

        $this->assertTrue($branch->categories->contains($category));
        $this->assertEquals(1, $branch->categories->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $branch->categories);

        $this->assertTrue($branch->products->contains($product));
        $this->assertEquals(1, $branch->products->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $branch->products);
    }

}
