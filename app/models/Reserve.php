    <?php

use Phalcon\Mvc\Model;

/**
 * Types of Products
 */
class Reserve extends Model
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

    public function searchReserve($id_client){


        $sql = "
                SELECT reserve.* , cellar.name , cellar.address , cellar.image , city.city , method_pay.name as pay FROM reserve INNER JOIN method_pay on reserve.type_pay = method_pay.id INNER JOIN cellar on reserve.id_cellar = cellar.id INNER JOIN city on cellar.id_city = city.id WHERE reserve.id_client = $id_client ORDER BY reserve.id ASC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchDetailReserve($id , $id_client){


        $sql = "
                SELECT reserve.* , cellar.name , cellar.address , cellar.image , cellar.storage_cost as cost , city.city , method_pay.name as pay , cellar.name_contact as supervisor , cellar.phone_contact , cellar.email_contact , cellar.address FROM reserve 
                    INNER JOIN method_pay on reserve.type_pay = method_pay.id 
                    INNER JOIN cellar on reserve.id_cellar = cellar.id 
                    INNER JOIN city on cellar.id_city = city.id
                    WHERE reserve.id = '$id' AND reserve.id_client = $id_client ORDER BY reserve.id ASC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchServiceReserve($id){


        $sql = "
                SELECT service.name , service.cost FROM service INNER JOIN reserved_service on service.id = reserved_service.id_service WHERE reserved_service.id_reserve = '$id' DESC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchServiceCost($id){


        $sql = "
                SELECT sum(service.cost) as cost FROM service INNER JOIN reserved_service on service.id = reserved_service.id_service WHERE reserved_service.id_reserve = '$id'";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchReserveCurso($id_client){


        $sql = "SELECT  reserve.*,
                        cellar.name,
                        cellar.address,
                        cellar.image,
                        city.city,
                        method_pay.name as pay
                        FROM reserve
                        INNER JOIN method_pay on reserve.type_pay = method_pay.id
                        INNER JOIN cellar on reserve.id_cellar = cellar.id
                        INNER JOIN city on cellar.id_city = city.id
                        WHERE reserve.id_client = $id_client
                        ORDER BY reserve.id DESC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchReserveCursoStatus($id_client , $status , $initial_date , $final_date){


        $sql = "
                SELECT reserve.* , cellar.name , cellar.address , cellar.image , city.city , method_pay.name as pay FROM reserve 
                    INNER JOIN method_pay on reserve.type_pay = method_pay.id INNER JOIN cellar on reserve.id_cellar = cellar.id 
                    INNER JOIN city on cellar.id_city = city.id 
                    WHERE reserve.id_client = $id_client AND 
                    reserve.status = '$status' AND reserve.initial_date >='$initial_date' AND reserve.final_date <= '$final_date' ORDER BY reserve.id DESC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchReserveLastDay($id_client , $date){


        $sql = "
                SELECT reserve.* , cellar.name , cellar.address , cellar.image , city.city , method_pay.name as pay FROM reserve INNER JOIN method_pay on reserve.type_pay = method_pay.id INNER JOIN cellar on reserve.id_cellar = cellar.id INNER JOIN city on cellar.id_city = city.id WHERE reserve.id_client = $id_client AND reserve.created_at >= '$date' ORDER BY reserve.id ASC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;
    }

    public function searchTransactionClient($client_id,$start_date = null ,$end_date = null){

        if($start_date != null and $end_date  != null){
            $sqlWhere = "initial_date BETWEEN '$start_date' and '$end_date' and final_date BETWEEN '$start_date' and '$end_date'";
        } else{
            $sqlWhere = "initial_date (now()::date-INTEGER '7') AND final_date now()";
        }
    

        $sql = "SELECT reserve.* , 
                cellar.name , 
                cellar.address , 
                cellar.image , 
                city.city , 
                method_pay.name as pay 
                FROM reserve 
                INNER JOIN method_pay on reserve.type_pay = method_pay.id 
                INNER JOIN cellar on reserve.id_cellar = cellar.id 
                JOIN city on cellar.id_city = city.id 
                WHERE reserve.id_client = '$client_id' and $sqlWhere ORDER BY reserve.id ASC";

        $prepare = $this->getDi()->getShared("db")->prepare($sql);
        $prepare->execute();
        return $prepare;

    }
}