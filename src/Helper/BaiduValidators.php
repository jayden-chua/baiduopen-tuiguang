<?php

namespace BaiduOpen\Tuiguang\Helper;

use ReflectionMethod;
use DateTime;

class BaiduValidators
{
    /**
     * BaiduValidators constructor.
     */
    public function __construct()
    {

    }

    public static function validateEmptyArguments($class, $methodName, $arguments)
    {
        $baiduResponse = new BaiduResponse();
        $method = new ReflectionMethod($class, $methodName);
        $params = $method->getParameters();

        foreach ($arguments as $key => $argument) {
            if (empty($argument) && BaiduParams::ERROR_EMPTY[$params[$key]->getName()]) {
                $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
                $baiduResponse->addErrors(BaiduParams::ERROR_EMPTY[$params[$key]->getName()]);
                return $baiduResponse;
            }
        }

        return false;
    }

    public static function validateEmptyField($field, $fieldName)
    {
        $baiduResponse = new BaiduResponse();

        if (empty($field)) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors($fieldName . ' cannot be empty');
            return $baiduResponse;
        }

        return false;
    }

    public static function validateEmptyFieldArray($fields)
    {
        $baiduResponse = new BaiduResponse();

        foreach ($fields as $field) {
            if (empty($field['value'])) {
                $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
                $baiduResponse->addErrors($field['name'] . ' cannot be empty');
            }
        }

        if ($baiduResponse->getStatus() == BaiduResponse::VALIDATION_FAILED) {
            return $baiduResponse;
        }
        return false;
    }

    public static function validateFieldLength($field, $fieldName, $fieldLength = 30)
    {
        $baiduResponse = new BaiduResponse();

        if (strlen($field) > $fieldLength) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors($fieldName . ' is greater than ' . $fieldLength . ' bytes');
            return $baiduResponse;
        }

        return false;
    }

    public static function validateArraySize($field, $fieldName, $maxArraySize, $minArraySize = 0)
    {
        $baiduResponse = new BaiduResponse();

        $actualArraySize = count($field);

        if (!($actualArraySize <= $maxArraySize && $actualArraySize >= 0)) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors($fieldName . ' size (' . $actualArraySize . ') is not between ' . $minArraySize . ' and ' . $maxArraySize);
            return $baiduResponse;
        }

        return false;
    }

    public static function calculateStringSize($sentence)
    {
        $strlen = mb_strlen($sentence);
        $charCount = 0;

        for( $i = 0; $i < $strlen; $i++ ) {
            $char = mb_substr($sentence, $i, 1);
            if (strlen($char) == 3) {
                $charCount += 2;
            } else {
                $charCount += strlen($char);
            }
        }

        return $charCount;
    }

    /**
     * @param $reportType
     * @return BaiduResponse
     */
    public function isValidReportType($reportType)
    {
        $baiduResponse = new BaiduResponse();

        if (!array_key_exists($reportType, BaiduParams::REPORT_TYPE)) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors($reportType . ' is not a valid report type');
            return $baiduResponse;
        }

        $baiduResponse->setStatus(BaiduResponse::VALIDATION_SUCCESS);
        $baiduResponse->addMessages($reportType . ' is a valid report type');
        return $baiduResponse;
    }

    /**
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @param $reportType
     * @return BaiduResponse
     */
    public function isValidReportStartEndDate(DateTime $startDate, DateTime $endDate, $reportType)
    {
        $validationResponse = $this->isValidReportType($reportType);
        if (!$validationResponse->isValid())
            return $validationResponse;

        $baiduResponse = new BaiduResponse();
        $validStartDate = BaiduParams::VALID_START_DATE[$reportType];

        // Validate start date
        if ($startDate->format('Ymd') >= $validStartDate) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_SUCCESS);
            $baiduResponse->addMessages('start date "' . $startDate->format('Ymd') . '" is a valid report start time for ' . $reportType . ' report type');
        } else {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors('start date "' . $startDate->format('Ymd') . '" is not a valid report start time for ' . $reportType . ' report type');
            return $baiduResponse;
        }

        // Validate end date
        if ($endDate > $startDate) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_SUCCESS);
            $baiduResponse->addMessages('end date "' . $endDate->format('Ymd') . '" is after start date "' . $startDate->format('Ymd') . '" for ' . $reportType . ' report type');
        } else {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors('end date "' . $endDate->format('Ymd') . '" is before or same as start date "' . $startDate->format('Ymd') . '" for ' . $reportType . ' report type');
            return $baiduResponse;
        }

        return $baiduResponse;
    }

    public function isValidLevelOfDetail($detailLevel, $reportType)
    {
        $validationResponse = $this->isValidReportType($reportType);
        if (!$validationResponse->isValid())
            return $validationResponse;

        $baiduResponse = new BaiduResponse();
        $validLevelsOfDetail = BaiduParams::VALID_LEVEL_OF_DETAIL[$reportType];

        if (in_array($detailLevel, $validLevelsOfDetail)) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_SUCCESS);
            $baiduResponse->addMessages('detail level "' . $detailLevel . '" is valid for ' . $reportType . ' report type');
        } else {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors('detail level "' . $detailLevel . '" is invalid for ' . $reportType . ' report type');
            return $baiduResponse;
        }

        return $baiduResponse;
    }

    public function isValidTimeOfUnit($timeUnit, $reportType)
    {
        $validationReponse = $this->isValidReportType($reportType);
        if (!$validationReponse->isValid())
            return $validationReponse;

        $baiduResponse = new BaiduResponse();
        $validUnitOfTime = BaiduParams::VALID_UNIT_OF_TIME[$reportType];

        if (in_array($timeUnit, $validUnitOfTime)) {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_SUCCESS);
            $baiduResponse->addMessages('unit of time "' . $timeUnit . '" is valid for ' . $reportType . ' report type');
        } else {
            $baiduResponse->setStatus(BaiduResponse::VALIDATION_FAILED);
            $baiduResponse->addErrors('unit of time "' . $timeUnit . '" is invalid for ' . $reportType . ' report type');
            return $baiduResponse;
        }

        return $baiduResponse;
    }
}
