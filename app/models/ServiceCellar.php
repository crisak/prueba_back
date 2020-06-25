<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class ServiceCellar extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $id_cellar;

    /**
     * @var string
     */
    public $id_service;

    /**
     * @var string
     */
    public $cost_service;

    /**
     * @var string
     */
    public $description_service;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

}