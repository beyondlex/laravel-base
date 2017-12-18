<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/18
 * Time: 上午10:41
 */
namespace App\Services;

use App\Files;
use App\Repositories\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService {

	private $file;

	public function __construct(FileRepository $file)
	{
		$this->file = $file;
	}

	/**
	 * @param string $path	Relative path. eg: 'avatar/sub_dir'
	 * @param string $disk	eg: public, local ...
	 * @param string $inputKey The key of file post in the form.
	 * @return Files
	 */
	public function store($path, $disk = 'public', $inputKey = 'file') {
		$request = app('request');
		/** @var UploadedFile $uploadedFile */
		$uploadedFile = $request->file($inputKey);

		$fileSystem = Storage::disk($disk);
		$path = $fileSystem->putFile($path, $uploadedFile);

		/** @var Files $file */
		$file = $this->file->skipPresenter()->create([
			'type'=> $fileSystem->mimeType($path),
			'size'=> $fileSystem->size($path),
			'url'=> Storage::url($path),// '/storage'. $path
			'filename'=> $uploadedFile->getClientOriginalName(),
		]);

		return $file;
	}
}