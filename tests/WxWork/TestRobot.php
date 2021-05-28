<?php declare(strict_types=1);

namespace ZJKe\PushRobotTest\WxWork;

use Exception;

class TestRobot extends \ZJKe\PushRobotTest\TestCase
{
    public function testPush()
    {
        $config = [
            'wx_work' => [
                'key' => '企业微信群机器人key'
            ]
        ];
        $msg    = new \ZJKe\PushRobot\WxWork\MsgTplExceptionMarkdown(new Exception('test'));
        $msg->setEnv('test')->setParam(['a' => 'a'])->setUrl('/test');
        $robot = (new \ZJKe\PushRobot\WxWork\Robot($config, $msg));
        $robot->push();
    }
}