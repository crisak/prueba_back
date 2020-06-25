<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class ReservedService extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $id_reserve;

    /**
     * @var string
     */
    public $id_service;



    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }


}