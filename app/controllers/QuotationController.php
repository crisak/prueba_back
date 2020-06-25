<?php

class QuotationController extends ControllerBase {

    /**
     * 
     *
     */ 

    public function reservationCellarAction() {
        $dataRequest = $this->request->getJsonPost();
        $dateTime = new \DateTime();
        $fields = array(
            "phone",
            "id_cellar",
            "storage_cost",
            "handling_cost",
            "cubic_meters",
            "initial_date",
            "final_date",
            "deposit_capacity",
            "id_client",
            "type_pay",
            "transaction_id"
            
        );
        $optional  = array(
            "service"

        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
                try {  
                    $initial_date = $dataRequest->initial_date; 

                    $initial_new = date('Y-m-d', strtotime(str_replace('-', '/', $initial_date)));

                    $final_date = $dataRequest->final_date; 

                    $final_new = date('Y-m-d', strtotime(str_replace('-', '/', $final_date)));

                    $de = $dataRequest->cubic_meters;
                    $cap = $dataRequest->deposit_capacity;

                    $cubicModel = new Cellar();
                    $cubicSql = $cubicModel->searchTest($dataRequest->id_cellar , $initial_new , $final_new);
                    while ($row = $cubicSql->fetch(PDO::FETCH_ASSOC)) {

                        $cub = $row;
                    }

                    $depositModel = new Cellar();

                    $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id_cellar);
                    while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {
                        $deposit = $row;
                    }

                    $deptotal = $deposit['deposit_capacity'] - $cub['c'];
                    $storage_cost = filter_var($dataRequest->storage_cost, FILTER_SANITIZE_NUMBER_INT);

                    $client = Client::findFirst(array(
                                    "conditions" => "id = ?1",
                                    "bind" => array(1 => $dataRequest->id_client)
                              ));

                    if (isset($dataRequest->phone))
                    {
                        $client->phone = $dataRequest->phone;
                        $client->save();
                    }
                    
                            $reservet = new Reserve();
                            $reservet->id_cellar = $dataRequest->id_cellar;
                            $reservet->cubic_meters = $dataRequest->cubic_meters;
                            $reservet->initial_date = $initial_new;
                            $reservet->final_date = $final_new;
                            $reservet->storage_cost = $storage_cost;
                            $reservet->handling_cost = $dataRequest->handling_cost;
                            $reservet->id_client = $dataRequest->id_client;
                            $reservet->type_pay = $dataRequest->type_pay;
                            $reservet->id_transaction = $dataRequest->transaction_id;
                            $reservet->status = 'Por aceptar';
                            $reservet->created_at = $dateTime->format('Y-m-d H:i:s');
                            $reservet->save();
                            // print_r($reservet);die;
                            // $servicenameModel = new Cellar();

                            //     if (isset($dataRequest->service)) {
                            //         $service2 = $dataRequest->service;

                            //         $servicenameSql = $servicenameModel->searchServiceN($service2);
                            //         while ($row4 = $servicenameSql->fetch(PDO::FETCH_ASSOC)) {

                            //             $row3[] = array (
                            //                 $reserved_service = new Reserved_service(),
                            //                 $reserved_service->id_reserve = $reservet->id,
                            //                 $reserved_service->id_service = $row4['id'],
                            //                 $reserved_service->save(),

                            //             );
                            //         }


                            //     }

                                $id_cellar =  $dataRequest->id_cellar;
                                $quantity = $dataRequest->cubic_meters;
                                $initial_date = $dataRequest->initial_date;
                                $final_date = $dataRequest->final_date;

                                // for($i=$initial_date;$i<=$final_date;$i++){

                                //     $con = Ocu::findFirst(array(
                                //                 "conditions" => "id_cellar = ?1 AND initial_date = ?2",
                                //                 "bind" => array(1 => $dataRequest->id_cellar , 2 => $i)
                                //           ));

                                //     $data [] = $i;



                                //     if ($con == true) {

                                //         $lol = Ocu::findFirst(array(
                                //                 "conditions" => "id_cellar = ?1 AND initial_date = ?2",
                                //                 "bind" => array(1 => $dataRequest->id_cellar , 2 => $i)
                                //         ));


                                //         if (isset($quantity)){
                                //             $lol->quantity = $lol->quantity + $quantity;

                                //         $lol->save();
                                //         }


                                //     } else {

                                //         $ocupation = new Ocu;
                                //         $ocupation->id_cellar = $id_cellar;
                                //         $ocupation->quantity = $quantity; 
                                //         $ocupation->initial_date = $i;
                                //         $ocupation->final_date = $i;
                                //         $ocupation->save();  
                                //     }

                                    
                                // }
                       
                        if($reservet == true){


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "dat0" => "true",
                                "message" => CellarConstants::CELLAR_SAVE_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));
                        }else {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }
                    
                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

