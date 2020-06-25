<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class Ocu extends Model
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }


}
