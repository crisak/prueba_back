<?php

class RegisterController extends ControllerBase {



    public function postAction() {

        $dataRequest = $this->request->getJsonPost();

        $dateTime = new \DateTime();
        $fields = array(
            "pass",
            "email",
            "name",
            "document"
        );

        $optional = array(
            "phone",
        );

        if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
                try {



                    $lol = User::findFirst(array(
                                    "conditions" => "email = ?1",
                                    "bind" => array(1 => $dataRequest->email)
                              ));

                    if (!isset($lol->name)){
                       
                        $user = new User();
                        $user->name = $dataRequest->name;
                        $user->phone = isset($dataRequest->phone) ?  $dataRequest->phone : null ;
                        $user->password = $dataRequest->pass;
                        $user->email = $dataRequest->email;
                        $user->created_at = $dateTime->format('Y-m-d H:i:s');
                        $user->token = hash('sha256',str_shuffle("p4q6r8s10t2u3v5a7b9cdefghijklmnowxyz" . uniqid()));

                        
                        if($user->save()){

                            $data = [
                                    "email" => "$user->email",
                                    "name" => "$user->name",
                                    "pass" => "$user->password"
                            ];


                            $this->setJsonResponse(ControllerBase::SUCCESS, ControllerBase::SUCCESS_MESSAGE, array(
                                "return" => true,
                                "data" => $data,
                                "status" => ControllerBase::SUCCESS
                            ));

                        }else{

                            $register = $this->validateRegister($lol);

                            $errors = array();
                            foreach ($user->getMessages() as $msj) {
                                $errors[] = (string)$msj;
                            }
                            $this->setJsonResponse(ControllerBase::SUCCESS, " Failed register user", array(
                                "return" => false,
                                "message" => $errors,
                                "status" => ControllerBase::FAILED
                            ));

                        }
                        
                    } else {

                             $this->setJsonResponse(ControllerBase::FAILED, ControllerBase::FAILED_MESSAGE, array(
                                "return" => false,
                                "message" => "El usuario ya se encuentra registrado",
                                "status" => ControllerBase::FAILED
                            ));
                        

                    }
            	

                }catch (Exception $e) {
                    $this->logError($e, $dataRequest);
                }	
            
        }
    }

}