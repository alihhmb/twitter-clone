@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                @guest
                    <h1>Welcome to Twitter Clone application.</h1>
                    <h4>Please register & login first to use the application.</h4>
                @else
                    <h3>Feeds</h3>

                    <div class="posts-wrp"></div>
                    <div>
                        <button id="btnLoadMoreFeedsPosts" class="btn hidden">Load More ...</button>
                    </div>

                    @if($feedCount === 0)
                        <p>
                            No feeds, follow some users to see posts<br>
                            <a href="{{ route('users_list')  }}">User list</a>
                        </p>
                    @endif
                @endguest
            </div>
        </div>
    </div>
@endsection

@section('bottom-scripts')
    <script>
        $(document).ready(function(){
            loadFeedsPostList();
        });
    </script>
@endsection