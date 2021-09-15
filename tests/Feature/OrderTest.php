<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Staff\OrderCreated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use NotificationChannels\Telegram\TelegramMessage;
use Tests\CreatesApplication;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $seed = true;

    public function test_new_order()
    {
        $response = $this->postJson('api/v1/order', []);
        $response->assertStatus(401);

        Sanctum::actingAs(User::where('role_id', Role::CUSTOMER)->first(), ['customer']);
        $response = $this->postJson('api/v1/order', []);
        $response->assertStatus(422);

        $branch_id = Branch::inRandomOrder()->first()->id;

        [$product1, $product2, $product3] = Product::whereHas('branch', function (Builder $query) use ($branch_id) {
            $query->where('branches.id', $branch_id);
        })->withOnly('ingredients')->inRandomOrder()->limit(3)->get();

        Notification::fake();
//        Queue::fake();

        $response = $this->postJson('api/v1/order', [
            'name' => 'Customer',
            'phone' => '+78583774758',
            'address' => 'Krasnaya 176',
            'door' => '3',
            'floor' => '14',
            'flat' => '886',
            'code' => '886',
            'latitude' => 45.158239,
            'longitude' => 38.989681,
            'branch_id' => $branch_id,
            'items' => [
                [
                    'product_id' => $product1->id,
                    'quantity' => rand(1, 3),
                    'ingredients' => [
                        $product1->ingredients()->inRandomOrder()->first()->id,
                    ]
                ],
                [
                    'product_id' => $product2->id,
                    'quantity' => rand(1, 3),
                    'ingredients' => [
                        $product2->ingredients()->inRandomOrder()->first()->id,
                        $product2->ingredients()->inRandomOrder()->first()->id,
                    ]
                ],
                [
                    'product_id' => $product3->id,
                    'quantity' => rand(1, 3),
                ],
            ]
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'state',
            'address',
            'door',
            'floor',
            'flat',
            'code',
            'latitude',
            'longitude',
            'branch_id',
            'user_id',
            'restaurant_id',
            'updated_at',
            'created_at',
            'id',
        ]);

        Notification::assertSentTo(User::admins()->get(), OrderCreated::class);
//        Queue::assertPushed(TelegramMessage::class);
    }

    public function test_index_order()
    {
        Sanctum::actingAs(User::where('role_id', Role::CUSTOMER)->first(), ['customer']);
        $response = $this->get('api/v1/order');
        $response->assertStatus(200);
    }

    public function test_show_order()
    {
        $user = User::where('role_id', Role::CUSTOMER)->first();
        $order = $user->orders->random();
        Sanctum::actingAs($user, ['customer']);

        $response = $this->get('api/v1/order/' . $order->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'state',
            'user_id',
            'delivery_id',
            'latitude',
            'longitude',
            'address',
            'door',
            'floor',
            'flat',
            'code',
            'created_at',
            'updated_at',
            'branch_id',
            'restaurant_id',
            'items',
            'user',
            'restaurant'
        ]);

        $order = Order::inRandomOrder()->where('user_id', '!=', $user->id)->first();
        $response = $this->get('api/v1/order/' . $order->id);
        $response->assertStatus(401);
    }

    public function test_show_alien_order()
    {
        $user = User::where('role_id', Role::CUSTOMER)->first();
        $order = Order::inRandomOrder()->where('user_id', '!=', $user->id)->first();
        Sanctum::actingAs($user, ['customer']);
        $response = $this->get('api/v1/order/' . $order->id);
        $response->assertStatus(401);
    }
}
