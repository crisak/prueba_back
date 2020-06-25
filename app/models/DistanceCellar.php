<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class DistanceCellar extends Model
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
    public $point_location;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

}