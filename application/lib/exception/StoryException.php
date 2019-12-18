<?php


namespace app\lib\exception;


class StoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定故事不存在，请检查故事ID';
    public $errorCode = 20000;
}