<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAuthorized implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user that authenticated.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The socketID where the event will be broadcasted.
     */
    public $socketID;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $socketID)
    {
        $this->user = $user;
        $this->socketID = $socketID;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('client.'.$this->socketID);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['authToken' => $this->user->createToken('Horizon Client')->plainTextToken];
    }
}
