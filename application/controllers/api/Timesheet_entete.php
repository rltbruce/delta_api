<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Timesheet_entete extends REST_Controller {

  
    public function __construct() {
        parent::__construct();
        $this->load->model('timesheet_entete_model', 'Timesheet_enteteManager');
        $this->load->model('personnel_model', 'PersonnelManager');
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
        $id_personnel = $this->get('id_personnel');
        $date_debut_semaine = $this->get('date_debut_semaine');
        $date_fin_semaine = $this->get('date_fin_semaine');
        $data = array();
        if ($menu=="get_personel")
        {
                
                $tmp = $this->PersonnelManager->findById($id_personnel);
                $data['id'] = $tmp->id;
                $data['code'] = $tmp->code;
                $data['nom'] = $tmp->nom;
            
        }
        if ($id)
        {
                
                $tmp = $this->Timesheet_enteteManager->findById($id);
                $personnel = $this->PersonnelManager->findById($tmp->id_pers);
                $data['id'] = $tmp->id;
                $data['date_feuille'] = $tmp->date_feuille;
                $data['personnel'] = $personnel;
            
        }
        if ($cle_etrangere) 
        {
            $data = $this->Timesheet_enteteManager->findAll_by_personnel($cle_etrangere);
        }
        
        if ($menu=="gettimesheet_entetebysemaine") 
        {
            
            $tmp = $this->Timesheet_enteteManager->gettimesheet_entetebysemaine($date_debut_semaine,$date_fin_semaine,$id_personnel);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $personnel = $this->PersonnelManager->findById($value->id_pers);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_feuille'] = $value->date_feuille;
                    $data[$key]['personnel'] = $personnel;
                }
            }
        }
        if ($menu=="findAll") 
        {
            
            $tmp = $this->Timesheet_enteteManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                            $personnel = $this->PersonnelManager->findById($value->id_pers);
                            $data[$key]['id'] = $value->id;
                            $data[$key]['date_feuille'] = $value->date_feuille;
                            $data[$key]['personnel'] = $personnel;
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
                    'date_feuille' => $this->post('date_feuille'),
                    'id_pers' => $this->post('id_pers')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Timesheet_enteteManager->add($data);
                if (!is_null($dataId))  {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId,
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
                    'date_feuille' => $this->post('date_feuille'),
                    'id_pers' => $this->post('id_pers')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Timesheet_enteteManager->update($id, $data);
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
            $delete = $this->Timesheet_enteteManager->delete($id);
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
