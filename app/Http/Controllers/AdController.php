<?php

namespace App\Http\Controllers;

use App\Repositories\AdRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdController extends Controller
{
    private $ad;

    public function __construct(AdRepository $ad)
    {
        $this->ad = $ad;
    }

    function all() {
        $perPage = (int) (Input::get('perPage') ?? 5);
        $data = $this->ad->paginate($perPage);
        return $data;
    }

    function one($id) {
        return $this->ad->find($id);
    }

    function create() {

    }
}
