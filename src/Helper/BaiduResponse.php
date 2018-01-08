<?php

namespace BaiduOpen\Tuiguang\Helper;

class BaiduResponse
{
    const VALIDATION_FAILED = 'Validation Failed';
    const VALIDATION_SUCCESS = 'Validation Success';
    const BAIDU_SUCCESS = 'success';

    protected $header;
    protected $data;
    protected $failures;
    protected $status;
    protected $errors = [];
    protected $messages = [];

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getFailures()
    {
        return $this->failures;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        if ($status) {
            $this->status = $status;
        }
    }

    /**
     * @param $errors
     */
    public function addErrors($errors)
    {
        if ($errors) {
            array_push($this->errors, $errors);
        }
    }

    /**
     * @param $messages
     */
    public function addMessages($messages)
    {
        if ($messages) {
            array_push($this->messages, $messages);
        }
    }

    /**
     * @param $header
     * @param $response
     */
    public function handleResponse($header, $response)
    {
        $this->setStatus($header->desc);
        $this->setHeader($header);
        $this->setData($response->data);
        $this->setFailures($header->failures);
    }

    public function isValid()
    {
        if ($this->getStatus() === self::VALIDATION_SUCCESS) {
            return true;
        }

        return false;
    }

    /**
     * @param $header
     */
    private function setHeader($header)
    {
        if ($header) {
            $this->header = $header;
        }
    }

    /**
     * @param $data
     */
    private function setData($data)
    {
        if (!empty($data)) {
            $this->data = $data;
        }
    }

    /**
     * @param $failures
     */
    private function setFailures($failures)
    {
        if (!empty($failures)) {
            $this->failures = $failures;
        }
    }
}
