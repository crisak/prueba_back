<?php

class TruckController extends ControllerBase {



    public function newAction() {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();
        $fields = array(
            "name",
            "type_load",
            "capacity",
            "cost"

        );

        $optional = array(
            "phone"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
                try {



                    $lol = Truck::findFirst(array(
                                    "conditions" => "name= ?1",
                                    "bind" => array(1 => $dataRequest->name)
                              ));

                    if (!isset($lol->id)){
                       
                        $truck = new Truck();
                        $truck->name = $dataRequest->name;
                        $truck->type_load = $dataRequest->type_load;
                        $truck->capacity = $dataRequest->capacity;
                        $truck->cost = $dataRequest->cost;
                        $truck->phone = isset($dataRequest->phone) ?  $dataRequest->phone : null ;
                        $truck->created_at = $dateTime->format('Y-m-d H:i:s');

                       
                        if($truck->save()){


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
                                "message" => 'creada con exito',
                                "status" => ControllerBase::FAILED
                            ));

                        }
                        
                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => 'Nombre del camión ya existe',
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
                

                }catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }   
            
        }
    }

    /**
     * 
     *
     */ 

    public function listTruckAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "idorigen",
            "iddestino",            
            "type_load",
            "type_truck",
        );

        $optional = array(            
            "initial_date",
            "hora",
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    $truck_city = new Truck();
                    $truckcitySql = $truck_city->searchForCity($dataRequest->idorigen);

                    $city = new City();
                    $cityoriSql = $city->searchCityforTruck($dataRequest->idorigen);
                    $citydesSql = $city->searchCityforTruck($dataRequest->iddestino);
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

                    while ($row3 = $truckcitySql->fetch(PDO::FETCH_ASSOC)){
                        
                        
                        $data[] = array(
                        
                            "id" => $row3['id'],
                            "id_city" => $row3['id_city']+2000,
                            "name_city" => $row3['city'],
                            "name" => $row3['name'],
                            "type_load" => $row3['type_load'],
                            "type_truck" => $dataRequest->type_truck,
                            "capacity" => $row3['capacity'],
                            "cost" => number_format($costo),
                            "initial_date" => $dataRequest->initial_date,
                            "hora" => $dataRequest->hora,
                            "tipo_carga" => $dataRequest->type_load,
                            "hour" => substr($row3['hour'], 0,-6),
                            "image" => $row3['image'],
                            "discount" => $row3['discount_truck'],
                            "score" => $row3['score_truck'],
                            "frequency_reservation" => $row3['frequency_reservation_truck'],
                            "time_hours_reservation" => $row3['time_hours_reservation_truck'],
                            "id_city2" => $rowcityori['id']+2000,
                            "name_city2" => $rowcityori['city'],
                            "id_city3" => $rowcitydes['id']+2000,
                            "name_city3" => $rowcitydes['city'],
                        );
                    }                    

                    if (count($data) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => TruckConstants::LIST_TRUCK_SUCCESS,
                            "data" => $data,
                            "status" => ControllerBase::SUCCESS
                        ));

                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => TruckConstants::LIST_TRUCK_FAILURE,
                            "status" => ControllerBase::FAILED
                        ));
                    }

                } catch (Exception $e) {
                        $this->logError($e, $dataRequest);
                }
               
        }
    }

    public function listSelectTruckAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(

        );

        $optional = array(
 
        );
        
        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    
                    $DepModel = new Truck();
                        $DepSql = $DepModel->searchDep();
                        while ($row2 = $DepSql->fetch(PDO::FETCH_ASSOC)){
                            $departament[] = array(                      

                                        "id_departament" => $row2['id']+1000,
                                        "departament" => $row2['departament']

                                );
                        }

                    $cityModel = new Truck();
                        $citySql = $cityModel->searchCit();
                        while ($row3 = $citySql->fetch(PDO::FETCH_ASSOC)){
                            $city[] = array(                      

                                        "id_city" => $row3['id']+2000,
                                        "city" => $row3['city'],
                                        "departament" => $row3['departament']

                                );
                        }
        
                    $truckModel = new Truck();
                        $truckSql = $truckModel->searchTruck();
                        while ($row = $truckSql->fetch(PDO::FETCH_ASSOC)) {
                            
                            $data[] = array(
                        
                                        "id" => $row['id']+10000,
                                        "name" => $row['name'],
                                        "departament" => $row['departament'],
                                        "city" => $row['id_city'],
                                        "date" => $row['date'],
                                        "hour" => $row['hour'],
                                        "type_load" => $row['type_load'],
                                        "image" => $row['image'],
                                        "freight_available" => $row['freight_available']
                                );
                            
                        }
                       
                    if (count($data) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => TruckConstants::LIST_TRUCK_SUCCESS,
                            "data" => $data,
                            "departament" => $departament,
                            "city" => $city,
                            "status" => ControllerBase::SUCCESS
                        ));
                        $this->view->index = Truck::find();
                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => TruckConstants::LIST_TRUCK_FAILURE,
                            "status" => ControllerBase::FAILED
                        ));
                    }

                } catch (Exception $e) {
                        $this->logError($e, $dataRequest);
                }
               
        }
    }

    /*
    *Accion detailTruck: Detalle del Camion
    */
    public function detailTruckAction()
    {
        $dataRequest = $this->request->getJsonPost();

        $fields = array(
            /* "id",
            "initial_date",
            "final_date",
            "space_require", */

            "id_city",
            "id_city2",
            "name_city",
            "name_city2",
            "id",
            "initial_date",
            "hora",
            "tipo_carga",
            "tipo_transporte",
        );

        if ($this->_checkFields($dataRequest, $fields)) {

            try {
                
                $id_Truck = new Truck();
                $truckSql = $id_Truck->searchIdTruck($dataRequest->id);
                    while ($row = $truckSql->fetch(PDO::FETCH_ASSOC)) {

                        /* if ($row['sunday_opening'] == '00:00:00-05') {
                            $sunday_opening = 'No recepcion';
                        } else{
                            $sunday_opening = date("g:i a",strtotime($row['saturday_opening']));
                        }

                        if ($row['sunday_closing'] == '00:00:00-05') {
                            $sunday_closing = '';
                        } else{
                            $sunday_closing = date("g:i a",strtotime($row['saturday_closing']));
                        } */

                        $data[] = array(
                                    "id" => $row['id'],
                                    "name" => $row['name'],
                                    "city" => $row['city'],
                                    "image_map" => $row['image_map_truck'],
                                    "image" => $row['image'],
                                    "conductor" => $row['driver_name'],
                                    "initial_date" => $dataRequest->initial_date,
                                    "hour" => $dataRequest->hora,
                                    "type_load" => $dataRequest->tipo_carga,
                                    "id_city" => $dataRequest->id_city,
                                    "id_city2" => $dataRequest->id_city2,
                                    "name_city" => $dataRequest->name_city,
                                    "name_city2" => $dataRequest->name_city2,
                                    "type_truck" => $dataRequest->tipo_transporte,

                        );

                    }
                    /* $distance = '';
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
                    } */

            
                if (count($data) > 0){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "message" => CellarConstants::LIST_CELLAR_SUCCESS,
                        "data" => $data,
                        /* "distance" => $distance, */
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

}