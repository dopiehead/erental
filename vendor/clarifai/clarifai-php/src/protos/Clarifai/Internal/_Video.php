<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/clarifai/api/video.proto

namespace Clarifai\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>clarifai.api.Video</code>
 */
class _Video extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string url = 1;</code>
     */
    private $url = '';
    /**
     * Generated from protobuf field <code>bytes base64 = 2;</code>
     */
    private $base64 = '';
    /**
     * Generated from protobuf field <code>bool allow_duplicate_url = 4;</code>
     */
    private $allow_duplicate_url = false;

    public function __construct() {
        \GPBMetadata\Proto\Clarifai\Api\Video::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>string url = 1;</code>
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Generated from protobuf field <code>string url = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->url = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes base64 = 2;</code>
     * @return string
     */
    public function getBase64()
    {
        return $this->base64;
    }

    /**
     * Generated from protobuf field <code>bytes base64 = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setBase64($var)
    {
        GPBUtil::checkString($var, False);
        $this->base64 = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool allow_duplicate_url = 4;</code>
     * @return bool
     */
    public function getAllowDuplicateUrl()
    {
        return $this->allow_duplicate_url;
    }

    /**
     * Generated from protobuf field <code>bool allow_duplicate_url = 4;</code>
     * @param bool $var
     * @return $this
     */
    public function setAllowDuplicateUrl($var)
    {
        GPBUtil::checkBool($var);
        $this->allow_duplicate_url = $var;

        return $this;
    }

}

