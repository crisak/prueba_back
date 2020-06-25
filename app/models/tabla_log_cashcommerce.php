<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class tabla_log_cashcommerce extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $recibido;

    /**
     * @var string
     */
    public $transaction_gateway_id;

    /**
     * @var string
     */
    public $ammount;
    /**
     * @var string
     */
    public $transaction_date;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $transaction;
    /**
     * @var string
     */
    public $state;
        /**
     * @var string
     */
    public $state_description;
        /**
     * @var string
     */
    public $signature;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

}