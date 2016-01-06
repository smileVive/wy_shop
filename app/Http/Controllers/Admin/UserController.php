<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()
    {
        view()->share(['_user' => 'am-active']);
    }

    public function index()
    {
        $users = User::orderBy('created_at')->paginate(config('wyshop.page_size'));
        return view('admin.user.index', ['users' => $users]);
    }

}
