<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $chatkit;

    public function __construct()
    {
        $this->chatkit = app('ChatKit');
    }
    
    public function createChatroom(Request $request,$roomId,$userId){
        if(is_null($roomId)){
            return 'not found';
        }else{
            $fetchMessages = $this->chatkit->getRoomMessages([
                'room_id' => $roomId,
                'direction' => 'newer',
                'limit' => 100
            ]);
    
            $messages = collect($fetchMessages['body'])->map(function ($message) {
                return [
                    'id' => $message['id'],
                    'senderId' => $message['user_id'],
                    'text' => $message['text'],
                    'timestamp' => $message['created_at']
                ];
            });
    
            return view('chat')->with(compact('messages', 'roomId', 'userId')); 
        }
        $chatkit_id = strtolower(str_random(5));

        $name_id = strtolower(str_random(5));
        $this->chatkit->createUser([
            'id' =>  $chatkit_id,
            'name' => $name_id,
        ]);
       $chatroomdetails = $this->chatkit->createRoom([
           'creator_id'=>$chatkit_id,
           'name' => "newprivateroom",
           'private' =>true,
         ]);
         
        $roomId = $chatroomdetails['body']['id'];
        $userId = $chatroomdetails['body']['member_user_ids'][0];

        $fetchMessages = $this->chatkit->getRoomMessages([
            'room_id' => $roomId,
            'direction' => 'newer',
            'limit' => 100
        ]);

        $messages = collect($fetchMessages['body'])->map(function ($message) {
            return [
                'id' => $message['id'],
                'senderId' => $message['user_id'],
                'text' => $message['text'],
                'timestamp' => $message['created_at']
            ];
        });

        return view('chat')->with(compact('messages', 'roomId', 'userId')); 



    }
    
    public function JoinChatroom(Request $request,$roomId){
        
        if(is_null($roomId)){
            return 'not found';
        }else{ 
            $chatkit_id = strtolower(str_random(5));
            $name_id = strtolower(str_random(5));

        // Create User account on Chatkit
        $this->chatkit->createUser([
            'id' =>  $chatkit_id,
            'name' => $name_id
        ]);

        $this->chatkit->addUsersToRoom([
            'room_id' => $roomId,
            'user_ids' => [$chatkit_id],
        ]);
            $fetchMessages = $this->chatkit->getRoomMessages([
                'room_id' => $roomId,
                'direction' => 'newer',
                'limit' => 100
            ]);
    
            $messages = collect($fetchMessages['body'])->map(function ($message) {
                return [
                    'id' => $message['id'],
                    'senderId' => $message['user_id'],
                    'text' => $message['text'],
                    'timestamp' => $message['created_at']
                ];
            });
             $userId = $chatkit_id;
            return view('chat')->with(compact('messages', 'roomId', 'userId')); 
        }
        

    }
    
    public function groupChat(Request $request){
        
        $roomId =  $request->roomId;
        $userId = $request->userId;

        $this->chatkit->addUsersToRoom([
            'room_id' => $roomId,
            'user_ids' => [$userId],
        ]);
            $fetchMessages = $this->chatkit->getRoomMessages([
                'room_id' => $roomId,
                'direction' => 'newer',
                'limit' => 100
            ]);
    
            $messages = collect($fetchMessages['body'])->map(function ($message) {
                return [
                    'id' => $message['id'],
                    'senderId' => $message['user_id'],
                    'text' => $message['text'],
                    'timestamp' => $message['created_at']
                ];
            });
             
            return view('chat')->with(compact('messages', 'roomId', 'userId')); 

    }

    public function createGroupchat(Request $request){
        $this->validate($request,[
         'name' => 'required'
        ]);
        $userId = $request->userId;
        $name = $request->name; 
        $this->chatkit->createRoom([
          'creator_id' => $userId,
          'name' => $name,
          'private'=>false
        ]);
        return redirect()->back();
    }



    public function getroom(){
       $rooms = $this->chatkit->getRooms(['include_private'=>true]);
       foreach($rooms['body'] as $room)
       {
           dd($room);
       }
      dd($rooms['body']);

    }
   public function getusersroom(){
       $users = $this->chatkit->getUserRooms(['id'=>'admin']);
       dd($this->chatkit->getRoom(['id'=>'6e48f423-bbcb-4ddc-821f-59f6caf2f0d2']));
       dd($users);
   }
   
}
