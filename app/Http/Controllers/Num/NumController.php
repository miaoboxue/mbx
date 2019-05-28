<?php

namespace App\Http\Controllers\Num;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NumController extends Controller
{
    //
    public function num($x){
        $num=1;
        for ($i=1;$i<=$x;$i++){
            $num=$num*$i;
        }
        echo $num;
    }

}
