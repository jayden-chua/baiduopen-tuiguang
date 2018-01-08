<?php

namespace BaiduOpen\Tuiguang;

use BaiduOpen\Tuiguang\Helper\AuthHeaderBaidu;
use BaiduOpen\Tuiguang\Helper\BaiduParams;
use BaiduOpen\Tuiguang\Helper\BaiduResponse;
use BaiduOpen\Tuiguang\Helper\BaiduValidators;
use BaiduOpen\Tuiguang\Library\sms_service_CreativeService;
use BaiduOpen\Tuiguang\Library\Creative\CreativeType;
use BaiduOpen\Tuiguang\Library\Creative\AddCreativeRequest;
use BaiduOpen\Tuiguang\Library\Creative\DeleteCreativeRequest;
use BaiduOpen\Tuiguang\Library\Creative\GetCreativeRequest;
use BaiduOpen\Tuiguang\Library\Creative\UpdateCreativeRequest;

class CreativeService
{
    /**
     * @var sms_service_CreativeService
     */
    protected $baiduCreativeService;

    /**
     * @var GetCreativeRequest
     */
    protected $getCreativeRequest;

    /**
     * @var AddCreativeRequest
     */
    protected $addCreativeRequest;

    /**
     * @var UpdateCreativeRequest
     */
    protected $updateCreativeRequest;

    /**
     * @var DeleteCreativeRequest
     */
    protected $deleteCreativeRequest;

    public function __construct(
        $authenticationHeaders,
        $isMcc = false,
        sms_service_CreativeService $baiduCreativeService = null,
        GetCreativeRequest $getCreativeRequest = null,
        AddCreativeRequest $addCreativeRequest = null,
        UpdateCreativeRequest $updateCreativeRequest = null,
        DeleteCreativeRequest $deleteCreativeRequest = null
    ) {
        $this->baiduCreativeService = $baiduCreativeService ? $baiduCreativeService : new sms_service_CreativeService();
        $this->baiduCreativeService->authHeader = AuthHeaderBaidu::updateAuthentication($isMcc, $authenticationHeaders);
        $this->baiduCreativeService->setIsJson(true);

        $this->getCreativeRequest = $getCreativeRequest ? $getCreativeRequest : new GetCreativeRequest();
        $this->addCreativeRequest = $addCreativeRequest ? $addCreativeRequest : new AddCreativeRequest();
        $this->updateCreativeRequest = $updateCreativeRequest ? $updateCreativeRequest : new UpdateCreativeRequest();
        $this->deleteCreativeRequest = $deleteCreativeRequest ? $deleteCreativeRequest : new DeleteCreativeRequest();
    }

    /**
     * @param $campaignId
     * @param $adgroupId
     * @param $creativeOptions
     * @return bool|BaiduResponse
     */
    public function addCreatives($campaignId, $adgroupId, $creativeOptions)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments(
            $this,
            'addCreatives',
            func_get_args()
        );
        if ($validationErrors) return $validationErrors;

        // Baidu requires that no more than 3000 be added per upload
        $validationErrors = BaiduValidators::validateArraySize(
            $creativeOptions,
            BaiduParams::OPTIONS_CREATIVE,
            BaiduParams::MAX_NUMBER_ADD_CREATIVE
        );
        if ($validationErrors) return $validationErrors;

