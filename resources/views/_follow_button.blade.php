@if(Auth::user()->id != $user->id)
    @php
    $isFollowing = App\Repositories\User\UserRepository::isFollowing(Auth::user()->id, $user->id);
    @endphp

    <button user-id="{{ $user->id }}" class="btnFollow btn btn-success float-right" follow="{{ $isFollowing ? "" : "1" }}" >{{ $isFollowing ? "Unfollow" : "Follow" }}</button>
@endif

