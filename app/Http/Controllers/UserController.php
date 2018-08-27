<?php

namespace App\Http\Controllers;

use App\Post;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Mockery\Exception;

class UserController extends Controller
{

    private $userRepository;
    private $postRepository;

    /**
     * PostController constructor.
     */
    public function __construct(UserRepositoryInterface $userRepository, PostRepositoryInterface $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        $users = $this->userRepository->getList();
        return view('users/index', ['users' => $users] );
    }

    public function user($id)
    {
        $user = $this->userRepository->getByIdOrFail($id);
        $numFollowers = $this->userRepository->getNumFollowers($id);
        $numFollow = $this->userRepository->getNumFollow($id);
        $isFollowing = $this->userRepository->isFollowing(Auth::user()->id, $id);

        return view('users/user', [
            'user' => $user,
            'numFollowers' => $numFollowers,
            'numFollow' => $numFollow,
            'isFollowing' => $isFollowing,
        ] );
    }

    public function editprofile()
    {
        return view('profile', array('user' => Auth::user()) );
    }

    public function favorites()
    {
        return view('users/favorites');
    }

    public function getUserFavoritesPosts(Request $request)
    {
        try {
            $me =  Auth::user();
            $offset = $request->request->get('offset');
            $posts = $this->postRepository->getUserFavorites($me->id, $offset);
            //get one record after the requested record to chech if there is more posts or not
            $morePosts = $this->postRepository->getUserFavorites($me->id, $offset + 10, 1);
            $more = $morePosts->count() ? true : false;
            $view = view('_post_list', ['posts' => $posts, 'hidePostWhenRemoveFavorites' => true]);
            $html = $view->__toString();
        }catch(Exception $e) {
            $errorMsg = 'User not found';
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
            'html' => isset($html) ? $html : null,
            'more' => isset($more) ? $more : false,
        ];
    }

    public function updateProfile(Request $request)
    {
        // Handle the user upload of avatar
        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename =  sha1( uniqid() ). '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
            $user = Auth::user();
            if('default.jpg' != $user->avatar) {
                $oldFilename = public_path('/uploads/avatars/' . $user->avatar );
                if(file_exists($oldFilename)) {
                    unlink($oldFilename);
                }
            }
            $user->avatar = $filename;
            $user->save();
        }
        return view('profile', array('user' => Auth::user()) );
    }


    public function follow(Request $request)
    {
        try {
            $userId = $request->request->get('user_id', 0);
            $user = $this->userRepository->getById($userId);
            if(!$user) {
                throw new Exception('User not found');
            }
            $me = Auth::user();
            $this->userRepository->follow($me->id, $userId);
            $numFollowers = $this->userRepository->getNumFollowers($userId);
            $numFollow = $this->userRepository->getNumFollow($userId);
        }catch(Exception  $e) {
            $errorMsg = 'User not found';
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
            'numFollowers' => isset($numFollowers) ? $numFollowers : null,
            'numFollow' => isset($numFollow) ? $numFollow : null,
        ];
    }

    public function unfollow(Request $request)
    {
        try {
            $userId = $request->request->get('user_id', 0);
            $user = $this->userRepository->getById($userId);
            if(!$user) {
                throw new Exception('User not found');
            }
            $me = Auth::user();
            $this->userRepository->unfollow($me->id, $userId);
            $numFollowers = $this->userRepository->getNumFollowers($userId);
            $numFollow = $this->userRepository->getNumFollow($userId);
        }catch(Exception $e) {
            $errorMsg = 'User not found';
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
            'numFollowers' => isset($numFollowers) ? $numFollowers : null,
            'numFollow' => isset($numFollow) ? $numFollow : null,
        ];
    }

    public function getUserPosts(Request $request)
    {
        try {
            $userId = $request->request->get('user_id', 0);
            $offset = $request->request->get('offset');
            $user = $this->userRepository->getById($userId);
            if(!$user) {
                throw new Exception('User not found');
            }
            $posts = $this->userRepository->getUserPosts($userId, $offset);
            //get one record after the requested record to chech if there is more posts or not
            $morePosts = $this->userRepository->getUserPosts($userId, $offset + 10, 1);
            $more = $morePosts->count() ? true : false;
            $view = view('_post_list', ['posts' => $posts]);
            $html = $view->__toString();
        }catch(Exception $e) {
            $errorMsg = 'User not found';
        }
        return [
            'error' => isset($errorMsg) ? $errorMsg : null,
            'html' => isset($html) ? $html : null,
            'more' => isset($more) ? $more : false,
        ];
    }

    public function getUserFeeds(Request $request)
    {
        $me =  Auth::user();
        $offset = $request->request->get('offset');
        $posts = $this->userRepository->getFeeds($me->id);
        //get one record after the requested record to chech if there is more posts or not
        $morePosts = $this->userRepository->getFeeds($me->id, $offset + 10, 1);
        $more = $morePosts->count() ? true : false;
        $view = view('_post_list', ['posts' => $posts]);
        $html = $view->__toString();

        return [
            'error' => null,
            'html' => isset($html) ? $html : null,
            'more' => isset($more) ? $more : false,
        ];
    }

}
