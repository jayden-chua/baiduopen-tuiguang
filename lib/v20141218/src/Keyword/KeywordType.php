<?php

namespace BaiduOpen\Tuiguang\Library\Keyword;

class KeywordType
{
    //------------------------
    // MEMBER VARIABLES
    //------------------------

    //KeywordType Attributes
    public $campaignId;
    public $keywordId;
    public $adgroupId;
    public $keyword;
    public $price;
    public $destinationUrl;
    public $matchType;
    public $pause;
    public $status;
    public $pcDestinationUrl;
    public $mobileDestinationUrl;
    public $phraseType;
    public $wmatchprefer;
    public $deviceprefer;
    public $owmatch;
    public $pcQuality;
    public $pcReliable;
    public $pcReason;
    public $pcScale;
    public $mobileQuality;
    public $mobileReliable;
    public $mobileReason;
    public $mobileScale;
    public $temp;
    public $operator;
    public $offlineReasons;
    public $tabs;
    public $leftPriceGuide;
    public $left3PriceGuide;
    public $mPriceGuide;
    public $pcEstimatedClickRate;
    public $pcBusinessRelationship;
    public $pcLandPageExperience;
    public $mobileEstimatedClickRate;
    public $mobileBusinessRelationship;
    public $mobileLandPageExperience;

    //------------------------
    // CONSTRUCTOR
    //------------------------

    public function __construct()
    {
    }

    //------------------------
    // INTERFACE
    //------------------------

    public function setCampaignId($aCampaignId)
    {
        $wasSet = false;
        $this->campaignId = $aCampaignId;
        $wasSet = true;
        return $wasSet;
    }

    public function setKeywordId($aKeywordId)
    {
        $wasSet = false;
        $this->keywordId = $aKeywordId;
        $wasSet = true;
        return $wasSet;
    }

    public function setAdgroupId($aAdgroupId)
    {
        $wasSet = false;
        $this->adgroupId = $aAdgroupId;
        $wasSet = true;
        return $wasSet;
    }

    public function setKeyword($aKeyword)
    {
        $wasSet = false;
        $this->keyword = $aKeyword;
        $wasSet = true;
        return $wasSet;
    }

    public function setPrice($aPrice)
    {
        $wasSet = false;
        $this->price = $aPrice;
        $wasSet = true;
        return $wasSet;
    }

    public function setDestinationUrl($aDestinationUrl)
    {
        $wasSet = false;
        $this->destinationUrl = $aDestinationUrl;
        $wasSet = true;
        return $wasSet;
    }

    public function setMatchType($aMatchType)
    {
        $wasSet = false;
        $this->matchType = $aMatchType;
        $wasSet = true;
        return $wasSet;
    }

    public function setPause($aPause)
    {
        $wasSet = false;
        $this->pause = $aPause;
        $wasSet = true;
        return $wasSet;
    }

