<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    //user has many posts
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    //user follows many users (user has many follows)
    public function follows(){
        return $this->hasMany(Follow::class, 'follower_id');
    }

    //user is followed by many users (user has many followers)
    public function followers(){
        return $this->hasMany(Follow::class, 'followed_id');
    }

    //return true if $this user is followed by logged-in user
    public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        //$this->followers() -- get list of $this user's followers (people following them)
        //where() -- among the followers, find logged-in user
        //exists() -- return true if where() found rows
    }

    //return true if $this user is following logged-in user
    public function followsYou(){
        return $this->follows()->where('followed_id', Auth::user()->id)->exists();
    }
}
