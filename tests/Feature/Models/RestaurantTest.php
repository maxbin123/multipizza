<?php

namespace Tests\Feature\Models;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Malhal\Geographical\Geographical;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_model_configuration()
    {
        $restaurant = new Restaurant();

        $this->assertEquals([], $restaurant->getFillable());
        $this->assertEquals(['*'], $restaurant->getGuarded());
        $this->assertEquals('restaurants', $restaurant->getTable());
        $this->assertEquals('id', $restaurant->getKeyName());
        $this->assertEquals([], $restaurant->getHidden());
        $this->assertEquals([], $restaurant->getVisible());
        $this->assertEquals(['id' => 'int'], $restaurant->getCasts());
        $this->assertEquals(['created_at', 'updated_at'], $restaurant->getDates());
        $this->assertEquals('Illuminate\Database\Eloquent\Collection', get_class($restaurant->newCollection()));

        $this->assertContains('Malhal\Geographical\Geographical', class_uses(Restaurant::class));
        $this->assertEquals('latitude', $restaurant->getLatitudeColumn());
        $this->assertEquals('longitude', $restaurant->getLongitudeColumn());
    }

    public function test_branch_relation_configuration()
    {
        $restaurant = new Restaurant();
        $relation = $restaurant->branch();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('branch_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getOwnerKeyName());
    }

    public function test_orders_relation_configuration()
    {
        $restaurant = new Restaurant();
        $relation = $restaurant->orders();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('restaurant_id', $relation->getForeignKeyName());
        $this->assertEquals('id', $relation->getLocalKeyName());
    }

    public function test_relations()
    {
        $branch = Branch::factory()->create();
        $restaurant = Restaurant::factory()->create([
            'branch_id' => $branch->id,
        ]);
        $customer = User::factory()->create([
            'role_id' => Role::CUSTOMER,
            'restaurant_id' => null,
        ]);
        $delivery = User::factory()->create([
            'role_id' => Role::DELIVERY,
            'restaurant_id' => null,
        ]);

        $order = Order::factory()->create([
            'branch_id' => $branch->id,
            'restaurant_id' => $restaurant->id,
        ]);


        $this->assertTrue($restaurant->orders->contains($order));
        $this->assertEquals(1, $restaurant->orders->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $restaurant->orders);

        $this->assertEquals(1, $restaurant->branch->count());
        $this->assertInstanceOf(Branch::class, $restaurant->branch);
    }

    public function test_geo_scopes()
    {
        $branch = Branch::factory()->create();
        $restaurant = Restaurant::factory()->create([
            'branch_id' => $branch->id,
        ]);

        $restaurant = Restaurant::nearest($branch->id, $this->faker->latitude(45, 45.2), $this->faker->longitude(38.9, 39.1))->first()->get('id')->toArray();

        $this->assertEquals(1, $restaurant[0]['id']);
    }

}
