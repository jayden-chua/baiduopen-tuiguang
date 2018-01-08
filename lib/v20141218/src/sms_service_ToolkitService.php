<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_ToolkitService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'ToolkitService');
    }

    public function getOperationRecord($getOperationRecordRequest)
    {
        return $this->execute('getOperationRecord', $getOperationRecordRequest);
    }
}
