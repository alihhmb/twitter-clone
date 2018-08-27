@php ($userUrl = route('users_user', ['id' => $user->id]) )

<div class="card post-wrp">
    <div class="card-body">
        <div class="post-header">
            @include('_follow_button', ['user' => $user])
            <a href="{{ $userUrl }}"><img class="avatar-small" src="{{ asset('/uploads/avatars/'. $user->avatar ) }}" /></a>
            <div><a href="{{ $userUrl }}">{{ $user->name  }}</a></div>
            <div class="date-small">Subscribed: {{ $user->created_at  }}</div>
        </div>
    </div>
</div>