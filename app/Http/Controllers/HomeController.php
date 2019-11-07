<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $chatkit;

    public function __construct()
    {
        $this->middleware('auth');
        $this->chatkit = app('ChatKit');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $id = Auth::user()->id;

        $users = User::orderBy('id','DESC')->where('id','!=',$id)->get();
        foreach($users as $user){
            $chatkit[] = $user->chatkit_id;
        }
         $data = User::find($id);
        $userrooms = $this->chatkit->getUserRooms(['id'=>$data->chatkit_id]);
        $rooms = $this->chatkit->getRooms([]);
        
        $allroom = $this->chatkit->getRooms(['include_private'=>true]);
        foreach($allroom['body'] as $room){
           $roomdetails[] = $this->chatkit->getRoom(['id'=> $room['id']]); 
         }
        foreach($roomdetails as $demo){
            $memberoom[]=$demo['body'];
         }
         foreach($memberoom as $member){
            if(in_array("czfwl",$member['member_user_ids']) && in_array("bgt3h",$member['member_user_ids']) ){
                // return $member['id'];
            }
            
        }
        
        // dd($rooms['body']); 
    //     foreach($rooms['body'] as $userroom){
    //         $private[] = $userroom['private']; 
    //     }
    //     dd($private);
    //    dd($userrooms);

    return view('home',compact('users','userrooms','rooms','chatkit'));
    }
}
