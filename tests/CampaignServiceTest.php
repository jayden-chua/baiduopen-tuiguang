<?php

namespace Tests\BaiduOpen;

use BaiduOpen\Tuiguang\Library\sms_service_CampaignService;
use BaiduOpen\Tuiguang\Library\Campaign\AddCampaignRequest;
use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\CampaignService;
use PHPUnit\Framework\TestCase;

class CampaignServiceTest extends TestCase
{
    protected $fakeGoodAuthHeaders;
    protected $fakeGoodCampaignOption;
    protected $fakeBadCampaignOptionsWithLongCampaignNames;

    protected function setUp()
    {
        $longCampaignName = '1234567890123456789012345678901'; // greater than 30bytes
        $shortCampaignNameA = '123456789012345678901234567890'; // equals 30bytes
        $shortCampaignNameB = 'ABC'; // less than 30bytes

        $this->fakeGoodAuthHeaders = [
            'username' => 'abc',
            'password' => 'abc',
            'token' => 'abc',
        ];

        $this->fakeGoodCampaignOption = [
            [BaiduParams::CAMPAIGN_NAME => $shortCampaignNameA],
            [BaiduParams::CAMPAIGN_NAME => $shortCampaignNameB],
        ];

        $this->fakeBadCampaignOptionsWithLongCampaignNames = [
            [BaiduParams::CAMPAIGN_NAME => $shortCampaignNameA],
            [BaiduParams::CAMPAIGN_NAME => $longCampaignName],
        ];
    }

    public function test_createCampaign_Should_Fail_When_CampaignOptions_Are_Empty()
    {
        $campaignOptions = [];

        $campaignService = new CampaignService($this->fakeGoodAuthHeaders);
        $campaignResponse = $campaignService->createBaiduCampaigns($campaignOptions);

        $responseStatus = $campaignResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $campaignResponse->getErrors();
        $this->assertTrue(in_array('campaignOptions cannot be empty', $responseErrors));
    }

    public function test_createCampaign_Should_Fail_When_CampaignName_Is_Too_Long()
    {
        $campaignService = new CampaignService($this->fakeGoodAuthHeaders);
        $campaignResponse = $campaignService->createBaiduCampaigns($this->fakeBadCampaignOptionsWithLongCampaignNames);

        $responseStatus = $campaignResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $campaignResponse->getErrors();
        $this->assertTrue(in_array('campaignName [1] is greater than 30 bytes', $responseErrors));
    }

    public function test_createCampaign_DI()
    {
        $mockAddRequestCampaign = $this->getMockBuilder(AddCampaignRequest::class)
                                       ->setMethods(['setCampaignTypes'])
                                       ->getMock();

        $mockAddRequestCampaign->expects($this->once())
                                ->method('setCampaignTypes');

        $testObject = (object) ['body' => '', 'desc' => '', 'data' => '', 'failures' => ''];
        $blahMock = $this->createMock(sms_service_CampaignService::class);

        $blahMock->method('addCampaign')
            ->willReturn($testObject);

        $blahMock->method('getJsonHeader')
            ->willReturn($testObject);

        $campaignService = new CampaignService($this->fakeGoodAuthHeaders, false, $blahMock, null, $mockAddRequestCampaign);
        $campaignService->createBaiduCampaigns($this->fakeGoodCampaignOption);
    }

    // TODO: to create more test case for output of request object before sending to baidu
}
