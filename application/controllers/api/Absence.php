<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Absence extends REST_Controller {

  
    public function __construct() {
        parent::__construct();
        $this->load->model('absence_model', 'AbsenceManager');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
      //  $this->load->model('typeindicateur_model', 'Type_indicateurManager');
    }
    public function index_get()
    {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $menu = $this->get('menu');      
        $id_personnel_absent = $this->get('id_personnel_absent');    
        $data = array();
     
        if ($menu=="getabsencebypersonnel") 
        {
            $tmp = $this->AbsenceManager->getabsencebypersonnel($id_personnel_absent);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel_absent = $this->AbsenceManager->findpersonnelById($value->id_personnel_absent);
                    $personnel_validation = $this->AbsenceManager->findpersonnelById($value->id_personnel_validation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type'] = intval($value->type) ;
                    $data[$key]['motif'] = $value->motif;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['personnel_absent'] = $personnel_absent;
                    $data[$key]['personnel_validation'] = $personnel_validation;
                    $data[$key]['validation'] = $value->validation;
                }
            }
        }
        
        if ($menu=="findAll") 
        {
            
            $tmp = $this->AbsenceManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel_absent = $this->AbsenceManager->findpersonnelById($value->id_personnel_absent);
                    $personnel_validation = $this->AbsenceManager->findpersonnelById($value->id_personnel_validation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type'] = $value->type;
                    $data[$key]['motif'] = $value->motif;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['personnel_absent'] = $personnel_absent;
                    $data[$key]['personnel_validation'] = $personnel_validation;
                    $data[$key]['validation'] = $value->validation;
                }
            }
        } 
        if ($menu=="getabsencebyid") 
        {
            $tmp = $this->AbsenceManager->getabsencebyid($id);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel_absent = $this->AbsenceManager->findpersonnelById($value->id_personnel_absent);
                    $personnel_validation = $this->AbsenceManager->findpersonnelById($value->id_personnel_validation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['type'] = intval($value->type) ;
                    $data[$key]['motif'] = $value->motif;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['personnel_absent'] = $personnel_absent;
                    $data[$key]['personnel_validation'] = $personnel_validation;
                    $data[$key]['validation'] = $value->validation;
                }
            }
        }    
        
        if (count($data)>0) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                // 'message' => 'Get data success',
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
                    'type' => $this->post('type'),
                    'motif' => $this->post('motif'),
                    'date_debut' => $this->post('date_debut'),
                    'date_fin' => $this->post('date_fin'),
                    'date_fin' => $this->post('date_fin'),
                    'duree' => $this->post('duree'),
                    'id_personnel_absent' => $this->post('id_personnel_absent'),
                    'id_personnel_validation' => $this->post('id_personnel_validation'),
                    'validation' => $this->post('validation')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->AbsenceManager->add($data);
                if (!is_null($dataId))  {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
                        'prev' => TRUE,
                        'message' => 'Data insert success'
                            ], REST_Controller::HTTP_OK);
                    
                } else {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }         
            } else {
                $data = array(
                    'type' => $this->post('type'),
                    'motif' => $this->post('motif'),
                    'date_debut' => $this->post('date_debut'),
                    'date_fin' => $this->post('date_fin'),
                    'date_fin' => $this->post('date_fin'),
                    'duree' => $this->post('duree'),
                    'id_personnel_absent' => $this->post('id_personnel_absent'),
                    'id_personnel_validation' => $this->post('id_personnel_validation'),
                    'validation' => $this->post('validation')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->AbsenceManager->update($id, $data);
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
                            ], REST_Controller::HTTP_OK);
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
            $delete = $this->AbsenceManager->delete($id);
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
                        ], REST_Controller::HTTP_OK);
            }
        }      
    }
}
/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
