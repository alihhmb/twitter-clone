<?php

namespace App\Http\Controllers;

use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $userRepository;


    public function __construct(UserRepositoryInterface $userRepository, PostRepositoryInterface $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        $user =  Auth::user();
        if($user) {
            $feedCount = $this->userRepository->getFeedsCount($user->id);
        }

        return view('users/feeds', [
            'feedCount' => isset($feedCount) ? $feedCount : null,
        ]);
    }

}
