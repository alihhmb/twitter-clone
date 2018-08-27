<?php

namespace App\Repositories\Post;

use App\Favorite;
use App\Post;
use App\Repositories\Post\PostRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\DB;

class PostRepository implements PostRepositoryInterface
{

    private $post;

    /**
     * PostRepository constructor.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    // Creates new post
    public function create($userId, $postText)
    {
        return $this->post->create([
            'user_id' => $userId,
            'post' => trim($postText),
        ]);
    }

    // Delete post
    public function delete($postId)
    {
        $post = Post::find($postId);
        if($post) {
            $post->delete();
        }
    }

    // Add post to favorites
    public function addToFavorites($userId, $postId)
    {
        $user = User::find($userId);
        $post = $this->post->find($postId);
        if($user && $post) {
            if(!$this->isPostInFavorites($userId, $postId)) {
                return Favorite::create([
                    'user_id' => $userId,
                    'post_id' => $postId,
                ]);
            }
        }
    }

    // remove post from user's favorites
    public function removeFromFavorites($userId, $postId)
    {
        if($this->isPostInFavorites($userId, $postId)) {
            DB::table('favorites')->where([
                ['user_id', '=', $userId],
                ['post_id', '=', $postId],
            ])->delete();
        }
    }

    // check weather the post is in user's favorites
    public static function isPostInFavorites($userId, $postId)
    {
        return DB::table('favorites')
            ->where([
                ['user_id', '=', $userId],
                ['post_id', '=', $postId],
            ])->exists();
    }

    // get user favorites
    public function getUserFavorites($userId, $offset = 0, $limit = 10)
    {
        $result = DB::table('posts')
            ->whereIn('id', function($query) use($userId) {
                $query->select('post_id')
                    ->from('favorites')
                    ->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return Post::hydrate($result->toArray());
    }

    public function edit($postId, $postText)
    {
        // TODO: Implement edit() method.
    }

    // get post by id, this method is used only in non Ajax requests
    // because if the post does not exist it redirects to 404 page
    public function getByIdOrFail($postId)
    {
        return $this->post->findOrFail($postId);
    }

    //get post by id, this method could be freely used in Ajax requests
    // because it returns null if the post does not exist
    public function getById($postId)
    {
        return $this->post->find($postId);
    }


}