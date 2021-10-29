<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Conge extends REST_Controller {

  
    public function __construct() {
        parent::__construct();
        $this->load->model('conge_model', 'CongeManager');
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
        $id_personnel_conge = $this->get('id_personnel_conge'); 
        $id_personnel = $this->get('id_personnel'); 
        $date_debut = $this->get('date_debut');  
        $annee_now = $this->get('annee_now');   
        $date_feuille = $this->get('date_feuille');   
        $data = array();
        if ($menu=="getmaxidcongevalidebypersonnel") 
        {
            $tmp = $this->CongeManager->getmaxidcongevalidebypersonnel($id_personnel_conge,$annee_now);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        if ($menu=="testcongebydate_debut") 
        {
            $tmp = $this->CongeManager->testcongebydate_debut($id_personnel_conge,$date_debut);
            if ($tmp) 
            {

            }
        }
        if ($menu=="getcongebypersonnel") 
        {
            $tmp = $this->CongeManager->getcongebypersonnel($id_personnel_conge);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel_conge = $this->CongeManager->findpersonnelById($value->id_personnel_conge);
                    $personnel_validation = $this->CongeManager->findpersonnelById($value->id_personnel_validation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['motif'] = $value->motif;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['personnel_conge'] = $personnel_conge;
                    $data[$key]['personnel_validation'] = $personnel_validation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_retour'] = $value->date_retour ;
                    $data[$key]['reste_conge'] = intval($value->reste_conge) ;
                }
            }
        }
        
        if ($menu=="findAll") 
        {
            
            $tmp = $this->CongeManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel_conge = $this->CongeManager->findpersonnelById($value->id_personnel_conge);
                    $personnel_validation = $this->CongeManager->findpersonnelById($value->id_personnel_validation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['motif'] = $value->motif;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['personnel_conge'] = $personnel_conge;
                    $data[$key]['personnel_validation'] = $personnel_validation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_retour'] = $value->date_retour ;
                    $data[$key]['reste_conge'] = intval($value->reste_conge) ;
                }
            }
        } 
        
        if ($menu=="getcongeencouretvalidebydate") 
        {
            
            $tmp = $this->CongeManager->getcongeencouretvalidebydate($date_feuille,$id_personnel);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        
        if ($menu=="getcongebyid") 
        {
            $tmp = $this->CongeManager->getcongebyid($id);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel_conge = $this->CongeManager->findpersonnelById($value->id_personnel_conge);
                    $personnel_validation = $this->CongeManager->findpersonnelById($value->id_personnel_validation);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['motif'] = $value->motif;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['personnel_conge'] = $personnel_conge;
                    $data[$key]['personnel_validation'] = $personnel_validation;
                    $data[$key]['validation'] = $value->validation;
                    $data[$key]['date_retour'] = $value->date_retour ;
                    $data[$key]['reste_conge'] = intval($value->reste_conge) ;
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
                if ($this->post('date_retour')!='' && $this->post('date_retour')!='undefined')
                {
                    $data = array(
                        'motif' => $this->post('motif'),
                        'date_debut' => $this->post('date_debut'),
                        'date_fin' => $this->post('date_fin'),
                        'date_fin' => $this->post('date_fin'),
                        'id_personnel_conge' => $this->post('id_personnel_conge'),
                        'id_personnel_validation' => $this->post('id_personnel_validation'),
                        'validation' => $this->post('validation'),
                        'date_retour' => $this->post('date_retour'),
                        'reste_conge' => $this->post('reste_conge')
                    );
                }
                else
                {
                    $data = array(
                        'motif' => $this->post('motif'),
                        'date_debut' => $this->post('date_debut'),
                        'date_fin' => $this->post('date_fin'),
                        'date_fin' => $this->post('date_fin'),
                        'id_personnel_conge' => $this->post('id_personnel_conge'),
                        'id_personnel_validation' => $this->post('id_personnel_validation'),
                        'validation' => $this->post('validation'),
                        'date_retour' => null,
                        'reste_conge' => $this->post('reste_conge')
                    );
                }
                
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->CongeManager->add($data);
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
                if ($this->post('date_retour')!='' && $this->post('date_retour')!='undefined')
                {
                    $data = array(
                        'motif' => $this->post('motif'),
                        'date_debut' => $this->post('date_debut'),
                        'date_fin' => $this->post('date_fin'),
                        'date_fin' => $this->post('date_fin'),
                        'id_personnel_conge' => $this->post('id_personnel_conge'),
                        'id_personnel_validation' => $this->post('id_personnel_validation'),
                        'validation' => $this->post('validation'),
                        'date_retour' => $this->post('date_retour'),
                        'reste_conge' => $this->post('reste_conge')
                    );
                }
                else
                {
                    $data = array(
                        'motif' => $this->post('motif'),
                        'date_debut' => $this->post('date_debut'),
                        'date_fin' => $this->post('date_fin'),
                        'date_fin' => $this->post('date_fin'),
                        'id_personnel_conge' => $this->post('id_personnel_conge'),
                        'id_personnel_validation' => $this->post('id_personnel_validation'),
                        'validation' => $this->post('validation'),
                        'date_retour' => null,
                        'reste_conge' => $this->post('reste_conge')
                    );
                }
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->CongeManager->update($id, $data);
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
            $delete = $this->CongeManager->delete($id);
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
