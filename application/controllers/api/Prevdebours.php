<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Prevdebours extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('prevdebours_model', 'DeboursManager');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->model('debours_model', 'DebManager');
    }
    public function index_get() {
        $id = $this->get('id');
		//$typeindicateur_id=$this->get('typeindicateur_id');
       // $code=$this->get('code');
        $idcl=$this->get('idcl');
		$data = array();
		if ($id) {
			$debours = $this->DeboursManager->findById($id);
			$grade = $this->GradeManager->findById($debours->grade);
			$data['id'] = $debours->id;
			$data['nbre_jours'] = $debours->nbre_jours;
			$data['id_debours'] = $debours->id_debours;
            $data['id_mission'] = $debours->id_mission;
            $data['pu'] = $debours->pu;
           // $data['libgrade']=$grade.libelle;
		
		} else{
                $menu = $this->DeboursManager->findAllByMission($idcl);
               // $menu = $this->DeboursManager->findAll();
                if ($menu) {
                    foreach ($menu as $key => $value) {
                                             
                        $deb = $this->DebManager->findById($value->id_debours);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['nbre_jours'] = $value->nbre_jours;
                        $data[$key]['id_debours'] = $value->id_debours;
                        $data[$key]['pu'] = $value->pu;
                        $data[$key]['id_mission'] = $value->id_mission;
                        $data[$key]['libdebours'] = $deb->libelle;
                        $data[$key]['edit'] = false;
                       
                    }
                }        

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
                    'nbre_jours' => $this->post('nbre_jours'),
                    'id_debours' => $this->post('id_debours'),
                    'pu' => intval($this->post('pu')),
                    'id_mission' => $this->post('id_mission'),
                   
                  
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
                    'nbre_jours' => $this->post('nbre_jours'),
                    'id_debours' => $this->post('id_debours'),
                    'pu' => intval($this->post('pu')),
                    'id_mission' => $this->post('id_mission'),
                   

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
