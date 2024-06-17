<?php
/**
 * SendTransacSms
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
 * SendTransacSms Class Doc Comment
 *
 * @category Class
 * @package  SendinBlue\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class SendTransacSms implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'sendTransacSms';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'sender' => 'string',
        'recipient' => 'string',
        'content' => 'string',
        'type' => 'string',
        'tag' => 'string',
        'webUrl' => 'string',
        'unicodeEnabled' => 'bool',
        'organisationPrefix' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'sender' => null,
        'recipient' => null,
        'content' => null,
        'type' => null,
        'tag' => null,
        'webUrl' => 'url',
        'unicodeEnabled' => null,
        'organisationPrefix' => null
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
        'sender' => 'sender',
        'recipient' => 'recipient',
        'content' => 'content',
        'type' => 'type',
        'tag' => 'tag',
        'webUrl' => 'webUrl',
        'unicodeEnabled' => 'unicodeEnabled',
        'organisationPrefix' => 'organisationPrefix'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'sender' => 'setSender',
        'recipient' => 'setRecipient',
        'content' => 'setContent',
        'type' => 'setType',
        'tag' => 'setTag',
        'webUrl' => 'setWebUrl',
        'unicodeEnabled' => 'setUnicodeEnabled',
        'organisationPrefix' => 'setOrganisationPrefix'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'sender' => 'getSender',
        'recipient' => 'getRecipient',
        'content' => 'getContent',
        'type' => 'getType',
        'tag' => 'getTag',
        'webUrl' => 'getWebUrl',
        'unicodeEnabled' => 'getUnicodeEnabled',
        'organisationPrefix' => 'getOrganisationPrefix'
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

    const TYPE_TRANSACTIONAL = 'transactional';
    const TYPE_MARKETING = 'marketing';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_TRANSACTIONAL,
            self::TYPE_MARKETING,
        ];
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
        $this->container['sender'] = isset($data['sender']) ? $data['sender'] : null;
        $this->container['recipient'] = isset($data['recipient']) ? $data['recipient'] : null;
        $this->container['content'] = isset($data['content']) ? $data['content'] : null;
        $this->container['type'] = isset($data['type']) ? $data['type'] : 'transactional';
        $this->container['tag'] = isset($data['tag']) ? $data['tag'] : null;
        $this->container['webUrl'] = isset($data['webUrl']) ? $data['webUrl'] : null;
        $this->container['unicodeEnabled'] = isset($data['unicodeEnabled']) ? $data['unicodeEnabled'] : false;
        $this->container['organisationPrefix'] = isset($data['organisationPrefix']) ? $data['organisationPrefix'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['sender'] === null) {
            $invalidProperties[] = "'sender' can't be null";
        }
        if ((mb_strlen($this->container['sender']) > 15)) {
            $invalidProperties[] = "invalid value for 'sender', the character length must be smaller than or equal to 15.";
        }

        if ($this->container['recipient'] === null) {
            $invalidProperties[] = "'recipient' can't be null";
        }
        if ($this->container['content'] === null) {
            $invalidProperties[] = "'content' can't be null";
        }
        $allowedValues = $this->getTypeAllowableValues();
        if (!is_null($this->container['type']) && !in_array($this->container['type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
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
     * Gets sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->container['sender'];
    }

    /**
     * Sets sender
     *
     * @param string $sender Name of the sender. **The number of characters is limited to 11 for alphanumeric characters and 15 for numeric characters**
     *
     * @return $this
     */
    public function setSender($sender)
    {
        if ((mb_strlen($sender) > 15)) {
            throw new \InvalidArgumentException('invalid length for $sender when calling SendTransacSms., must be smaller than or equal to 15.');
        }

        $this->container['sender'] = $sender;

        return $this;
    }

    /**
     * Gets recipient
     *
     * @return string
     */
    public function getRecipient()
    {
        return $this->container['recipient'];
    }

    /**
     * Sets recipient
     *
     * @param string $recipient Mobile number to send SMS with the country code
     *
     * @return $this
     */
    public function setRecipient($recipient)
    {
        $this->container['recipient'] = $recipient;

        return $this;
    }

    /**
     * Gets content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->container['content'];
    }

    /**
     * Sets content
     *
     * @param string $content Content of the message. If more than 160 characters long, will be sent as multiple text messages
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->container['content'] = $content;

        return $this;
    }

    /**
     * Gets type
     *
     * @return string
     */
    public function getType()
    {
        return $this->container['type'];
    }

    /**
     * Sets type
     *
     * @param string $type Type of the SMS. Marketing SMS messages are those sent typically with marketing content. Transactional SMS messages are sent to individuals and are triggered in response to some action, such as a sign-up, purchase, etc.
     *
     * @return $this
     */
    public function setType($type)
    {
        $allowedValues = $this->getTypeAllowableValues();
        if (!is_null($type) && !in_array($type, $allowedValues, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid value for 'type', must be one of '%s'",
                    implode("', '", $allowedValues)
                )
            );
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->container['tag'];
    }

    /**
     * Sets tag
     *
     * @param string $tag Tag of the message
     *
     * @return $this
     */
    public function setTag($tag)
    {
        $this->container['tag'] = $tag;

        return $this;
    }

    /**
     * Gets webUrl
     *
     * @return string
     */
    public function getWebUrl()
    {
        return $this->container['webUrl'];
    }

    /**
     * Sets webUrl
     *
     * @param string $webUrl Webhook to call for each event triggered by the message (delivered etc.)
     *
     * @return $this
     */
    public function setWebUrl($webUrl)
    {
        $this->container['webUrl'] = $webUrl;

        return $this;
    }

    /**
     * Gets unicodeEnabled
     *
     * @return bool
     */
    public function getUnicodeEnabled()
    {
        return $this->container['unicodeEnabled'];
    }

    /**
     * Sets unicodeEnabled
     *
     * @param bool $unicodeEnabled Format of the message. It indicates whether the content should be treated as unicode or not.
     *
     * @return $this
     */
    public function setUnicodeEnabled($unicodeEnabled)
    {
        $this->container['unicodeEnabled'] = $unicodeEnabled;

        return $this;
    }

    /**
     * Gets organisationPrefix
     *
     * @return string
     */
    public function getOrganisationPrefix()
    {
        return $this->container['organisationPrefix'];
    }

    /**
     * Sets organisationPrefix
     *
     * @param string $organisationPrefix A recognizable prefix will ensure your audience knows who you are. Recommended by U.S. carriers. This will be added as your Brand Name before the message content. **Prefer verifying maximum length of 160 characters including this prefix in message content to avoid multiple sending of same sms.**
     *
     * @return $this
     */
    public function setOrganisationPrefix($organisationPrefix)
    {
        $this->container['organisationPrefix'] = $organisationPrefix;

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


