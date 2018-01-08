<?php

namespace Tests\BaiduOpen;

use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\AdgroupService;
use PHPUnit\Framework\TestCase;

class AdgroupServiceTest extends TestCase
{
    protected $fakeGoodAuthHeaders;
    protected $fakeGoodAdgroupOption;
    protected $fakeBadAdgroupOptionsWithLongAdgroupNames;

    protected function setUp()
    {
        $longAdgroupName = '1234567890123456789012345678901'; // greater than 30bytes
        $shortAdgroupNameA = '123456789012345678901234567890'; // equals 30bytes
        $shortAdgroupNameB = 'ABC'; // less than 30bytes

        $this->fakeGoodAuthHeaders = [
            'username' => 'abc',
            'password' => 'abc',
            'token' => 'abc',
        ];

        $this->fakeGoodAdgroupOption = [
            [
                'campaignId' => '1',
                'adgroupName' => $shortAdgroupNameA,
                'maxPrice' => '10',
            ],
            [
                'campaignId' => '2',
                'adgroupName' => $shortAdgroupNameB,
                'maxPrice' => '10',
            ],
        ];

        $this->fakeBadAdgroupOptionsWithLongAdgroupNames = [
            [
                'campaignId' => '1',
                'adgroupName' => $shortAdgroupNameA,
                'maxPrice' => '10',
            ],
            [
                'campaignId' => '2',
                'adgroupName' => $longAdgroupName,
                'maxPrice' => '10',
            ],
        ];
    }

    public function test_addAdGroups_Should_Fail_When_Options_Are_Empty()
    {
        $emptyAdgroupOptions = [];

        $adgroupService = new AdgroupService($this->fakeGoodAuthHeaders);
        $adgroupResponse = $adgroupService->addAdGroups('abc', $emptyAdgroupOptions, 123);

        $responseStatus = $adgroupResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $adgroupResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY['adgroupOptions'], $responseErrors));
    }

    public function test_addAdGroups_Should_Fail_When_CampaignId_Is_Empty()
    {
        $adgroupService = new AdgroupService($this->fakeGoodAuthHeaders);
        $adgroupResponse = $adgroupService->addAdGroups('', $this->fakeGoodAdgroupOption, 123);

        $responseStatus = $adgroupResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $adgroupResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY['campaignId'], $responseErrors));
    }

    public function test_addAdGroups_Should_Fail_When_Max_Price_Is_Empty()
    {
        $adgroupService = new AdgroupService($this->fakeGoodAuthHeaders);
        $adgroupResponse = $adgroupService->addAdGroups('123', $this->fakeGoodAdgroupOption, '');

        $responseStatus = $adgroupResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $adgroupResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY['maxPrice'], $responseErrors));
    }

    public function test_updateAdGroups_Should_Fail_When_Options_Are_Empty()
    {
        $emptyAdgroupOptions = [];

        $adgroupService = new AdgroupService($this->fakeGoodAuthHeaders);
        $adgroupResponse = $adgroupService->updateAdGroups($emptyAdgroupOptions);

        $responseStatus = $adgroupResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $adgroupResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY['adgroupOptions'], $responseErrors));
    }

    public function test_updateAdGroups_Should_Fail_When_Any_Adgroup_Id_Is_Empty()
    {
        $adgroupOptions = [
            [BaiduParams::ADGROUP_ID => ''],
        ];

        $adgroupService = new AdgroupService($this->fakeGoodAuthHeaders);
        $adgroupResponse = $adgroupService->updateAdGroups($adgroupOptions);

        $responseStatus = $adgroupResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $adgroupResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ADGROUP_ID . ' cannot be empty', $responseErrors));
    }

    // TODO: to create more test case for output of request object before sending to baidu
}
