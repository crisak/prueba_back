<?php

class CellarController extends ControllerBase {



    public function newAction() {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();
        $fields = array(
            "name",
            "cellar_type",
            "description",
            "id_city",
            "address",
            "type_area",
            "deposit_capacity",
            "collection_frequency",
            "storage_cost",
            "handling_cost",
            "minimum_time",
            "image", 
            "name_contact",
            "phone_contact",
            "email_contact",
            "weekday_opening",
            "saturday_opening",
            "sunday_opening",
            "festive_opening",
            "weekday_closing",
            "saturday_closing",
            "sunday_closing",
            "festive_closing"


        );

        $optional = array(
            "description",
            "id_service",
            "cost_service",
            "description_service",
            "image_map",
            "point_location",
            "distance_point",
            "time_travel"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
                try {



                    $lol = Cellar::findFirst(array(
                                    "conditions" => "name= ?1",
                                    "bind" => array(1 => $dataRequest->name)
                              ));

                    $departament = City::findFirst(array(
                                    "conditions" => "id= ?1",
                                    "bind" => array(1 => $dataRequest->id_city)
                              ));
                    if (!isset($lol->id)){
                       
                        $cellar = new Cellar();
                        $cellar->name = $dataRequest->name;
                        $cellar->cellar_type = $dataRequest->cellar_type;
                        $cellar->description = $dataRequest->description;
                        $cellar->id_departament = $departament->id_departament;
                        $cellar->id_city = $dataRequest->id_city;
                        $cellar->address = $dataRequest->address;
                        $cellar->type_area = $dataRequest->type_area;
                        $cellar->deposit_capacity = $dataRequest->deposit_capacity;
                        $cellar->collection_frequency = $dataRequest->collection_frequency;
                        $cellar->storage_cost = $dataRequest->storage_cost;
                        $cellar->handling_cost = $dataRequest->handling_cost;
                        $cellar->minimum_time = $dataRequest->minimum_time;
                        $cellar->status = 'Activa';
                        $cellar->image = $dataRequest->image;
                        $cellar->name_contact = $dataRequest->name_contact;
                        $cellar->phone_contact = $dataRequest->phone_contact;
                        $cellar->email_contact = $dataRequest->email_contact;
                        $cellar->created_at = $dateTime->format('Y-m-d H:i:s');
                        $cellar->save();

                            $servicenameModel = new Cellar();

                            if (isset($dataRequest->id_service)) {
                                $service2[] = $dataRequest->id_service;

                                for($i=0; $i<count($service2); $i++ ){

                                    $id_cellar = $cellar->id;
                                    $id_service = $dataRequest->id_service[$i];
                                    $cost_service = $dataRequest->cost_service[$i];
                                    $description_service = $dataRequest->description_service[$i];

                                    $row3[] = array (
                                        $service_cellar = new Service_cellar(),
                                        $service_cellar->id_cellar = $id_cellar,
                                        $service_cellar->id_service = $id_service,
                                        $service_cellar->cost_service = $cost_service,
                                        $service_cellar->description_service = $description_service,
                                        $service_cellar->save(),

                                    );

                                }

                            }

                            $schedule = new Schedule();
                            $schedule->id_cellar = $cellar->id;
                            $schedule->weekday_opening = $dataRequest->weekday_opening;
                            $schedule->saturday_opening = $dataRequest->saturday_opening;
                            $schedule->sunday_opening = $dataRequest->sunday_opening;
                            $schedule->festive_opening = $dataRequest->festive_opening;
                            $schedule->weekday_closing = $dataRequest->weekday_closing;
                            $schedule->saturday_closing = $dataRequest->saturday_closing;
                            $schedule->sunday_closing = $dataRequest->sunday_opening;
                            $schedule->festive_closing = $dataRequest->festive_closing;
                            $schedule->created_at = $dateTime->format('Y-m-d H:i:s');
                            $schedule->save();

                       
                        if($cellar->save()){


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => CellarConstants::CELLAR_SAVE_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));

                        }else{


                            $errors = array();
                            foreach ($cellar->getMessages() as $msj) {
                                $errors[] = (string)$msj;
                            }
                            $this->setJsonResponse(ControllerBase::SUCCESS, " Failed register cellar", array(
                                "return" => false,
                                "message" => CellarConstants::CELLAR_SAVE_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));

                        }
                        
                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::CELLAR_SAVE_EXIST,
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
                

                }catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }   
            
        }
    }

    /*
    *Accion updateCellar: Actualizar datos del Cellar
    */
    public function updateCellarAction()
    {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();

        $fields = array(
            "id"
        );

        $optional = array(
            "name",
            "cellar_type",
            "description",
            "id_city",
            "address",
            "type_area",
            "deposit_capacity",
            "collection_frequency",
            "storage_cost",
            "handling_cost",
            "status",
            "minimum_time",
            "image", 
            "name_contact",
            "phone_contact",
            "email_contact",
            "weekday_opening",
            "saturday_opening",
            "sunday_opening",
            "festive_opening",
            "weekday_closing",
            "saturday_closing",
            "sunday_closing",
            "festive_closing",
            "id_service",
            "cost_service",
            "description_service",
            "image_map",
            "point_location",
            "distance_point",
            "time_travel"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

            try {

                $cellar = Cellar::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));

                $departament = City::findFirst(array(
                    "conditions" => "id= ?1",
                    "bind" => array(1 => $dataRequest->id_city)
                ));

                if (isset($dataRequest->name))
                    $cellar->name = $dataRequest->name;

                if (isset($dataRequest->cellar_type))
                    $cellar->cellar_type = $dataRequest->cellar_type;

                if (isset($dataRequest->description))
                    $cellar->description = $dataRequest->description;

                if (isset($departament->id_departament))
                    $cellar->id_departament = $departament->id_departament;

                if (isset($dataRequest->id_city))
                    $cellar->id_city = $dataRequest->id_city;

                if (isset($dataRequest->address))
                    $cellar->address = $dataRequest->address;

                if (isset($dataRequest->type_area))
                    $cellar->type_area = $dataRequest->type_area;

                if (isset($dataRequest->deposit_capacity))
                    $cellar->deposit_capacity = $dataRequest->deposit_capacity;

                if (isset($dataRequest->collection_frequency))
                    $cellar->collection_frequency = $dataRequest->collection_frequency;

                if (isset($dataRequest->storage_cost))
                    $cellar->storage_cost = $dataRequest->storage_cost;

                if (isset($dataRequest->handling_cost))
                    $cellar->handling_cost = $dataRequest->handling_cost;

                if (isset($dataRequest->status))
                    $cellar->status = $dataRequest->status;

                if (isset($dataRequest->minimum_time))
                    $cellar->minimum_time = $dataRequest->minimum_time;

                if (isset($dataRequest->image))
                    $cellar->image = $dataRequest->image;

                if (isset($dataRequest->image_map))
                    $cellar->image_map = $dataRequest->image_map;

                if (isset($dataRequest->name_contact))
                    $cellar->name_contact = $dataRequest->name_contact;

                if (isset($dataRequest->phone_contact))
                    $cellar->phone_contact = $dataRequest->phone_contact;

                if (isset($dataRequest->email_contact))
                    $cellar->email_contact = $dataRequest->email_contact;
                
                $cellar->updated_at = $dateTime->format('Y-m-d H:i:s');

                 $schedule = Schedule::findFirst(array(
                    "conditions" => "id_cellar = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));

                if (isset($dataRequest->weekday_opening))
                    $schedule->weekday_opening = $dataRequest->weekday_opening;

                if (isset($dataRequest->saturday_opening))
                    $schedule->saturday_opening = $dataRequest->saturday_opening;

                if (isset($dataRequest->sunday_opening))
                    $schedule->sunday_opening = $dataRequest->sunday_opening;

                if (isset($dataRequest->festive_opening))
                    $schedule->festive_opening = $dataRequest->festive_opening;

                if (isset($dataRequest->weekday_closing))
                    $schedule->weekday_closing = $dataRequest->weekday_closing;

                if (isset($dataRequest->saturday_closing))
                    $schedule->saturday_closing = $dataRequest->saturday_closing;

                if (isset($dataRequest->sunday_closing))
                    $schedule->sunday_closing = $dataRequest->sunday_closing;

                if (isset($dataRequest->festive_closing))
                    $schedule->festive_closing = $dataRequest->festive_closing;

                $schedule->updated_at = $dateTime->format('Y-m-d H:i:s');

                $schedule->save();


                if ($cellar->save()){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "message" => CellarConstants::CELLAR_UPDATE_SUCCESS,
                        "data" => $cellar,
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => CellarConstants::CELLAR_UPDATE_FAILURE,
                        "status" => ControllerBase::FAILED
                    ));
                }
                
            } catch (Exception $e) {
                $this->logError($e, $dataRequest);
            }
         
        }
    }

    /*
    *Accion detailCellar: Detalle de la Bodega
    */
    public function detailCellarAction()
    {
        $dataRequest = $this->request->getJsonPost();

        $fields = array(
            "id",
            "initial_date",
            "final_date",
            "space_require"
        );

        if ($this->_checkFields($dataRequest, $fields)) {

            try {
                
                $costotal = $dataRequest->costotal;
                $depositModel = new Cellar();
                $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id);
                    while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {

                        if ($row['sunday_opening'] == '00:00:00-05') {
                            $sunday_opening = 'No hay atención';
                        }

                        if ($row['festive_opening'] == '00:00:00-05') {
                            $festive_opening = 'No hay atención';
                        }

                        $data[] = array(

                                    "id" => $row['id'],
                                    "name" => $row['name'],
                                    "city" => $row['city'],
                                    "address" => $row['address'],
                                    "type_area" => $row['type_area'],
                                    "cellar_type" => $row['cellar_type'],
                                    "minimum_time" => $row['minimum_time'],
                                    "minimum_area" => $row['minimum_area'],
                                    "storage_cost" =>  $costotal,
                                    "handling_cost" =>  number_format($row['handling_cost']),
                                    "name_contact" => $row['name_contact'],
                                    "email_contact" => $row['email_contact'],
                                    "phone_contact" => $row['phone_contact'],
                                    "image_map" => $row['image_map'],
                                    "image" => $row['image'],
                                    "imagedos" => $row['imagedos'],
                                    "imagetres" => $row['imagetres'],
                                    "imagecuatro" => $row['imagecuatro'],
                                    "imagecuatro" => $row['imagecuatro'],
                                    "collection_frequency" => $row['collection_frequency'],
                                    "deposit_capacity" => $row['deposit_capacity'],
                                    "initial_date" => $dataRequest->initial_date,
                                    "final_date" => $dataRequest->final_date,
                                    "space_require" => $dataRequest->space_require,
                                    "discount" => $row['discount'],
                                    "time_hours_reservation" => $row['time_hours_reservation'],
                                    "frequency_reservation" => $row['frequency_reservation'],
                                    "score" => $row['score'],
                                    "weekday_opening" => date("g:i a",strtotime($row['weekday_opening'])),
                                    "saturday_opening" => date("g:i a",strtotime($row['saturday_opening'])),
                                    "sunday_opening" =>  $sunday_opening,
                                    "festive_opening" => $festive_opening,
                                    "weekday_closing" => date("g:i a",strtotime($row['weekday_closing'])),
                                    "saturday_closing" => date("g:i a",strtotime($row['saturday_closing'])),
                                    "sunday_closing" => '',
                                    "festive_closing" => '',
                                    "type_vehicle" => $row['type_vehicle'],
                                    "sizes_vehicle" => $row['sizes_vehicle'],
                                    "price_vehicle" => $row['price_vehicle'],
                                    "img_vehicle" => $row['img_vehicle']

                        );

                    }
                    $distance = '';
                    $distanceModel = new Cellar();
                    $distanceSql = $distanceModel->searchDistance_cellar($dataRequest->id);
                    while ($row = $distanceSql->fetch(PDO::FETCH_ASSOC)) {

                        $distance[] = array(
                                    "point_location" => $row['point_location'],
                                    "distance_point" => $row['distance_point'],
                                    "time_travel" => $row['time_travel'],

                        );

                    }
                    if (isset($distance)) {
                        $distance = $distance;
                    }

            
                if (count($data) > 0){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                        "data" => $data,
                        "distance" => $distance,
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

    public function listCellarAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id",
            "deposit_capacity",
            "measure"
        );

        $optional = array(
            "initial_date",
            "final_date",
            "category"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    // print_r($dataRequest);die;
                    $difference_days = $dataRequest->difference_days; 
                    // print_r ($difference_days);die;

                    if ($dataRequest->category == 'almabox'){

                        $initial_date = $dataRequest->initial_date; 

                        $initial_new = date('Y/m/d', strtotime(str_replace('/', '-', $initial_date)));

                        $final_date = $dataRequest->final_date; 

                        $final_new = date('Y/m/d', strtotime(str_replace('/', '-', $final_date)));

                        $dias   = (strtotime($initial_new)-strtotime($final_new))/86400;
                        $dias   = abs($dias); 
                        $dias   = floor($dias);     

                        if ($dias < 5){
                            $sol = 5;
                        }else{
                            $sol = $dias + 1;
                        }

                         
                        //$this->timeReservation(); //Servicio para cambio aleatorio de los campos time_hours_reservation y frequency_reservation de la tabla Cellar                        
                        
                        $departamentModel = new Cellar();
                        $departamentSql = $departamentModel->searchAlmabox($dataRequest->deposit_capacity, $dataRequest->category, $dataRequest->id);
                        
                        while ($row = $departamentSql->fetch(PDO::FETCH_ASSOC)) {                        
                            $depositSql = $departamentModel->searchDeposit_capacity($row['id']);
                            while ($row2 = $depositSql->fetch(PDO::FETCH_ASSOC)) {

                                if ($row2['sunday_opening'] == '00:00:00-05') {
                                    $sunday_opening = 'No hay atención';
                                }
        
                                if ($row2['festive_opening'] == '00:00:00-05') {
                                    $festive_opening = 'No hay atención';
                                }

                                $storage_cost= str_replace( '.', '', $row['storage_cost']);
                                $storage_cost= str_replace( ',', '', $storage_cost);
                                // print_r($storage_cost);die;
                                $costo_diario = $storage_cost/30;   

                                $costo_total = $costo_diario*$difference_days;
                                // print_r($costo_total);die;
                                // $costo_total = round($costo_total, 0, PHP_ROUND_HALF_UP);
                                $costo_total = number_format($costo_total,0,',','.');



                            $data[] = array(
                                
                                                "id" => $row['id'],
                                                "id_select" => $row['id_departament']+1000,
                                                "name" => $row['name'],
                                                "departament" => $row['departament'],
                                                "city" => $row['city'],
                                                "address" => $row['address'],
                                                "type_area" => $row['type_area'],
                                                "minimum_time" => $row['minimum_time'],
                                                "minimum_area" => $row['minimum_area'],
                                                "storage_cost" => $costo_total,
                                                "storage_costonly" => $row['storage_cost'],
                                                "handling_cost" =>  number_format($row['handling_cost']),
                                                "image_map" => $row['image_map'],
                                                "image" => $row['image'],
                                                "image_url" => $row['image_url'],
                                                "collection_frequency" => $row['collection_frequency'],
                                                "deposit_capacity" => $row['deposit_capacity'],
                                                "initial_date" => $dataRequest->initial_date,
                                                "final_date" => $dataRequest->final_date,
                                                "space_require" => $dataRequest->deposit_capacity,
                                                "costotal" => number_format($row['storage_cost'] * $sol * $dataRequest->deposit_capacity),
                                                "discount" => $row['discount'],
                                                "time_hours_reservation" => $row['time_hours_reservation'],
                                                "frequency_reservation" => $row['frequency_reservation'],
                                                "score" => $row['score'],
                                                "weekday_opening" => date("g:i a",strtotime($row2['weekday_opening'])),
                                                "saturday_opening" => date("g:i a",strtotime($row2['saturday_opening'])),
                                                "sunday_opening" =>  $sunday_opening,
                                                "festive_opening" => $festive_opening,
                                                "weekday_closing" => date("g:i a",strtotime($row2['weekday_closing'])),
                                                "saturday_closing" => date("g:i a",strtotime($row2['saturday_closing'])),
                                                "sunday_closing" => '',
                                                "festive_closing" => '',
                                                "measure" => $dataRequest->measure,
                                                "category" => $dataRequest->category,
                                );
                            }
                        }

                        

                        if (count($data) > 0) {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                                "data" => $data,
                                "type_area" => $data[0]['type_area'],
                                "status" => ControllerBase::SUCCESS
                            ));

                            
                        } else {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::LIST_CELLAR_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }

                    }else{

                        

                            $initial_date = $dataRequest->initial_date; 

                            $initial_new = date('Y/m/d', strtotime(str_replace('/', '-', $initial_date)));

                            $final_date = $dataRequest->final_date; 

                            $final_new = date('Y/m/d', strtotime(str_replace('/', '-', $final_date)));

                            $dias   = (strtotime($initial_new)-strtotime($final_new))/86400;                            
                            $dias   = abs($dias);                            
                            $dias   = floor($dias);
                            
                            if ($dias > 31){
                                $operacion = $dias/30;
                                $sol = explode(".",$operacion);
                                $sol = $sol[0];
                                $sol = intval($sol);
                            }else{
                                //$sol = $dias + 1;
                                $sol = 1;
                            }
                                           

                            //$this->timeReservation(); //Servicio para cambio aleatorio de los campos time_hours_reservation y frequency_reservation de la tabla Cellar

                            if($dataRequest->id < 1999) {

                                $id = $dataRequest->id;

                                $departamentModel = new Cellar();
                                $departamentSql = $departamentModel->searchCity($id , $dataRequest->deposit_capacity, $dataRequest->measure);
                                
                                while ($row = $departamentSql->fetch(PDO::FETCH_ASSOC)) {
                                    $depositSql = $departamentModel->searchDeposit_capacity($row['id']);
                                    while ($row2 = $depositSql->fetch(PDO::FETCH_ASSOC)) {

                                        if ($row2['sunday_opening'] == '00:00:00-05') {
                                            $sunday_opening = 'No hay atención';
                                        }
                
                                        if ($row2['festive_opening'] == '00:00:00-05') {
                                            $festive_opening = 'No hay atención';
                                        }

                                        $storage_cost= str_replace( '.', '', $row['storage_cost']);
                                        $storage_cost= str_replace( ',', '', $storage_cost);
                                        // print_r($storage_cost);die;
                                        $costo_diario = $storage_cost/30;   

                                        $costo_total = $costo_diario*$difference_days;
                                        // print_r($costo_total);die;
                                        // $costo_total = round($costo_total, 0, PHP_ROUND_HALF_UP);
                                        $costo_total = number_format($costo_total,0,',','.');
                                        // print_r($costo_total);die;

                                    $data[] = array(
                                        
                                                        "id" => $row['id'], 
                                                        "id_select" => $row['id_departament'],
                                                        "name" => $row['name'],
                                                        "departament" => $row['departament'],
                                                        "city" => $row['city'],
                                                        "address" => $row['address'],
                                                        "type_area" => $row['type_area'],
                                                        "minimum_time" => $row['minimum_time'],
                                                        "minimum_area" => $row['minimum_area'],
                                                        "storage_cost" =>  $costo_total,
                                                        "storage_costonly" => $row['storage_cost'],
                                                        "handling_cost" =>  number_format($row['handling_cost']),
                                                        "image_map" => $row['image_map'],
                                                        "image" => $row['image'],
                                                        "image_url" => $row['image_url'],
                                                        "collection_frequency" => $row['collection_frequency'],
                                                        "deposit_capacity" => $row['deposit_capacity'],
                                                        "initial_date" => $dataRequest->initial_date,
                                                        "final_date" => $dataRequest->final_date,
                                                        "space_require" => $dataRequest->deposit_capacity,
                                                        "costotal" => number_format($row['storage_cost'] * $sol * $dataRequest->deposit_capacity),
                                                        "discount" => $row['discount'],
                                                        "time_hours_reservation" => $row['time_hours_reservation'],
                                                        "frequency_reservation" => $row['frequency_reservation'],
                                                        "score" => $row['score'],
                                                        "weekday_opening" => date("g:i a",strtotime($row2['weekday_opening'])),
                                                        "saturday_opening" => date("g:i a",strtotime($row2['saturday_opening'])),
                                                        "sunday_opening" =>  $sunday_opening,
                                                        "festive_opening" => $festive_opening,
                                                        "weekday_closing" => date("g:i a",strtotime($row2['weekday_closing'])),
                                                        "saturday_closing" => date("g:i a",strtotime($row2['saturday_closing'])),
                                                        "sunday_closing" => '',
                                                        "festive_closing" => '',
                                                        "measure" => $dataRequest->measure,
                                                        "category" => $dataRequest->category,
                                        );
                                    }
                                }
                            }
                            //  elseif ($dataRequest->id < 3999) {
                            //     $id = $dataRequest->id - 2000;

                            //     $cityModel = new Cellar();
                            //     $citySql = $cityModel->searchCity($id , $dataRequest->deposit_capacity, $dataRequest->measure);
                            //     while ($row = $citySql->fetch(PDO::FETCH_ASSOC)) {
                            //         $depositSql = $cityModel->searchDeposit_capacity($row['id']);
                            //         while ($row2 = $depositSql->fetch(PDO::FETCH_ASSOC)) {

                            //             if ($row2['sunday_opening'] == '00:00:00-05') {
                            //                 $sunday_opening = 'No hay atención';
                            //             }
                
                            //             if ($row2['festive_opening'] == '00:00:00-05') {
                            //                 $festive_opening = 'No hay atención';
                            //             }
                                        
                            //         $data[] = array(
                                        
                            //                             "id" => $row['id'],
                            //                             "id_select" => $row['id_city']+2000,
                            //                             "name" => $row['name'],
                            //                             "departament" => $row['departament'],
                            //                             "city" => $row['city'],
                            //                             "address" => $row['address'],
                            //                             "type_area" => $row['type_area'],
                            //                             "minimum_time" => $row['minimum_time'],
                            //                             "minimum_area" => $row['minimum_area'],
                            //                             "storage_cost" => number_format($row['storage_cost']),
                            //                             "handling_cost" => number_format($row['handling_cost']),
                            //                             "image_map" => $row['image_map'],
                            //                             "image" => $row['image'],
                            //                             "collection_frequency" => $row['collection_frequency'],
                            //                             "deposit_capacity" => $row['deposit_capacity'],
                            //                             "initial_date" => $dataRequest->initial_date,
                            //                             "final_date" => $dataRequest->final_date,
                            //                             "space_require" => $dataRequest->deposit_capacity,
                            //                             "costotal" => number_format($dataRequest->deposit_capacity * $row['storage_cost'] * $sol),
                            //                             "discount" => $row['discount'],
                            //                             "time_hours_reservation" => $row['time_hours_reservation'],
                            //                             "frequency_reservation" => $row['frequency_reservation'],
                            //                             "score" => $row['score'],
                            //                             "weekday_opening" => date("g:i a",strtotime($row2['weekday_opening'])),
                            //                             "saturday_opening" => date("g:i a",strtotime($row2['saturday_opening'])),
                            //                             "sunday_opening" =>  $sunday_opening,
                            //                             "festive_opening" => $festive_opening,
                            //                             "weekday_closing" => date("g:i a",strtotime($row2['weekday_closing'])),
                            //                             "saturday_closing" => date("g:i a",strtotime($row2['saturday_closing'])),
                            //                             "sunday_closing" => '',
                            //                             "festive_closing" => '',
                            //             );
                            //         }
                            //     }
                            // }else {

                            //     $id = $dataRequest->id - 10000;

                            //     $cModel = new Cellar();
                            //     $cSql = $cModel->searchC($id , $dataRequest->deposit_capacity, $dataRequest->measure);
                            //     while ($row = $cSql->fetch(PDO::FETCH_ASSOC)) {
                            //         $depositSql = $cModel->searchDeposit_capacity($row['id']);
                            //         while ($row2 = $depositSql->fetch(PDO::FETCH_ASSOC)) {

                            //             if ($row2['sunday_opening'] == '00:00:00-05') {
                            //                 $sunday_opening = 'No hay atención';
                            //             }
                
                            //             if ($row2['festive_opening'] == '00:00:00-05') {
                            //                 $festive_opening = 'No hay atención';
                            //             }

                            //             $data[] = array(
                                            
                            //                 "id" => $row['id'],
                            //                 "id_select" => $row['id']+10000,
                            //                 "name" => $row['name'],
                            //                 "departament" => $row['departament'],
                            //                 "city" => $row['city'],
                            //                 "address" => $row['address'],
                            //                 "type_area" => $row['type_area'],
                            //                 "minimum_time" => $row['minimum_time'],
                            //                 "minimum_area" => $row['minimum_area'],
                            //                 "storage_cost" => number_format($row['storage_cost']),
                            //                 "handling_cost" => number_format($row['handling_cost']),
                            //                 "image_map" => $row['image_map'],
                            //                 "image" => $row['image'],
                            //                 "collection_frequency" => $row['collection_frequency'],
                            //                 "deposit_capacity" => $row['deposit_capacity'],
                            //                 "initial_date" => $dataRequest->initial_date,
                            //                 "final_date" => $dataRequest->final_date,
                            //                 "space_require" => $dataRequest->deposit_capacity,
                            //                 "costotal" => number_format($dataRequest->deposit_capacity * $row['storage_cost'] * $sol),
                            //                 "discount" => $row['discount'],
                            //                 "time_hours_reservation" => $row['time_hours_reservation'],
                            //                 "frequency_reservation" => $row['frequency_reservation'],
                            //                 "score" => $row['score'],
                            //                 "weekday_opening" => date("g:i a",strtotime($row2['weekday_opening'])),
                            //                 "saturday_opening" => date("g:i a",strtotime($row2['saturday_opening'])),
                            //                 "sunday_opening" =>  $sunday_opening,
                            //                 "festive_opening" => $festive_opening,
                            //                 "weekday_closing" => date("g:i a",strtotime($row2['weekday_closing'])),
                            //                 "saturday_closing" => date("g:i a",strtotime($row2['saturday_closing'])),
                            //                 "sunday_closing" => '',
                            //                 "festive_closing" => '',
                            //             );
                            //         }
                            //     }

                            // }
                        

                        

                        if (count($data) > 0) {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                                "data" => $data,
                                "type_area" => $data[0]['type_area'],
                                "status" => ControllerBase::SUCCESS
                            ));

                            
                        } else {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::LIST_CELLAR_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }

                    }
                    
                } catch (Exception $e) {
                        $this->logError($e, $dataRequest);
                }
               
        }
    }

    public function listSelectAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(

        );

        $optional = array(
 
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {

                    $DepModel = new Cellar();
                        $DepSql = $DepModel->searchDep();
                        while ($row2 = $DepSql->fetch(PDO::FETCH_ASSOC)){
                            $departament[] = array(                      

                                        "id_departament" => $row2['id'],
                                        "departament" => $row2['departament']

                                );
                        }

                    $cityModel = new Cellar();
                        $citySql = $cityModel->searchCit();
                        while ($row3 = $citySql->fetch(PDO::FETCH_ASSOC)){
                            $city[] = array(                      

                                        "id_city" => $row3['id'],
                                        "city" => $row3['city'],
                                        "departament" => $row3['departament']

                                );
                        }

                    $cellarModel = new Cellar();
                        $cellarSql = $cellarModel->searchCellar();
                        while ($row = $cellarSql->fetch(PDO::FETCH_ASSOC)) {

                            $data[] = array(
                        
                                        "id" => $row['id'],
                                        "name" => $row['name'],
                                        "departament" => $row['departament'],
                                        "city" => $row['city'],
                                        "address" => $row['address'],
                                        "storage_cost" => $row['storage_cost'],
                                        "handling_cost" => $row['handling_cost'],
                                        "image_map" => $row['image_map'],
                                        "image" => $row['image'],
                                        "deposit_capacity" => $row['deposit_capacity'],
                                        "cellar_type" => $row['cellar_type'],
                                        "status" => $row['status'],
                                );
                            
                        }

                    if (count($data) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                            "data" => $data,
                            "departament" => $departament,
                            "city" => $city,
                            "status" => ControllerBase::SUCCESS
                        ));
                        $this->view->index = Cellar::find();
                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
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
        public function listCityCellarAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(

        );

        $optional = array(
 
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {

                    $cityModel = new City();
                        $citySql = $cityModel->searchCity();
                        while ($row3 = $citySql->fetch(PDO::FETCH_ASSOC)){
                            $city[] = array(                      

                                        "id_city" => $row3['id'],
                                        "city" => $row3['city'],
                                        "id_departament" => $row3['id_departament']

                                );
                        }

                    if (count($city) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "data" => $city,
                            "status" => ControllerBase::SUCCESS
                        ));
                        $this->view->index = Cellar::find();
                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
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

    public function listCellarPartnerAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
        );

        $optional = array(        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {

                        $cellarModel = new Cellar();
                        $cellarSql = $cellarModel->searchCellarPartner();
                        while ($row3 = $cellarSql->fetch(PDO::FETCH_ASSOC)){
                            $data[] = array(                      

                                        "id" => $row3['id'],
                                        "name" => $row3['name'],
                                        "city" => $row3['city'],
                                        "address" => $row3['address'],
                                        "storage_cost" => $row3['storage_cost'],
                                        "handling_cost" => $row3['handling_cost'],
                                        "minimum_time" => $row3['minimum_time'],
                                        "image" => $row3['image']

                                );
                        }

                    if (count($data) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                            "data" => $data,
                            "status" => ControllerBase::SUCCESS
                        ));

                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
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

    /*
    *Accion detailCellar: Detalle de la Bodega
    */
    public function detailCellarPartnerAction()
    {
        $dataRequest = $this->request->getJsonPost();

        $fields = array(
            "id",

        );

        if ($this->_checkFields($dataRequest, $fields)) {

            try {
                

                $depositModel = new Cellar();
                $depositSql = $depositModel->searchDeposit_capacity($dataRequest->id);
                    while ($row = $depositSql->fetch(PDO::FETCH_ASSOC)) {

                        $data[] = array(
                            "id" => $row['id'],
                            "name" => $row['name'],
                            "id_city" => $row['id_city'],
                            "city" => $row['city'],
                            "address" => $row['address'],
                            "image" => $row['image'],
                            "storage_cost" => $row['storage_cost'],
                            "handling_cost" => $row['handling_cost'],
                            "deposit_capacity" => $row['deposit_capacity'],
                            "minimum_time" => $row['minimum_time'],
                            "name_contact" => $row['name_contact'],
                            "phone_contact" => $row['phone_contact'],
                            "email_contact" => $row['email_contact'],
                            "weekday_opening" => date("h:m",strtotime($row['weekday_opening'])),
                            "saturday_opening" => date("h:m",strtotime($row['saturday_opening'])),
                            "sunday_opening" =>  date("h:m",strtotime($row['sunday_opening'])),
                            "festive_opening" => date("h:m",strtotime($row['festive_opening'])),
                            "weekday_closing" => date("h:m",strtotime($row['weekday_closing'])),
                            "saturday_closing" => date("h:m",strtotime($row['saturday_closing'])),
                            "sunday_closing" => date("h:m",strtotime($row['sunday_opening'])),
                            "festive_closing" => date("h:m",strtotime($row['festive_closing'])),
                            
                        );

                    }
                $distance = '';
                $distanceModel = new Cellar();
                $distanceSql = $distanceModel->searchDistance_cellar($dataRequest->id);
                    while ($row = $distanceSql->fetch(PDO::FETCH_ASSOC)) {

                        $distance[] = array(
                                    "point_location" => $row['point_location'],
                                    "distance_point" => $row['distance_point'],
                                    "time_travel" => $row['time_travel'],

                        );

                    }
                    if (isset($distance)) {
                        $distance = $distance;
                    }

            
                if (count($data) > 0){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                        "data" => $data,
                        "distance" => $distance,
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

    public function deleteCellarAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id"
        );

        $optional = array();

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

                try {
                    $cellar = Cellar::findFirst($dataRequest->id);

                    $schedule = Schedule::findFirst(array(
                        "conditions" => "id_cellar = ?1",
                        "bind" => array(1 => $dataRequest->id)
                    ));

                    $schedule->id;
                    $schedule->delete();

                    if ($cellar) {
                        if ($cellar->delete()) {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => CellarConstants::DELETE_CELLAR_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));
                        } else {
                             $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::DELETE_CELLAR_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }


                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::DELETE_CELLAR_NOT_FOUNT,
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
                }

                catch (Exception $e) {
                        $this->logError($e, $dataRequest);
                }

            
        }
    }

    public function timeReservation() {
        $cellar = Cellar::find(array("order" => "id DESC"));
        $valores = array( 2, 4, 6, 12, 24, 48, 72);

        foreach ($cellar as $cellars){
            $numeroaleatorio = array_rand($valores, 1);
            $cellars->time_hours_reservation = $valores[$numeroaleatorio];
            $cellars->frequency_reservation = rand(0,6);
            $cellars->save();
        }
    }

}