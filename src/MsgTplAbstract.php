<?php declare(strict_types=1);


namespace ZJKe\PushRobot;


abstract class MsgTplAbstract implements MsgTplInterface
{
    const MSG_TYPE_MARKDOWN = 'markdown';
    public $type;

    abstract public function getContent(): string;

}