<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/9
 * Time: 下午3:33
 */

namespace App\Extensions;

use App\Models\Monolog;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class MongoDBHandler extends AbstractProcessingHandler {

    private $model;

    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     * @return void
     */
    protected function write(array $record)
    {
        try {
            $this->model = new Monolog();
            $this->model->channel = $record['channel'];
            $this->model->level = $record['level'];
            $this->model->message = $record['message'];
            $this->model->context = $record['context'] ? $record['context'] : '';
            $this->model->extra = $record['extra'] ? $record['extra'] : '';
            $this->model->save();
        } catch (\Exception $e) {
            //@todo
        }

    }
}