<?php

namespace BaiduOpen\Tuiguang\Library;

use BaiduOpen\Tuiguang\Library\Common\CommonService;

class sms_service_KeywordService extends CommonService
{
    public function __construct()
    {
        parent::__construct('sms', 'service', 'KeywordService');
    }

    public function updateWord($updateWordRequest)
    {
        return $this->execute('updateWord', $updateWordRequest);
    }

    public function addWord($addWordRequest)
    {
        return $this->execute('addWord', $addWordRequest);
    }

    public function deleteWord($deleteWordRequest)
    {
        return $this->execute('deleteWord', $deleteWordRequest);
    }

    public function getWord($getWordRequest)
    {
        return $this->execute('getWord', $getWordRequest);
    }
}
