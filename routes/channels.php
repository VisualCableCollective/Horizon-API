<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('client.{socketID}', function($user, $socketID){
    $client_headers = getallheaders();
    Log::debug($client_headers["X-Socket-ID"]);
    if(!$client_headers["X-Socket-ID"])
        return false;
    return (int)$client_headers["X-Socket-ID"] === (int)$socketID;
});
