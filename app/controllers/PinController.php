<?php

class PinController extends ControllerBase {

  /**
    * 
    *
  */ 

  public function reportsTodayAction() {
      $dataRequest = $this->request->getJsonPost();
      $fields = array(
          "id_client",
          "date"
      );

      $optional = array(        );

      if ($this->_checkFields($dataRequest, $fields, $optional)) {
           
          
              try {

                  $reserveTodayModel = new Reserve();

                  $reserveTodaySql = $reserveTodayModel->searchReserveLastDay($dataRequest->id_client , $dataRequest->date);
                  while ($row = $reserveTodaySql->fetch(PDO::FETCH_ASSOC)) {

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

}
