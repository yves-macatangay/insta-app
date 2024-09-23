<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    private $post;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->search){
            //search data
            $home_posts = $this->post->latest()
                                    ->where('description', 'LIKE', '%'.$request->search.'%')
                                        ->get();
            //SELECT * .... WHERE description LIKE '%keyword%' 
            //RegEx - patterns
        }else{
            //get all posts, with latest at the top of the list
            $all_posts = $this->post->latest()->get();

            //filter posts to only auth user's posts AND followed users' posts
            $home_posts = [];
            foreach($all_posts as $post){
                if($post->user_id == Auth::user()->id || $post->user->isFollowed()){
                    $home_posts []= $post;
                }
            }
        }

        return view('user.home')->with('all_posts', $home_posts)
                                ->with('suggested_users', $this->getSuggestedUsers())
                                ->with('search', $request->search);
    }

    //get 10 suggested users (not followed yet)
    private function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);

        $suggested_users = [];
        $count = 0;
        foreach($all_users as $user){
            if(!$user->isFollowed() && $count<10){
                $suggested_users []= $user;
                $count++;
            }
        }
        return $suggested_users;
    }

    public function suggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);

        $suggested_users = [];
        foreach($all_users as $user){
            if(!$user->isFollowed()){
                $suggested_users []= $user;
            }
        }
        return view('user.suggested-users')->with('users', $suggested_users);
    }
}
