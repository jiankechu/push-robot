<?php

namespace ZJKe\PushRobot\WxWork;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use ZJKe\PushRobot\Exception\LogicException;
use ZJKe\PushRobot\Exception\RuntimeException;
use ZJKe\PushRobot\MsgTplAbstract;
use ZJKe\PushRobot\RobotAbstract;

class Robot extends RobotAbstract
{
    protected $robotType = 'wx_work';
    private   $req       = [
        "msgtype"  => "markdown",
        "markdown" => [
            "content"               => '',
            "mentioned_list"        => [],
            "mentioned_mobile_list" => [],
        ]
    ];

    protected function setMarkdown(MsgTplAbstract $msgTpl)
    {
        $this->req['markdown']['content'] = $msgTpl->getContent();
        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws RuntimeException|LogicException
     */
    public function push(): \Psr\Http\Message\ResponseInterface
    {
        if (empty($this->req)) {
            throw new LogicException('未设置消息内容!');
        }
        $client = new Client();
        $uri    = http_build_query([
            'key' => $this->config['key'],
        ]);
        $url    = sprintf('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?%s', $uri);
        $resp   = $client->request('POST', $url, [
            'json' => $this->req]);

        if ($resp->getStatusCode() !== 200) {
            throw new RuntimeException('企业微信消息推送失败');
        }
        $body = json_decode($resp->getBody()->getContents(), 1);
        if (!empty($body['errcode'])) {
            throw new RuntimeException($body['errmsg']);
        }
        return $resp;
    }
}