<?php

namespace App\Http\Controllers;

use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdController extends Controller
{
    //

    function all(AdRepository $ad) {
        $perPage = (int) (Input::get('perPage') ?? 5);
        $data = $ad->paginate($perPage);
        return $data;
    }
}
