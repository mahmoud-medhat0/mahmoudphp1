<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class printsum extends Controller
{
    public function sum()
    {
        $x = 5;
        $y = 5;
        $z = $x + $y;
        return view('printsum',compact('z'));
    }
}
