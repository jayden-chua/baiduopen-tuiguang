<?php

namespace BaiduOpen\Tuiguang;

use BaiduOpen\Tuiguang\Helper\AuthHeaderBaidu;
use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\Helper\BaiduValidators;
use BaiduOpen\Tuiguang\Library\sms_service_CampaignService;
use BaiduOpen\Tuiguang\Library\Campaign\CampaignType;
use BaiduOpen\Tuiguang\Library\Campaign\AddCampaignRequest;
use BaiduOpen\Tuiguang\Library\Campaign\DeleteCampaignRequest;
use BaiduOpen\Tuiguang\Library\Campaign\GetCampaignRequest;
use BaiduOpen\Tuiguang\Library\Campaign\UpdateCampaignRequest;

class CampaignService
{
    /**
     * @var sms_service_CampaignService|null
     */
    protected $baiduCampaignService;

    /**
     * @var GetCampaignRequest|null
     */
    protected $getCampaignRequest;

    /**
     * @var AddCampaignRequest|null
     */
    protected $addCampaignRequest;

    /**
     * @var UpdateCampaignRequest|null
     */
    protected $updateCampaignRequest;

    /**
     * @var DeleteCampaignRequest|null
     */
    protected $deleteCampaignRequest;

    /**
     * CampaignService constructor.
     * @param $authenticationHeaders
     * @param bool $isMcc
     * @param sms_service_CampaignService|null $baiduCampaignService
     * @param GetCampaignRequest|null $getCampaignRequest
     * @param AddCampaignRequest|null $addCampaignRequest
     * @param UpdateCampaignRequest|null $updateCampaignRequest
     * @param DeleteCampaignRequest|null $deleteCampaignRequest
     */
    public function __construct(
        $authenticationHeaders,
        $isMcc = false,
        sms_service_CampaignService $baiduCampaignService = null,
        GetCampaignRequest $getCampaignRequest = null,
        AddCampaignRequest $addCampaignRequest = null,
        UpdateCampaignRequest $updateCampaignRequest = null,
        DeleteCampaignRequest $deleteCampaignRequest = null
    ) {
        $this->baiduCampaignService = $baiduCampaignService ? $baiduCampaignService : new sms_service_CampaignService();
        $this->baiduCampaignService->authHeader = AuthHeaderBaidu::updateAuthentication($isMcc, $authenticationHeaders);
        $this->baiduCampaignService->setIsJson(true);

        $this->getCampaignRequest = $getCampaignRequest ? $getCampaignRequest : new GetCampaignRequest();
        $this->addCampaignRequest = $addCampaignRequest ? $addCampaignRequest : new AddCampaignRequest();
        $this->updateCampaignRequest = $updateCampaignRequest ? $updateCampaignRequest : new UpdateCampaignRequest();
        $this->deleteCampaignRequest = $deleteCampaignRequest ? $deleteCampaignRequest : new DeleteCampaignRequest();
    }

