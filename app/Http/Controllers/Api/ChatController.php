<?php

namespace App\Http\Controllers\Api;

use App\Models\Chat;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Http\Resources\ChatResource;

class ChatController extends Controller
{
    public function index()
    {
        return ChatResource::collection(Chat::all());
    }

    public function store(StoreChatRequest $request)
    {
        $chat = Chat::create($request->validated());
        return new ChatResource($chat);
    }

    public function show(Chat $chat)
    {
        return new ChatResource($chat);
    }

    public function update(UpdateChatRequest $request, Chat $chat)
    {
        $chat->update($request->validated());
        return new ChatResource($chat);
    }

    public function destroy(Chat $chat)
    {
        $chat->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
