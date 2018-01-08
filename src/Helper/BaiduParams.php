<?php

namespace BaiduOpen\Tuiguang\Helper;

class BaiduParams
{
    // Parameter Names from Baidu API
    const CAMPAIGN_ID = 'campaignId';
    const CAMPAIGN_NAME = 'campaignName';
    const ADGROUP_ID = 'adgroupId';
    const ADGROUP_NAME = 'adgroupName';
    const ADGROUP_PAUSE = 'pause';
    const KEYWORD = 'keyword';
    const KEYWORD_ID = 'keywordId';
    const KEYWORD_PRICE = 'price';
    const KEYWORD_NEGATIVE = 'negativeWords';
    const KEYWORD_NEGATIVE_EXACT = 'exactNegativeWords';
    const REGION_TARGET = 'regionTarget';
    const MAX_PRICE = 'maxPrice';
    const CREATIVE_ID = 'creativeId';
    const CREATIVE_TITLE = 'title';
    const CREATIVE_DESCRIPTION_1 = 'description1';
    const CREATIVE_DESCRIPTION_2 = 'description2';
    const CREATIVE_PC_DEST_URL = 'pcDestinationUrl';
    const CREATIVE_PC_DISP_URL = 'pcDisplayUrl';
    const CREATIVE_MOBILE_DEST_URL = 'mobileDestinationUrl';
    const CREATIVE_MOBILE_DISP_URL = 'mobileDisplayUrl';
    const CREATIVE_PAUSE = 'pause';

    // Parameter Names that are used in Services
    const OPTIONS_ADGROUP = 'adgroupOptions';
    const OPTIONS_CREATIVE = 'creativeOptions';
    const OPTIONS_KEYWORD = 'keywordOptions';
    const OPTIONS_CREATIVE_IDS = 'creativeIds';
    const OPTIONS_KEYWORD_IDS = 'keywordIds';

    const CAMPAIGN_STATUS = [
        '21' => 'Valid',
        '22' => 'Under pause time bucket',
        '23' => 'Pause',
        '24' => 'Budget of promotion plan is insufficient',
        '25' => 'Budget of the account is insufficient'
    ];

    // Required Sizes
    // Max number of creatives per addCreative, requirement from Baidu
    const MAX_NUMBER_ADD_CREATIVE = 3000;
    const MAX_NUMBER_DELETE_CREATIVE = 10000;
    const MAX_NUMBER_ADD_KEYWORD = 10000;
    const MAX_NUMBER_DELETE_KEYWORD = 10000;

    // Each chinese characters are considered 2 bytes
    const BYTE_UNIT = 2;

    // Max character limits
    const MAX_CHAR = [
        self::CREATIVE_TITLE => 50 * self::BYTE_UNIT, // wild cards & punctuations exempted from rule
        self::CREATIVE_DESCRIPTION_1 => 80 * self::BYTE_UNIT, // wild cards & punctuations exempted from rule
        self::CREATIVE_DESCRIPTION_2 => 80 * self::BYTE_UNIT, // wild cards & punctuations exempted from rule
        self::CREATIVE_PC_DEST_URL => 1024,
        self::CREATIVE_PC_DISP_URL => 36,
        self::CREATIVE_MOBILE_DEST_URL => 1017,
        self::CREATIVE_MOBILE_DEST_URL => 36
    ];

    // Min character limits
    const MIN_CHAR = [
        self::CREATIVE_TITLE => 9 * self::BYTE_UNIT, // wild cards & punctuations exempted from rule
        self::CREATIVE_DESCRIPTION_1 => 9 * self::BYTE_UNIT // wild cards & punctuations exempted from rule
    ];

    // Default Required Fields
    const ERROR_EMPTY = [
        self::CAMPAIGN_ID => 'campaignId cannot be empty',
        self::ADGROUP_ID => 'adgroupId cannot be empty',
        self::OPTIONS_CREATIVE_IDS => 'creativeIds cannot be empty',
        self::OPTIONS_KEYWORD_IDS => 'keywordIds cannot be empty',
        self::OPTIONS_ADGROUP => 'adgroupOptions cannot be empty',
        self::OPTIONS_CREATIVE => 'creativeOptions cannot be empty',
        self::OPTIONS_KEYWORD => 'keywordOptions cannot be empty',
        self::MAX_PRICE => 'maxPrice cannot be empty',
    ];

    // Report keys
    const ACCOUNT_REPORT = 'account'; // 账户报告
    const REGION_REPORT = 'region'; // 地域报告
    const SECONDARY_REGION_REPORT = 'secondaryRegion'; // 二级地域报告
    const SEARCH_WORD_REPORT = 'search'; // 搜索词报告
    const WORDID_REPORT = 'wordid'; // 关键词报告
    const PLAN_REPORT = 'plan'; // 计划报告
    const UNIT_REPORT = 'unit'; // 单元报告
    const CREATION_REPORT = 'creation'; // 创意报告
    const KEYWORD_REPORT = 'keyword'; // 关键词报告
    const MATCH_REPORT = 'match'; // 配对报告
    const PATH_REPORT = 'path'; // 蹊径报告
    const HISTORICAL_RANKING_REPORT = 'historicalRanking'; // 历史排名报告

