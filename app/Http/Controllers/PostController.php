<?php

namespace App\Http\Controllers;

use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Mockery\Exception;

class PostController extends Controller
{

    private $postRepository;
    private $userRepository;


    /**
     * PostController constructor.
     */
    public function __construct(PostRepositoryInterface $postRepository, UserRepositoryInterface $userRepository)
    {
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }

    public function addToFavorites(Request $request)
    {
        try {
            $postId = $request->request->get('post_id', 0);
            $post = $this->postRepository->getById($postId);
            if(!$post) {
                throw new Exception('Post not found');
            }
            $me = Auth::user();
            $this->postRepository->addToFavorites($me->id, $postId);
        }catch(Exception $e) {
            $errorMsg = 'Post not found';
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
        ];
    }

    public function removeFromFavorites(Request $request)
    {
        try {
            $postId = $request->request->get('post_id', 0);
            $post = $this->postRepository->getById($postId);
            if(!$post) {
                throw new Exception('Post not found');
            }
            $me = Auth::user();
            $this->postRepository->removeFromFavorites($me->id, $postId);
        }catch(Exception $e) {
            $errorMsg = 'User not found';
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
        ];
    }

    public function publish(Request $request)
    {
        try {
            $tweet = $request->request->get('tweet');
            if(!trim($tweet)) {
                throw new Exception('You must write somethinig');
            }
            if($tweet != strip_tags($tweet)) {
                throw new Exception('The tweet contains HTML');
            }

            $me = Auth::user();
            $post = $this->postRepository->create($me->id, $tweet);

            $view = view('_post', array('post' => $post) );
            $postHtml = $view->__toString();

        }catch(Exception $e) {
            $errorMsg = $e->getMessage();
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
            'html' => isset($postHtml) ? $postHtml : null,
        ];
    }

}
