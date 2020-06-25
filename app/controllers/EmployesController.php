<?php

class EmployesController extends ControllerBase {



    public function newAction() {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();
        $fields = array(
            "name",
            "document",
            "phone",
            "email",
            "address",
            "type_employee"
            

        );

        $optional = array(
            "image"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
                try {



                    $lol = Employes::findFirst(array(
                                    "conditions" => "document= ?1",
                                    "bind" => array(1 => $dataRequest->document)
                              ));

                    if (!isset($lol->name)){
                       
                        $employes = new Employes();
                        $employes->name = $dataRequest->name;
                        $employes->document = $dataRequest->document;
                        $employes->phone = $dataRequest->phone;
                        $employes->email = $dataRequest->email;
                        $employes->address = $dataRequest->address;
                        $employes->type_employee = $dataRequest->type_employee;
                        $employes->image = isset($dataRequest->image) ?  $dataRequest->image : null ;
                        $employes->created_at = $dateTime->format('Y-m-d H:i:s');

                       
                        if($employes->save()){


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => EmployesConstants::EMPLOYES_SAVE_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));

                        }else{


                            $errors = array();
                            foreach ($employes->getMessages() as $msj) {
                                $errors[] = (string)$msj;
                            }
                            $this->setJsonResponse(ControllerBase::SUCCESS, " Failed register employes", array(
                                "return" => false,
                                "message" => EmployesConstants::EMPLOYES_SAVE_FAILURE,
                                "errors" => $errors,
                                "status" => ControllerBase::FAILED
                            ));

                        }
                        
                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => EmployesConstants::EMPLOYES_SAVE_EXIST,
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
                

                }catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }   
            
        }
    }

    /*
    *Accion updateEmployes: Actualizar datos del employes
    */
    public function updateEmployesAction()
    {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();

        $fields = array(
            "id"
        );

        $optional = array(
            "name",
            "document",
            "phone",
            "email",
            "address",
            "type_employee",
            "image"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

            try {

                $employes = Employes::findFirst(array(
                    "conditions" => "id = ?1",
                    "bind" => array(1 => $dataRequest->id)
                ));

                if (isset($dataRequest->name))
                    $employes->name = $dataRequest->name;

                if (isset($dataRequest->document))
                    $employes->document = $dataRequest->document;

                if (isset($dataRequest->phone))
                    $employes->phone = $dataRequest->phone;

                if (isset($dataRequest->email))
                    $employes->email = $dataRequest->email;

                if (isset($dataRequest->address))
                    $employes->address = $dataRequest->address;

                if (isset($dataRequest->type_employee))
                    $employes->type_employee = $dataRequest->type_employee;

                if (isset($dataRequest->image))
                    $employes->image = $dataRequest->image;


                $employes->updated_at = $dateTime->format('Y-m-d H:i:s');

                if ($employes->save()){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "message" => "update",
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => EmployesConstants::EMPLOYES_UPDATE_FAILURE,
                        "status" => ControllerBase::FAILED
                    ));
                }
                
            } catch (Exception $e) {
                $this->logError($e, $dataRequest);
            }
         
        }
    }

    /*
    *Accion detailEmployes: Detalle de la Bodega
    */
    public function detailEmployesAction()
    {
        $dataRequest = $this->request->getJsonPost();

        $fields = array(
            "id"
        );

        if ($this->_checkFields($dataRequest, $fields)) {

            try {

                $employes = Employes::find(array(
                        "conditions" => "id = ?1",
                        "bind" => array(1 => $dataRequest->id)
                    ));

                    $data = array();
                    foreach ($employes as $value) {
                        $data[] = [
                                    "id" => $value->id,
                                    "name" => $value->name,
                                    "document" => $value->document,
                                    "phone" => $value->phone,
                                    "email" => $value->email,
                                    "address" => $value->address,
                                    "type_employee" => $value->type_employee,
                                    "image" => $value->image


                        ];
                    }
            
                if (count($data) > 0){
                    $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => true,
                        "message" => EmployesConstants::LIST_EMPLOYES_SUCCESS,
                        "data" => $data,
                        "status" => ControllerBase::SUCCESS
                    ));

                } else {

                   $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::SUCCESS_MESSAGE, array(
                        "return" => false,
                        "message" => EmployesConstants::LIST_EMPLOYES_FAILURE,                       
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

    public function listEmployesAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "type_employee"
        );

        $optional = array(
            "name",
            "document",
            "phone",
            "email",
            "address",
            "image"
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
            
            
                try {
                    $employes = Employes::find(array(
                        "conditions" => "type_employee = ?1",
                        "bind" => array(1 => $dataRequest->type_employee)
                    ));


                    $data = array();
                    foreach ($employes as $value) {
                        $data[] = [
                                    "id" => $value->id,
                                    "name" => $value->name,
                                    "document" => $value->document,
                                    "phone" => $value->phone,
                                    "email" => $value->email,
                                    "address" => $value->address,
                                    "type_employee" => $value->type_employee,
                                    "image" => $value->image

                        ];
                    }

                    if (count($data) > 0) {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => true,
                            "message" => EmployesConstants::LIST_EMPLOYES_SUCCESS,
                            "data" => $data,
                            "status" => ControllerBase::SUCCESS
                        ));
                         
                    } else {
                        $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                            "return" => false,
                            "message" => EmployesConstants::LIST_EMPLOYES_FAILURE,
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

    public function deleteEmployesAction() {
        $dataRequest = $this->request->getJsonPost();
        $fields = array(
            "id"
        );

        $optional = array();

        if ($this->_checkFields($dataRequest, $fields, $optional)) {

                try {
                    $employes = Employes::findFirst($dataRequest->id);

                    if ($employes) {
                        if ($employes->delete()) {
                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "message" => EmployesConstants::DELETE_EMPLOYES_SUCCESS,
                                "status" => ControllerBase::SUCCESS
                            ));
                        } else {
                             $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => false,
                                "message" => EmployesConstants::DELETE_EMPLOYES_FAILURE,
                                "status" => ControllerBase::FAILED
                            ));
                        }


                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => EmployesConstants::DELETE_EMPLOYES_NOT_FOUNT,
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