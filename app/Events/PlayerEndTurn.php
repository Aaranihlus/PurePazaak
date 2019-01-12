<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayerEndTurn implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game_id;
    public $data;
    public $random_dealer_card;
    public $player_index;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($game_id, $data, $random_dealer_card, $player_index)
    {
        $this->game_id = $game_id;
        $this->data = $data;
        $this->random_dealer_card = $random_dealer_card;
        $this->player_index = $player_index;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('player.endturn.game.' . $this->game_id);
    }
}
