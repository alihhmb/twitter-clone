$(document).ready(function(){
    $(document).on('click','.btnFollow', {} ,function(e){
        var url, btn = this;
        if(!$(btn).attr('working')) {
            $(btn).attr('working', '1');
            if($(btn).attr('follow')) {
                url = route('users_follow');
            }else{
                url = route('users_unfollow');
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,
                data: {
                    'user_id': $(btn).attr('user-id')
                },
                dataType: "json"
            }).done(function (json) {
                if (json.error) {
                    alert(json.error);
                } else {
                    if($(btn).attr('follow')) {
                        $(btn).attr('follow','');
                        $(btn).text('Unfollow');
                    }else{
                        $(btn).attr('follow','1');
                        $(btn).text('Follow');
                    }
                    $('#numFollowers').html(json.numFollowers);
                    $('#numFollow').html(json.numFollow);
                }
            }).always(function () {
                $(btn).attr('working', '');
            }).fail(function () {
            });
        }
    });

    $(document).on('click','.btn-favorite', {} ,function(e){
        var url, btn = this;
        if(!$(btn).attr('working')) {
            $(btn).attr('working', '1');
            if($(btn).attr('in-favorites')) {
                url = route('posts_removefromfavorites');
            }else{
                url = route('posts_addtofavorites');
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,
                data: {
                    'post_id': $(btn).attr('post-id')
                },
                dataType: "json"
            }).done(function (json) {
                if (json.error) {
                    alert(json.error);
                } else {
                    if($(btn).attr('in-favorites')) {
                        $(btn).attr('in-favorites','');
                        $(btn).attr('title','Add to Favorites');
                        $(btn).removeClass('btn-favorite-active').addClass('btn-favorite-inactive');
                        if($(btn).attr('hidePostWhenRemoveFavorites')) {
                            $(btn).closest(".post-wrp").fadeOut().remove();
                        }
                    }else{
                        $(btn).attr('in-favorites','1');
                        $(btn).attr('title','Remove From Favorites');
                        $(btn).removeClass('btn-favorite-inactive').addClass('btn-favorite-active');
                    }
                }
            }).always(function () {
                $(btn).attr('working', '');
            }).fail(function () {
            });
        }
    });

    $(document).on('click','#btnLoadMorePosts', {} ,function(e){
        loadPostList($(this).attr('user-id'));
    });

    $(document).on('click','#btnLoadMoreFavPosts', {} ,function(e){
        loadMyFavoritesPostList();
    });

    $(document).on('click','#btnLoadMoreFeedsPosts', {} ,function(e){
        loadFeedsPostList();
    });

    $("#btnPublish").click(function(){
        var url, btn = this;
        if(!$(btn).attr('working')) {
            var tweet = $('#tweet').val();
            $(btn).attr('working', '1');
            $(btn).prop('disabled', true);
            $('#tweet').prop('disabled', true);
            url = route('posts_publish');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "POST",
                url: url,
                data: {
                    'tweet': tweet
                },
                dataType: "json"
            }).done(function (json) {
                if (json.error) {
                    alert(json.error);
                } else {
                    $('#tweet').val('');
                    $('.posts-wrp').prepend(json.html);
                }
            }).always(function () {
                $(btn).attr('working', '');
                $(btn).prop('disabled', false);
                $('#tweet').prop('disabled', false);
            }).fail(function () {
            });
        }
    });

});

var postListOffset = 0;

function loadPostList(user_id) {
    $('#btnLoadMorePosts').prop('disabled', true);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: route('users_get_user_posts'),
        data: {
            'user_id': user_id,
            'offset': postListOffset
        },
        dataType: "json"
    }).done(function (json) {
        if (json.error) {
            alert(json.error);
        } else {
            if(json.more) {
                $('#btnLoadMorePosts').removeClass('hidden');
            }else{
                $('#btnLoadMorePosts').addClass('hidden');
            }
            postListOffset += 10;
            $('.posts-wrp').append(json.html);
        }
    }).always(function () {
        $('#btnLoadMorePosts').prop('disabled', false);
    }).fail(function () {
    });
}

var favoritesPostListOffset = 0;

function loadMyFavoritesPostList() {
    $('#btnLoadMoreFavPosts').prop('disabled', true);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: route('users_get_user_favorites_posts'),
        data: {
            'offset': favoritesPostListOffset
        },
        dataType: "json"
    }).done(function (json) {
        if (json.error) {
            alert(json.error);
        } else {
            if(json.more) {
                $('#btnLoadMoreFavPosts').removeClass('hidden');
            }else{
                $('#btnLoadMoreFavPosts').addClass('hidden');
            }
            favoritesPostListOffset += 10;
            $('.posts-wrp').append(json.html);
        }
    }).always(function () {
        $('#btnLoadMoreFavPosts').prop('disabled', false);
    }).fail(function () {
    });
}


var feedsPostListOffset = 0;

function loadFeedsPostList() {
    $('#btnLoadMoreFeedsPosts').prop('disabled', true);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: route('users_get_user_feeds'),
        data: {
            'offset': feedsPostListOffset
        },
        dataType: "json"
    }).done(function (json) {
        if (json.error) {
            alert(json.error);
        } else {
            if(json.more) {
                $('#btnLoadMoreFeedsPosts').removeClass('hidden');
            }else{
                $('#btnLoadMoreFeedsPosts').addClass('hidden');
            }
            feedsPostListOffset += 10;
            $('.posts-wrp').append(json.html);
        }
    }).always(function () {
        $('#btnLoadMoreFeedsPosts').prop('disabled', false);
    }).fail(function () {
    });
}