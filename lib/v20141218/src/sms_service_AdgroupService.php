<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_AdgroupService extends CommonService
{
    public function __construct() {
        parent::__construct ( 'sms', 'service', 'AdgroupService' );
    }

    public function addAdgroup ($addAdgroupRequest)
    {
        return $this->execute ( 'addAdgroup', $addAdgroupRequest );
    }

    public function updateAdgroup ($updateAdgroupRequest)
    {
        return $this->execute ( 'updateAdgroup', $updateAdgroupRequest );
    }

    public function deleteAdgroup ($deleteAdgroupRequest)
    {
        return $this->execute ( 'deleteAdgroup', $deleteAdgroupRequest );
    }

    public function getAdgroup ($getAdgroupRequest)
    {
        return $this->execute ( 'getAdgroup', $getAdgroupRequest );
    }
}
