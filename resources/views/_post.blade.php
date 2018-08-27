@php
    $userUrl = route('users_user', ['id' => $post->user->id]);
    if(!isset($hidePostWhenRemoveFavorites)) {
        $hidePostWhenRemoveFavorites = false;
    }
@endphp

<div class="card post-wrp">
    <div class="card-body">
        <div class="post-header">
            @include('_favorite_button', ['post' => $post, 'hidePostWhenRemoveFavorites' => $hidePostWhenRemoveFavorites])

            <a href="{{ $userUrl }}"><img class="avatar-small" src="{{ asset('/uploads/avatars/'. $post->user->avatar ) }}" /></a>
            <div><a href="{{ $userUrl }}">{{ $post->user->name  }}</a></div>
            <div class="date-small">{{ $post->created_at  }}</div>
        </div>
        <div>{!! nl2br(e($post->post)) !!}</div>
    </div>
</div>