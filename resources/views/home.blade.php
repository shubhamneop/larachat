@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">User</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($users as $user)
                    <a class="dropdown-item" href="{{ route('privatechat') }}" onclick="event.preventDefault();
                             document.getElementById('{{$user->chatkit_id}}').submit();">
                              {{$user->name}}  </a>
                             <form id="{{$user->chatkit_id}}" action="{{ route('privatechat') }}" method="POST" style="display: none;">
                              @csrf
                             <input type="hidden" name="id" value="{{$user->chatkit_id}}">
                             <input type="hidden" name="userId" value="{{Auth::user()->chatkit_id}}">
                             </form>
                    <!-- @foreach($userrooms['body'] as $userroom)
                         @if(in_array($user->chatkit_id,$userroom['member_user_ids']))                           
                          @if($userroom['private']==true)
                            <a class="dropdown-item" href="{{ route('privatechat') }}" onclick="event.preventDefault();
                             document.getElementById('{{$userroom['id']}}').submit();">
                              {{$user->name}}  </a>
                             <form id="{{$userroom['id']}}" action="{{ route('privatechat') }}" method="POST" style="display: none;">
                              @csrf
                             <input type="hidden" name="roomId" value="{{$userroom['id']}}">
                             <input type="hidden" name="userId" value="{{Auth::user()->chatkit_id}}">
                             </form>
                             @else
                              <a href="{{url('privatechat/'.$user->id)}}">{{$user->name}} </a>
                              @endif
                             @endif  
                         
                     

                    @endforeach  -->
                    @endforeach                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Groups </div>

                <div class="card-body">
                   @foreach($rooms['body'] as $room)
                   <a class="dropdown-item" href="{{ route('groupchat') }}" onclick="event.preventDefault();
                       document.getElementById('{{$room['id']}}').submit();">
                           {{$room['name']}}  </a>
                          <form id="{{$room['id']}}" action="{{ route('groupchat') }}" method="POST" style="display: none;">
                            @csrf
                           <input type="hidden" name="roomId" value="{{$room['id']}}">
                           <input type="hidden" name="userId" value="{{Auth::user()->chatkit_id}}">
                          </form>
                     
                   @endforeach

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Create Group </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                     <!-- <form id="{{$room['id']}}" action="{{ route('creategroupchat') }}" method="POST">
                            @csrf
                            <label>Group Name</label>
                           <input type="text" name="name" >
                           <input type="hidden" name="userId" value="{{Auth::user()->chatkit_id}}">
                           <input type="submit"  value="create">
                     </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
