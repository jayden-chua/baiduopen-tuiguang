<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_KRService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'KRService');
    }

    public function getEstimatedDataByBid($getEstimatedDataByBidRequest)
    {
        return $this->execute('getEstimatedDataByBid', $getEstimatedDataByBidRequest);
    }

    public function getEstimatedData($getEstimatedDataRequest)
    {
        return $this->execute('getEstimatedData', $getEstimatedDataRequest);
    }

    public function getKRFileIdByWords($getKRFileIdByWordsRequest)
    {
        return $this->execute('getKRFileIdByWords', $getKRFileIdByWordsRequest);
    }

    public function getFileStatus($getFileStatusRequest)
    {
        return $this->execute('getFileStatus', $getFileStatusRequest);
    }

    public function getFilePath($getFilePathRequest)
    {
        return $this->execute('getFilePath', $getFilePathRequest);
    }

    public function getKRByQuery($getKRByQueryRequest)
    {
        return $this->execute('getKRByQuery', $getKRByQueryRequest);
    }

    public function getKRCustom($getKRCustomRequest)
    {
        return $this->execute('getKRCustom', $getKRCustomRequest);
    }

    public function getBidByWords($getBidByWordsRequest)
    {
        return $this->execute('getBidByWords', $getBidByWordsRequest);
    }
}
