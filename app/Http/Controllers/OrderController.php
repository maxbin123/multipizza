<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Restaurant;

class OrderController extends Controller
{
    public function create(OrderRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['restaurant_id'] = Restaurant::nearest(
            $data['branch_id'],
            $data['latitude'],
            $data['longitude']
        )->first()->id;

        $order = Order::create($data);

        foreach ($data['items'] as $item) {
            $new_item = $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity']
            ]);
            if (!empty($item['ingredients'])) {
                $new_item->ingredients()->attach($item['ingredients']); // TODO price
            }
        }
        return $order;
    }
}
