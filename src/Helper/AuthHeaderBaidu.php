<?php

namespace BaiduOpen\Tuiguang\Helper;

use BaiduOpen\Tuiguang\Library\Common\AuthHeader;

class AuthHeaderBaidu
{
    // Both this parameters will be provided when
    const TARGET = 'TARGET';
    const ACCESSTOKEN = 'ACCESS_TOKEN';

    public static function updateAuthentication($isMcc = false, $headerOptions = [])
    {
        $authenticationHeader = new AuthHeader();

        $authenticationHeader->setUsername($headerOptions['username']);
        $authenticationHeader->setPassword($headerOptions['password']);
        $authenticationHeader->setToken($headerOptions['token']);

        if ($isMcc && $headerOptions['accessToken'] && $headerOptions['target']) {
            $authenticationHeader->setTarget(self::TARGET);
            $authenticationHeader->setAccessToken(self::ACCESSTOKEN);
        }

        return $authenticationHeader;
    }
}
