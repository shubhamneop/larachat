<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
class OneToOneController extends Controller
{   
    private $chatkit;

    public function __construct()
    {
        $this->chatkit = app('ChatKit');
    }


    public function createChatroom(Request $request){
      
           $id = $request->id;
           $userId = $request->userId;
      
          $allroom = $this->chatkit->getRooms(['include_private'=>true]);
        foreach($allroom['body'] as $room){
           $roomdetails[] = $this->chatkit->getRoom(['id'=> $room['id']]); 
         }
        foreach($roomdetails as $demo){
            $memberoom[]=$demo['body'];
         } 
         $roomIss = null;
         foreach($memberoom as $member){
            if(in_array($userId,$member['member_user_ids']) && in_array($id,$member['member_user_ids']) ){
                 $roomIss = $member['id'];
               break;
            }
            
        }
        if(is_null($roomIss)){

            $chatroomdetails = $this->chatkit->createRoom([
                'creator_id'=>$userId,
                'name' => "newprivateroom",
                'private' =>true,
                'user_ids'=>[$userId,$id]
              ]);
              
             $roomId = $chatroomdetails['body']['id'];
     
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
        }else{
            $roomId = $roomIss;
            
    
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
       

      
    }

    public function chat(Request $request)
    {  
          $roomId = $request->roomId;
        $userId = $request->userId;

        if (is_null($userId)) {
            $request->session()->flash('status', 'Join to access chat room!');
            return redirect(url('/'));
        }

        // Get messages via Chatkit
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

    public function users(){
     $userdata = $this->chatkit->getUsersById([
         'user_ids' => "bgt3h",
     ]);
      return $this->chatkit->getReadCursorsForUser(['user_id'=>'bgt3h']);
     return  $this->chatkit->setReadCursor([
        'user_id' => 'bgt3h',
        'room_id' => '978d081e-9080-41a5-bc8d-80f8e1bf4a9b',
        'position' => 102612569
      ]);
      return $this->chatkit->getReadCursor([
        'user_id' => 'hbgt3ham',
        'room_id' => '978d081e-9080-41a5-bc8d-80f8e1bf4a9b',
      ]);
    // dd($userdata);
    }
}
