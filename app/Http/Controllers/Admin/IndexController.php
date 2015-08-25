<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Good;
use Auth;

class IndexController extends Controller
{

    public function index()
    {

		// $good = Good::with('brand')->get();



		// return $good;
        // $user = Auth::user();
        return view('admin.index.index');
    }


}
