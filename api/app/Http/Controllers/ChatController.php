<?php

namespace App\Http\Controllers;

use App\Chat;
use App\ChatMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index(Request $request){
        $chat = Chat::where('website_id', $request->website->id)->where('website_user_id', $request->website_user->id)->first();
        if(!$chat) $chat = Chat::create([
            'hash' => md5(Str::random(60)),
            'website_id' => $request->website->id,
            'website_user_id' => $request->website_user->id,
        ]);
        return response()->json($chat->load('messages'));
    }
    public function getChats(Request $request){
        $chats = Chat::whereHas('website', function ($q)use($request){
            $q->where('user_id', $request->user('api')->id);
        })->whereHas('messages')->with('websiteUser')->paginate(20);
        return response()->json($chats);
    }
    public function show(Request $request, $hash){
        $chat = Chat::where('hash', $hash)->with('website')->first();
        if(!$chat) return response()->json(['errors', 'Nie ma takiego czatu'], 400);
        if($chat->website->user_id != $request->user('api')->id) return response()->json(['errors' => 'Brak autoryzacji'], 403);
        if($request->markAsSeen){
            ChatMessage::where('chat_id', $chat->id)->where('type', ($request->website_user)? 'website' : 'user')->update([
                'seen' => true
            ]);
        }
        return response()->json($chat->load('messages', 'websiteUser'));
    }
    public function message(Request $request){
        $request->validate([
            'chat_hash' => 'required|exists:chats,hash',
            'message' => 'required',
            'type' => 'required',
        ]);
        $chat = Chat::where('hash', $request->chat_hash)->first();
        if($request->type == 'user'){
            if($chat->website_user_id != $request->website_user->id) return response()->json(['errors' => 'Nie masz dostępu'], 403);
            $message = $chat->messages()->create($request->all());
        }
        if($request->type == 'website'){
            if($chat->website->user->id != $request->user('api')->id) return response()->json(['errors' => 'Nie masz dostępu'], 403);
            $message = $chat->messages()->create($request->all());
        }
        $chat->update([
            'last_message' => Carbon::now()
        ]);
        return response()->json($message);
    }
    public function markAsRead(Request $request){
        foreach ($request->except('website', 'website_user') as $data){
            $message = ChatMessage::where('id', $data['id'])->first();
            if($message){
                if($message->type == 'website'){
                    if($request->website_user->id != $message->chat->website_user_id) return response()->json(['errors' => 'Nie masz dostępu'], 403);
                }
                if($message->type == 'user'){
                    if($request->user('api')->id != $message->chat->website_id) return response()->json(['errors' => 'Nie masz dostępu'], 403);
                }
                $message->update([
                    'seen' => true
                ]);
            }
        }
        return response()->json(true);
    }
}
