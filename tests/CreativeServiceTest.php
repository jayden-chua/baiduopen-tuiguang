<?php

namespace Tests\BaiduOpen;

use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\CreativeService;
use PHPUnit\Framework\TestCase;

class CreativeServiceTest extends TestCase
{
    protected $fakeGoodAuthHeaders;
    protected $fakeHugeCreativeOptions;
    protected $fakeEmptyCreativeOptions;

    protected function setUp()
    {
        $this->fakeGoodAuthHeaders = [
            'username' => 'abc',
            'password' => 'abc',
            'token' => 'abc',
        ];

        $this->fakeHugeCreativeOptions = array_fill(0, 3001, 'abc');

        $this->fakeEmptyCreativeOptions = [];
    }

    public function test_addCreatives_Should_Fail_When_CampaignId_Is_Empty()
    {
        $creativeOptions = ['abc', 'abc', 'abc'];

        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->addCreatives('', 'def', $creativeOptions);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(in_array(
            BaiduParams::ERROR_EMPTY[BaiduParams::CAMPAIGN_ID],
            $responseErrors)
        );
    }

    public function test_addCreatives_Should_Fail_When_AdgroupId_Is_Empty()
    {
        $creativeOptions = ['abc', 'abc', 'abc'];

        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->addCreatives('abc', '', $creativeOptions);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(in_array(
                              BaiduParams::ERROR_EMPTY[BaiduParams::ADGROUP_ID],
                              $responseErrors)
        );
    }

