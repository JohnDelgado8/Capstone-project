<?php
/**
 * AbTestCampaignResultStatistics
 *
 * PHP version 5
 *
 * @category Class
 * @package  SendinBlue\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * SendinBlue API
 *
 * SendinBlue provide a RESTFul API that can be used with any languages. With this API, you will be able to :   - Manage your campaigns and get the statistics   - Manage your contacts   - Send transactional Emails and SMS   - and much more...  You can download our wrappers at https://github.com/orgs/sendinblue  **Possible responses**   | Code | Message |   | :-------------: | ------------- |   | 200  | OK. Successful Request  |   | 201  | OK. Successful Creation |   | 202  | OK. Request accepted |   | 204  | OK. Successful Update/Deletion  |   | 400  | Error. Bad Request  |   | 401  | Error. Authentication Needed  |   | 402  | Error. Not enough credit, plan upgrade needed  |   | 403  | Error. Permission denied  |   | 404  | Error. Object does not exist |   | 405  | Error. Method not allowed  |   | 406  | Error. Not Acceptable  |
 *
 * OpenAPI spec version: 3.0.0
 * Contact: contact@sendinblue.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.29
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SendinBlue\Client\Model;

use \ArrayAccess;
use \SendinBlue\Client\ObjectSerializer;

/**
 * AbTestCampaignResultStatistics Class Doc Comment
 *
 * @category Class
 * @package  SendinBlue\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class AbTestCampaignResultStatistics implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'abTestCampaignResult_statistics';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'openers' => '\SendinBlue\Client\Model\AbTestVersionStats',
        'clicks' => '\SendinBlue\Client\Model\AbTestVersionStats',
        'unsubscribed' => '\SendinBlue\Client\Model\AbTestVersionStats',
        'hardBounces' => '\SendinBlue\Client\Model\AbTestVersionStats',
        'softBounces' => '\SendinBlue\Client\Model\AbTestVersionStats',
        'complaints' => '\SendinBlue\Client\Model\AbTestVersionStats'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'openers' => null,
        'clicks' => null,
        'unsubscribed' => null,
        'hardBounces' => null,
        'softBounces' => null,
        'complaints' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'openers' => 'openers',
        'clicks' => 'clicks',
        'unsubscribed' => 'unsubscribed',
        'hardBounces' => 'hardBounces',
        'softBounces' => 'softBounces',
        'complaints' => 'complaints'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'openers' => 'setOpeners',
        'clicks' => 'setClicks',
        'unsubscribed' => 'setUnsubscribed',
        'hardBounces' => 'setHardBounces',
        'softBounces' => 'setSoftBounces',
        'complaints' => 'setComplaints'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'openers' => 'getOpeners',
        'clicks' => 'getClicks',
        'unsubscribed' => 'getUnsubscribed',
        'hardBounces' => 'getHardBounces',
        'softBounces' => 'getSoftBounces',
        'complaints' => 'getComplaints'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['openers'] = isset($data['openers']) ? $data['openers'] : null;
        $this->container['clicks'] = isset($data['clicks']) ? $data['clicks'] : null;
        $this->container['unsubscribed'] = isset($data['unsubscribed']) ? $data['unsubscribed'] : null;
        $this->container['hardBounces'] = isset($data['hardBounces']) ? $data['hardBounces'] : null;
        $this->container['softBounces'] = isset($data['softBounces']) ? $data['softBounces'] : null;
        $this->container['complaints'] = isset($data['complaints']) ? $data['complaints'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['openers'] === null) {
            $invalidProperties[] = "'openers' can't be null";
        }
        if ($this->container['clicks'] === null) {
            $invalidProperties[] = "'clicks' can't be null";
        }
        if ($this->container['unsubscribed'] === null) {
            $invalidProperties[] = "'unsubscribed' can't be null";
        }
        if ($this->container['hardBounces'] === null) {
            $invalidProperties[] = "'hardBounces' can't be null";
        }
        if ($this->container['softBounces'] === null) {
            $invalidProperties[] = "'softBounces' can't be null";
        }
        if ($this->container['complaints'] === null) {
            $invalidProperties[] = "'complaints' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets openers
     *
     * @return \SendinBlue\Client\Model\AbTestVersionStats
     */
    public function getOpeners()
    {
        return $this->container['openers'];
    }

    /**
     * Sets openers
     *
     * @param \SendinBlue\Client\Model\AbTestVersionStats $openers openers
     *
     * @return $this
     */
    public function setOpeners($openers)
    {
        $this->container['openers'] = $openers;

        return $this;
    }

    /**
     * Gets clicks
     *
     * @return \SendinBlue\Client\Model\AbTestVersionStats
     */
    public function getClicks()
    {
        return $this->container['clicks'];
    }

    /**
     * Sets clicks
     *
     * @param \SendinBlue\Client\Model\AbTestVersionStats $clicks clicks
     *
     * @return $this
     */
    public function setClicks($clicks)
    {
        $this->container['clicks'] = $clicks;

        return $this;
    }

    /**
     * Gets unsubscribed
     *
     * @return \SendinBlue\Client\Model\AbTestVersionStats
     */
    public function getUnsubscribed()
    {
        return $this->container['unsubscribed'];
    }

    /**
     * Sets unsubscribed
     *
     * @param \SendinBlue\Client\Model\AbTestVersionStats $unsubscribed unsubscribed
     *
     * @return $this
     */
    public function setUnsubscribed($unsubscribed)
    {
        $this->container['unsubscribed'] = $unsubscribed;

        return $this;
    }

    /**
     * Gets hardBounces
     *
     * @return \SendinBlue\Client\Model\AbTestVersionStats
     */
    public function getHardBounces()
    {
        return $this->container['hardBounces'];
    }

    /**
     * Sets hardBounces
     *
     * @param \SendinBlue\Client\Model\AbTestVersionStats $hardBounces hardBounces
     *
     * @return $this
     */
    public function setHardBounces($hardBounces)
    {
        $this->container['hardBounces'] = $hardBounces;

        return $this;
    }

    /**
     * Gets softBounces
     *
     * @return \SendinBlue\Client\Model\AbTestVersionStats
     */
    public function getSoftBounces()
    {
        return $this->container['softBounces'];
    }

    /**
     * Sets softBounces
     *
     * @param \SendinBlue\Client\Model\AbTestVersionStats $softBounces softBounces
     *
     * @return $this
     */
    public function setSoftBounces($softBounces)
    {
        $this->container['softBounces'] = $softBounces;

        return $this;
    }

    /**
     * Gets complaints
     *
     * @return \SendinBlue\Client\Model\AbTestVersionStats
     */
    public function getComplaints()
    {
        return $this->container['complaints'];
    }

    /**
     * Sets complaints
     *
     * @param \SendinBlue\Client\Model\AbTestVersionStats $complaints complaints
     *
     * @return $this
     */
    public function setComplaints($complaints)
    {
        $this->container['complaints'] = $complaints;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


