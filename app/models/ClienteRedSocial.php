<?php

use \Phalcon\Mvc\Model;

class ClienteRedSocial extends Model
{

    /**
     *
     * @var bigint
     */
    public $id_cliente_red_social;

    /**
     *
     * @var integer
     */
    public $id_red_social;
    /**
     *
     * @var character varying
     */
    public $social_id;

    /**
     *
     * @var smallint
     */
    public $estado;

    /**
     *
     * @var timestamp without time zone
     */
    public $fecha_registro;

    /**
     *
     * @var timestamp without time zone
     */
    public $fecha_actualizacion;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
    }

}
