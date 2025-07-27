<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBookingEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $booking;

    public function __construct($bookingId)
    {
        // Nạp lại booking từ DB, có quan hệ
        $this->booking = Booking::with(['user', 'bookingRooms.room'])->findOrFail($bookingId);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('admin-booking'), // dùng Channel (public)
        ];
    }

    public function broadcastAs()
    {
        return 'new-booking';
    }

    public function broadcastWith()
    {
        $userName = $this->booking->user->name;

        // Lấy tên tất cả các phòng đã đặt
        $roomNames = $this->booking->bookingRooms->map(function ($bookingRoom) {
            return $bookingRoom?->room->title;
        })->implode(', ');

        return [
            'booking' => [
                'name' => $userName,
                'room' => $roomNames,
            ]
        ];
    }
}