        $creativeTypeCollection = [];
        foreach ($creativeOptions as $key => $creativeOption) {
            $requiredFields = [
                [
                    'name' => BaiduParams::CREATIVE_TITLE . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_TITLE]
                ],
                [
                    'name' => BaiduParams::CREATIVE_DESCRIPTION_1 . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_DESCRIPTION_1]
                ],
                [
                    'name' => BaiduParams::CREATIVE_DESCRIPTION_2 . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_DESCRIPTION_2]
                ]
            ];
            $validationErrors = BaiduValidators::validateEmptyFieldArray($requiredFields);
            if ($validationErrors) return $validationErrors;

            $creativeType = new CreativeType();
            $creativeType->setCampaignId($campaignId);
            $creativeType->setAdgroupId($adgroupId);
            $creativeType->setTitle($creativeOption[BaiduParams::CREATIVE_TITLE]);
            $creativeType->setDescription1($creativeOption[BaiduParams::CREATIVE_DESCRIPTION_1]);
            $creativeType->setDescription2($creativeOption[BaiduParams::CREATIVE_DESCRIPTION_2]);

            if (isset($creativeOption[BaiduParams::CREATIVE_PC_DEST_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_PC_DEST_URL])) {
                $creativeType->setPcDestinationUrl($creativeOption[BaiduParams::CREATIVE_PC_DEST_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_PC_DISP_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_PC_DISP_URL])) {
                $creativeType->setPcDisplayUrl($creativeOption[BaiduParams::CREATIVE_PC_DISP_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_MOBILE_DEST_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_MOBILE_DEST_URL])) {
                $creativeType->setMobileDestinationUrl($creativeOption[BaiduParams::CREATIVE_MOBILE_DEST_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_MOBILE_DISP_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_MOBILE_DISP_URL])) {
                $creativeType->setMobileDisplayUrl($creativeOption[BaiduParams::CREATIVE_MOBILE_DISP_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_PAUSE]) && !empty($creativeOption[BaiduParams::CREATIVE_PAUSE])) {
                $creativeType->setPause($creativeOption[BaiduParams::CREATIVE_PAUSE]);
            }

            array_push($creativeTypeCollection, $creativeType);
        }

        $this->addCreativeRequest->setCreativeTypes($creativeTypeCollection);
        $response = $this->baiduCreativeService->addCreative($this->addCreativeRequest);
        $jsonHeader = $this->baiduCreativeService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('addCreatives executed');
        return $baiduResponse;
    }

    /**
     * @param $creativeOptions
     * @return bool|BaiduResponse
     */
    public function updateCreatives($creativeOptions)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments(
            $this,
            'updateCreatives',
            func_get_args()
        );
        if ($validationErrors) return $validationErrors;

        // Baidu requires that no more than 3000 be added per upload
        $validationErrors = BaiduValidators::validateArraySize(
            $creativeOptions,
            BaiduParams::OPTIONS_CREATIVE,
            BaiduParams::MAX_NUMBER_ADD_CREATIVE
        );
        if ($validationErrors) return $validationErrors;

        $creativeTypeCollection = [];
        foreach ($creativeOptions as $key => $creativeOption) {
            $requiredFields = [
                [
                    'name' => BaiduParams::CREATIVE_ID . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_ID]
                ],
                [
                    'name' => BaiduParams::CREATIVE_TITLE . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_TITLE]
                ],
                [
                    'name' => BaiduParams::CREATIVE_DESCRIPTION_1 . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_DESCRIPTION_1]
                ],
                [
                    'name' => BaiduParams::CREATIVE_DESCRIPTION_2 . ' [' . $key . ']',
                    'value' => $creativeOption[BaiduParams::CREATIVE_DESCRIPTION_2]
                ]
            ];
            $validationErrors = BaiduValidators::validateEmptyFieldArray($requiredFields);
            if ($validationErrors) return $validationErrors;

            $creativeType = new CreativeType();
            $creativeType->setCreativeId($creativeOption[BaiduParams::CREATIVE_ID]);
            $creativeType->setTitle($creativeOption[BaiduParams::CREATIVE_TITLE]);
            $creativeType->setDescription1($creativeOption[BaiduParams::CREATIVE_DESCRIPTION_1]);
            $creativeType->setDescription2($creativeOption[BaiduParams::CREATIVE_DESCRIPTION_2]);

            if (isset($creativeOption[BaiduParams::CREATIVE_PC_DEST_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_PC_DEST_URL])) {
                $creativeType->setPcDestinationUrl($creativeOption[BaiduParams::CREATIVE_PC_DEST_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_PC_DISP_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_PC_DISP_URL])) {
                $creativeType->setPcDisplayUrl($creativeOption[BaiduParams::CREATIVE_PC_DISP_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_MOBILE_DEST_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_MOBILE_DEST_URL])) {
                $creativeType->setMobileDestinationUrl($creativeOption[BaiduParams::CREATIVE_MOBILE_DEST_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_MOBILE_DISP_URL]) && !empty($creativeOption[BaiduParams::CREATIVE_MOBILE_DISP_URL])) {
                $creativeType->setMobileDisplayUrl($creativeOption[BaiduParams::CREATIVE_MOBILE_DISP_URL]);
            }

            if (isset($creativeOption[BaiduParams::CREATIVE_PAUSE]) && !empty($creativeOption[BaiduParams::CREATIVE_PAUSE])) {
                $creativeType->setPause($creativeOption[BaiduParams::CREATIVE_PAUSE]);
            }

            array_push($creativeTypeCollection, $creativeType);
        }

        $this->updateCreativeRequest->setCreativeTypes($creativeTypeCollection);
        $response = $this->baiduCreativeService->updateCreative($this->updateCreativeRequest);
        $jsonHeader = $this->baiduCreativeService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('updateCreatives executed');
        return $baiduResponse;
    }

    /**
     * @param $creativeIds
     * @return bool|BaiduResponse
     */
    public function deleteCreatives($creativeIds)
    {
        $validationErrors = BaiduValidators::validateEmptyArguments(
            $this,
            'deleteCreatives',
            func_get_args()
        );
        if ($validationErrors) return $validationErrors;

        $validationErrors = BaiduValidators::validateArraySize(
            $creativeIds,
            BaiduParams::OPTIONS_CREATIVE_IDS,
            BaiduParams::MAX_NUMBER_DELETE_CREATIVE);
        if ($validationErrors) return $validationErrors;

        $creativeIdCollection = [];

        foreach ($creativeIds as $key => $creativeId) {
            $validationErrors = BaiduValidators::validateEmptyField(
                $creativeId,
                BaiduParams::CREATIVE_ID . ' [' . $key . ']'
            );
            if ($validationErrors) return $validationErrors;

            array_push($creativeIdCollection, $creativeId);
        }

        $this->deleteCreativeRequest->setCreativeIds($creativeIdCollection);
        $response = $this->baiduCreativeService->deleteCreative($this->deleteCreativeRequest);
        $jsonHeader = $this->baiduCreativeService->getJsonHeader();

        $baiduResponse = new BaiduResponse();
        $baiduResponse->handleResponse($jsonHeader, $response);
        $baiduResponse->addMessages('deleteCreatives executed');
        return $baiduResponse;
    }
}
