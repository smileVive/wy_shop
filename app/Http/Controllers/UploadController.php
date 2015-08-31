<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class UploadController extends Controller
{
    //上传文件
    public function store(Request $request)
    {
        if ($request->hasFile('Filedata') and $request->file('Filedata')->isValid()) {

            //上传文件夹，如果不存在，建立文件夹
            $date = date("Y_m");
            $path = getcwd().'/uploads/'.$date;
            if(!is_dir($path)) {
                Storage::makeDirectory($path);
            }

            //生成新文件名
            $extension = $request->file('Filedata')->getClientOriginalExtension();
            $file_name=bcrypt(time().rand(0,9999999)).'.'.$extension;

            $request->file('Filedata')->move($path, $file_name);

            //返回新文件名
            return '/uploads/'.$date.'/'.$file_name;
        }
    }
}
