<?php

namespace BaiduOpen\Tuiguang;

use BaiduOpen\Tuiguang\Helper\AuthHeaderBaidu;
use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\Helper\BaiduValidators;
use BaiduOpen\Tuiguang\Library\sms_service_AdgroupService;
use BaiduOpen\Tuiguang\Library\Adgroup\AdgroupType;
use BaiduOpen\Tuiguang\Library\Adgroup\AddAdgroupRequest;
use BaiduOpen\Tuiguang\Library\Adgroup\DeleteAdgroupRequest;
use BaiduOpen\Tuiguang\Library\Adgroup\GetAdgroupRequest;
use BaiduOpen\Tuiguang\Library\Adgroup\UpdateAdgroupRequest;

class AdgroupService
{
    /**
     * @var sms_service_AdgroupService|null
     */
    protected $baiduAdgroupService;

    /**
     * @var GetAdgroupRequest|null
     */
    protected $getAdgroupRequest;

    /**
     * @var AddAdgroupRequest|null
     */
    protected $addAdgroupRequest;

    /**
     * @var UpdateAdgroupRequest|null
     */
    protected $updateAdgroupRequest;

    /**
     * @var DeleteAdgroupRequest|null
     */
    protected $deleteAdgroupRequest;

    /**
     * AdgroupService constructor.
     * @param $authenticationHeaders
     * @param bool $isMcc
     * @param sms_service_AdgroupService|null $baiduAdgroupService
     * @param GetAdgroupRequest|null $getAdgroupRequest
     * @param AddAdgroupRequest|null $addAdgroupRequest
     * @param UpdateAdgroupRequest|null $updateAdgroupRequest
     * @param DeleteAdgroupRequest|null $deleteAdgroupRequest
     */
    public function __construct(
        $authenticationHeaders,
        $isMcc = false,
        sms_service_AdgroupService $baiduAdgroupService = null,
        GetAdgroupRequest $getAdgroupRequest = null,
        AddAdgroupRequest $addAdgroupRequest = null,
        UpdateAdgroupRequest $updateAdgroupRequest = null,
        DeleteAdgroupRequest $deleteAdgroupRequest = null
    ) {
        $this->baiduAdgroupService = $baiduAdgroupService ? $baiduAdgroupService : new sms_service_AdgroupService();
        $this->baiduAdgroupService->authHeader = AuthHeaderBaidu::updateAuthentication($isMcc, $authenticationHeaders);
        $this->baiduAdgroupService->setIsJson(true);

        $this->getAdgroupRequest = $getAdgroupRequest ? $getAdgroupRequest : new GetAdgroupRequest();
        $this->addAdgroupRequest = $addAdgroupRequest ? $addAdgroupRequest : new AddAdgroupRequest();
        $this->updateAdgroupRequest = $updateAdgroupRequest ? $updateAdgroupRequest : new UpdateAdgroupRequest();
        $this->deleteAdgroupRequest = $deleteAdgroupRequest ? $deleteAdgroupRequest : new DeleteAdgroupRequest();
    }

    /**
     * @param $campaignId
     * @param $adgroupOptions
     * @param $maxPrice
     * @return bool|BaiduResponse
     */
    public function addAdGroups($campaignId, $adgroupOptions, $maxPrice)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments($this, 'addAdGroups', func_get_args());
        if ($validationErrors) return $validationErrors;

        $baiduAdgroupCollection = [];

        foreach ($adgroupOptions as $key => $adgroupOption) {
            $baiduAdgroup = new AdgroupType();
            $validationErrors = BaiduValidators::validateEmptyField(
                $adgroupOption[BaiduParams::ADGROUP_NAME],
                BaiduParams::ADGROUP_NAME . ' [' . $key . ']'
            );
            if ($validationErrors) return $validationErrors;

            $baiduAdgroup->setAdgroupName($adgroupOption[BaiduParams::ADGROUP_NAME]);

            if (!empty($adgroupOption[BaiduParams::KEYWORD_NEGATIVE])) {
                $baiduAdgroup->setNegativeWords($adgroupOption[BaiduParams::KEYWORD_NEGATIVE]);
            }

            if (!empty($adgroupOption[BaiduParams::KEYWORD_NEGATIVE_EXACT])) {
                $baiduAdgroup->setExactNegativeWords($adgroupOption[BaiduParams::KEYWORD_NEGATIVE_EXACT]);
            }

            $baiduAdgroup->setCampaignId($campaignId);
            $baiduAdgroup->setMaxPrice($maxPrice);
            array_push($baiduAdgroupCollection, $baiduAdgroup);
        }

        $this->addAdgroupRequest->setAdgroupTypes($baiduAdgroupCollection);
        $response = $this->baiduAdgroupService->addAdgroup($this->addAdgroupRequest);
        $jsonHeader = $this->baiduAdgroupService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('addAdGroups executed');
        return $baiduResponse;
    }

    /**
     * @param $adgroupOptions
     * @return bool|BaiduResponse
     */
    public function updateAdGroups($adgroupOptions)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments(
            $this,
            'updateAdGroups',
            func_get_args()
        );
        if ($validationErrors) return $validationErrors;

        $adgroupTypeCollection = array();

        foreach ($adgroupOptions as $adgroupOption) {
            $validationErrors = BaiduValidators::validateEmptyField(
                $adgroupOption[BaiduParams::ADGROUP_ID],
                BaiduParams::ADGROUP_ID
            );
            if ($validationErrors) return $validationErrors;

            $adgroupType = new AdgroupType();
            $adgroupType->setAdgroupId($adgroupOption[BaiduParams::ADGROUP_ID]);

            if (!empty($adGroup[BaiduParams::KEYWORD_NEGATIVE])) {
                $adgroupType->setNegativeWords($adgroupOption[BaiduParams::KEYWORD_NEGATIVE]);
            }

            if (!empty($adGroup[BaiduParams::KEYWORD_NEGATIVE_EXACT])) {
                $adgroupType->setExactNegativeWords($adgroupOption[BaiduParams::KEYWORD_NEGATIVE_EXACT]);
            }

            array_push($adgroupTypeCollection, $adgroupType);
        }

        $this->updateAdgroupRequest->setAdgroupTypes($adgroupTypeCollection);
        $response = $this->baiduAdgroupService->updateAdgroup($this->updateAdgroupRequest);
        $jsonHeader = $this->baiduAdgroupService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('updateAdgroups executed');
        return $baiduResponse;
    }
}
