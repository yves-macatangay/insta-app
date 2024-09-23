<div class="modal fade" id="likes-post{{ $post->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button data-bs-dismiss="modal" class="btn btn-sm ms-auto text-primary fw-bold">X</button>
            </div>
            <div class="modal-body">
                <div class="container w-75 mx-auto">
                @foreach($post->likes as $like)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <a href="{{ route('profile.show', $like->user->id)}}">
                                @if($like->user->avatar)
                                    <img src="{{ $like->user->avatar }}" alt="" class="rounded-circle avatar-sm">
                                @else 
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif 
                            </a>
                        </div>
                        <div class="col ps-0 text-truncate">
                            <a href="{{ route('profile.show', $like->user->id)}}" class="text-decoration-none fw-bold text-dark">
                                {{ $like->user->name }}
                            </a>
                        </div>
                        <div class="col-auto">
                            @if($like->user->id != Auth::user()->id)
                                @if($like->user->isFollowed())
                                    {{-- unfollow --}}
                                    <form action="{{ route('follow.delete', $like->user->id)}}" method="post">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 text-secondary">Unfollow</button>
                                    </form>
                                @else 
                                    {{-- follow --}}
                                    <form action="{{ route('follow.store', $like->user->id)}}" method="post">
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
        </div>
    </div>
</div>