<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';
    public $timestamps = false; //do not save timestamps
    protected $fillable = ['category_id', 'post_id']; //needed for create() or createMany()
                                                      //allowable columns in the inserted array

    //category_post belongs to category
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //category_post belongs to post
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
