<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/clarifai/api/data.proto

namespace Clarifai\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>clarifai.api.FrameInfo</code>
 */
class _FrameInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>uint32 index = 1 [(.clarifai.api.utils.cl_show_if_empty) = true];</code>
     */
    private $index = 0;
    /**
     * Generated from protobuf field <code>uint32 time = 2 [(.clarifai.api.utils.cl_show_if_empty) = true];</code>
     */
    private $time = 0;

    public function __construct() {
        \GPBMetadata\Proto\Clarifai\Api\Data::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>uint32 index = 1 [(.clarifai.api.utils.cl_show_if_empty) = true];</code>
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Generated from protobuf field <code>uint32 index = 1 [(.clarifai.api.utils.cl_show_if_empty) = true];</code>
     * @param int $var
     * @return $this
     */
    public function setIndex($var)
    {
        GPBUtil::checkUint32($var);
        $this->index = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint32 time = 2 [(.clarifai.api.utils.cl_show_if_empty) = true];</code>
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Generated from protobuf field <code>uint32 time = 2 [(.clarifai.api.utils.cl_show_if_empty) = true];</code>
     * @param int $var
     * @return $this
     */
    public function setTime($var)
    {
        GPBUtil::checkUint32($var);
        $this->time = $var;

        return $this;
    }

}

