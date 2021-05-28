<?php

namespace ZJKe\PushRobot\WxWork;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use ZJKe\PushRobot\Exception\RuntimeException;
use ZJKe\PushRobot\MsgTplAbstract;
use ZJKe\PushRobot\RobotAbstract;

class Robot extends RobotAbstract
{
    protected $robotType = 'wx_work';

    /**
     * @throws GuzzleException
     */
    protected function pushMarkdown(MsgTplAbstract $msgTpl)
    {
        $req = [
            "msgtype"  => "markdown",
            "markdown" => [
                "content"               => $msgTpl->getContent(),
                "mentioned_list"        => [],
                "mentioned_mobile_list" => [],
            ]
        ];
        return $this->send($req);
    }

    /**
     * @throws GuzzleException
     * @throws RuntimeException
     */
    private function send(array $req): \Psr\Http\Message\ResponseInterface
    {
        $client = new Client();
        $uri    = http_build_query([
            'key' => $this->config['key'],
        ]);
        $url    = sprintf('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?%s', $uri);
        $resp   = $client->request('POST', $url, [
            'json' => $req]);

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