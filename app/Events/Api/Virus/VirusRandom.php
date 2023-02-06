<?php

namespace App\Events\Api\Virus;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Http\Resources\Api\Virus\Item as VirusItemResourse;
use App\Virus;
use App\Game;

class VirusRandom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $game;
    public $virus;
    public $position;

    public function __construct(Game $game, Virus $virus, $position)
    {
        $this->game = $game;
        $this->virus = $virus;
        $this->position = $position;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('game.'.$this->game->id);
    }

    public function broadcastWith()
    {
        return ['virus' => new VirusItemResourse($this->virus), 'position' => $this->position];
    }
}
