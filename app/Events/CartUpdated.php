<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CartUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $count; // Số lượng trong giỏ hàng

    /**
     * Tạo một instance mới cho sự kiện.
     *
     * @param  int  $count
     * @return void
     */
    public function __construct($count)
    {
        $this->count = $count; // Gán số lượng giỏ hàng
    }

    public function broadcastOn()
    {
        return new PrivateChannel('cart.' . Auth::id()); 
    }
    public function broadcastWith()
    {
        return [
            'count' => $this->count, 
        ];
    }
}
