<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function sendMessageToOwner(Request $request)
    {
        if ($user = Auth::user()) {

            $service = new MessageService($request);

            $service->sendMessage();

            return response()->json(['message' => 'Message sent!']);
        }

    }
}
