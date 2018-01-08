<?php

namespace BaiduOpen\Tuiguang;

use BaiduOpen\Tuiguang\Helper\AuthHeaderBaidu;
use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\Helper\BaiduValidators;
use BaiduOpen\Tuiguang\Library\sms_service_KeywordService;
use BaiduOpen\Tuiguang\Library\Keyword\KeywordType;
use BaiduOpen\Tuiguang\Library\Keyword\AddWordRequest;
use BaiduOpen\Tuiguang\Library\Keyword\GetWordRequest;
use BaiduOpen\Tuiguang\Library\Keyword\DeleteWordRequest;
use BaiduOpen\Tuiguang\Library\Keyword\UpdateWordRequest;

class KeywordService
{
    /**
     * @var sms_service_KeywordService|null
     */
    protected $baiduKeywordService;

    /**
     * @var GetWordRequest|null
     */
    protected $getWordRequest;

    /**
     * @var AddWordRequest|null
     */
    protected $addWordRequest;

    /**
     * @var UpdateWordRequest|null
     */
    protected $updateWordRequest;

    /**
     * @var DeleteWordRequest|null
     */
    protected $deleteWordRequest;

    /**
     * KeywordService constructor.
     * @param $authenticationHeaders
     * @param bool $isMcc
     * @param sms_service_KeywordService|null $baiduKeywordService
     * @param GetWordRequest|null $getWordRequest
     * @param AddWordRequest|null $addWordRequest
     * @param UpdateWordRequest|null $updateWordRequest
     * @param DeleteWordRequest|null $deleteWordRequest
     */
    public function __construct(
        $authenticationHeaders,
        $isMcc = false,
        sms_service_KeywordService $baiduKeywordService = null,
        GetWordRequest $getWordRequest = null,
        AddWordRequest $addWordRequest = null,
        UpdateWordRequest $updateWordRequest = null,
        DeleteWordRequest $deleteWordRequest = null
    ) {
        $this->baiduKeywordService = $baiduKeywordService ? $baiduKeywordService : new sms_service_KeywordService();
        $this->baiduKeywordService->authHeader = AuthHeaderBaidu::updateAuthentication($isMcc, $authenticationHeaders);
        $this->baiduKeywordService->setIsJson(true);

        $this->getWordRequest = $getWordRequest ? $getWordRequest : new GetWordRequest();
        $this->addWordRequest = $addWordRequest ? $addWordRequest : new AddWordRequest();
        $this->updateWordRequest = $updateWordRequest ? $updateWordRequest : new UpdateWordRequest();
        $this->deleteWordRequest = $deleteWordRequest ? $deleteWordRequest : new DeleteWordRequest();
    }

    /**
     * @param $campaignId
     * @param $adgroupId
     * @param $keywordOptions
     * @return bool|BaiduResponse
     */
    public function addKeywords($campaignId, $adgroupId, $keywordOptions)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments(
            $this,
            'addKeywords',
            func_get_args()
        );
        if ($validationErrors) return $validationErrors;

        $validationErrors = BaiduValidators::validateArraySize(
            $keywordOptions,
            BaiduParams::OPTIONS_KEYWORD,
            BaiduParams::MAX_NUMBER_ADD_KEYWORD
        );
        if ($validationErrors) return $validationErrors;

        $keywordTypeCollection = [];

        foreach ($keywordOptions as $key => $keywordOption) {
            $validationErrors = BaiduValidators::validateEmptyField(
                $keywordOption,
                BaiduParams::KEYWORD . ' [' . $key . ']'
            );
            if ($validationErrors) return $validationErrors;

            $keywordType = new KeywordType();
            $keywordType->setCampaignId($campaignId);
            $keywordType->setAdgroupId($adgroupId);
            $keywordType->setKeyword($keywordOption);
            array_push($keywordTypeCollection, $keywordType);
        }

        $this->addWordRequest->setKeywordTypes($keywordTypeCollection);
        $response = $this->baiduKeywordService->addWord($this->addWordRequest);
        $jsonHeader = $this->baiduKeywordService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('addKeywords executed');
        return $baiduResponse;
    }

    /**
     * @param $keywordIds
     * @return bool|BaiduResponse
     */
    public function deleteKeywords($keywordIds)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments(
            $this,
            'deleteKeywords',
            func_get_args()
        );
        if ($validationErrors) return $validationErrors;

        $validationErrors = BaiduValidators::validateArraySize(
            $keywordIds,
            BaiduParams::OPTIONS_KEYWORD_IDS,
            BaiduParams::MAX_NUMBER_DELETE_KEYWORD
        );
        if ($validationErrors) return $validationErrors;

        $keywordIdCollection = [];

        foreach ($keywordIds as $key => $keywordId) {
            $validationErrors = BaiduValidators::validateEmptyField(
                $keywordId,
                BaiduParams::KEYWORD_ID . ' [' . $key . ']');
            if ($validationErrors) return $validationErrors;
            array_push($keywordIdCollection, $keywordId);
        }

        $this->deleteWordRequest->setKeywordIds($keywordIdCollection);
        $response = $this->baiduKeywordService->deleteWord($this->deleteWordRequest);
        $jsonHeader = $this->baiduKeywordService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('deleteKeywords executed');
        return $baiduResponse;
    }
}