    // Report types
    const REPORT_TYPE = [
        self::ACCOUNT_REPORT => 2,
        self::REGION_REPORT => 3,
        self::SECONDARY_REGION_REPORT => 5,
        self::SEARCH_WORD_REPORT => 6,
        self::WORDID_REPORT => 9,
        self::PLAN_REPORT => 10,
        self::UNIT_REPORT => 11,
        self::CREATION_REPORT => 12,
        self::KEYWORD_REPORT => 14,
        self::MATCH_REPORT => 15,
        self::PATH_REPORT => 21,
        self::HISTORICAL_RANKING_REPORT => 38
    ];

    // Valid start dates for different report types
    // For search word report, there isn't a fixed start date
    const VALID_START_DATE = [
        self::ACCOUNT_REPORT => 20010917,
        self::REGION_REPORT => 20090420,
        self::SECONDARY_REGION_REPORT => 20090420,
        self::SEARCH_WORD_REPORT => 20090420,
        self::WORDID_REPORT => 20091201,
        self::PLAN_REPORT => 20010917,
        self::UNIT_REPORT => 20010917,
        self::CREATION_REPORT => 20010917,
        self::KEYWORD_REPORT => 20091201,
        self::MATCH_REPORT => 20091201,
        self::PATH_REPORT => 20010917,
        self::HISTORICAL_RANKING_REPORT => 20090420
    ];

    // Valid level of detail for different report types
    // The first item in each array is the default levelOfDetail
    const VALID_LEVEL_OF_DETAIL = [
        self::ACCOUNT_REPORT => [2],
        self::REGION_REPORT => [2,3,5],
        self::SECONDARY_REGION_REPORT => [2,3],
        self::SEARCH_WORD_REPORT => [7,12],
        self::WORDID_REPORT => [6],
        self::PLAN_REPORT => [3],
        self::UNIT_REPORT => [5],
        self::CREATION_REPORT => [7],
        self::KEYWORD_REPORT => [11],
        self::MATCH_REPORT => [12],
        self::PATH_REPORT => [6],
        self::HISTORICAL_RANKING_REPORT => [11]
    ];

    // Valid unit of time for different report types
    // The first item in each array is the default unitOfTime
    const VALID_UNIT_OF_TIME = [
        self::ACCOUNT_REPORT => [1,3,4,5,7,8],
        self::REGION_REPORT => [1,3,4,5,8],
        self::SECONDARY_REGION_REPORT => [1,3,4,5,8],
        self::SEARCH_WORD_REPORT => [5,8],
        self::WORDID_REPORT => [1,3,4,5,7,8],
        self::PLAN_REPORT => [5,1,3,4,7,8],
        self::UNIT_REPORT => [1,3,4,5,7,8],
        self::CREATION_REPORT => [1,3,4,5,7,8],
        self::KEYWORD_REPORT => [1,3,4,5,7,8],
        self::MATCH_REPORT => [1,3,4,5,8],
        self::PATH_REPORT => [3,4,5],
        self::HISTORICAL_RANKING_REPORT => [3,7]
    ];

    // Valid stat range for different report types
    // The first item in each array is the default statRange
    const VALID_STAT_RANGE = [
        self::ACCOUNT_REPORT => [2],
        self::REGION_REPORT => [2,3,5],
        self::SECONDARY_REGION_REPORT => [2,3],
        self::SEARCH_WORD_REPORT => [2,3],
        self::WORDID_REPORT => [2,3,5,11],
        self::PLAN_REPORT => [3,2],
        self::UNIT_REPORT => [2,3,5],
        self::CREATION_REPORT => [2,3,5,7],
        self::KEYWORD_REPORT => [2,3,5,11],
        self::MATCH_REPORT => [2,3,5,7,11],
        self::PATH_REPORT => [2],
        self::HISTORICAL_RANKING_REPORT => [2,11]
    ];

    const DEFAULT_PERFORMANCE_DATA = [
        self::ACCOUNT_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'conversion'],
        self::REGION_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::SECONDARY_REGION_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'position', 'conversion'],
        self::SEARCH_WORD_REPORT => ['click', 'impression'],
        self::WORDID_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'conversion'],
        self::PLAN_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'conversion'],
        self::UNIT_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'conversion'],
        self::CREATION_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm',' position', 'conversion'],
        self::KEYWORD_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'position', 'conversion'],
        self::MATCH_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::PATH_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr'],
        self::HISTORICAL_RANKING_REPORT => ['rank1shows', 'rank2shows', 'rank3shows', 'rank4to8shows','left:rank1to8shows', 'upper:rank1to3shows', 'left ratio:rank1to8ratio', 'upper ratio: rank1to3ratio']
    ];

    const DEFAULT_PERFORMANCE_DATA_HOURLY = [
        self::ACCOUNT_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::REGION_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::SECONDARY_REGION_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm', 'position', 'conversion'],
        self::SEARCH_WORD_REPORT => ['click', 'impression'],
        self::WORDID_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::PLAN_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::UNIT_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::CREATION_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::KEYWORD_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::MATCH_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr', 'cpm'],
        self::PATH_REPORT => ['cost', 'cpc', 'click', 'impression', 'ctr'],
        self::HISTORICAL_RANKING_REPORT => ['rank1shows', 'rank2shows', 'rank3shows', 'rank4to8shows','left:rank1to8shows', 'upper:rank1to3shows', 'left ratio:rank1to8ratio', 'upper ratio: rank1to3ratio']
    ];
}
