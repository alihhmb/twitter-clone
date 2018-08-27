@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @include('_follow_button', ['user' => $user])

                <h1>{{ $user->name }}</h1>

                <div>Subscribed: {{ $user->created_at }}</div>
                <div>Followers: <h3 id="numFollowers" class="d-inline-block">{{ $numFollowers }}</h3></div>
                <div>Follow: <h3 id="numFollow" class="d-inline-block">{{ $numFollow }}</h3></div>

                @if(Auth::user()->id == $user->id)
                <div class="card tweet-wrp">
                    <div class="card-body">
                        <textarea id="tweet"></textarea>
                        <div><button id="btnPublish" class="btn btn-success">Tweet</button></div>
                    </div>
                </div>
                @endif

                <div class="posts-wrp"></div>
                <div>
                    <button id="btnLoadMorePosts" user-id="{{ $user->id }}" class="btn hidden">Load More ...</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottom-scripts')
<script>
    $(document).ready(function(){
        loadPostList('{{ $user->id }}');
    });
</script>
@endsection