    public function test_addCreatives_Should_Fail_When_CreativeOptions_Is_Empty()
    {
        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->addCreatives('abc', 'def', $this->fakeEmptyCreativeOptions);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::ERROR_EMPTY[BaiduParams::OPTIONS_CREATIVE],
                $responseErrors
            )
        );
    }

    public function test_addCreative_Should_Fail_When_Title_Or_Descriptions_Are_Empty()
    {
        $emptyTitleCreativeOption = [
            [
              BaiduParams::CREATIVE_TITLE => '',
              BaiduParams::CREATIVE_DESCRIPTION_1 => 'abc',
              BaiduParams::CREATIVE_DESCRIPTION_2 => 'abc',
            ],
        ];

        $emptyDesc1CreativeOption = [
            [
                BaiduParams::CREATIVE_TITLE => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_1 => '',
                BaiduParams::CREATIVE_DESCRIPTION_2 => 'abc',
            ],
        ];

        $emptyDesc2CreativeOption = [
            [
                BaiduParams::CREATIVE_TITLE => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_1 => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_2 => '',
            ],
        ];

        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponseEmptyId = $creativeService->addCreatives('abc', 'def', $emptyTitleCreativeOption);
        $creativeResponseEmptyDesc1 = $creativeService->addCreatives('abc', 'def', $emptyDesc1CreativeOption);
        $creativeResponseEmptyDesc2 = $creativeService->addCreatives('abc', 'def', $emptyDesc2CreativeOption);

        $responseStatus1 = $creativeResponseEmptyId->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus1);

        $responseErrors1 = $creativeResponseEmptyId->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_TITLE . ' [0] cannot be empty',
                $responseErrors1
            )
        );

        $responseStatus2 = $creativeResponseEmptyDesc1->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus2);

        $responseErrors2 = $creativeResponseEmptyDesc1->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_DESCRIPTION_1 . ' [0] cannot be empty',
                $responseErrors2
            )
        );

        $responseStatus3 = $creativeResponseEmptyDesc2->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus3);

        $responseErrors3 = $creativeResponseEmptyDesc2->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_DESCRIPTION_2 . ' [0] cannot be empty',
                $responseErrors3
            )
        );
    }

    public function test_addCreative_Should_Fail_When_CreativeOptions_Size_Is_Bigger_Than_3000()
    {
        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->addCreatives('abc', 'def', $this->fakeHugeCreativeOptions);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::OPTIONS_CREATIVE . ' size (3001) is not between 0 and 3000',
                $responseErrors
            )
        );
    }

    public function test_updateCreatives_Should_Fail_When_CreativeOptions_Is_Empty()
    {
        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->updateCreatives($this->fakeEmptyCreativeOptions);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::ERROR_EMPTY[BaiduParams::OPTIONS_CREATIVE],
                $responseErrors
            )
        );
    }

    public function test_updateCreatives_Should_Fail_When_CreativeOptions_Size_Is_Bigger_Than_3000()
    {
        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->updateCreatives($this->fakeHugeCreativeOptions);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::OPTIONS_CREATIVE . ' size (3001) is not between 0 and 3000',
                $responseErrors
            )
        );
    }

    public function test_updateCreative_Should_Fail_When_CreativeId_Or_Descriptions_Are_Empty()
    {
        $emptyIdCreativeOption = [
            [
                BaiduParams::CREATIVE_ID => '',
                BaiduParams::CREATIVE_TITLE => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_1 => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_2 => 'abc',
            ],
        ];

        $emptyTitleCreativeOption = [
            [
                BaiduParams::CREATIVE_ID => 'abc',
                BaiduParams::CREATIVE_TITLE => '',
                BaiduParams::CREATIVE_DESCRIPTION_1 => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_2 => 'abc',
            ],
        ];

        $emptyDesc1CreativeOption = [
            [
                BaiduParams::CREATIVE_ID => 'abc',
                BaiduParams::CREATIVE_TITLE => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_1 => '',
                BaiduParams::CREATIVE_DESCRIPTION_2 => 'abc',
            ],
        ];

        $emptyDesc2CreativeOption = [
            [
                BaiduParams::CREATIVE_ID => 'abc',
                BaiduParams::CREATIVE_TITLE => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_1 => 'abc',
                BaiduParams::CREATIVE_DESCRIPTION_2 => '',
            ],
        ];

        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponseEmptyId = $creativeService->updateCreatives($emptyIdCreativeOption);
        $creativeResponseEmptyTitle = $creativeService->updateCreatives($emptyTitleCreativeOption);
        $creativeResponseEmptyDesc1 = $creativeService->updateCreatives($emptyDesc1CreativeOption);
        $creativeResponseEmptyDesc2 = $creativeService->updateCreatives($emptyDesc2CreativeOption);

        $responseStatus = $creativeResponseEmptyId->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponseEmptyId->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_ID . ' [0] cannot be empty',
                $responseErrors
            )
        );

        $responseStatus1 = $creativeResponseEmptyTitle->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus1);

        $responseErrors1 = $creativeResponseEmptyTitle->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_TITLE . ' [0] cannot be empty',
                $responseErrors1
            )
        );

        $responseStatus2 = $creativeResponseEmptyDesc1->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus2);

        $responseErrors2 = $creativeResponseEmptyDesc1->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_DESCRIPTION_1 . ' [0] cannot be empty',
                $responseErrors2
            )
        );

        $responseStatus3 = $creativeResponseEmptyDesc2->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus3);

        $responseErrors3 = $creativeResponseEmptyDesc2->getErrors();
        $this->assertTrue(
            in_array(
                BaiduParams::CREATIVE_DESCRIPTION_2 . ' [0] cannot be empty',
                $responseErrors3
            )
        );
    }

    public function test_deleteCreative_Should_Fail_When_CreativeId_Is_Empty()
    {
        $emptyCreativeId = [];

        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->deleteCreatives($emptyCreativeId);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(in_array(
                              BaiduParams::ERROR_EMPTY[BaiduParams::OPTIONS_CREATIVE_IDS],
                              $responseErrors)
        );
    }

    public function test_deleteCreatives_Should_Fail_When_CreativeIds_Size_Is_Bigger_Than_10000()
    {
        $fakeHugeCreativeIds = array_fill(0, 10001, 'a');
        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->deleteCreatives($fakeHugeCreativeIds);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(
            in_array(
                'creativeIds size (10001) is not between 0 and 10000',
                $responseErrors
            )
        );
    }

    public function test_deleteCreative_Should_Fail_When_Some_CreativeId_Is_Empty()
    {
        $emptyCreativeId = ['1111', '222', ''];

        $creativeService = new CreativeService($this->fakeGoodAuthHeaders);
        $creativeResponse = $creativeService->deleteCreatives($emptyCreativeId);

        $responseStatus = $creativeResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $creativeResponse->getErrors();
        $this->assertTrue(in_array(
            'creativeId [2] cannot be empty',
            $responseErrors)
        );
    }

    // TODO: to create more test case for max field lengths especially for urls and adnames
    // TODO: to create more test case for output of request object before sending to baidu
}
