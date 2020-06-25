<?php

class ServiceController extends ControllerBase {

    public function newAction() {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();
        $fields = array(
            "key_hash",
            "name",
            "status"
        );

        $optional = array(      );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
                try {

                    $lol = Key::findFirst(array(
                                    "conditions" => "key_hash= ?1",
                                    "bind" => array(1 => $dataRequest->key_hash)
                              ));

                    if (isset($lol->id)){
                       
                        $service = new Service();
                        $service->name = $dataRequest->name;
                        $service->id_key = $lol->id;
                        $service->status = $dataRequest->status;
                        $service->created_at = $dateTime->format('Y-m-d H:i:s');

                        
                        if($service->save()){


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => ServiceConstants::SERVICE_SAVE_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));

                        }else{

                            $register = $this->validateRegister($lol);

                            $errors = array();
                            foreach ($service->getMessages() as $msj) {
                                $errors[] = (string)$msj;
                            }
                            $this->setJsonResponse(ControllerBase::SUCCESS, " Failed register service", array(
                                "return" => false,
                                "message" => $errors,
                                "status" => ControllerBase::FAILED
                            ));

                        }
                        
                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => ServiceConstants::KEY_SERVICE_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
                

                }catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }   
            
        }
    }

    /*
    *Accion updateeditService: Actualizar datos del Service
    */
    public function updateServiceAction()
    {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();

        $fields = array(
            "id"
        );

        $optional = array(
            "name",
            "status"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

            try {

                $service = Service::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));

                if (isset($dataRequest->name))
                    $service->name = $dataRequest->name;

                if (isset($dataRequest->status))
                    $service->status = $dataRequest->status;

                $service->updated_at = $dateTime->format('Y-m-d H:i:s');

                if ($service->save()){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "data" => $service,
                        "message" => ServiceConstants::UPDATE_SERVICE_SUCCESS,
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => ServiceConstants::UPDATE_SERVICE_FAILURE,
                        "status" => ControllerBase::FAILED
                    ));
                }
                
            } catch (Exception $e) {
                $this->logError($e, $dataRequest);
            }
         
        }
    }

    /*
    *Accion detailService: Detalle de Servicio
    */
    public function detailServiceAction()
    {
        $dataRequest = $this->request->getJsonPost();

        $fields = array(
            "id"
        );

        if ($this->_checkFields($dataRequest, $fields)) {

            try {

                $service = Service::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));


                if ($service->id){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "data" => $service,
                        "message" => ServiceConstants::LIST_SERVICE_SUCCESS,
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => ServiceConstants::LIST_SERVICE_FAILURE,
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

    public function listServiceAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "name"
        );

        $optional = array(
            "status"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    $service = Service::find(array(
                        "conditions" => "name = ?1",
                        "bind" => array(1 => $dataRequest->name)
                    ));


                    $data = array();
                    foreach ($service as $value) {
                        $data[] = [
                                    "id" => $value->id,
                                    "name" => $value->name,
                                    "status" => $value->status

                        ];
                        
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

        /**
     * 
     *
     */ 

    public function deleteServiceAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id"
        );

        $optional = array();

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

                try {
                    $service = Service::findFirst($dataRequest->id);

                    if ($service) {
                        if ($service->delete()) {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => ServiceConstants::DELETE_SERVICE_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));
                        } else {
                             $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => ServiceConstants::DELETE_SERVICE_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }
                    } 

                    else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => ServiceConstants::DELETE_SERVICE_NOT_FOUNT,
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
                }

                catch (Exception $e) {
                        $this->logError($e, $dataRequest);
                }

            
        }
    } 

}