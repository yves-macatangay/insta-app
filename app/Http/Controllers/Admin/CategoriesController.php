<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->orderBy('name')->paginate(10);

        $all_posts = $this->post->all();
        $count = 0;
        foreach($all_posts as $post){
            if($post->categoryPosts->count() == 0){
                $count++;
            }
        }

        return view('admin.categories.index')->with('all_categories', $all_categories)
                                            ->with('uncategorized_count', $count);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);

        $this->category->name = ucwords($request->name);
        $this->category->save();

        return redirect()->back();
    }

    public function delete($id){
        $this->category->destroy($id);

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            "categ_name$id" => 'required|max:50|unique:categories,name,'.$id
        ],[
            "categ_name$id.required" => 'Name is required.',
            "categ_name$id.max" => 'Maximum of 50 characters only',
            "categ_name$id.unique" => 'This name is already taken'
        ]);

        $category_a = $this->category->findOrFail($id);
        $category_a->name = $request->input('categ_name'.$id);
        $category_a->save();

        return redirect()->back();
    }
}
