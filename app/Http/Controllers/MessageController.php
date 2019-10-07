<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Events\MessagePushed;

class MessageController extends Controller
{
    public function index()
    {
        return response()->json(Message::with('user')->orderBy('id', 'desc')->take(10)->get());
    }

    public function store(Request $request)
    {
        $message = (new Message([
            'message' => $request->input('message'),
            'created_by' => $request->user()->id,
        ]));
        $message->save();
        $message->load('user');
        broadcast(new MessagePushed($message))->toOthers();
        return response()->json($message);
    }
}