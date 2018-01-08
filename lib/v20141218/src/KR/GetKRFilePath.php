<?php

namespace BaiduOpen\Tuiguang\Library\KR;

class GetKRFilePath
{
    //------------------------
    // MEMBER VARIABLES
    //------------------------

    //GetKRFilePath Attributes
    public $filePath;

    //------------------------
    // CONSTRUCTOR
    //------------------------

    public function __construct()
    {
    }

    //------------------------
    // INTERFACE
    //------------------------

    public function setFilePath($aFilePath)
    {
        $wasSet = false;
        $this->filePath = $aFilePath;
        $wasSet = true;
        return $wasSet;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function equals($compareTo)
    {
        return $this == $compareTo;
    }

    public function delete()
    {
    }
}
