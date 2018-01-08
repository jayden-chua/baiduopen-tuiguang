<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_DynamicCreativeService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'DynamicCreativeService');
    }

    public function getDynCreative($getDynCreativeRequest)
    {
        return $this->execute('getDynCreative', $getDynCreativeRequest);
    }

    public function getExclusionTypeByCampaignId($getExclusionTypeByCampaignIdRequest)
    {
        return $this->execute('getExclusionTypeByCampaignId', $getExclusionTypeByCampaignIdRequest);
    }

    public function addDynCreative($addDynCreativeRequest)
    {
        return $this->execute('addDynCreative', $addDynCreativeRequest);
    }

    public function deleteDynCreative($deleteDynCreativeRequest)
    {
        return $this->execute('deleteDynCreative', $deleteDynCreativeRequest);
    }

    public function updateDynCreative($updateDynCreativeRequest)
    {
        return $this->execute('updateDynCreative', $updateDynCreativeRequest);
    }

    public function addExclusionType($addExclusionTypeRequest)
    {
        return $this->execute('addExclusionType', $addExclusionTypeRequest);
    }

    public function delExclusionType($delExclusionTypeRequest)
    {
        return $this->execute('delExclusionType', $delExclusionTypeRequest);
    }
}
