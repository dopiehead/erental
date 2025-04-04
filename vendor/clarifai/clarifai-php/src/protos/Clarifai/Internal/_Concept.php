<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: proto/clarifai/api/concept.proto

namespace Clarifai\Internal;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>clarifai.api.Concept</code>
 */
class _Concept extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * Generated from protobuf field <code>string name = 2;</code>
     */
    private $name = '';
    /**
     * Generated from protobuf field <code>float value = 3 [(.clarifai.api.utils.cl_show_if_empty) = true, (.clarifai.api.utils.cl_default_float) = 1];</code>
     */
    private $value = 0.0;
    /**
     * Generated from protobuf field <code>.google.protobuf.Timestamp created_at = 4;</code>
     */
    private $created_at = null;
    /**
     * Generated from protobuf field <code>string language = 5;</code>
     */
    private $language = '';
    /**
     * Generated from protobuf field <code>string app_id = 6;</code>
     */
    private $app_id = '';
    /**
     * Generated from protobuf field <code>string definition = 7;</code>
     */
    private $definition = '';

    public function __construct() {
        \GPBMetadata\Proto\Clarifai\Api\Concept::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Generated from protobuf field <code>string name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>float value = 3 [(.clarifai.api.utils.cl_show_if_empty) = true, (.clarifai.api.utils.cl_default_float) = 1];</code>
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Generated from protobuf field <code>float value = 3 [(.clarifai.api.utils.cl_show_if_empty) = true, (.clarifai.api.utils.cl_default_float) = 1];</code>
     * @param float $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkFloat($var);
        $this->value = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.google.protobuf.Timestamp created_at = 4;</code>
     * @return \Google\Protobuf\Timestamp
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Generated from protobuf field <code>.google.protobuf.Timestamp created_at = 4;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreatedAt($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->created_at = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string language = 5;</code>
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Generated from protobuf field <code>string language = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setLanguage($var)
    {
        GPBUtil::checkString($var, True);
        $this->language = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string app_id = 6;</code>
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * Generated from protobuf field <code>string app_id = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setAppId($var)
    {
        GPBUtil::checkString($var, True);
        $this->app_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string definition = 7;</code>
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Generated from protobuf field <code>string definition = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setDefinition($var)
    {
        GPBUtil::checkString($var, True);
        $this->definition = $var;

        return $this;
    }

}

