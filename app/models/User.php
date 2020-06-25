<?php


use \Phalcon\Mvc\Model;

class User extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $pass;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

}
