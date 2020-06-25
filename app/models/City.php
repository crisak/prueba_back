<?php

use \Phalcon\Mvc\Model;

class City extends Model
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
    }

    public function searchCity(){


        $sql = "
               SELECT DISTINCT city.city , city.id , departament.id as id_departament FROM city INNER JOIN departament on city.id_departament = departament.id ORDER BY id LIMIT 1120";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCityforTruck($id_city2){

        $sql = "SELECT  city.city, 
                        city.id
                FROM city
                WHERE city.id = $id_city2";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;

    }

}