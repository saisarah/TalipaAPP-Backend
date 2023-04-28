<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::channel('users.{id}', function (User $user, $id) {
    return true;
});

Broadcast::channel('farmers', function (User $user) {
    return $user->isFarmer();
});

Broadcast::channel('farmer-groups.{id}', function (User $user, $id) {
    return $user->groups()->where('farmer_group_id', $id)->exists();
});

Broadcast::channel('farmer-group-posts.{id}', function (User $user, $id) {
    return true; //Change this
});

Broadcast::channel('orders.{id}', function (User $user, $id) {
    return true; //Change this
});