    /**
     * @param $campaignOptions
     * @param bool $campaignPause
     * @return bool|BaiduResponse
     */
    public function createBaiduCampaigns($campaignOptions, $campaignPause = false)
    {
        $validationErrors = BaiduValidators::validateEmptyField(
          $campaignOptions,
          'campaignOptions'
        );
        if ($validationErrors) return $validationErrors;

        $campaignCollection = [];

        foreach ($campaignOptions as $key => $campaignOption) {
            $singleCampaign = new CampaignType();

            // Baidu expects campaign names no longer than 30 bytes
            $validationErrors = BaiduValidators::validateFieldLength(
                $campaignOption[BaiduParams::CAMPAIGN_NAME],
                BaiduParams::CAMPAIGN_NAME . ' [' . $key . ']'
            );
            if ($validationErrors) return $validationErrors;

            $singleCampaign->setCampaignName($campaignOption[BaiduParams::CAMPAIGN_NAME]);

            if (isset($campaignOption[BaiduParams::KEYWORD_NEGATIVE]) &&
                !empty($campaignOption[BaiduParams::KEYWORD_NEGATIVE])) {
                $singleCampaign->setNegativeWords(array_values($campaignOption[BaiduParams::KEYWORD_NEGATIVE]));
            }

            if (isset($campaignOption[BaiduParams::KEYWORD_NEGATIVE_EXACT]) &&
                !empty($campaignOption[BaiduParams::KEYWORD_NEGATIVE_EXACT])) {
                $singleCampaign->setExactNegativeWords($campaignOption[BaiduParams::KEYWORD_NEGATIVE_EXACT]);
            }

            if (isset($campaignOption[BaiduParams::REGION_TARGET]) &&
                !empty($campaignOption[BaiduParams::REGION_TARGET])) {
                $singleCampaign->setRegionTarget($campaignOption[BaiduParams::REGION_TARGET]);
            }

            if ($campaignPause === true) {
                $singleCampaign->setPause(true);
            }

            array_push($campaignCollection, $singleCampaign);
        }

        $this->addCampaignRequest->setCampaignTypes($campaignCollection);
        $response = $this->baiduCampaignService->addCampaign($this->addCampaignRequest);
        $jsonHeader = $this->baiduCampaignService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('createCampaign executed');
        return $baiduResponse;
    }

    /**
     * @param $campaignOptions
     * @param bool $campaignPause
     * @return BaiduResponse
     */
    public function updateBaiduCampaign($campaignOptions, $campaignPause = false)
    {

        $validationErrors = BaiduValidators::validateEmptyField(
            $campaignOptions,
            'campaignOptions'
        );
        if ($validationErrors) return $validationErrors;

        $campaignTypeCollection = [];

        foreach ($campaignOptions as $key => $campaignOption) {
            $campaignType = new CampaignType();

            if (isset($campaignOption[BaiduParams::CAMPAIGN_ID]) &&
                !empty($campaignOption[BaiduParams::CAMPAIGN_ID])) {
                $campaignType->setCampaignId($campaignOption[BaiduParams::CAMPAIGN_ID]);
            }

            if (isset($campaignOption[BaiduParams::CAMPAIGN_NAME]) &&
                !empty($campaignOption[BaiduParams::CAMPAIGN_NAME])) {

                $validationErrors = BaiduValidators::validateFieldLength(
                    $campaignOption[BaiduParams::CAMPAIGN_NAME],
                    BaiduParams::CAMPAIGN_NAME . ' [' . $key . ']'
                );

                if ($validationErrors) return $validationErrors;

                $campaignType->setCampaignName($campaignOption[BaiduParams::CAMPAIGN_NAME]);
            }

            if (isset($campaignOption[BaiduParams::KEYWORD_NEGATIVE]) &&
                !empty($campaignOption[BaiduParams::KEYWORD_NEGATIVE])) {
                $campaignType->setNegativeWords(array_values($campaignOption[BaiduParams::KEYWORD_NEGATIVE]));
            }

            if (isset($campaignOption[BaiduParams::KEYWORD_NEGATIVE_EXACT]) &&
                !empty($campaignOption[BaiduParams::KEYWORD_NEGATIVE_EXACT])) {
                $campaignType->setExactNegativeWords($campaignOption[BaiduParams::KEYWORD_NEGATIVE_EXACT]);
            }

            if (isset($campaignOption[BaiduParams::REGION_TARGET]) &&
                !empty($campaignOption[BaiduParams::REGION_TARGET])) {
                $campaignType->setRegionTarget($campaignOption[BaiduParams::REGION_TARGET]);
            }

            if (is_bool($campaignPause)) {
                $campaignType->setPause($campaignPause);
            }

            array_push($campaignTypeCollection, $campaignType);
        }

        $this->updateCampaignRequest->setCampaignTypes($campaignTypeCollection);

        $response = $this->baiduCampaignService->updateCampaign($this->updateCampaignRequest);
        $jsonHeader = $this->baiduCampaignService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('updateCampaign executed');
        return $baiduResponse;
    }
}
