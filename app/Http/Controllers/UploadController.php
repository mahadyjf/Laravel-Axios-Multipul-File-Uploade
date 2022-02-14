<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    function OnFileUpload(Request $req){
      $req->file('FileKey')->store('MyFile');
    }
}
