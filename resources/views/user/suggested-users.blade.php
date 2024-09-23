@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
<div class="row justify-content-center">
    <div class="col-4">
        
        <h3 class="h5 mb-4">Suggested</h3>

        @forelse($users as $user)

        <div class="row align-items-center mb-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="" class="rounded-circle avatar-md">
                    @else
                        <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>

            <div class="col ps-0 text-truncate">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold small">{{ $user->name }}</a>
                <p class="text-secondary mb-0">{{ $user->email }}</p>
                <span class="small text-secondary">
                    @if($user->followsYou())
                    Follows you
                    @else
                        @if($user->followers->count() == 0)
                        No followers yet
                        @elseif($user->followers->count() == 1)
                        1 follower
                        @else
                        {{ $user->followers->count() }} followers
                        @endif
                    @endif
                </span>
            </div>

            <div class="col-auto">
                <form action="{{ route('follow.store', $user->id) }}" method="post" class="d-inline">
                    @csrf 
                    <button type="submit" class="border-0 bg-transparent p-0
                    text-primary btn-sm">Follow</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center text-muted">No users found.</p>

        @endforelse
    </div>
</div>
@endsection