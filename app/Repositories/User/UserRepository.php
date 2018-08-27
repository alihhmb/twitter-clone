<?php

namespace App\Repositories\User;

use App\Following;
use App\Post;
use App\Repositories\User\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{

    private $user;

    /**
     * UserRepository constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // make user follows another user
    public function follow($userId, $userWhoWantToFollowId)
    {
        if($userId != $userWhoWantToFollowId) {
            $user = $this->user->find($userId);
            $userWhoWantToFollow = $this->user->find($userWhoWantToFollowId);
            if($user && $userWhoWantToFollow) {
                if(!$this->isFollowing($userId, $userWhoWantToFollowId)) {
                    return Following::create([
                        'user_id' => $userId,
                        'followed_id' => $userWhoWantToFollowId,
                    ]);
                }
            }
        }
    }

    // make user unfollow another user
    public function unfollow($userId, $userWhoWantToUnfollowId)
    {
        if($this->isFollowing($userId, $userWhoWantToUnfollowId)) {
            DB::table('following')->where([
                ['user_id', '=', $userId],
                ['followed_id', '=', $userWhoWantToUnfollowId],
            ])->delete();
        }
    }

    // check weather a user follow another user or not
    public static function isFollowing($userId, $theOtherUserId)
    {
        return DB::table('following')
            ->where([
                ['user_id', '=', $userId],
                ['followed_id', '=', $theOtherUserId],
            ])->exists();
    }

    // get number of users which follow the user
    public function getNumFollowers($userId)
    {
        return DB::table('following')
            ->where('followed_id', $userId)->count();
    }

    // get number of users which the user follows
    public function getNumFollow($userId)
    {
        return DB::table('following')
            ->where('user_id', $userId)->count();
    }


    // get posts that belong to a user
    public function getUserPosts($userId, $offset = 0, $limit = 10)
    {
        $result = DB::table('posts')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return Post::hydrate($result->toArray());
    }

    //get post list for user
    public function getFeeds($userId, $offset = 0, $limit = 10)
    {
        $result = DB::table('posts')
            ->whereIn('user_id', function($query) use($userId) {
                $query->select('followed_id')
                    ->from('following')
                    ->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return Post::hydrate($result->toArray());
    }

    // get number of posts in user feeds
    public function getFeedsCount($userId)
    {
        return DB::table('posts')
            ->whereIn('user_id', function($query) use($userId) {
                $query->select('followed_id')
                    ->from('following')
                    ->where('user_id', $userId);
            })
            ->count();
    }

    // get user by id, this method is used only in non Ajax requests
    // because if the user does not exist it redirects to 404 page
    public function getByIdOrFail($userId)
    {
        return $this->user->findOrFail($userId);
    }

    //get user by id, this method could be freely used in Ajax requests
    // because it returns null if the user does not exist
    public function getById($userId)
    {
        return $this->user->find($userId);
    }

    // get the entire user list
    public function getList()
    {
        return $this->user->orderBy('name', 'asc')
            ->get();
    }

}