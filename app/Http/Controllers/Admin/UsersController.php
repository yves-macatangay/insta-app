<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(Request $request){

        if($request->search){
            $all_users = $this->user->withTrashed()->orderBy('name')
                                    ->where('name', 'LIKE', '%'.$request->search.'%')
                                    ->paginate(10);
        }else{
            //get all users, arranged/ordered by name
            $all_users = $this->user->withTrashed()->orderBy('name')->paginate(10);
            //paginate(n) - show n number of rows per page
            //withTrashed() - include soft-deleted records in the lists
        }

        return view('admin.users.index')->with('all_users', $all_users)
                                        ->with('search', $request->search);
    }

    public function deactivate($id){
        $this->user->destroy($id);

        return redirect()->back();
    }

    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        //onlyTrashed() -- only have soft-deleted records

        return redirect()->back();
    }
}
