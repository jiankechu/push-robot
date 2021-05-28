<?php declare(strict_types=1);


namespace ZJKe\PushRobot;


use ZJKe\PushRobot\Exception\LogicException;

abstract class  RobotAbstract implements RobotInterface
{
    protected $config;
    protected $robotType = '';

    public function __construct(array $config)
    {
        if (empty($config[$this->robotType])) {
            throw new LogicException();
        }
        $this->config = $config[$this->robotType];
    }

    public function push(MsgTplAbstract $msgTpl)
    {
        switch ($msgTpl->type) {
            case MsgTplAbstract::MSG_TYPE_MARKDOWN:
                return $this->pushMarkdown($msgTpl);
                break;
            default:
                throw new LogicException('不支持的消息类型');
        }
    }

    abstract protected function pushMarkdown(MsgTplAbstract $msgTpl);

}