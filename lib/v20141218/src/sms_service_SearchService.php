<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_SearchService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'SearchService');
    }

    public function getCountById($getCountByIdRequest)
    {
        return $this->execute('getCountById', $getCountByIdRequest);
    }

    public function getTab($getTabRequest)
    {
        return $this->execute('getTab', $getTabRequest);
    }

    public function getMaterialInfoBySearch($getMaterialInfoBySearchRequest)
    {
        return $this->execute('getMaterialInfoBySearch', $getMaterialInfoBySearchRequest);
    }
}
