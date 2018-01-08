<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_AccountService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'AccountService');
    }

    public function getAccountInfo($getAccountInfoRequest)
    {
        return $this->execute('getAccountInfo', $getAccountInfoRequest);
    }

    public function updateAccountInfo($updateAccountInfoRequest)
    {
        return $this->execute('updateAccountInfo', $updateAccountInfoRequest);
    }
}
