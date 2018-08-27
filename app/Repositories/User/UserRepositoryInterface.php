<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{

    public function getList();
    public function follow($userId, $userWhoWantToFollowId);
    public function unfollow($userId, $userWhoWantToUnfollowId);
    public static function isFollowing($userId, $theOtherUserId);
    public function getNumFollowers($userId);
    public function getNumFollow($userId);
    public function getUserPosts($userId, $offset = 0, $limit = 10);
    public function getByIdOrFail($userId);
    public function getById($userId);
    public function getFeeds($userId);
    public function getFeedsCount($userId);

}