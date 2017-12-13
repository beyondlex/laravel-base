<?php

namespace App\Http\Controllers;

use App\Repositories\MonologRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Monologs
 * @Resource("Monologs")
 * @package App\Http\Controllers
 */
class MonologController extends Controller
{
    /**
     * Get all logs
     * @Get("/api/logs")
     * @Request({"search": "channel:100"})
     * @Response(200, body={"channel":"laravel", "level":100, "message":"hello", "context":"", "extra":{} })
     * @param MonologRepository $monolog
     * @return mixed
     */
    public function getAll(MonologRepository $monolog) {
//        DB::connection('mongodb')->enableQueryLog();
        $perPage = (int) (Input::get('perPage') ?? 5);

        $data = $monolog->paginate($perPage);
//        dd(DB::connection('mongodb')->getQueryLog());
        return $data;


    }

}
