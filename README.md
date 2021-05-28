## 消息推送机器人

- 企业微信

```php
    //推送异常消息示例
  $config = [
            'wx_work' => [
                'key' => '企业微信群机器人key'
            ]
        ];
        $msg    = new \ZJKe\PushRobot\WxWork\MsgTplExceptionMarkdown(new Exception('test'));
        $msg->setEnv('test')->setParam(['a' => 'a'])->setUrl('/test');
        $robot = (new \ZJKe\PushRobot\WxWork\Robot($config, $msg));
        $robot->push();
```