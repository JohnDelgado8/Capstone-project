<?php
/**
 * ConversationsMessage
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
 * ConversationsMessage Class Doc Comment
 *
 * @category Class
 * @description a Conversations message
 * @package  SendinBlue\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ConversationsMessage implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ConversationsMessage';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'id' => 'string',
        'type' => 'string',
        'text' => 'string',
        'visitorId' => 'string',
        'agentId' => 'string',
        'agentName' => 'string',
        'createdAt' => 'int',
        'isPushed' => 'bool',
        'receivedFrom' => 'string',
        'file' => '\SendinBlue\Client\Model\ConversationsMessageFile'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'id' => null,
        'type' => null,
        'text' => null,
        'visitorId' => null,
        'agentId' => null,
        'agentName' => null,
        'createdAt' => 'int64',
        'isPushed' => null,
        'receivedFrom' => null,
        'file' => null
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
        'id' => 'id',
        'type' => 'type',
        'text' => 'text',
        'visitorId' => 'visitorId',
        'agentId' => 'agentId',
        'agentName' => 'agentName',
        'createdAt' => 'createdAt',
        'isPushed' => 'isPushed',
        'receivedFrom' => 'receivedFrom',
        'file' => 'file'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'type' => 'setType',
        'text' => 'setText',
        'visitorId' => 'setVisitorId',
        'agentId' => 'setAgentId',
        'agentName' => 'setAgentName',
        'createdAt' => 'setCreatedAt',
        'isPushed' => 'setIsPushed',
        'receivedFrom' => 'setReceivedFrom',
        'file' => 'setFile'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'type' => 'getType',
        'text' => 'getText',
        'visitorId' => 'getVisitorId',
        'agentId' => 'getAgentId',
        'agentName' => 'getAgentName',
        'createdAt' => 'getCreatedAt',
        'isPushed' => 'getIsPushed',
        'receivedFrom' => 'getReceivedFrom',
        'file' => 'getFile'
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

    const TYPE_AGENT = 'agent';
    const TYPE_VISITOR = 'visitor';
    

    
    /**
     * Gets allowable values of the enum
     *
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_AGENT,
            self::TYPE_VISITOR,
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
        $this->container['id'] = isset($data['id']) ? $data['id'] : null;
        $this->container['type'] = isset($data['type']) ? $data['type'] : null;
        $this->container['text'] = isset($data['text']) ? $data['text'] : null;
        $this->container['visitorId'] = isset($data['visitorId']) ? $data['visitorId'] : null;
        $this->container['agentId'] = isset($data['agentId']) ? $data['agentId'] : null;
        $this->container['agentName'] = isset($data['agentName']) ? $data['agentName'] : null;
        $this->container['createdAt'] = isset($data['createdAt']) ? $data['createdAt'] : null;
        $this->container['isPushed'] = isset($data['isPushed']) ? $data['isPushed'] : null;
        $this->container['receivedFrom'] = isset($data['receivedFrom']) ? $data['receivedFrom'] : null;
        $this->container['file'] = isset($data['file']) ? $data['file'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        $allowedValues = $this->getTypeAllowableValues();
        if (!is_null($this->container['type']) && !in_array($this->container['type'], $allowedValues, true)) {
            $invalidProperties[] = sprintf(
                "invalid value for 'type', must be one of '%s'",
                implode("', '", $allowedValues)
            );
        }

        if (!is_null($this->container['createdAt']) && ($this->container['createdAt'] < 0)) {
            $invalidProperties[] = "invalid value for 'createdAt', must be bigger than or equal to 0.";
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
     * Gets id
     *
     * @return string
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param string $id Message ID. It can be used for further manipulations with the message.
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->container['id'] = $id;

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
     * @param string $type `\"agent\"` for agents’ messages, `\"visitor\"` for visitors’ messages.
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
     * Gets text
     *
     * @return string
     */
    public function getText()
    {
        return $this->container['text'];
    }

    /**
     * Sets text
     *
     * @param string $text Message text or name of the attached file
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->container['text'] = $text;

        return $this;
    }

    /**
     * Gets visitorId
     *
     * @return string
     */
    public function getVisitorId()
    {
        return $this->container['visitorId'];
    }

    /**
     * Sets visitorId
     *
     * @param string $visitorId visitor’s ID
     *
     * @return $this
     */
    public function setVisitorId($visitorId)
    {
        $this->container['visitorId'] = $visitorId;

        return $this;
    }

    /**
     * Gets agentId
     *
     * @return string
     */
    public function getAgentId()
    {
        return $this->container['agentId'];
    }

    /**
     * Sets agentId
     *
     * @param string $agentId ID of the agent on whose behalf the message was sent (only in messages sent by an agent).
     *
     * @return $this
     */
    public function setAgentId($agentId)
    {
        $this->container['agentId'] = $agentId;

        return $this;
    }

    /**
     * Gets agentName
     *
     * @return string
     */
    public function getAgentName()
    {
        return $this->container['agentName'];
    }

    /**
     * Sets agentName
     *
     * @param string $agentName Agent’s name as displayed to the visitor. Only in the messages sent by an agent.
     *
     * @return $this
     */
    public function setAgentName($agentName)
    {
        $this->container['agentName'] = $agentName;

        return $this;
    }

    /**
     * Gets createdAt
     *
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->container['createdAt'];
    }

    /**
     * Sets createdAt
     *
     * @param int $createdAt Timestamp in milliseconds.
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {

        if (!is_null($createdAt) && ($createdAt < 0)) {
            throw new \InvalidArgumentException('invalid value for $createdAt when calling ConversationsMessage., must be bigger than or equal to 0.');
        }

        $this->container['createdAt'] = $createdAt;

        return $this;
    }

    /**
     * Gets isPushed
     *
     * @return bool
     */
    public function getIsPushed()
    {
        return $this->container['isPushed'];
    }

    /**
     * Sets isPushed
     *
     * @param bool $isPushed `true` for pushed messages
     *
     * @return $this
     */
    public function setIsPushed($isPushed)
    {
        $this->container['isPushed'] = $isPushed;

        return $this;
    }

    /**
     * Gets receivedFrom
     *
     * @return string
     */
    public function getReceivedFrom()
    {
        return $this->container['receivedFrom'];
    }

    /**
     * Sets receivedFrom
     *
     * @param string $receivedFrom In two-way integrations, messages sent via REST API can be marked with receivedFrom property and then filtered out when received in a webhook to avoid infinite loop.
     *
     * @return $this
     */
    public function setReceivedFrom($receivedFrom)
    {
        $this->container['receivedFrom'] = $receivedFrom;

        return $this;
    }

    /**
     * Gets file
     *
     * @return \SendinBlue\Client\Model\ConversationsMessageFile
     */
    public function getFile()
    {
        return $this->container['file'];
    }

    /**
     * Sets file
     *
     * @param \SendinBlue\Client\Model\ConversationsMessageFile $file file
     *
     * @return $this
     */
    public function setFile($file)
    {
        $this->container['file'] = $file;

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


