<?php

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

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chatBuyer.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chatCourier.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('topup.status.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order.status.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('payment.status.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
