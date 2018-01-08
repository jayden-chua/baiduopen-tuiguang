<?php

namespace BaiduOpen\Tuiguang;

class ServiceManager
{
    /**
     * @var CampaignService
     */
    public $campaign;

    /**
     * @var AdgroupService
     */
    public $adgroup;

    /**
     * @var KeywordService
     */
    public $keyword;

    /**
     * @var CreativeService
     */
    public $creative;

    /**
     * @var ReportService
     */
    public $report;

    /**
     * ServiceManager constructor.
     * @param $authHeader
     * @param bool $isMcc
     * @param CampaignService|null $campaign
     * @param AdgroupService|null $adgroup
     * @param KeywordService|null $keyword
     * @param CreativeService|null $creative
     */
    public function __construct(
        $authHeader,
        $isMcc = false,
        CampaignService $campaign = null,
        AdgroupService $adgroup = null,
        KeywordService $keyword = null,
        CreativeService $creative = null,
        ReportService $report = null
    ) {
        $this->campaign = $campaign ?: new CampaignService($authHeader, $isMcc);
        $this->adgroup = $adgroup ?: new AdgroupService($authHeader, $isMcc);
        $this->keyword = $keyword ?: new KeywordService($authHeader, $isMcc);
        $this->creative = $creative ?: new CreativeService($authHeader, $isMcc);
        $this->report = $report ?: new ReportService($authHeader, $isMcc);
    }
}