<?php

class ConsultreserveclientController extends ControllerBase {    
    /**
     * 
     *
     */ 

    public function listReserveAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id_client"
        );

        $optional = array(        
            "start_date",
            "end_date"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

                try {

                    if (isset($dataRequest->start_date) || isset($dataRequest->end_date)){
                        $start_date = isset($dataRequest->start_date) ? $dataRequest->start_date : null;
                        $end_date = isset($dataRequest->end_date) ? $dataRequest->end_date : null;

                        $reserveModel = (new Reserve)->searchTransactionClient($dataRequest->id_client,$start_date,$end_date);
                        $rows = $reserveModel->fetchAll();
                        $data = array();
                        
                        foreach ($rows as $row) {
                            if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                    $month = 'Enero';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                    $month = 'Febrero';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                    $month = 'Marzo';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                    $month = 'Abril';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                    $month = 'Mayo';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                    $month = 'Junio';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                    $month = 'Julio';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                    $month = 'Agosto';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                    $month = 'Septiembre';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                    $month = 'Octubre';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                    $month = 'Noviembre';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                    $month = 'Diciembre';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'January'){
                                    $month_final = 'Enero';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'February'){
                                    $month_final = 'Febrero';
                                }
                            if(date('F' , strtotime($row['final_date'])) == 'March'){
                                    $month_final = 'Marzo';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'April'){
                                    $month_final = 'Abril';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'May'){
                                    $month_final = 'Mayo';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'June'){
                                    $month_final = 'Junio';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'July'){
                                    $month_final = 'Julio';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'August'){
                                    $month_final = 'Agosto';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'September'){
                                    $month_final = 'Septiembre';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'October'){
                                    $month_final = 'Octubre';
                                }
                            if(date('F' , strtotime($row['final_date'])) == 'November'){
                                    $month_final = 'Noviembre';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'December'){
                                    $month_final = 'Diciembre';
                                }
                            
                            $data[] = array(

                                'id' => $row['id'],
                                'id_cellar' => $row['id_cellar'],
                                'id_client' => $row['id_client'],
                                'name' => $row['name'],
                                'image' => $row['image'],
                                'city' => $row['city'],
                                'address' => $row['address'],
                                'space_require' => $row['cubic_meters'],
                                'storage_cost' => number_format($row['storage_cost']),
                                'pay' => $row['type_pay'],
                                'status' => $row['status'],
                                'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                'final_year' => date('Y' , strtotime($row['final_date'])),
                                'initial_month' => $month ,
                                'final_month' => $month_final,
                                'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                'final_day' => date('d' , strtotime($row['final_date']))
                            );
                        }

                    }else{
                        $reserveModel = new Reserve();

                        $reserveSql = $reserveModel->searchReserve($dataRequest->id_client);
                        while ($row = $reserveSql->fetch(PDO::FETCH_ASSOC)) {

                            if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                    $month = 'Enero';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                    $month = 'Febrero';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                    $month = 'Marzo';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                    $month = 'Abril';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                    $month = 'Mayo';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                    $month = 'Junio';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                    $month = 'Julio';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                    $month = 'Agosto';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                    $month = 'Septiembre';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                    $month = 'Octubre';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                    $month = 'Noviembre';
                                }

                            if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                    $month = 'Diciembre';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'January'){
                                    $month_final = 'Enero';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'February'){
                                    $month_final = 'Febrero';
                                }
                            if(date('F' , strtotime($row['final_date'])) == 'March'){
                                    $month_final = 'Marzo';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'April'){
                                    $month_final = 'Abril';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'May'){
                                    $month_final = 'Mayo';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'June'){
                                    $month_final = 'Junio';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'July'){
                                    $month_final = 'Julio';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'August'){
                                    $month_final = 'Agosto';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'September'){
                                    $month_final = 'Septiembre';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'October'){
                                    $month_final = 'Octubre';
                                }
                            if(date('F' , strtotime($row['final_date'])) == 'November'){
                                    $month_final = 'Noviembre';
                                }

                            if(date('F' , strtotime($row['final_date'])) == 'December'){
                                    $month_final = 'Diciembre';
                                }

                            
                            $data[] = array(

                                        'id' => $row['id'],
                                        'id_cellar' => $row['id_cellar'],
                                        'id_client' => $row['id_client'],
                                        'name' => $row['name'],
                                        'image' => $row['image'],
                                        'city' => $row['city'],
                                        'address' => $row['address'],
                                        'space_require' => $row['cubic_meters'],
                                        'storage_cost' => number_format($row['storage_cost']),
                                        'pay' => $row['type_pay'],
                                        'status' => $row['status'],
                                        'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                        'final_year' => date('Y' , strtotime($row['final_date'])),
                                        'initial_month' => $month ,
                                        'final_month' => $month_final,
                                        'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                        'final_day' => date('d' , strtotime($row['final_date']))

                            );
                        }
                    }

                                
                    if ($data > 0) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
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

        /**
     * 
     *
     */ 

    public function listReserveCursoAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id_client"
        );

        $optional = array(    
            "status",
            "initial_date",
            "final_date"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
                        
                try {

                    if (isset($dataRequest->status)) {

                        if ($dataRequest->status == 'Todas') {
                            
                            $reserveModel = new Reserve();
                            $reserveSql = $reserveModel->searchReserveCurso($dataRequest->id_client);
                            
                            while ($row = $reserveSql->fetch(PDO::FETCH_ASSOC)) {

                                if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                    $month = 'Enero';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                    $month = 'Febrero';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                    $month = 'Marzo';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                    $month = 'Abril';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                    $month = 'Mayo';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                    $month = 'Junio';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                    $month = 'Julio';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                    $month = 'Agosto';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                    $month = 'Septiembre';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                    $month = 'Octubre';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                    $month = 'Noviembre';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                    $month = 'Diciembre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'January'){
                                    $month_final = 'Enero';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'February'){
                                    $month_final = 'Febrero';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'March'){
                                    $month_final = 'Marzo';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'April'){
                                    $month_final = 'Abril';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'May'){
                                    $month_final = 'Mayo';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'June'){
                                    $month_final = 'Junio';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'July'){
                                    $month_final = 'Julio';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'August'){
                                    $month_final = 'Agosto';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'September'){
                                    $month_final = 'Septiembre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'October'){
                                    $month_final = 'Octubre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'November'){
                                    $month_final = 'Noviembre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'December'){
                                    $month_final = 'Diciembre';
                                }

                                
                                $data[] = array(

                                    'id' => $row['id'],
                                    'id_cellar' => $row['id_cellar'],
                                    'id_client' => $row['id_client'],
                                    'name' => $row['name'],
                                    'city' => $row['city'],
                                    'address' => $row['address'],
                                    'image' => $row['image'],
                                    'space_require' => $row['cubic_meters'],
                                    'storage_cost' => number_format($row['storage_cost']),
                                    'pay' => $row['type_pay'],
                                    'status' => $row['status'],
                                    'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                    'final_year' => date('Y' , strtotime($row['final_date'])),
                                    'initial_month' =>  $month ,
                                    'final_month' => $month_final,
                                    'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                    'final_day' => date('d' , strtotime($row['final_date']))

                                );
                            }
                    }else{

                            $reserveModel = new Reserve();
                            $reserveSql = $reserveModel->searchReserveCursoStatus($dataRequest->id_client , $dataRequest->status , $dataRequest->initial_date , $dataRequest->final_date);
                            
                            while ($row = $reserveSql->fetch(PDO::FETCH_ASSOC)) {

                                if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                    $month = 'Enero';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                    $month = 'Febrero';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                    $month = 'Marzo';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                    $month = 'Abril';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                    $month = 'Mayo';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                    $month = 'Junio';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                    $month = 'Julio';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                    $month = 'Agosto';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                    $month = 'Septiembre';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                    $month = 'Octubre';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                    $month = 'Noviembre';
                                }

                                if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                    $month = 'Diciembre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'January'){
                                    $month_final = 'Enero';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'February'){
                                    $month_final = 'Febrero';
                                }
                                if(date('F' , strtotime($row['final_date'])) == 'March'){
                                    $month_final = 'Marzo';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'April'){
                                    $month_final = 'Abril';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'May'){
                                    $month_final = 'Mayo';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'June'){
                                    $month_final = 'Junio';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'July'){
                                    $month_final = 'Julio';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'August'){
                                    $month_final = 'Agosto';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'September'){
                                    $month_final = 'Septiembre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'October'){
                                    $month_final = 'Octubre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'November'){
                                    $month_final = 'Noviembre';
                                }

                                if(date('F' , strtotime($row['final_date'])) == 'December'){
                                    $month_final = 'Diciembre';
                                }

                                
                                $data[] = array(

                                    'id' => $row['id'],
                                    'id_cellar' => $row['id_cellar'],
                                    'id_client' => $row['id_client'],
                                    'name' => $row['name'],
                                    'city' => $row['city'],
                                    'address' => $row['address'],
                                    'image' => $row['image'],
                                    'space_require' => $row['cubic_meters'],
                                    'storage_cost' => number_format($row['storage_cost']),
                                    'pay' => $row['type_pay'],
                                    'status' => $row['status'],
                                    'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                    'final_year' => date('Y' , strtotime($row['final_date'])),
                                    'initial_month' =>  $month ,
                                    'final_month' => $month_final,
                                    'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                    'final_day' => date('d' , strtotime($row['final_date']))

                                );
                            }
                        }
                    }else {
                        $reserveModel = new Reserve();
                        $reserveSql = $reserveModel->searchReserveCurso($dataRequest->id_client);
                        
                        while ($row = $reserveSql->fetch(PDO::FETCH_ASSOC)) {

                            if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                $month = 'Enero';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                $month = 'Febrero';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                $month = 'Marzo';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                $month = 'Abril';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                $month = 'Mayo';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                $month = 'Junio';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                $month = 'Julio';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                $month = 'Agosto';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                $month = 'Septiembre';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                $month = 'Octubre';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                $month = 'Noviembre';
                            }

                            if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                $month = 'Diciembre';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'January'){
                                $month_final = 'Enero';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'February'){
                                $month_final = 'Febrero';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'March'){
                                $month_final = 'Marzo';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'April'){
                                $month_final = 'Abril';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'May'){
                                $month_final = 'Mayo';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'June'){
                                $month_final = 'Junio';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'July'){
                                $month_final = 'Julio';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'August'){
                                $month_final = 'Agosto';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'September'){
                                $month_final = 'Septiembre';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'October'){
                                $month_final = 'Octubre';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'November'){
                                $month_final = 'Noviembre';
                            }

                            if(date('F' , strtotime($row['final_date'])) == 'December'){
                                $month_final = 'Diciembre';
                            }

                            
                            $data[] = array(

                                'id' => $row['id'],
                                'id_cellar' => $row['id_cellar'],
                                'id_client' => $row['id_client'],
                                'name' => $row['name'],
                                'city' => $row['city'],
                                'address' => $row['address'],
                                'image' => $row['image'],
                                'space_require' => $row['cubic_meters'],
                                'storage_cost' => number_format($row['storage_cost']),
                                'pay' => $row['type_pay'],
                                'status' => $row['status'],
                                'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                'final_year' => date('Y' , strtotime($row['final_date'])),
                                'initial_month' =>  $month ,
                                'final_month' => $month_final,
                                'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                'final_day' => date('d' , strtotime($row['final_date']))

                            );
                        }
                        
                    }

                    
                                
                    if ($data > 0) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
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

            /**
     * 
     *
     */ 

    public function checkReservationsClientAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id_client"
        );

        $optional = array(    
            "status",
            "initial_date",
            "final_date"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    $reserveModel = new Reserve();

                    $reserveSql = $reserveModel->searchReserve($dataRequest->id_client);
                    while ($row = $reserveSql->fetch(PDO::FETCH_ASSOC)) {

                        if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                $month = 'Enero';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                $month = 'Febrero';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                $month = 'Marzo';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                $month = 'Abril';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                $month = 'Mayo';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                $month = 'Junio';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                $month = 'Julio';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                $month = 'Agosto';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                $month = 'Septiembre';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                $month = 'Octubre';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                $month = 'Noviembre';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                $month = 'Diciembre';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'January'){
                                $month_final = 'Enero';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'February'){
                                $month_final = 'Febrero';
                            }
                        if(date('F' , strtotime($row['final_date'])) == 'March'){
                                $month_final = 'Marzo';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'April'){
                                $month_final = 'Abril';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'May'){
                                $month_final = 'Mayo';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'June'){
                                $month_final = 'Junio';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'July'){
                                $month_final = 'Julio';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'August'){
                                $month_final = 'Agosto';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'September'){
                                $month_final = 'Septiembre';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'October'){
                                $month_final = 'Octubre';
                            }
                        if(date('F' , strtotime($row['final_date'])) == 'November'){
                                $month_final = 'Noviembre';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'December'){
                                $month_final = 'Diciembre';
                            }

                        
                        $data[] = array(

                                    'id' => $row['id'],
                                    'id_cellar' => $row['id_cellar'],
                                    'id_client' => $row['id_client'],
                                    'name' => $row['name'],
                                    'image' => $row['image'],
                                    'city' => $row['city'],
                                    'address' => $row['address'],
                                    'space_require' => $row['cubic_meters'],
                                    'storage_cost' => number_format($row['storage_cost']),
                                    'pay' => $row['type_pay'],
                                    'status' => $row['status'],
                                    'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                    'final_year' => date('Y' , strtotime($row['final_date'])),
                                    'initial_month' =>  $month ,
                                    'final_month' => $month_final,
                                    'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                    'final_day' => date('d' , strtotime($row['final_date']))

                                );
                    }                    

                    
                                
                    if ($data > 0) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
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

    /**
     * 
     *
     */ 

    public function detailReserveClientAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id",
            "id_client"
        );

        $optional = array(        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {

                    $serviceModel = new Reserve();

                    $serviceSql = $serviceModel->searchServiceReserve($dataRequest->id);
                    while ($row = $serviceSql->fetch(PDO::FETCH_ASSOC)) {

                        $service[] = array(
                                    'name' => $row['name'],
                                    'cost' => $row['cost']

                                );
                    }

                    if (isset($service)) {
                        $service = $service;
                    }else{
                        $service = '';
                    }

                    $serviceModel = new Reserve();

                    $serviceSql = $serviceModel->searchServiceCost($dataRequest->id);
                    while ($row = $serviceSql->fetch(PDO::FETCH_ASSOC)) {

                        $cost_service = $row['cost'];
                        
                    }

                    if (isset($cost_service)) {
                        $cost_service = $cost_service;
                    }else{
                        $cost_service = 0;
                    }

                    
                    $reserveModel = new Reserve();

                    $reserveSql = $reserveModel->searchDetailReserve($dataRequest->id , $dataRequest->id_client);
                    while ($row = $reserveSql->fetch(PDO::FETCH_ASSOC)) {

                        $storage_cost = $row['storage_cost'] - $cost_service;

                        if(date('F' , strtotime($row['initial_date'])) == 'January'){
                                $month = 'Enero';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'February'){
                                $month = 'Febrero';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'March'){
                                $month = 'Marzo';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'April'){
                                $month = 'Abril';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'May'){
                                $month = 'Mayo';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'June'){
                                $month = 'Junio';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'July'){
                                $month = 'Julio';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'August'){
                                $month = 'Agosto';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'September'){
                                $month = 'Septiembre';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'October'){
                                $month = 'Octubre';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'November'){
                                $month = 'Noviembre';
                            }

                        if(date('F' , strtotime($row['initial_date'])) == 'December'){
                                $month = 'Diciembre';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'January'){
                                $month_final = 'Enero';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'February'){
                                $month_final = 'Febrero';
                            }
                        if(date('F' , strtotime($row['final_date'])) == 'March'){
                                $month_final = 'Marzo';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'April'){
                                $month_final = 'Abril';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'May'){
                                $month_final = 'Mayo';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'June'){
                                $month_final = 'Junio';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'July'){
                                $month_final = 'Julio';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'August'){
                                $month_final = 'Agosto';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'September'){
                                $month_final = 'Septiembre';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'October'){
                                $month_final = 'Octubre';
                            }
                        if(date('F' , strtotime($row['final_date'])) == 'November'){
                                $month_final = 'Noviembre';
                            }

                        if(date('F' , strtotime($row['final_date'])) == 'December'){
                                $month_final = 'Diciembre';
                            }

                        $data = array(

                                    'id' => $row['id'],
                                    'id_cellar' => $row['id_cellar'],
                                    'id_client' => $row['id_client'],
                                    'name' => $row['name'],
                                    'image' => $row['image'],
                                    'city' => $row['city'],
                                    'address' => $row['address'],
                                    'space_require' => $row['cubic_meters'],
                                    'storage_cost' => number_format($storage_cost),
                                    'cost_total' => number_format($row['storage_cost']),
                                    'pay' => $row['pay'],
                                    'status' => $row['status'],
                                    'initial_year' =>  date('Y' , strtotime($row['initial_date'])) ,
                                    'final_year' => date('Y' , strtotime($row['final_date'])),
                                    'initial_month' =>  $month ,
                                    'final_month' => $month_final,
                                    'initial_day' =>  date('d' , strtotime($row['initial_date'])) ,
                                    'final_day' => date('d' , strtotime($row['final_date'])),
                                    "supervisor" => $row['supervisor'],
                                    "phone_contact" => $row['phone_contact'],
                                    "email_contact" => $row['email_contact']

                                );
                    }

                                
                    if ($data > 0) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
                                "service" => $service,
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

    /**
     * 
     *
    */ 

    public function UpdateReserveAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id",
            "status"
        );

        $optional = array(        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {

                    $reserve = Reserve::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                        ));

                        if (isset($dataRequest->status))
                            $reserve->status = $dataRequest->status;

                                
                    if ($reserve->save()) {


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => 'Se ha actualizado el estado de la reserva',
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