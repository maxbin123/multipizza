<?php

namespace Tests\Feature\Models;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_model_configuration()
    {
        $category = new Category();

        $this->assertEquals([], $category->getFillable());
        $this->assertEquals([], $category->getGuarded());
        $this->assertEquals('categories', $category->getTable());
        $this->assertEquals('id', $category->getKeyName());
        $this->assertEquals([], $category->getHidden());
        $this->assertEquals([], $category->getVisible());
        $this->assertEquals(['id' => 'int'], $category->getCasts());
        $this->assertEquals(['created_at', 'updated_at'], $category->getDates());
        $this->assertEquals('Illuminate\Database\Eloquent\Collection', get_class($category->newCollection()));
    }

    public function test_parent_relation_configuration()
    {
        $category = new Category();
        $relation = $category->parent();

        $this->assertInstanceOf(belongsTo::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function test_children_relation_configuration()
    {
        $category = new Category();
        $relation = $category->children();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function test_childrenRecursive_relation_configuration()
    {
        $category = new Category();
        $relation = $category->childrenRecursive();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function test_branch_relation_configuration()
    {
        $category = new Category();
        $relation = $category->branch();

        $this->assertInstanceOf(belongsTo::class, $relation);
        $this->assertEquals('branch_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function test_products_relation_configuration()
    {
        $category = new Category();
        $relation = $category->products();

        $this->assertInstanceOf(HasMany::class, $relation);
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
        $parent_category = Category::factory()->create([
            'branch_id' => $branch->id,
            'parent_id' => null,
        ]);
        $category = Category::factory()->create([
            'branch_id' => $branch->id,
            'parent_id' => $parent_category->id,
        ]);
        $restaurant = Restaurant::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $product = Product::factory()->create([
            'category_id' => $category->id,
        ]);

        $this->assertEquals(2, $category->parent->count());
        $this->assertInstanceOf(Category::class, $category->parent);

        $this->assertTrue($parent_category->children->contains($category));
        $this->assertEquals(1, $parent_category->children->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $parent_category->children);

        $this->assertEquals(1, $category->branch->count());
        $this->assertInstanceOf(Branch::class, $category->branch);

        $this->assertTrue($category->products->contains($product));
        $this->assertEquals(1, $category->products->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->products);
    }

}
