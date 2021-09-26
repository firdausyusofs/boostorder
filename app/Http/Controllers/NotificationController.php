<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function getNoti()
    {
        $unread = Notification::where('read', 0)->count();

        $notifications = Notification::orderBy('id', 'desc')->get();

        $html = "";

        foreach($notifications as $noti)
        {
            $html .= "
                <div>
                    <p>".$noti['message']."</p>
                </div>
            ";
        }

        return json_encode([
            'html' => $html,
            'unread' => $unread
        ]);

    }

    public function readNoti()
    {

        Notification::where('read', 0)->update(['read' => 1]);

        return true;

    }
}
