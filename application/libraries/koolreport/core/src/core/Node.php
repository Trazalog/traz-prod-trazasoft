<?php
/**
 * This file contains foundation class for legos-like structure of KoolReport
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */

namespace koolreport\core;

/**
 * This file contains foundation class for legos-like structure of KoolReport
 *
 * @category  Core
 * @package   KoolReport
 * @author    KoolPHP Inc <support@koolphp.net>
 * @copyright 2017-2028 KoolPHP Inc
 * @license   MIT License https://www.koolreport.com/license#mit-license
 * @link      https://www.koolphp.net
 */
class Node
{
    /**
     * List of nodes the object receive data from
     * 
     * @var array $sources List of nodes the object receive data from
     */
    protected $sources;
    
    /**
     * List of nods that object send data to
     * 
     * @var array $destinations List of nods that object send data to  
     */
    protected $destinations;
    
    /**
     * Whether node is ended receiving data
     * 
     * @var bool $is_end Whether node is ended receiving data
     */
    protected $is_ended=false;

    /**
     * Containing meta data for output data from this node
     * 
     * @var array $metaData Containing meta data for output data from this node
     */
    protected $metaData;

    /**
     * The current source that send data to this node.
     * 
     * @var Node $streamingSource The current source that send data to this node.
     */
    protected $streamingSource;
    

    /**
     * Constructor
     * 
     * Constructor
     * 
     * @return null
     */
    public function __construct()
    {
        $this->sources = array();
        $this->destinations = array();
        $this->metaData = array();
    }
        
    /**
     * Add a new node that this node will send data to
     * 
     * @param Node $node The node that data will be sent to
     * 
     * @return Node The new node
     */
    public function pipe($node)
    {
        array_push($this->destinations, $node);
        $node->source($this);
        return $node;
    }

    /**
     * Pipe with condition
     * 
     * @param bool     $condition     The condition to branch
     * @param function $trueFunction  The function will be called if condition is true
     * @param function $falseFunction The function will be alled if condition is false  
     * 
     * @return Node The new node in condition
     */
    public function pipeIf($condition, $trueFunction, $falseFunction = null)
    {
        if ($condition) {
            return $trueFunction($this);
        } else if ($falseFunction) {
            return $falseFunction($this);
        }
        return $this;
    }

    /**
     * Pipe from a node to multiple branches
     * ->pipeTree(
     *      function ($node){
     *          //Do thing
     *      },
     *      function ($node){
     *          //Do thing
     *      }
     * );
     * 
     * @return Node This node
     */
    public function pipeTree()
    {
        $params = func_get_args();
        foreach ($params as $func) {
            $func($this);
        }
        return $this;
    }


    /**
     * Get the previous source that send data to this node
     * 
     * This method is very helpful if we want to go trace back to the root
     * source that is sending data. Since a node can receive data from
     * multiple sources, the $index params help to return the node you need.
     * By default $index is 0 meaning the first node that streams data to this
     * node.
     * 
     * @param integer $index The index of the source that you want to get
     * 
     * @return Node The source that sends data to this node
     */
    public function previous($index=0)
    {
        if (count($this->sources)>0) {
            return Utility::get($this->sources, $index);
        }
        return null;
    }
    
    /**
     * Save the node to a variable
     * 
     * @param Node $self The variable you want to save node
     * 
     * @return Node Return this node
     */
    public function saveTo(&$self)
    {
        $self = $this;
        return $this;
    }
    
    /**
     * Add another source of data that stream data to this node
     * 
     * @param Node $source The source that stream data to this node
     * 
     * @return null
     */
    public function source($source)
    {
        //The one that forward data to.
        array_push($this->sources, $source);
    }
    
    /**
     * Get the meta data of the node
     * 
     * @return array Meta data of the node
     */
    public function meta()
    {
        return $this->metaData;
    }
    
    /**
     * Send data row to the next destinations
     * 
     * @param array $data An associate array epresenting a row of data
     * 
     * @return null
     */
    public function next($data)
    {
        if ($this->destinations!=null) {
            foreach ($this->destinations as $node) {
                $node->input($data, $this);
            }
        }
    }
  
    /**
     * Receive signal from source node that this node will be about to receive data
     * 
     * @param Node $source The source that is about to send data
     * 
     * @return null
     */
    public function startInput($source)
    {
        $this->streamingSource = $source;
        $this->is_ended = false;
        $this->onInputStart();
        foreach ($this->destinations as $node) {
            $node->startInput($this);
        }
    }
    
    /**
     * This method will be called when source nodes sending start input signal
     * 
     * @return null
     */
    protected function onInputStart()
    {

    }

    /**
     * Receive data from source
     * 
     * @param array $data   The associate array representing a row of data
     * @param array $source The previous node that sent data
     * 
     * @return null
     */
    public function input($data,$source)
    {
        $this->streamingSource = $source;
        $this->onInput($data);
    }
    
    /**
     * This method will be called when data is sending from the sources
     * 
     * @param array $data The associate array representing a row of data
     * 
     * @return null
     */
    protected function onInput($data)
    {
        $this->next($data);
    }

    /**
     * The source will call this method to tell that it finishes sending data
     * 
     * @param Node $source The source that sends data to
     * 
     * @return null
     */
    public function endInput($source)
    {
        $this->streamingSource = $source;
        $sourceAllEnded = true;
        foreach ($this->sources as $src) {
            $sourceAllEnded &= $src->isEnded();
        }
        if ($sourceAllEnded) {
            $this->is_ended = true;
            $this->onInputEnd();
            foreach ($this->destinations as $node) {
                $node->endInput($this);
            }
        }
    }
    
    /**
     * This method will be called when sources data is finishes
     * 
     * @return null
     */
    protected function onInputEnd()
    {

    }

    /**
     * Get whether this node is ended sending and receiving data.
     * 
     * @return bool Whether this node is ended sending and receiving data
     */
    public function isEnded()
    {
        return $this->is_ended;
    }

    /**
     * Set whether this node is ended sending and receiving data
     * 
     * @param bool $bool Whether true or false value to indicate whether data sending is ended
     * 
     * @return null
     */
    public function setEnded($bool)
    {
        $this->is_ended = $bool;
    }
        
    /**
     * Sending meta data to next nodes
     * 
     * @param array $metaData the meta data that will be sent to next nodes
     * 
     * @return null
     */
    protected function sendMeta($metaData)
    {
        foreach ($this->destinations as $node) {
            $node->receiveMeta($metaData, $this);
        }
    }

    /**
     * Recieving meta data from the source
     * 
     * @param array $metaData The meta data receiving from sources
     * @param array $source   The source that sends meta data
     * 
     * @return null
     */
    public function receiveMeta($metaData,$source)
    {
        $this->streamingSource = $source;
        $this->metaData = $metaData;
        $metaData = $this->onMetaReceived($metaData);
        $this->sendMeta($metaData);
    }

    /**
     * This method will be called when node received meta data
     * 
     * @param array $metaData The passing meta data
     * 
     * @return null
     */
    protected function onMetaReceived($metaData)
    {
        return $metaData;
    }

    /**
     * Request source nodes to send data.
     * 
     * @return Node This node object
     */
    public function requestDataSending()
    {
        if (!$this->isEnded()) {
            foreach ($this->sources as $source) {
                $source->requestDataSending();
            }
        }
        return $this;
    }
    
    /**
     * Get the report that holds this node
     * 
     * @return KoolReport The report that holds this node
     */
    public function getReport()
    {
        if (isset($this->sources[0])) {
            return $this->sources[0]->getReport();
        }
        return null;
    }
}