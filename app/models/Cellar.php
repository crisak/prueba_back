<?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class Cellar extends Model
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
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string
     */
    public $cost;

    /**
     * @var string
     */
    public $long;

    /**
     * @var string
     */
    public $width;

    /**
     * @var string
     */
    public $height;


    /**
     * @var string
     */
    public $image_map;


    /**
     * @var string
     */
    public $image;


    /**
     * @var string
     */
    public $deposit_capacity;

    /**
     * @var string
     */
    public $almacenamiento;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
       
    }

    public function searchDeposit($deposit_capacity){


        $sql = "
                SELECT cellar.id , cellar.city , cellar.description , cellar.address , cellar.storage_cost, cellar.handling_cost , cellar.deposit_capacity , cellar.image_map , cellar.image
                FROM cellar  
                WHERE cellar.deposit_capacity >= $deposit_capacity ORDER BY cellar.id ASC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCubic($id_cellar){


        $sql = "
                SELECT sum(cubic_meters) FROM reserve WHERE id_cellar = $id_cellar " ;

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchDeposit_capacity($id_cellar){


        $sql = "SELECT  cellar.id,
                        cellar.name,
                        cellar.id_city,
                        city.city,
                        cellar.description,
                        cellar.address,
                        cellar.storage_cost,
                        cellar.handling_cost ,
                        cellar.deposit_capacity,
                        cellar.image_map,
                        cellar.image,
                        cellar.image_url,
                        cellar.imagedos,
                        cellar.imagetres,
                        cellar.imagecuatro,
                        cellar.type_vehicle,
                        cellar.sizes_vehicle,
                        cellar.price_vehicle,
                        cellar.img_vehicle,
                        cellar.name_contact,
                        cellar.phone_contact,
                        cellar.email_contact,
                        cellar.minimum_time,
                        cellar.minimum_area,
                        cellar.type_area,
                        cellar.cellar_type,
                        cellar.discount,
                        cellar.collection_frequency,
                        cellar.time_hours_reservation,
                        cellar.frequency_reservation,
                        cellar.score,
                        schedule.weekday_opening,
                        schedule.saturday_opening,
                        schedule.sunday_opening,
                        schedule.festive_opening,
                        schedule.weekday_closing,
                        schedule.saturday_closing,
                        schedule.sunday_closing,
                        schedule.festive_closing
                FROM cellar 
                INNER JOIN city on cellar.id_city = city.id 
                INNER JOIN schedule on cellar.id = schedule.id_cellar 
                WHERE cellar.id = $id_cellar";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchDistance_cellar($id_cellar){


        $sql = "
                SELECT distance_cellar.point_location , distance_cellar.distance_point , distance_cellar.time_travel FROM distance_cellar
                    INNER JOIN cellar on cellar.id = distance_cellar.id
                    WHERE distance_cellar.id_cellar = $id_cellar "; 

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchService($service){

        $service = implode(",", $service);

        $sql = "
                SELECT sum(cost) as cost FROM service WHERE id IN($service) ";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchServiceName($service2){

       $service2 = implode(",", $service2);

        $sql = "
                SELECT id , name FROM service WHERE id IN($service2) ";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchServiceNa($service2){

     //   $service2 = implode(",", $service2);

        $sql = "
                SELECT id , name FROM service WHERE id IN($service2) ";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchServiceN($service2){

        $sql = "
                SELECT id  FROM service WHERE id IN($service2) ";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchTest($id_cellar , $initial_date , $final_date){


        $sql = "
                SELECT sum(cubic_meters) as c FROM reserve 
                    WHERE id_cellar = '$id_cellar' AND
                    ('$initial_date' BETWEEN initial_date AND final_date
                    OR 
                    '$final_date' BETWEEN initial_date AND final_date
                    OR 
                    (initial_date <= '$initial_date' AND final_date >= '$final_date'));";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchDepartament($id , $deposit_capacity, $measure){

        if($measure == 'cuadrado'){
            $measure = 'Metros cuadrados';
        }
        if($measure == 'patiocuadrado'){
            $measure = 'Metros cuadrados patio';
        }
        if($measure == 'estiba'){
            $measure = 'Posicion de estiba';
        }

        $sql = "SELECT  cellar.id,
                        cellar.name,
                        cellar.description,
                        cellar.address,
                        cellar.storage_cost,
                        cellar.handling_cost,
                        cellar.deposit_capacity,
                        cellar.image_map,
                        cellar.image,
                        cellar.type_area,
                        cellar.minimum_time,
                        cellar.minimum_area,
                        cellar.collection_frequency,
                        departament.id as id_departament,
                        departament.departament,
                        city.city,
                        cellar.discount,
                        cellar.time_hours_reservation,
                        cellar.frequency_reservation,
                        cellar.score,
                        cellar.status
                FROM cellar 
                INNER JOIN departament ON cellar.id_departament = departament.id 
                INNER JOIN city ON cellar.id_city = city.id 
                WHERE cellar.deposit_capacity >= $deposit_capacity AND cellar.id_departament = $id AND cellar.status = 'Activa' AND cellar.type_area = '$measure'
                ORDER BY cellar.id";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCity($id , $deposit_capacity, $measure){

        if($measure == 'cuadrado'){
            $measure = 'Metros cuadrados';
        }
        if($measure == 'patiocuadrado'){
            $measure = 'Metros cuadrados patio';
        }
        if($measure == 'estiba'){
            $measure = 'Posicion de estiba';
        }

        $sql = "SELECT  cellar.id,
                        cellar.name,
                        cellar.description,
                        cellar.address,
                        cellar.storage_cost,
                        cellar.handling_cost,
                        cellar.deposit_capacity,
                        cellar.image_map,
                        cellar.image,
                        cellar.image_url,
                        cellar.type_area,
                        cellar.minimum_time,
                        cellar.minimum_area,
                        cellar.collection_frequency,
                        departament.id as id_departament,
                        city.id as id_city,
                        departament.departament,
                        city.city,
                        cellar.discount,
                        cellar.time_hours_reservation,
                        cellar.frequency_reservation,
                        cellar.score,
                        cellar.status
                FROM cellar 
                INNER JOIN departament ON cellar.id_departament = departament.id 
                INNER JOIN city on cellar.id_city = city.id 
                WHERE cellar.deposit_capacity >= $deposit_capacity AND cellar.id_city = $id AND cellar.status = 'Activa' AND cellar.type_area = '$measure'
                ORDER BY cellar.id";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCellar(){


        $sql = "SELECT  cellar.id, 
                        cellar.name, 
                        cellar.description, 
                        cellar.address, 
                        cellar.storage_cost, 
                        cellar.handling_cost, 
                        cellar.deposit_capacity, 
                        cellar.image_map, 
                        cellar.image,
                        cellar.status,
                        cellar.cellar_type,
                        departament.id as id_departament, 
                        departament.departament , 
                        city.id as id_city , 
                        city.city 
                FROM cellar 
                INNER JOIN departament ON cellar.id_departament = departament.id
                INNER JOIN city on cellar.id_city = city.id
                WHERE cellar.status = 'Activa'
                ORDER BY departament.departament";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchDep(){


        $sql = "SELECT DISTINCT departament.departament,
                                departament.id,
                                cellar.status
                                FROM departament 
                                INNER JOIN cellar on departament.id = cellar.id_departament
                                WHERE cellar.status = 'Activa'
                                ORDER BY departament.departament";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCit(){


        $sql = "SELECT DISTINCT city.city,
                                city.id,
                                departament.departament,
                                cellar.status
                                FROM city INNER JOIN cellar on city.id = cellar.id_city
                                INNER JOIN departament on cellar.id_departament = departament.id
                                WHERE cellar.status = 'Activa'
                                ORDER BY city.city";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchC($id , $deposit_capacity, $measure){

        if($measure == 'cuadrado'){
            $measure = 'Metros cuadrados';
        }
        if($measure == 'patiocuadrado'){
            $measure = 'Metros cuadrados patio';
        }
        if($measure == 'estiba'){
            $measure = 'Posicion de estiba';
        }

        $sql = "SELECT  cellar.id,
                        cellar.name,
                        cellar.description,
                        cellar.address,
                        cellar.storage_cost,
                        cellar.handling_cost,
                        cellar.deposit_capacity,
                        cellar.image_map,
                        cellar.image,
                        cellar.image_url,
                        cellar.type_area,
                        cellar.minimum_time,
                        cellar.minimum_area,
                        cellar.collection_frequency,
                        departament.id as id_departament,
                        departament.departament,
                        city.city,
                        cellar.discount,
                        cellar.time_hours_reservation,
                        cellar.frequency_reservation,
                        cellar.score,
                        cellar.status
                FROM cellar 
                INNER JOIN departament ON cellar.id_departament = departament.id 
                INNER JOIN city on cellar.id_city = city.id 
                WHERE cellar.deposit_capacity >= $deposit_capacity AND cellar.id = $id AND cellar.status = 'Activa' AND cellar.type_area = '$measure'
                ORDER BY cellar.id";
                
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchCellarPartner(){


        $sql = "
                SELECT cellar.id , cellar.name , cellar.description , cellar.address , cellar.storage_cost, cellar.handling_cost , cellar.deposit_capacity , cellar.minimum_time , cellar.image , departament.departament , city.city FROM cellar INNER JOIN departament 
                ON cellar.id_departament = departament.id INNER JOIN city on cellar.id_city = city.id ORDER BY cellar.id";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchAlmabox($deposit_capacity, $category, $id_city){
        $sql = "SELECT  cellar.id,
                        cellar.name,
                        cellar.description,
                        cellar.address,
                        cellar.storage_cost,
                        cellar.handling_cost,
                        cellar.deposit_capacity,
                        cellar.image_map,
                        cellar.image,
                        cellar.image_url,
                        cellar.type_area,
                        cellar.minimum_time,
                        cellar.minimum_area,
                        cellar.collection_frequency,
                        cellar.cellar_type,
                        departament.id as id_departament,
                        departament.departament,
                        city.city,
                        cellar.discount,
                        cellar.time_hours_reservation,
                        cellar.frequency_reservation,
                        cellar.score,
                        cellar.status
                FROM cellar 
                INNER JOIN departament ON cellar.id_departament = departament.id 
                INNER JOIN city ON cellar.id_city = city.id 
                WHERE cellar.deposit_capacity = $deposit_capacity AND cellar.almacenamiento = '2' AND cellar.status = 'Activa' AND cellar.id_city = $id_city
                ORDER BY cellar.id";
        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }
}
/* cellar_type = 'Almacenamiento Personalizado' */