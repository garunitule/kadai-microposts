<!--favorites.blade.phpから$user, $micropostsが渡される-->

<ul class="list-unstyled">
    @foreach($microposts as $micropost)
        <li class="media mb-3">
            <div class="container">
                <div class="row mb-3">
                    <img class="mr-2 rounded" src="{{ Gravatar::src($micropost->user->email, 50) }}" alt="">
                    <div class="media-body">
                        {!! link_to_route('users.show', $micropost->user->name, ['id' => $micropost->user_id]) !!}<span class="text-muted">posted at {{ $micropost->created_at }}</span>
                    </div>
                    <div>
                        <p class="mb-0">{!! nl2br(e($micropost->content)) !!}</p>
                    </div>
                </div>
                
                <div class="row">
                    @include('user_favorite.favorite_button', ['user' => $user, 'micropost' => $micropost])
                    @if(Auth::id() == $micropost->user_id)
                        {!! Form::open(['route' => ['microposts.destroy', $micropost->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-md']) !!}
                        {!! Form::close() !!}
                    @endif

                </div>
            </div>
        </li>
    @endforeach
</ul>
{{ $microposts->links('pagination::bootstrap-4') }}