    public function reservationCellaralmaboxAction() {
        $dataRequest = $this->request->getJsonPost();
        $dateTime = new \DateTime();
        $fields = array(
            "phone",
            "id_cellar",
            "storage_cost",
            "handling_cost",
            "cubic_meters",
            "initial_date",
            "final_date",
            "deposit_capacity",
            "id_client",
            "type_pay",
            "transaction_id"
            
        );

        $optional  = array(
            // "service"

        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
                try {  
                    $initial_date = $dataRequest->initial_date; 

                    $initial_new = date('Y-m-d', strtotime(str_replace('-', '/', $initial_date)));

                    $final_date = $dataRequest->final_date; 

                    $final_new = date('Y-m-d', strtotime(str_replace('-', '/', $final_date)));

                    $de = $dataRequest->cubic_meters;
                    $cap = $dataRequest->deposit_capacity;

                    $cubicModel = new Cellar();
                    $cubicSql = $cubicModel->searchTest($dataRequest->id_cellar , $initial_new , $final_new);
                    while ($row = $cubicSql->fetch(PDO::FETCH_ASSOC)) {

                        $cub = $row;
                    }

                    $depositModel = new Cellar();

                    $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id_cellar);
                    while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {
                        $deposit = $row;
                    }

                    $deptotal = $deposit['deposit_capacity'] - $cub['c'];
                    $storage_cost = filter_var($dataRequest->storage_cost, FILTER_SANITIZE_NUMBER_INT);

                    $client = Client::findFirst(array(
                                    "conditions" => "id = ?1",
                                    "bind" => array(1 => $dataRequest->id_client)
                              ));

                    if (isset($dataRequest->phone))
                    {
                        $client->phone = $dataRequest->phone;
                        $client->save();
                    }
                    
                            $reservet = new Reserve();
                            $reservet->id_cellar = $dataRequest->id_cellar;
                            $reservet->cubic_meters = $dataRequest->cubic_meters;
                            $reservet->initial_date = $initial_new;
                            $reservet->final_date = $final_new;
                            $reservet->storage_cost = $storage_cost;
                            $reservet->handling_cost = $dataRequest->handling_cost;
                            $reservet->id_client = $dataRequest->id_client;
                            $reservet->type_pay = $dataRequest->type_pay;
                            $reservet->id_transaction = $dataRequest->transaction_id;
                            $reservet->status = 'Por aceptar';
                            $reservet->created_at = $dateTime->format('Y-m-d H:i:s');
                            $reservet->save();
                            // print_r($reservet);die;
                            // $servicenameModel = new Cellar();

                            //     if (isset($dataRequest->service)) {
                            //         $service2 = $dataRequest->service;

                            //         $servicenameSql = $servicenameModel->searchServiceN($service2);
                            //         while ($row4 = $servicenameSql->fetch(PDO::FETCH_ASSOC)) {

                            //             $row3[] = array (
                            //                 $reserved_service = new Reserved_service(),
                            //                 $reserved_service->id_reserve = $reservet->id,
                            //                 $reserved_service->id_service = $row4['id'],
                            //                 $reserved_service->save(),

                            //             );
                            //         }


                            //     }

                            //     $id_cellar =  $dataRequest->id_cellar;
                            //     $quantity = $dataRequest->cubic_meters;
                            //     $initial_date = $dataRequest->initial_date;
                            //     $final_date = $dataRequest->final_date;

                            //     for($i=$initial_date;$i<=$final_date;$i++){

                            //         $con = Ocu::findFirst(array(
                            //                     "conditions" => "id_cellar = ?1 AND initial_date = ?2",
                            //                     "bind" => array(1 => $dataRequest->id_cellar , 2 => $i)
                            //               ));

                            //         $data [] = $i;



                            //         if ($con == true) {

                            //             $lol = Ocu::findFirst(array(
                            //                     "conditions" => "id_cellar = ?1 AND initial_date = ?2",
                            //                     "bind" => array(1 => $dataRequest->id_cellar , 2 => $i)
                            //             ));


                            //             if (isset($quantity)){
                            //                 $lol->quantity = $lol->quantity + $quantity;

                            //             $lol->save();
                            //             }


                            //         } else {

                            //             $ocupation = new Ocu;
                            //             $ocupation->id_cellar = $id_cellar;
                            //             $ocupation->quantity = $quantity; 
                            //             $ocupation->initial_date = $i;
                            //             $ocupation->final_date = $i;
                            //             $ocupation->save();  
                            //         }

                                    
                            //     }
                       
                        if($reservet == true){


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $reservet,
                                "message" => CellarConstants::CELLAR_SAVE_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));
                        }else {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }
                    
                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

