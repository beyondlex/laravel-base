<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/22
 * Time: 下午9:53
 */

namespace App\Extensions\Image\Filters;


use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class ThumbFilter implements FilterInterface
{

	/**
	 * Applies filter to given image
	 *
	 * @param  Image $image
	 * @return Image
	 */
	public function applyFilter(Image $image)
	{
		return $image->resize(200, null, function ($constraint) {
			$constraint->aspectRatio();
		});
	}
}