<?php

namespace App;
use App\Domain\Models\Ad;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Notification;


class Main
{


    public function run(){
         Notification::send([Ad::query()->first()],new TestNotification(Ad::query()->first()));

            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])

            // (Optional) Inline Buttons

            // (Optional) Inline Button with callback. You can handle callback in your bot instance

    }
}
