<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class Service extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $code;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

}