<?php

class ScheduleController extends ControllerBase {



    public function newAction() {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();
        $fields = array(
            "opening",
            "closing",
            "days",
            "id_cellar"
        );

        $optional = array(     );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
                try {



                    $lol = Schedule::findFirst(array(
                                    "conditions" => "id_cellar= ?1",
                                    "bind" => array(1 => $dataRequest->id_cellar)
                              ));

                    if (!isset($lol->id)){
                       
                        $schedule = new schedule();
                        $schedule->opening = $dataRequest->opening;
                        $schedule->closing = $dataRequest->closing;
                        $schedule->days = $dataRequest->days;
                        $schedule->id_cellar = $dataRequest->id_cellar;
                        $schedule->created_at = $dateTime->format('Y-m-d H:i:s');

                       
                        if($schedule->save()){

                            $data = [
                                    "Successfully registered winery"
                            ];


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
                                "status" => ControllerBase::SUCCESS
                            ));

                        }else{

                            $register = $this->validateRegister($lol);

                            $errors = array();
                            foreach ($schedule->getMessages() as $msj) {
                                $errors[] = (string)$msj;
                            }
                            $this->setJsonResponse(ControllerBase::SUCCESS, " Failed register cellar", array(
                                "return" => false,
                                "message" => $errors,
                                "status" => ControllerBase::FAILED
                            ));

                        }
                        
                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => "The winery is already registered",
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
    public function updateScheduleAction()
    {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();

        $fields = array(
            "id"
        );

        $optional = array(
            "opening",
            "closing",
            "days",
            "id_cellar"        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

            try {

                $schedule = Schedule::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));

                if (isset($dataRequest->opening))
                    $schedule->opening = $dataRequest->opening;

                if (isset($dataRequest->closing))
                    $schedule->closing = $dataRequest->closing;

                if (isset($dataRequest->days))
                    $schedule->days = $dataRequest->days;

                if (isset($dataRequest->id_cellar))
                    $schedule->id_cellar = $dataRequest->id_cellar;


                $schedule->updated_at = $dateTime->format('Y-m-d H:i:s');

                if ($schedule->save()){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "data" => $schedule,
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => ServiceConstant::CLIENT_UPDATE_FAILURE,
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
    public function detailScheduleAction()
    {
        $dataRequest = $this->request->getJsonPost();

        $fields = array(
            "id"
        );

        if ($this->_checkFields($dataRequest, $fields)) {

            try {

                $schedule = Schedule::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));


                if ($schedule->id){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "data" => $schedule,
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => "No se encontro el horario",
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

    public function listScheduleAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "days"
        );

        $optional = array(     );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    $schedule = Schedule::find(array(
                        "conditions" => "days = ?1",
                        "bind" => array(1 => $dataRequest->days)
                    ));

                    $data = array();
                    foreach ($schedule as $value) {
                        $data[] = [
                                    "id" => $value->id,
                                    "opening" => $value->opening,
                                    "closing" => $value->closing,
                                    "days" => $value->days,
                                    "id_cellar" => $value->id_cellar

                        ];
                    }

                    if (count($data) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => "bien",
                            "data" => $data,

                            "status" => ControllerBase::SUCCESS
                        ));
                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => "not found",
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

    public function deleteScheduleAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id"
        );

        $optional = array();

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

                try {
                    $schedule = Schedule::findFirst($dataRequest->id);

                    if ($schedule) {
                        if ($schedule->delete()) {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => CellarConstants::DELETE_CELLAR_SUCCESS_MESSAGE,
                                "status" => ControllerBase::SUCCESS
                            ));
                        } else {
                             $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => CellarConstants::DELETE_CELLAR_FAILURE_MESSAGE,
                                "status" => ControllerBase::FAILED
                            ));
                        }
                    } 
                }

                catch (Exception $e) {
                        $this->logError($e, $dataRequest);
                }

            
        }
    } 

}