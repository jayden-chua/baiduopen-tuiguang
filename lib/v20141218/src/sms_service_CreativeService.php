<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_CreativeService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'CreativeService');
    }

    public function updateCreative($updateCreativeRequest)
    {
        return $this->execute('updateCreative', $updateCreativeRequest);
    }

    public function deleteCreative($deleteCreativeRequest)
    {
        return $this->execute('deleteCreative', $deleteCreativeRequest);
    }

    public function addCreative($addCreativeRequest)
    {
        return $this->execute('addCreative', $addCreativeRequest);
    }

    public function getCreative($getCreativeRequest)
    {
        return $this->execute('getCreative', $getCreativeRequest);
    }
}
