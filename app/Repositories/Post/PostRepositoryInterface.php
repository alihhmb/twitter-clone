<?php

namespace App\Repositories\Post;

interface PostRepositoryInterface
{
    public function create($userId, $postText);
    public function edit($postId, $postText);
    public function getByIdOrFail($postId);
    public function getById($postId);
    public function delete($postId);
    public function addToFavorites($userId, $postId);
    public static function isPostInFavorites($userId, $postId);
    public function removeFromFavorites($userId, $postId);
    public function getUserFavorites($userId, $offset = 0, $limit = 10);
}