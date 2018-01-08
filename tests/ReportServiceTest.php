<?php

namespace Tests\BaiduOpen;

use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\Library\sms_service_ReportService;
use BaiduOpen\Tuiguang\Library\Report\GetProfessionalReportIdRequest;
use BaiduOpen\Tuiguang\ReportService;
use PHPUnit\Framework\TestCase;
use DateTime;
use stdClass;

class ReportServiceTest extends TestCase
{
    protected $fakeGoodAuthHeaders;

    protected function setUp()
    {
        $this->fakeGoodAuthHeaders = [
            'username' => 'abc',
            'password' => 'abc',
            'token' => 'abc',
        ];
    }

    public function test_getProfessionalReportId_With_InvalidReportType_Should_ReturnErrors()
    {
        $reportService = new ReportService($this->fakeGoodAuthHeaders);
        $startDate = new DateTime('2017-06-01');
        $endDate = new DateTime('2017-06-07');
        $badReportType = 'fakeReport';
        $reportServiceResponse = $reportService->getProfessionalReportId($startDate, $endDate, $badReportType);

        $responseStatus = $reportServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $reportServiceResponse->getErrors();
        $this->assertEquals('fakeReport is not a valid report type', $responseErrors[0]);
    }

    public function test_getProfessionalReportId_With_InvalidStartDate_Should_ReturnErrors()
    {
        $reportService = new ReportService($this->fakeGoodAuthHeaders);
        $badStartDate = new DateTime('1970-06-01');
        $endDate = new DateTime('2017-06-07');
        $goodReportType = 'account';
        $reportServiceResponse = $reportService->getProfessionalReportId($badStartDate, $endDate, $goodReportType);

        $responseStatus = $reportServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $reportServiceResponse->getErrors();
        $this->assertEquals('start date "19700601" is not a valid report start time for account report type', $responseErrors[0]);
    }

    public function test_getProfessionalReportId_With_SameStartEndDates_Should_ReturnErrors()
    {
        $reportService = new ReportService($this->fakeGoodAuthHeaders);
        $startDate = new DateTime('2017-06-01');
        $endDate = new DateTime('2017-06-01');
        $goodReportType = 'account';
        $reportServiceResponse = $reportService->getProfessionalReportId($startDate, $endDate, $goodReportType);

        $responseStatus = $reportServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $reportServiceResponse->getErrors();
        $this->assertEquals('end date "20170601" is before or same as start date "20170601" for account report type', $responseErrors[0]);
    }

    public function test_getProfessionalReportId_With_EarlierEndDates_Should_ReturnErrors()
    {
        $reportService = new ReportService($this->fakeGoodAuthHeaders);
        $startDate = new DateTime('2017-06-01 00:00:00');
        $endDate = new DateTime('2017-05-31 23:59:59');
        $goodReportType = 'account';
        $reportServiceResponse = $reportService->getProfessionalReportId($startDate, $endDate, $goodReportType);

        $responseStatus = $reportServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $reportServiceResponse->getErrors();
        $this->assertEquals('end date "20170531" is before or same as start date "20170601" for account report type', $responseErrors[0]);
    }

    public function test_getProfessionalReportId_With_InvalidDetailLevels_Should_ReturnErrors()
    {
        $reportService = new ReportService($this->fakeGoodAuthHeaders);
        $startDate = new DateTime('2017-06-01 00:00:00');
        $endDate = new DateTime('2017-06-30 23:59:59');
        $goodReportType = 'account';
        $badDetailLevel = 999;

        $reportServiceResponse = $reportService->getProfessionalReportId($startDate, $endDate, $goodReportType, $badDetailLevel);

        $responseStatus = $reportServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $reportServiceResponse->getErrors();
        $this->assertEquals('detail level "999" is invalid for account report type', $responseErrors[0]);
    }

    public function test_getProfessionalReportId_With_InvalidUnitOfTime_Should_ReturnErrors()
    {
        $reportService = new ReportService($this->fakeGoodAuthHeaders);
        $startDate = new DateTime('2017-06-01 00:00:00');
        $endDate = new DateTime('2017-06-30 23:59:59');
        $goodReportType = 'account';
        $goodDetailLevel = 2;
        $badUnitOfTime = 999;

        $reportServiceResponse = $reportService->getProfessionalReportId($startDate, $endDate, $goodReportType, $goodDetailLevel, $badUnitOfTime);

        $responseStatus = $reportServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $reportServiceResponse->getErrors();
        $this->assertEquals('unit of time "999" is invalid for account report type', $responseErrors[0]);
    }
}
