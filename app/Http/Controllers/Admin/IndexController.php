<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Good;
use Auth;
use Session;

class IndexController extends Controller
{

    public function index()
    {
        // $user = Auth::user();
        return view('admin.index.index');
    }


}
