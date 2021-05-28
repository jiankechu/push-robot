<?php declare(strict_types=1);


namespace ZJKe\PushRobot\WxWork;


use Throwable;
use ZJKe\PushRobot\MsgTplAbstract;

class MsgTplExceptionMarkdown extends MsgTplAbstract
{
    public    $type       = parent::MSG_TYPE_MARKDOWN;
    private   $e;
    protected $url        = '';
    protected $env        = 'dev';
    protected $param      = [];
    protected $contentLen = 1000;

    public function __construct(Throwable $e)
    {
        $this->e = $e;
    }

    /**
     * 设置正文长度默认1000
     * @param int $contentLen
     * @return MsgTplExceptionMarkdown
     */
    public function setContentLen(int $contentLen): self
    {
        $this->contentLen = $contentLen;
        return $this;
    }

    /**
     * 设置请求参数
     * @param array $param
     * @return MsgTplExceptionMarkdown
     */
    public function setParam(array $param): self
    {
        $this->param = json_encode($param);
        return $this;
    }


    /**
     * 设置环境变量值
     * @param string $env
     * @return MsgTplExceptionMarkdown
     */
    public function setEnv(string $env): self
    {
        $this->env = $env;
        return $this;
    }

    /**
     * 设置请求url
     * @param string $url
     * @return MsgTplExceptionMarkdown
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }


    public function getContent(): string
    {
        $e        = $this->e;
        $traceStr = $e->getTraceAsString();
        if (mb_strlen($traceStr) > $this->contentLen) {
            $traceStr = mb_substr($traceStr, 0, $this->contentLen) . ' ...';
        }
        $className = get_class($e);
        return <<<MARDOWN
**警告: <font color="comment">{$e->getMessage()}</font>** 
环境： <font color="warning">{$this->env}</font>
异常类： <font color="comment">{$className}</font>
URL： <font color="comment">{$this->url}</font>
请求参数：
```
$this->param
```
**文件：**
`{$e->getFile()} : {$e->getLine()}`
**堆栈：**
```
$traceStr
```
MARDOWN;
    }
}