    public function setStatus($aStatus)
    {
        $wasSet = false;
        $this->status = $aStatus;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcDestinationUrl($aPcDestinationUrl)
    {
        $wasSet = false;
        $this->pcDestinationUrl = $aPcDestinationUrl;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileDestinationUrl($aMobileDestinationUrl)
    {
        $wasSet = false;
        $this->mobileDestinationUrl = $aMobileDestinationUrl;
        $wasSet = true;
        return $wasSet;
    }

    public function setPhraseType($aPhraseType)
    {
        $wasSet = false;
        $this->phraseType = $aPhraseType;
        $wasSet = true;
        return $wasSet;
    }

    public function setWmatchprefer($aWmatchprefer)
    {
        $wasSet = false;
        $this->wmatchprefer = $aWmatchprefer;
        $wasSet = true;
        return $wasSet;
    }

    public function setDeviceprefer($aDeviceprefer)
    {
        $wasSet = false;
        $this->deviceprefer = $aDeviceprefer;
        $wasSet = true;
        return $wasSet;
    }

    public function setOwmatch($aOwmatch)
    {
        $wasSet = false;
        $this->owmatch = $aOwmatch;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcQuality($aPcQuality)
    {
        $wasSet = false;
        $this->pcQuality = $aPcQuality;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcReliable($aPcReliable)
    {
        $wasSet = false;
        $this->pcReliable = $aPcReliable;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcReason($aPcReason)
    {
        $wasSet = false;
        $this->pcReason = $aPcReason;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcScale($apcScale)
    {
        $this->pcScale = $apcScale;
    }

    public function addPcScale($aPcScale)
    {
        $wasAdded = false;
        $this->pcScale[] = $aPcScale;
        $wasAdded = true;
        return $wasAdded;
    }

    public function removePcScale($aPcScale)
    {
        $wasRemoved = false;
        unset($this->pcScale[$this->indexOfPcScale($aPcScale)]);
        $this->pcScale = array_values($this->pcScale);
        $wasRemoved = true;
        return $wasRemoved;
    }

    public function setMobileQuality($aMobileQuality)
    {
        $wasSet = false;
        $this->mobileQuality = $aMobileQuality;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileReliable($aMobileReliable)
    {
        $wasSet = false;
        $this->mobileReliable = $aMobileReliable;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileReason($aMobileReason)
    {
        $wasSet = false;
        $this->mobileReason = $aMobileReason;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileScale($amobileScale)
    {
        $this->mobileScale = $amobileScale;
    }

    public function addMobileScale($aMobileScale)
    {
        $wasAdded = false;
        $this->mobileScale[] = $aMobileScale;
        $wasAdded = true;
        return $wasAdded;
    }

    public function removeMobileScale($aMobileScale)
    {
        $wasRemoved = false;
        unset($this->mobileScale[$this->indexOfMobileScale($aMobileScale)]);
        $this->mobileScale = array_values($this->mobileScale);
        $wasRemoved = true;
        return $wasRemoved;
    }

    public function setTemp($aTemp)
    {
        $wasSet = false;
        $this->temp = $aTemp;
        $wasSet = true;
        return $wasSet;
    }

    public function setOperator($aOperator)
    {
        $wasSet = false;
        $this->operator = $aOperator;
        $wasSet = true;
        return $wasSet;
    }

    public function setOfflineReasons($aofflineReasons)
    {
        $this->offlineReasons = $aofflineReasons;
    }

    public function addOfflineReason($aOfflineReason)
    {
        $wasAdded = false;
        $this->offlineReasons[] = $aOfflineReason;
        $wasAdded = true;
        return $wasAdded;
    }

    public function removeOfflineReason($aOfflineReason)
    {
        $wasRemoved = false;
        unset($this->offlineReasons[$this->indexOfOfflineReason($aOfflineReason)]);
        $this->offlineReasons = array_values($this->offlineReasons);
        $wasRemoved = true;
        return $wasRemoved;
    }

    public function setTabs($atabs)
    {
        $this->tabs = $atabs;
    }

    public function addTab($aTab)
    {
        $wasAdded = false;
        $this->tabs[] = $aTab;
        $wasAdded = true;
        return $wasAdded;
    }

    public function removeTab($aTab)
    {
        $wasRemoved = false;
        unset($this->tabs[$this->indexOfTab($aTab)]);
        $this->tabs = array_values($this->tabs);
        $wasRemoved = true;
        return $wasRemoved;
    }

    public function setLeftPriceGuide($aLeftPriceGuide)
    {
        $wasSet = false;
        $this->leftPriceGuide = $aLeftPriceGuide;
        $wasSet = true;
        return $wasSet;
    }

    public function setLeft3PriceGuide($aLeft3PriceGuide)
    {
        $wasSet = false;
        $this->left3PriceGuide = $aLeft3PriceGuide;
        $wasSet = true;
        return $wasSet;
    }

    public function setMPriceGuide($aMPriceGuide)
    {
        $wasSet = false;
        $this->mPriceGuide = $aMPriceGuide;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcEstimatedClickRate($aPcEstimatedClickRate)
    {
        $wasSet = false;
        $this->pcEstimatedClickRate = $aPcEstimatedClickRate;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcBusinessRelationship($aPcBusinessRelationship)
    {
        $wasSet = false;
        $this->pcBusinessRelationship = $aPcBusinessRelationship;
        $wasSet = true;
        return $wasSet;
    }

    public function setPcLandPageExperience($aPcLandPageExperience)
    {
        $wasSet = false;
        $this->pcLandPageExperience = $aPcLandPageExperience;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileEstimatedClickRate($aMobileEstimatedClickRate)
    {
        $wasSet = false;
        $this->mobileEstimatedClickRate = $aMobileEstimatedClickRate;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileBusinessRelationship($aMobileBusinessRelationship)
    {
        $wasSet = false;
        $this->mobileBusinessRelationship = $aMobileBusinessRelationship;
        $wasSet = true;
        return $wasSet;
    }

    public function setMobileLandPageExperience($aMobileLandPageExperience)
    {
        $wasSet = false;
        $this->mobileLandPageExperience = $aMobileLandPageExperience;
        $wasSet = true;
        return $wasSet;
    }

    public function getCampaignId()
    {
        return $this->campaignId;
    }

    public function getKeywordId()
    {
        return $this->keywordId;
    }

    public function getAdgroupId()
    {
        return $this->adgroupId;
    }

    public function getKeyword()
    {
        return $this->keyword;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getDestinationUrl()
    {
        return $this->destinationUrl;
    }

    public function getMatchType()
    {
        return $this->matchType;
    }

    public function getPause()
    {
        return $this->pause;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getPcDestinationUrl()
    {
        return $this->pcDestinationUrl;
    }

    public function getMobileDestinationUrl()
    {
        return $this->mobileDestinationUrl;
    }

    public function getPhraseType()
    {
        return $this->phraseType;
    }

    public function getWmatchprefer()
    {
        return $this->wmatchprefer;
    }

    public function getDeviceprefer()
    {
        return $this->deviceprefer;
    }

    public function getOwmatch()
    {
        return $this->owmatch;
    }

    public function getPcQuality()
    {
        return $this->pcQuality;
    }

    public function getPcReliable()
    {
        return $this->pcReliable;
    }

    public function getPcReason()
    {
        return $this->pcReason;
    }

    public function getPcScale()
    {
        $newPcScale = $this->pcScale;
        return $newPcScale;
    }

    public function numberOfPcScale()
    {
        $number = count($this->pcScale);
        return $number;
    }

    public function indexOfPcScale($aPcScale)
    {
        $rawAnswer = array_search($aPcScale, $this->pcScale);
        $index = $rawAnswer == null && $rawAnswer !== 0 ? -1 : $rawAnswer;
        return $index;
    }

    public function getMobileQuality()
    {
        return $this->mobileQuality;
    }

    public function getMobileReliable()
    {
        return $this->mobileReliable;
    }

    public function getMobileReason()
    {
        return $this->mobileReason;
    }

    public function getMobileScale()
    {
        $newMobileScale = $this->mobileScale;
        return $newMobileScale;
    }

    public function numberOfMobileScale()
    {
        $number = count($this->mobileScale);
        return $number;
    }

    public function indexOfMobileScale($aMobileScale)
    {
        $rawAnswer = array_search($aMobileScale, $this->mobileScale);
        $index = $rawAnswer == null && $rawAnswer !== 0 ? -1 : $rawAnswer;
        return $index;
    }

    public function getTemp()
    {
        return $this->temp;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getOfflineReasons()
    {
        $newOfflineReasons = $this->offlineReasons;
        return $newOfflineReasons;
    }

    public function numberOfOfflineReasons()
    {
        $number = count($this->offlineReasons);
        return $number;
    }

    public function indexOfOfflineReason($aOfflineReason)
    {
        $rawAnswer = array_search($aOfflineReason, $this->offlineReasons);
        $index = $rawAnswer == null && $rawAnswer !== 0 ? -1 : $rawAnswer;
        return $index;
    }

    public function getTabs()
    {
        $newTabs = $this->tabs;
        return $newTabs;
    }

    public function numberOfTabs()
    {
        $number = count($this->tabs);
        return $number;
    }

    public function indexOfTab($aTab)
    {
        $rawAnswer = array_search($aTab, $this->tabs);
        $index = $rawAnswer == null && $rawAnswer !== 0 ? -1 : $rawAnswer;
        return $index;
    }

    public function getLeftPriceGuide()
    {
        return $this->leftPriceGuide;
    }

    public function getLeft3PriceGuide()
    {
        return $this->left3PriceGuide;
    }

    public function getMPriceGuide()
    {
        return $this->mPriceGuide;
    }

    public function getPcEstimatedClickRate()
    {
        return $this->pcEstimatedClickRate;
    }

    public function getPcBusinessRelationship()
    {
        return $this->pcBusinessRelationship;
    }

    public function getPcLandPageExperience()
    {
        return $this->pcLandPageExperience;
    }

    public function getMobileEstimatedClickRate()
    {
        return $this->mobileEstimatedClickRate;
    }

    public function getMobileBusinessRelationship()
    {
        return $this->mobileBusinessRelationship;
    }

    public function getMobileLandPageExperience()
    {
        return $this->mobileLandPageExperience;
    }

    public function isPause()
    {
        return $this->pause;
    }

    public function equals($compareTo)
    {
        return $this == $compareTo;
    }

    public function delete()
    {
    }
}
