<?php

namespace BaiduOpen\Tuiguang;

use BaiduOpen\Tuiguang\Helper\AuthHeaderBaidu;
use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\Helper\BaiduValidators;
use BaiduOpen\Tuiguang\Library\sms_service_ReportService;
use BaiduOpen\Tuiguang\Library\Report\ReportRequestType;
use BaiduOpen\Tuiguang\Library\Report\GetProfessionalReportIdRequest;
use BaiduOpen\Tuiguang\Library\Report\GetRealTimeDataRequest;
use DateTime;

class ReportService
{
    /**
     * @var sms_service_ReportService
     */
    protected $baiduReportService;

    /**
     * @var GetProfessionalReportIdRequest
     */
    protected $getReportIdRequest;

    /**
     * @var GetRealTimeDataRequest
     */
    protected $getRealTimeDataRequest;

    /**
     * ReportService constructor.
     * @param $authenticationHeaders
     * @param bool $isMcc
     * @param sms_service_ReportService|null $baiduReportService
     * @param GetProfessionalReportIdRequest|null $getReportIdRequest
     */
    public function __construct(
        $authenticationHeaders,
        $isMcc = false,
        sms_service_ReportService $baiduReportService = null,
        GetProfessionalReportIdRequest $getReportIdRequest = null,
        GetRealTimeDataRequest $getRealTimeDataRequest = null
    )
    {
        $this->baiduReportService = $baiduReportService ?: new sms_service_ReportService();
        $this->baiduReportService->authHeader = AuthHeaderBaidu::updateAuthentication($isMcc, $authenticationHeaders);
        $this->baiduReportService->setIsJson(true);

        $this->getReportIdRequest = $getReportIdRequest ?: new GetProfessionalReportIdRequest();
        $this->getRealTimeDataRequest = $getRealTimeDataRequest ?: new GetRealTimeDataRequest();
    }

    public function getRealTimeDataByPlan(DateTime $startTime = null, DateTime $endTime = null, $planId)
    {
        // TODO: Validate fields.

        $reportType = BaiduParams::REPORT_TYPE['plan'];
        $levelOfDetail = BaiduParams::VALID_LEVEL_OF_DETAIL['plan'][0];
        $statRange = BaiduParams::VALID_STAT_RANGE['plan'][0];
        $unitOfTime = BaiduParams::VALID_UNIT_OF_TIME['plan'][0];
        $performanceData = ['cost', 'cpc', 'click', 'impression', 'ctr', 'conversion'];

        return $this->getRealTimeData($reportType, $startTime, $endTime, $levelOfDetail, $statRange, $planId, $unitOfTime, 0, $performanceData);
    }

    public function getRealTimeData($reportType, DateTime $startTime, DateTime $endTime, $levelOfDetail, $statRange, $statIds, $unitOfTime, $device = 0, $performanceData = [])
    {
        // TODO: Validate fields.
        $startTime->setTimezone('Asia/Shanghai');
        $endTime->setTimezone('Asia/Shanghai');

        if ($performanceData == []) {
            $performanceData = ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'];
        }

        $type = new ReportRequestType();
        $type->setReportType($reportType);
        $type->setStartDate($startTime->format('Y-m-d H:i:s'));
        $type->setEndDate($endTime->format('Y-m-d H:i:s'));
        $type->setLevelOfDetails($levelOfDetail);
        $type->setStatRange($statRange);
        $type->setStatIds($statIds);
        $type->setUnitOfTime($unitOfTime);
        $type->setDevice($device);
        $type->setPerformanceData($performanceData);

        $this->getRealTimeDataRequest->setRealTimeRequestType($type);
        $response = $this->baiduReportService->getRealTimeData($this->getRealTimeDataRequest);
        $jsonHeader = $this->baiduReportService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('getRealTimeData executed');
        return $baiduResponse;
    }

    public function getAccountReportId(DateTime $startDate, DateTime $endDate, $detailLevel = null, $timeUnit = null)
    {
        return $this->getProfessionalReportId($startDate, $endDate, 'account', $detailLevel, $timeUnit);
    }

    public function getRegionReportId(DateTime $startDate, DateTime $endDate, $detailLevel = null, $timeUnit = null)
    {
        return $this->getProfessionalReportId($startDate, $endDate, 'region', $detailLevel, $timeUnit);
    }

    public function getProfessionalReportId(DateTime $startDate, DateTime $endDate, $reportType, $detailLevel = null, $timeUnit = null)
    {
        $validator = new BaiduValidators();

        $validationResponse = $validator->isValidReportType($reportType);
        if (!$validationResponse->isValid())
            return $validationResponse;

        $validationResponse = $validator->isValidReportStartEndDate($startDate, $endDate, $reportType);
        if (!$validationResponse->isValid())
            return $validationResponse;

        if ($detailLevel === null) {
            $detailLevel = BaiduParams::VALID_LEVEL_OF_DETAIL[$reportType][0];
        } else {
            $validationResponse = $validator->isValidLevelOfDetail($detailLevel, $reportType);
            if (!$validationResponse->isValid())
                return $validationResponse;
        }

        if ($timeUnit === null) {
            $timeUnit = BaiduParams::VALID_UNIT_OF_TIME[$reportType][0];
        } else {
            $validationResponse = $validator->isValidTimeOfUnit($timeUnit, $reportType);
            if (!$validationResponse->isValid())
                return $validationResponse;
        }

        $performanceData = BaiduParams::DEFAULT_PERFORMANCE_DATA[$reportType];

        $startDate->setTimezone('Asia/Shanghai');
        $endDate->setTimezone('Asia/Shanghai');

        $type = new ReportRequestType();
        $type->setPerformanceData($performanceData);
        $type->setLevelOfDetails($detailLevel);
        $type->setUnitOfTime($timeUnit);
        $type->setReportType(BaiduParams::REPORT_TYPE[$reportType]);
        $type->setStartDate($startDate->format('Y-m-d H:i:S'));
        $type->setEndDate($endDate->format('Y-m-d H:i:S'));

        $this->getReportIdRequest->setReportRequestType($type);
        $response = $this->baiduReportService->getProfessionalReportId($this->getReportIdRequest);
        $jsonHeader = $this->baiduReportService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('getProfessionalReportId executed');
        return $baiduResponse;
    }
}
