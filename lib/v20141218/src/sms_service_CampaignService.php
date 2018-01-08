<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_CampaignService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'CampaignService');
    }

    public function getCampaign($getCampaignRequest)
    {
        return $this->execute('getCampaign', $getCampaignRequest);
    }

    public function updateCampaign($updateCampaignRequest)
    {
        return $this->execute('updateCampaign', $updateCampaignRequest);
    }

    public function deleteCampaign($deleteCampaignRequest)
    {
        return $this->execute('deleteCampaign', $deleteCampaignRequest);
    }

    public function addCampaign($addCampaignRequest)
    {
        return $this->execute('addCampaign', $addCampaignRequest);
    }
}
