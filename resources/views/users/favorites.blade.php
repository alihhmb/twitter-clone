@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h>My Favorites</h>

                <div class="posts-wrp"></div>
                <div>
                    <button id="btnLoadMoreFavPosts" class="btn hidden">Load More ...</button>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('bottom-scripts')
    <script>
        $(document).ready(function(){
            loadMyFavoritesPostList();
        });
    </script>
@endsection