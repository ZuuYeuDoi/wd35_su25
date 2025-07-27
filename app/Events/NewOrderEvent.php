<?php

namespace App\Events;

use App\Models\Cart;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $cart;

    public function __construct($cartId)
    {
        // Lấy cart với liên kết user và các món ăn
        $this->cart = Cart::with(['user', 'cartServiceItems.service'])
            ->findOrFail($cartId);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastOn(): array
    {
        return [
            new Channel('admin-orders'), // dùng Channel (public)
        ];
    }


    public function broadcastAs()
    {
        return 'new-order';
    }

    public function broadcastWith(): array
    {
        $user = $this->cart->user?->name;

        $services = $this->cart->cartServiceItems
            ->filter(function ($item) {
                return $item->service;
            })
            ->map(function ($item) {
                return [
                    'name' => $item->service->name,
                    'quantity' => $item->quantity,
                ];
            })
            ->values()
            ->toArray();

        return [
            'order' => [
                'user' => $user,
                'services' => $services
            ]
        ];
    }
}
