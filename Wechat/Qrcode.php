<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

namespace Wechat;

use Wechat\Contracts\Wechat;

/**
 * 二维码管理
 * Class Qrcode
 * @package Wechat
 */
class Qrcode extends Wechat
{

    /**
     * 创建二维码ticket
     * @param string|integer $scene 场景
     * @param int $expire_seconds 有效时间
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function create($scene, $expire_seconds = 0)
    {
        if (is_numeric($scene)) {
            $data = ['action_name' => 'QR_LIMIT_SCENE', 'action_info' => ['scene' => ['scene_id' => $scene]]];
        } else {
            $data = ['action_name' => 'QR_LIMIT_STR_SCENE', 'action_info' => ['scene' => ['scene_str' => $scene]]];
        }
        empty($expire_seconds) ?: $data['expire_seconds'] = $expire_seconds;
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 通过ticket换取二维码
     * @param string $ticket
     * @return string
     */
    public function url($ticket)
    {
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
    }

    /**
     * 长链接转短链接接口
     * @param string $longUrl 需要转换的长链接
     * @return array
     * @throws Exceptions\InvalidResponseException
     * @throws Exceptions\LocalCacheException
     */
    public function shortUrl($longUrl)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['action' => 'long2short', 'long_url' => $longUrl]);
    }

}