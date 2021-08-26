<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Mission extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mission_model', 'DeboursManager');
        $this->load->model('mission_model', 'MissionManager');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
      //  $this->load->model('typeindicateur_model', 'Type_indicateurManager');
    }
    public function index_get() {
        $id = $this->get('id');
		//$typeindicateur_id=$this->get('typeindicateur_id');
		$code=$this->get('code');
        $data = array();
        
        $idcl=$this->get('idcl');
       
        if($idcl )
        {
            
            $menu = $this->DeboursManager->findAllByClient($idcl);
                if ($menu) {
                    foreach ($menu as $key => $value) {
                       
                        $data[$key]['id'] = $value->id;
                        $data[$key]['num_contrat'] = $value->num_contrat;
                        $data[$key]['date_contrat'] = $value->date_contrat;
                        $data[$key]['montant_ht'] = $value->montant_ht;
                        $data[$key]['id_client'] = $value->id_client;
                       /* $mission = $this->MissionManager->findAllByClient($value->id);
                        if($mission)
                        {
                        $data[$key]['mission']=$mission;
                        }else
                        {
                            $data[$key]['mission']=array();
                        }*/


                        //Mission

                        //fin mission

                    }
                }        


        }
       

		if ($id) {
			$debours = $this->DeboursManager->findById($id);
			//$type_indicateur = $this->Type_indicateurManager->findById($indicateur->type_indicateur_id);
            $data[$key]['id'] = $value->id;
            $data[$key]['num_contrat'] = $value->num_contrat;
            $data[$key]['date_contrat'] = $value->date_contrat;
            $data[$key]['montant_ht'] = $value->montant_ht;
            $data[$key]['id_client'] = $value->id_client;
           
		
        } 
        
        if(!$id & !$idcl)
        {
          //  $data = $this->DeboursManager->findAll();
            $data=array();
        }
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post() {
        $id = $this->post('id') ;
       
        $supprimer = $this->post('supprimer') ;
      
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'code' => $this->post('code'),
                    'libelle' => $this->post('libelle'),
                    'associe_resp' => $this->post('associe_resp'),
                    'senior_manager' => $this->post('senior_manager'),
                    'chef_mission' => $this->post('chef_mission'),
                    'produit' => $this->post('produit'),
                    'id_contrat' => $this->post('id_contrat')
                
                  
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->DeboursManager->add($data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
                        'message' => 'Data insert success'
                            ], REST_Controller::HTTP_OK);
                }  else {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                
                $data = array(
                    'code' => $this->post('code'),
                    'libelle' => $this->post('libelle'),
                    'associe_resp' => $this->post('associe_resp'),
                    'senior_manager' => $this->post('senior_manager'),
                    'chef_mission' => $this->post('chef_mission'),
                    'produit' => $this->post('produit'),
                    'id_contrat' => $this->post('id_contrat')
                
                
                   
                  

                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->DeboursManager->update($id, $data);
                if(!is_null($update)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => 1,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        } else {
            if (!$id) {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
            $delete = $this->DeboursManager->delete($id);
            if (!is_null($delete)) {
                $this->response([
                    'status' => TRUE,
                    'response' => 1,
                    'message' => "Delete data success"
                        ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'response' => 0,
                    'message' => 'No request found'
                        ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }        
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
