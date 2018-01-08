<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_ReportService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'ReportService');
    }

    public function getRealTimeQueryData($getRealTimeQueryDataRequest)
    {
        return $this->execute('getRealTimeQueryData', $getRealTimeQueryDataRequest);
    }

    public function getRealTimePairData($getRealTimePairDataRequest)
    {
        return $this->execute('getRealTimePairData', $getRealTimePairDataRequest);
    }

    public function getProfessionalReportId($getProfessionalReportIdRequest)
    {
        return $this->execute('getProfessionalReportId', $getProfessionalReportIdRequest);
    }

    public function getReportState($getReportStateRequest)
    {
        return $this->execute('getReportState', $getReportStateRequest);
    }

    public function getReportFileUrl($getReportFileUrlRequest)
    {
        return $this->execute('getReportFileUrl', $getReportFileUrlRequest);
    }

    public function getRealTimeData($getRealTimeDataRequest)
    {
        return $this->execute('getRealTimeData', $getRealTimeDataRequest);
    }
}
