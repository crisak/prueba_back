<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class MethodPay extends Model
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

}
