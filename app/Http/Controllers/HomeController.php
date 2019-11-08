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
        $usersCount = User::orderBy('id','DESC')->where('id','!=',$id)->count();
        foreach($users as $user){
            $chatkit[] = $user->chatkit_id;
        }
         $data = User::find($id);
        $userrooms = $this->chatkit->getUserRooms(['id'=>$data->chatkit_id]);
           $roomcount=0;
        foreach($userrooms['body'] as $value){
            if($value['private']==true){
              $roomcount++;
            }

        }

        $rooms = $this->chatkit->getRooms([]);
        

        
        // dd($rooms['body']); 
    //     foreach($rooms['body'] as $userroom){
    //         $private[] = $userroom['private']; 
    //     }
    //     dd($private);
    //    dd($userrooms);

    return view('home',compact('users','userrooms','rooms','roomcount','usersCount'));
    }
}