    public function pageconfirmationAction() {

        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "transaction_gateway_id",
            "ammount",
            "transaction_date",
            "transaction",
            "state",
            "state_description",
            "signature"
            
        );

        $optional  = array(
            // "service"

        );
        // echo print_r($dataRequest);die;
        if ($this->_checkFields($dataRequest, $fields, $optional)) {   
                try {  

                    $table_log_cashcommerce = new TablaLogCashcommerce();
                    $table_log_cashcommerce->transaction_gateway_id = $dataRequest->transaction_gateway_id;
                    $table_log_cashcommerce->ammount = intval($dataRequest->ammount);
                    $table_log_cashcommerce->transaction_date =$dataRequest->transaction_date;
                    $table_log_cashcommerce->transaction = $dataRequest->transaction;
                    $table_log_cashcommerce->state = intval($dataRequest->state);
                    $table_log_cashcommerce->state_description = $dataRequest->state_description;
                    $table_log_cashcommerce->signature = $dataRequest->signature;
                  
                    
                    if($table_log_cashcommerce->save()){


                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "data" => $table_log_cashcommerce,
                            "message" => CellarConstants::CELLAR_SAVE_SUCCESS,
                            "status" => ControllerBase::SUCCESS
                        ));

                    }else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                            "status" => ControllerBase::FAILED
                        ));
                    }

                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

    /**
     * 
     *
     */ 

    public function testCellarAction() {
        $dataRequest = $this->request->getJsonPost();
        $dateTime = new \DateTime();
        $fields = array(
            "id_cellar",
            "quantity",
            "initial_date",
            "final_date"
            
        );
        $optional  = array(
            "service"

        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
                try { 

                    $id_cellar =  $dataRequest->id_cellar;
                    $quantity = $dataRequest->quantity;
                    $initial_date = $dataRequest->initial_date;
                    $final_date = $dataRequest->final_date;

                    for($i=$initial_date;$i<=$final_date;$i = date("Y-m-d", strtotime(str_replace('-', '/',$i ."+ 1 days")))){

                        $con = Ocu::findFirst(array(
                                    "conditions" => "id_cellar = ?1 AND initial_date = ?2",
                                    "bind" => array(1 => $dataRequest->id_cellar , 2 => $i)
                              ));

                        $data [] = $i;
                        if ($con == true) {

                            $lol = Ocu::findFirst(array(
                                    "conditions" => "id_cellar = ?1 AND initial_date = ?2",
                                    "bind" => array(1 => $dataRequest->id_cellar , 2 => $i)
                            ));


                            if (isset($quantity)){
                                $lol->quantity = $lol->quantity + $quantity;

                            $lol->save();
                            }


                        } else {

                            $ocupation = new Ocu;
                            $ocupation->id_cellar = $id_cellar;
                            $ocupation->quantity = $quantity; 
                            $ocupation->initial_date = $i;
                            $ocupation->final_date = $i;
                            $ocupation->save();  
                        }

                        
                    }
                       
                    if(2 < 1 ){


                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "lol" => $data,
                            "message" => CellarConstants::CELLAR_SAVE_SUCCESS,
                            "status" => ControllerBase::SUCCESS
                        ));
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "data" => $data,
                            "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                            "status" => ControllerBase::FAILED
                        ));
                    }

                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

           /**
     * 
     *
     */ 

     public function quotationCellarAction() {
        $dataRequest = $this->request->getJsonRawBody();
        $dateTime = new \DateTime();
        $fields = array(
            "id_cellar",
            "initial_date",
            "final_date",
            "cubic_meters"
        );
        $optional  = array(
            "service"
        );
                    // print_r($dataRequest);die;
                
               // debuguear el dataRequest 
    //            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
    //             "return" => true,
    //             "message" => "TODO bien" ,
    //             "data"=> $dataRequest,
    //             "status" => ControllerBase::SUCCESS                
    //         ));die;

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
                try {  



                    $initial_date = $dataRequest->initial_date; 

                    $initial_new = date('Y/m/d', strtotime(str_replace('/', '-', $initial_date)));

                    $final_date = $dataRequest->final_date; 

                    $final_new = date('Y/m/d', strtotime(str_replace('/', '-', $final_date)));

                    $dias   = (strtotime($initial_new)-strtotime($final_new))/86400;
                    $dias   = abs($dias); 
                    $dias = floor($dias);     

   
                    

                    $de = $dataRequest->cubic_meters;

                    $cubicModel = new Cellar();
                    $cubicSql = $cubicModel->searchTest($dataRequest->id_cellar , $initial_new , $final_new);
                    while ($row = $cubicSql->fetch(PDO::FETCH_ASSOC)) {

                        $cub = $row;
                    }

                    $depositModel = new Cellar();

                    $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id_cellar);
                    // print_r($depositSql);die;
                    while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {
                        $deposit = $row;
                    }
                    // print_r($deposit);die;
                    if ($deposit['type_area'] == 'Metros cubicos'){
                        if ($dias < 5){
                            $sol = 5;
                        }else{
                            $sol = $dias + 1;
                        }
                    }else{
                        if ($dias > 31){
                            $operacion = $dias/30;
                            $sol = explode(".",$operacion);
                            $sol = $sol[0];
                            $sol = intval($sol)+1;
                            
                        }else{                            
                            $sol = 1;
                        }
                    }
                    
                    $serviceModel = new Cellar();

                    $service_cost = 0;

                    if (isset($dataRequest->service)) {
                        
                        $service = $dataRequest->service;
                        $serviceSql = $serviceModel->searchService($service);
                        while ($row = $serviceSql->fetch(PDO::FETCH_ASSOC)) {
                            $service = $row;
                        }
                        $service_cost = $service['cost'];
                        
                    }
                    
                    $service4[] = '';
                    $service5 = 0;

                    $servicenameModel = new Cellar();

                    if (isset($dataRequest->service)) {
                        $service2 = $dataRequest->service;
                        $service5 = implode(",", $service2);
                        
                        $servicenameSql = $servicenameModel->searchServiceName($service2);
                        // print_r($servicenameSql);die;
                        while ($row4 = $servicenameSql->fetch(PDO::FETCH_ASSOC)) {
                            // print_r($row4['id']);die;
                            $service4[] = array(                                
                                "id" => $row4['id'],
                                "name" => $row4['name'],
                            );
                        }
                        // print_r($service4);die;
                    }


                   

                    $deptotal = $deposit['deposit_capacity'] - $cub['c'];

                    $data = array(

                        'id_cellar' => $deposit['id'],
                        'name' => $deposit['name'],
                        'city' => $deposit['city'],
                        'address' => $deposit['address'],
                        "type_area" => $deposit['type_area'],
                        "cellar_type" => $deposit['cellar_type'],
                        'deposit_capacity' => $deposit['deposit_capacity'],
                        'storage_cost' => number_format(($deposit['storage_cost'] * $sol * $dataRequest->cubic_meters)+ $service_cost),
                        'initial_date' => $dataRequest->initial_date,
                        'final_date' => $dataRequest->final_date,
                        'supervisor' => $deposit['name_contact'],
                        'space_require' => $dataRequest->cubic_meters,
                        'deptotal' => $deptotal,
                        'service5' => $service5


                    );

                              

                    // print_r($data);die;
                    if ($data) {

                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => 'Datos de la Bodega para Reservar',
                                "data" => $data,
                                "service" => $service4,                                
                                "status" => ControllerBase::SUCCESS
                            ));
                        
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                            "data" => "No se realizo la consulta correctamente",
                            "status" => ControllerBase::FAILED
                        ));
                    }
                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

    public function quotationTruckAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id",
            "initial_date",
            "hour",
            "type_load",
            "id_city",
            "id_city2",
            "name_city",
            "name_city2",
            "type_truck",
            
        );

        if ($this->_checkFields($dataRequest, $fields)) {
            
                try {  

                    $id_Truck = new Truck();
                    $truckSql = $id_Truck->searchIdTruck($dataRequest->id);

                    $city = new City();
                    $cityoriSql = $city->searchCityforTruck($dataRequest->id_city);
                    $citydesSql = $city->searchCityforTruck($dataRequest->id_city2);
                    $rowcityori = $cityoriSql->fetch(PDO::FETCH_ASSOC);
                    $rowcitydes = $citydesSql->fetch(PDO::FETCH_ASSOC);

                    // Tarifa Urbana
                    if ($rowcityori['id'] == 19 && $rowcitydes['id'] == 19){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 250000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 380000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 900000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 1300000;
                        }
                    }elseif ($rowcityori['id'] == 117 && $rowcitydes['id'] == 117){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 210000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 300000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 750000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 900000;
                        }
                    }elseif ($rowcityori['id'] == 75 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 98 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 129 && $rowcitydes['id'] == 129 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 159 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 183){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 220000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 320000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 750000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 900000;
                        }
                    }

                    // Tarifa Nacional
                    // Aguazul = 19
                    // Armenia = 75
                    // Barranquilla = 98
                    // Bogota = 117
                    // Bucaramanga = 127
                    // Buenaventura = 129
                    // Cali = 159
                    // Cartagena = 183
                    if ($rowcityori['id'] == 19 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 75 && $rowcitydes['id'] == 19 || $rowcityori['id'] == 75 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 117 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 117 && $rowcitydes['id'] == 183 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 183){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 1850000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2050000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 3200000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 3800000;
                        }
                    }elseif ($rowcityori['id'] == 19 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 19 && $rowcitydes['id'] == 183 || $rowcityori['id'] == 75 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 75 && $rowcitydes['id'] == 183 || $rowcityori['id'] == 98 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 98 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 129){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 1950000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2300000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 4200000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 4800000;
                        }
                    }elseif ($rowcityori['id'] == 19 && $rowcitydes['id'] == 117 || $rowcityori['id'] == 75 && $rowcitydes['id'] == 117){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 900000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1100000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 2200000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 2900000;
                        }
                    }elseif ($rowcityori['id'] == 19 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 19 && $rowcitydes['id'] == 129 || $rowcityori['id'] == 19 && $rowcitydes['id'] == 159 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 19){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 1200000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1450000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 3500000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 4200000;
                        }
                    }elseif ($rowcityori['id'] == 75 && $rowcitydes['id'] == 129){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 750000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1050000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 1800000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 2600000;
                        }
                    }elseif ($rowcityori['id'] == 75 && $rowcitydes['id'] == 159){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 650000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 950000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 1600000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 2400000;
                        }
                    }elseif ($rowcityori['id'] == 98 && $rowcitydes['id'] == 19 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 19){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 2350000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2750000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 5050000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 5800000;
                        }
                    }elseif ($rowcityori['id'] == 98 && $rowcitydes['id'] == 117 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 19 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 19 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 117){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 2100000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2450000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 4800000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 5600000;
                        }
                    }elseif ($rowcityori['id'] == 98 && $rowcitydes['id'] == 129 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 129 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 129){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 2800000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 3050000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 6500000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 7100000;
                        }
                    }elseif ($rowcityori['id'] == 98 && $rowcitydes['id'] == 159 || $rowcityori['id'] == 127 && $rowcitydes['id'] == 159 || $rowcityori['id'] == 129 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 159){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 2600000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2800000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 5200000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 5900000;
                        }
                    }elseif ($rowcityori['id'] == 98 && $rowcitydes['id'] == 183 || $rowcityori['id'] == 117 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 129 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 75 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 98){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 850000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1050000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 1800000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 2200000;
                        }
                    }elseif ($rowcityori['id'] == 117 && $rowcitydes['id'] == 19 || $rowcityori['id'] == 117 && $rowcitydes['id'] == 127){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 1250000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1600000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 2800000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 3200000;
                        }
                    }elseif ($rowcityori['id'] == 117 && $rowcitydes['id'] == 129 || $rowcityori['id'] == 117 && $rowcitydes['id'] == 159){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 1100000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1300000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 2700000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 3200000;
                        }
                    }elseif ($rowcityori['id'] == 127 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 129 && $rowcitydes['id'] == 159 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 129){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 950000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1200000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 2200000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 2800000;
                        }
                    }elseif ($rowcityori['id'] == 127 && $rowcitydes['id'] == 129){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 750000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 900000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 2200000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 2800000;
                        }
                    }elseif ($rowcityori['id'] == 129 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 129 && $rowcitydes['id'] == 183 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 98 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 183){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 2340000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2760000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 5040000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 5760000;
                        }
                    }elseif ($rowcityori['id'] == 129 && $rowcitydes['id'] == 117 || $rowcityori['id'] == 159 && $rowcitydes['id'] == 117){
                        if($dataRequest->type_truck == 'Turbo'){
                            $costo = 1300000;
                        }elseif ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 1550000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 3800000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 4500000;
                        }
                    }elseif ($rowcityori['id'] == 98 && $rowcitydes['id'] == 127 || $rowcityori['id'] == 183 && $rowcitydes['id'] == 127){
                        if ($dataRequest->type_truck == 'Sencillo'){
                            $costo = 2100000;
                        }elseif ($dataRequest->type_truck == 'Minimula'){
                            $costo = 4600000;
                        }elseif ($dataRequest->type_truck == 'Tractomula'){
                            $costo = 5200000;
                        }
                    }

                        while ($row = $truckSql->fetch(PDO::FETCH_ASSOC)) {

                            $data[] = array(
                                "id" => $row['id'],
                                "name" => $row['name'],
                                "city" => $row['city'],
                                "image_map" => $row['image_map_truck'],
                                "image" => $row['image'],
                                "conductor" => $row['driver_name'],
                                "cost" => number_format($costo),
                                "capacity" => $row['capacity'],
                                "initial_date" => $dataRequest->initial_date,
                                "hour" => $dataRequest->hour,
                                "horasinsegundos" => substr($dataRequest->hour, 0,-3),
                                "type_load" => $dataRequest->type_load,
                                "id_city" => $dataRequest->id_city,
                                "id_city2" => $dataRequest->id_city2,
                                "name_city" => $dataRequest->name_city,
                                "name_city2" => $dataRequest->name_city2,
                                "type_truck" => $dataRequest->type_truck,

                            );

                        }

                
                    if (count($data) > 0){
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                            "data" => $data,
                            "status" => ControllerBase::SUCCESS
                        ));

                    } else {

                    $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => CellarConstants::LIST_CELLAR_FAILURE,                       
                            "status" => ControllerBase::FAILED
                        ));
                    }

                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }
    /**
     * 
     *
     */ 

    public function billingCellarAction() {
        $dataRequest = $this->request->getJsonPost();
        $dateTime = new \DateTime();
        $fields = array(
            "id_cellar",
            "storage_cost",
            "cubic_meters",
            "initial_date",
            "final_date",
            "id_client",
            "deposit_capacity"
            
        );
        $optional  = array(
            "service"

        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
                try {  
                    $initial_date = $dataRequest->initial_date; 

                    $initial_new = date('Y/m/d', strtotime(str_replace('/', '-', $initial_date)));

                    $final_date = $dataRequest->final_date; 

                    $final_new = date('Y/m/d', strtotime(str_replace('/', '-', $final_date)));

                    $client = Client::findFirst(array(
                        "conditions" => "id = ?1",
                        "bind" => array(1 => $dataRequest->id_client)
                    ));

                    $service4 = "";
                    $base_amount = intval(str_replace(".", "", $dataRequest->storage_cost));                
                    $iva = (19*$base_amount)/100;
                    $amount = $base_amount+$iva;
                    $transaction_id = date('His');
                    $ivanum = number_format($iva);
                    $amountnum = number_format($amount);
                    // $signature = hash('sha256','59~'.$transaction_id.'~'.$amount.'~ea9f55db13f0c2790a70f3718e80d72327e627272b02ec50c7e00e74438f74a8'); //Almagrario
                    // $signature = hash('sha256','81~'.$transaction_id.'~'.$amount.'~3c727ec903146f587cddd3d8add25c9af00bd2a96dffa61675dd9984425a51a4');    //Strouman
                    $signature = hash('sha256','83~'.$transaction_id.'~'.$amount.'~0f67174d46a328e78657f793a44cefdbbefbaa1db119f3f052e5f0cc73639bc7');    //Almagrario 2 quality
                    // $signature = hash('sha256','84~'.$transaction_id.'~'.$amount.'~0f67174d46a328e78657f793a44cefdbbefbaa1db119f3f052e5f0cc73639bc7');    //Seguros Mundial quality
                    
                    $depositModel = new Cellar();
                        $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id_cellar);
                        
                        while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {                                                                                
                            $name = $row['name'];
                            $address = $row['address'];
                            $image = $row['image'];
                            $city = $row['city'];
                            $image_url = $row['image_url'];
                        }


                    // if (isset($dataRequest->service)) {
                    //     $service = $dataRequest->service;

                    //     $servicenameModel = new Cellar();
                    //     $servicenameSql = $servicenameModel->searchServiceNa($service);

                    //     $depositModel = new Cellar();
                    //     $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id_cellar);
                        
                    //     while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {                                                                                
                    //         $name = $row['name'];
                    //         $address = $row['address'];
                    //         $image = $row['image'];
                    //         $city = $row['city'];
                    //         $image_url = $row['image_url'];
                    //     }
                    //     while ($row4 = $servicenameSql->fetch(PDO::FETCH_ASSOC)) {
                    //         $service4[] = array(                                
                    //             "name" => $row4['name']
                    //         );
                    //     }
                    // }

                    $data = array(

                        'id' => $dataRequest->id_cellar,
                        'storage_cost' => $dataRequest->storage_cost,
                        'space_require' => $dataRequest->cubic_meters,
                        'deposit_capacity' => $dataRequest->deposit_capacity,
                        'initial_date' => $dataRequest->initial_date,
                        'final_date' => $dataRequest->final_date,
                        // 'service' => $service,
                        'id_client' => $client->id,
                        'nameclient' => $client->name,
                        'document' => $client->document_client,
                        'phone' => $client->phone,
                        'email' => $client->email,
                        'address' => $address,
                        'image' => $image,
                        'name' => $name,
                        'signature' => $signature,
                        'transaction_id' => $transaction_id,
                        'base_amount' => $base_amount,
                        'iva' => $iva,
                        'amount' => $amount,
                        'city' => $city,
                        'image_url' => $image_url,
                        'ivanum' => $ivanum,
                        'amountnum' => $amountnum,

                    );

                   
                    if ($data > 0) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
                                "service" => $service4, 
                                "status" => ControllerBase::SUCCESS
                            ));
                    }
                        
                     else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                            "status" => ControllerBase::FAILED
                        ));
                    }
                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

    public function billingTruckAction() {
        $dataRequest = $this->request->getJsonPost();
        $dateTime = new \DateTime();
        $fields = array(
            "id_truck",
            "initial_date_truck",
            "hour",
            "type_load",
            "capacity",
            "id_client",
            "cost",
            "name_city",
            "name_city2",
            
        );
        $optional  = array(
            "service"

        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
                try {  
                    $initial_date = $dataRequest->initial_date_truck; 
                    $initial_new = date('Y/m/d', strtotime(str_replace('/', '-', $initial_date)));

                    $client = Client::findFirst(array(
                        "conditions" => "id = ?1",
                        "bind" => array(1 => $dataRequest->id_client)
                    ));

                    $service4 = "";
                    $base_amount = intval(str_replace(",", "", $dataRequest->cost));
                    $iva = (19*$base_amount)/100;
                    $amount = $base_amount+$iva;
                    $transaction_id = date('His');
                    $ivanum = number_format($iva);
                    $amountnum = number_format($amount);
                    $signature = hash('sha256','70~'.$transaction_id.'~'.$amount.'~ea9f55db13f0c2790a70f3718e80d72327e627272b02ec50c7e00e74438f74a8');
                    
                    $truck = new Truck();
                    $truckSql = $truck->searchIdTruck($dataRequest->id_truck);

                    while ($row = $truckSql->fetch(PDO::FETCH_ASSOC)) {
                        $name = $row['name'];
                        $image = $row['image'];
                        $city = $row['city'];
                        $image_url = $row['image_url'];
                    }

                    if (isset($dataRequest->service)) {
                        $service = $dataRequest->service;
                    
                        $depositModel = new Cellar();
                        $servicenameSql = $servicenameModel->searchServiceNa($service);                        
                        
                        while ($row4 = $servicenameSql->fetch(PDO::FETCH_ASSOC)) {
                            $service4[] = array(                                
                                "name" => $row4['name']
                            );
                        }
                    }

                    $data = array(

                        'id' => $dataRequest->id_truck,
                        'cost' => $dataRequest->cost,
                        'hour' => $dataRequest->hour,
                        'type_load' => $dataRequest->type_load,
                        'capacity' => $dataRequest->capacity,
                        'name_city' => $dataRequest->name_city,
                        'name_city2' => $dataRequest->name_city2,
                        'initial_date_truck' => $dataRequest->initial_date_truck,
                        'id_client' => $client->id,
                        'nameclient' => $client->name,
                        'document' => $client->document_client,
                        'phone' => $client->phone,
                        'email' => $client->email,
                        'image' => $image,
                        'name' => $name,
                        'signature' => $signature,
                        'transaction_id' => $transaction_id,
                        'base_amount' => $base_amount,
                        'iva' => $iva,
                        'amount' => $amount,
                        'city' => $city,
                        'image_url' => $image_url,
                        'ivanum' => $ivanum,
                        'amountnum' => $amountnum,

                    );

                   
                    if ($data > 0) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
                                "service" => $service4, 
                                "status" => ControllerBase::SUCCESS
                            ));
                    }
                        
                     else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => CellarConstants::RESERVE_CELLAR_FAILURE,
                            "status" => ControllerBase::FAILED
                        ));
                    }
                } catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }
            
        }
    }

}