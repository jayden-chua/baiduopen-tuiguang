<?php

namespace Tests\BaiduOpen;

use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\KeywordService;
use PHPUnit\Framework\TestCase;

class KeywordServiceTest extends TestCase
{
    protected $fakeGoodAuthHeaders;
    protected $fakeGoodKeywordOptions;
    protected $fakeEmptyKeywordOptions;
    protected $fakeHugeKeywordOptions;

    protected function setUp()
    {
        $this->fakeGoodAuthHeaders = [
            'username' => 'abc',
            'password' => 'abc',
            'token' => 'abc',
        ];

        $this->fakeGoodKeywordOptions = ['abc', 'def', 'ghi'];
        $this->fakeEmptyKeywordOptions = '';
        $this->fakeHugeKeywordOptions = array_fill(0, 10001, 'a');
    }

    public function test_addKeywords_Should_Fail_When_CampaignId_Is_Empty()
    {
        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->addKeywords('', 'abc', $this->fakeGoodKeywordOptions);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY[BaiduParams::CAMPAIGN_ID], $responseErrors));
    }

    public function test_addKeywords_Should_Fail_When_AdgroupId_Is_Empty()
    {
        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->addKeywords('abc', '', $this->fakeGoodKeywordOptions);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY[BaiduParams::ADGROUP_ID], $responseErrors));
    }

    public function test_addKeywords_Should_Fail_When_KeywordOptions_Is_Empty()
    {
        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->addKeywords('abc', '123', $this->fakeEmptyKeywordOptions);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY[BaiduParams::OPTIONS_KEYWORD], $responseErrors));
    }

    public function test_addKeywords_Should_Fail_When_Any_Keyword_Is_Empty()
    {
        $oneMissingKeywordKeywordOptions = ['abc', '123', ''];

        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->addKeywords('abc', '123', $oneMissingKeywordKeywordOptions);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array(
            'keyword [2] cannot be empty',
            $responseErrors)
        );
    }

    public function test_addKeywords_Should_Fail_When_Any_KeywordOptions_Size_Is_Greater_Than_10000()
    {
        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->addKeywords('abc', '123', $this->fakeHugeKeywordOptions);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array('keywordOptions size (10001) is not between 0 and 10000', $responseErrors)
        );
    }

    public function test_deleteKeywords_Should_Fail_When_KeywordIds_Is_Empty()
    {
        $emptyIds = [];

        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->deleteKeywords($emptyIds);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array(BaiduParams::ERROR_EMPTY[BaiduParams::OPTIONS_KEYWORD_IDS], $responseErrors)
        );
    }

    public function test_deleteKeywords_Should_Fail_When_KeywordIds_Size_Is_Greater_Than_10000()
    {
        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->deleteKeywords($this->fakeHugeKeywordOptions);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array('keywordIds size (10001) is not between 0 and 10000', $responseErrors)
        );
    }

    public function test_deleteKeywords_Should_Fail_When_Any_KeywordId_Is_Empty()
    {
        $keywordIds = ['abc', 'def', ''];
        $keywordService = new KeywordService($this->fakeGoodAuthHeaders);
        $keywordServiceResponse = $keywordService->deleteKeywords($keywordIds);

        $responseStatus = $keywordServiceResponse->getStatus();
        $this->assertEquals(BaiduResponse::VALIDATION_FAILED, $responseStatus);

        $responseErrors = $keywordServiceResponse->getErrors();
        $this->assertTrue(in_array('keywordId [2] cannot be empty', $responseErrors)
        );
    }

    // TODO: to create more test case for output of request object before sending to baidu
}
