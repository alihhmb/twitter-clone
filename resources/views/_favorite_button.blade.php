@php
    $inFavorites = App\Repositories\Post\PostRepository::isPostInFavorites(Auth::user()->id, $post->id);
    if(!isset($hidePostWhenRemoveFavorites)) {
        $hidePostWhenRemoveFavorites = false;
    }
@endphp
<button post-id="{{ $post->id }}" hidePostWhenRemoveFavorites="{{ $hidePostWhenRemoveFavorites ? "1" : "" }}"  class="float-right btn-favorite {{ $inFavorites ? "btn-favorite-active" : "btn-favorite-inactive" }}"  in-favorites="{{ $inFavorites ? "1" : "" }}" title="{{ $inFavorites ? "Remove From Favorites" : "Add to Favorites" }}"></button>


