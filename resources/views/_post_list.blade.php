@php
    if(!isset($hidePostWhenRemoveFavorites)) {
        $hidePostWhenRemoveFavorites = false;
    }
@endphp


@foreach ($posts as $post)
    @include('_post', ['post' => $post, 'hidePostWhenRemoveFavorites' => $hidePostWhenRemoveFavorites])
@endforeach