@extends('layouts.app')

@section('title', $user->name)

@section('content')
    @include('user.profiles.header')

    @if($user->followers->isNotEmpty())
        <h2 class="h5 text-muted text-center">Followers</h2>
        <div class="row justify-content-center">
            <div class="col-4">
                @foreach($user->followers as $follow)
                    <div class="row mb-3 align-items-center">
                        <div class="col-auto">
                            {{-- icon/avatar --}}
                            @if($follow->follower->avatar)
                                <img src="{{ $follow->follower->avatar}}" alt="" class="rounded-circle avatar-sm">
                            @else 
                                <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif 
                        </div>
                        <div class="col ps-0 text-truncate">
                            {{-- name --}}
                            <a href="{{ route('profile.show', $follow->follower->id)}}" class="text-decoration-none text-dark fw-bold">
                                {{ $follow->follower->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            {{-- button --}}
                            @if($follow->follower->id != Auth::user()->id)
                                @if($follow->follower->isFollowed())
                                    {{-- unfollow --}}
                                    <form action="{{ route('follow.delete', $follow->follower->id)}}" method="post">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 text-secondary">Unfollow</button>
                                    </form>
                                @else 
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $follow->follower->id)}}" method="post">
                                        @csrf 
                                        <button type="submit" class="btn p-0 text-primary">Follow</button>
                                    </form>
                                @endif 
                            @endif 
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else 
        <p class="text-center h5 text-muted">No followers yet.</p>
    @endif

@endsection