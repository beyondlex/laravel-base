<?php

namespace App\Http\Controllers;

use App\Repositories\MonologRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MonologController extends Controller
{
    //
    public function getAll(MonologRepository $monolog) {
//        DB::connection('mongodb')->enableQueryLog();
        $perPage = (int) (Input::get('perPage') ?? 5);

        $data = $monolog->paginate($perPage);
//        dd(DB::connection('mongodb')->getQueryLog());
        return $data;


    }

}
