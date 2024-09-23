<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    //post belongs to 1 user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    //post has many category_posts
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }

    //post has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //post has many likes
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //return true if the post is liked by logged-in user
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();

        //$this->likes() --> get the post's likes 
        //where() --> in the list of likes, look for logged-in user
        //exists() --> if where() finds records, return true
    }
}
