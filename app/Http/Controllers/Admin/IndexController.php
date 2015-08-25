<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Model\Good;

class IndexController extends Controller
{

    public function index()
    {
		
		$good = Good::with('brand')->get();
		
		
		
		return $good;
        // return view('admin.index.index');
    }

    
}
