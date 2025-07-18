<?php
/**
 * WhiteLabelName SDK
 *
 * This library allows to interact with the WhiteLabelName payment service.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


namespace WhiteLabelMachineName\Sdk\Model;

use \ArrayAccess;
use \WhiteLabelMachineName\Sdk\ObjectSerializer;

/**
 * AbstractWebhookListenerUpdate model
 *
 * @category    Class
 * @package     WhiteLabelMachineName\Sdk
 * @author      WhiteLabelMachineName
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 */
class AbstractWebhookListenerUpdate implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Abstract.WebhookListener.Update';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'enable_payload_signature_and_state' => 'bool',
        'entity_states' => 'string[]',
        'name' => 'string',
        'notify_every_change' => 'bool',
        'state' => '\WhiteLabelMachineName\Sdk\Model\CreationEntityState'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'enable_payload_signature_and_state' => null,
        'entity_states' => null,
        'name' => null,
        'notify_every_change' => null,
        'state' => null
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'enable_payload_signature_and_state' => 'enablePayloadSignatureAndState',
        'entity_states' => 'entityStates',
        'name' => 'name',
        'notify_every_change' => 'notifyEveryChange',
        'state' => 'state'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'enable_payload_signature_and_state' => 'setEnablePayloadSignatureAndState',
        'entity_states' => 'setEntityStates',
        'name' => 'setName',
        'notify_every_change' => 'setNotifyEveryChange',
        'state' => 'setState'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'enable_payload_signature_and_state' => 'getEnablePayloadSignatureAndState',
        'entity_states' => 'getEntityStates',
        'name' => 'getName',
        'notify_every_change' => 'getNotifyEveryChange',
        'state' => 'getState'
    ];

    

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
        
        $this->container['enable_payload_signature_and_state'] = isset($data['enable_payload_signature_and_state']) ? $data['enable_payload_signature_and_state'] : null;
        
        $this->container['entity_states'] = isset($data['entity_states']) ? $data['entity_states'] : null;
        
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        
        $this->container['notify_every_change'] = isset($data['notify_every_change']) ? $data['notify_every_change'] : null;
        
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
        
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if (!is_null($this->container['name']) && (mb_strlen($this->container['name']) > 50)) {
            $invalidProperties[] = "invalid value for 'name', the character length must be smaller than or equal to 50.";
        }

        return $invalidProperties;
    }

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
     * Gets enable_payload_signature_and_state
     *
     * @return bool
     */
    public function getEnablePayloadSignatureAndState()
    {
        return $this->container['enable_payload_signature_and_state'];
    }

    /**
     * Sets enable_payload_signature_and_state
     *
     * @param bool $enable_payload_signature_and_state Whether signature header and 'state' property are enabled in webhook payload.
     *
     * @return $this
     */
    public function setEnablePayloadSignatureAndState($enable_payload_signature_and_state)
    {
        $this->container['enable_payload_signature_and_state'] = $enable_payload_signature_and_state;

        return $this;
    }
    

    /**
     * Gets entity_states
     *
     * @return string[]
     */
    public function getEntityStates()
    {
        return $this->container['entity_states'];
    }

    /**
     * Sets entity_states
     *
     * @param string[] $entity_states The entity's target states that are to be monitored.
     *
     * @return $this
     */
    public function setEntityStates($entity_states)
    {
        $this->container['entity_states'] = $entity_states;

        return $this;
    }
    

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name The name used to identify the webhook listener.
     *
     * @return $this
     */
    public function setName($name)
    {
        if (!is_null($name) && (mb_strlen($name) > 50)) {
            throw new \InvalidArgumentException('invalid length for $name when calling AbstractWebhookListenerUpdate., must be smaller than or equal to 50.');
        }

        $this->container['name'] = $name;

        return $this;
    }
    

    /**
     * Gets notify_every_change
     *
     * @return bool
     */
    public function getNotifyEveryChange()
    {
        return $this->container['notify_every_change'];
    }

    /**
     * Sets notify_every_change
     *
     * @param bool $notify_every_change Whether every update of the entity or only state changes are to be monitored.
     *
     * @return $this
     */
    public function setNotifyEveryChange($notify_every_change)
    {
        $this->container['notify_every_change'] = $notify_every_change;

        return $this;
    }
    

    /**
     * Gets state
     *
     * @return \WhiteLabelMachineName\Sdk\Model\CreationEntityState
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param \WhiteLabelMachineName\Sdk\Model\CreationEntityState $state The object's current state.
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->container['state'] = $state;

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


