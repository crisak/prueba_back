<?php

use \Phalcon\Mvc\Model;

class Truck extends Model
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
    public $type_load;

    /**
     *
     * @var string
     */
    public $capacity;

    /**
     *
     * @var string
     */
    public $cost;

    /**
     *
     * @var integer
     */
    public $created_at;

    /**
     *
     * @var integer
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
    }

    public function searchDep(){


        $sql = "SELECT DISTINCT departament.departament, 
                departament.id 
                FROM departament 
                INNER JOIN truck on departament.id = truck.id_departament 
                ORDER BY departament.departament";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCit(){


        $sql = "SELECT DISTINCT city.city, 
                city.id, 
                departament.departament 
                FROM city 
                INNER JOIN truck on city.id = truck.id_city 
                INNER JOIN departament on truck.id_departament = departament.id 
                ORDER BY city.city";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchTruck(){


        $sql = "SELECT truck.id , 
                truck.name ,
                truck.id_city,
                truck.date,
                truck.hour,
                truck.image,
                truck.type_load,
                truck.freight_available, 
                departament.id as id_departament, 
                departament.departament, 
                city.id as id_city , 
                city.city 
                FROM truck 
                INNER JOIN departament ON truck.id_departament = departament.id 
                INNER JOIN city on truck.id_city = city.id 
                ORDER BY departament.departament";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchForCity($id_city){


        $sql = "SELECT truck.id, 
                truck.name,
                truck.id_city,
                truck.date,
                truck.hour,
                truck.image,
                truck.type_load,
                truck.capacity,
                truck.cost,
                truck.score_truck,
                truck.discount_truck,
                truck.freight_available,
                truck.frequency_reservation_truck,
                truck.time_hours_reservation_truck,
                city.id as id_city,
                city.city
                FROM truck
                INNER JOIN city on truck.id_city = city.id
                WHERE truck.id_city = $id_city";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchIdTruck($id){


        $sql = "SELECT truck.id, 
                       truck.name, 
                       truck.id_city,
                       city.city,
                       truck.image_map_truck, 
                       truck.image,
                       truck.cost,
                       truck.capacity,
                       truck.image_url,
                       employes.name as driver_name
                       FROM truck 
                       INNER JOIN city on truck.id_city = city.id
                       INNER JOIN employes on truck.id_employee = employes.id
                       WHERE truck.id = $id";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }    

}
