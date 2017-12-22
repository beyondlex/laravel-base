<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/22
 * Time: 下午9:38
 */

namespace App\Extensions\Traits;


trait ImageTrait
{

	function originalUrl($relativePath) {
		return 'http://'.$_SERVER['HTTP_HOST']."/". config('imagecache.route'). '/original'.$relativePath;
	}
	function smallUrl($relativePath) {
		return 'http://'.$_SERVER['HTTP_HOST']."/". config('imagecache.route'). '/small'.$relativePath;
	}
	function thumbUrl($relativePath) {
		return 'http://'.$_SERVER['HTTP_HOST']."/". config('imagecache.route'). '/thumb'.$relativePath;
	}


}