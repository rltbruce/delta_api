<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Timesheet_entete extends REST_Controller {

  
    public function __construct() {
        parent::__construct();
        $this->load->model('timesheet_entete_model', 'Timesheet_enteteManager');
        $this->load->model('timesheet_detail_model', 'Timesheet_detailManager');
        $this->load->model('soussection_model', 'SoussectionManager');
        $this->load->model('mission_model', 'MissionManager');
        $this->load->model('client_model', 'ClientManager');
        $this->load->model('section_model', 'SectionManager');
        $this->load->model('personnel_model', 'PersonnelManager');
        $this->load->model('conge_model', 'CongeManager');
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
        $id_personnel = $this->get('id_personnel');
        $date_debut_semaine = $this->get('date_debut_semaine');
        $date_fin_semaine = $this->get('date_fin_semaine');
        $date_debut = $this->get('date_debut');
        $date_fin = $this->get('date_fin');
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
        if ($menu=="getfeuilletempsbydate_debu_fin") 
        {
            
            $tmp = $this->Timesheet_enteteManager->getfeuilletempsbydate_debu_fin($date_debut,$date_fin,$id_personnel);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        if ($menu=="gettimesheet_entetebydate_personnel") 
        {
            
            $tmp = $this->Timesheet_enteteManager->gettimesheet_entetebydate_personnel($date_debut_semaine,$date_fin_semaine,$id_personnel);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                   // $personnel = $this->PersonnelManager->findById($value->id_pers);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['date_feuille'] = $value->date_feuille;
                    $data[$key]['date_debut'] = $value->date_debut;
                    $data[$key]['date_fin'] = $value->date_fin;
                    $data[$key]['type'] = $value->type;
                   // $data[$key]['personnel'] = $personnel;
                }
            }
        }
        
        if ($menu=="gettimesheet_entetebydate_personnel_detail") 
        {
            
            $tmp = $this->Timesheet_enteteManager->gettimesheet_entetebydate_personnel($date_debut_semaine,$date_fin_semaine,$id_personnel);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                   // $personnel = $this->PersonnelManager->findById($value->id_pers);
                    $data[$value->date_feuille]['id'] = $value->id;
                    $data[$value->date_feuille]['type'] = $value->type;
                    if ($value->type=='timesheet') {
                        $tmp_time = $this->Timesheet_detailManager->findAll_by_entete($value->id,$id_personnel);
                        if ($tmp_time) 
                        {
                            foreach ($tmp_time as $key2 => $value_time)
                            {
                                $sous_section = $this->SoussectionManager->findById($value_time->id_sous_section);
                                $mission = $this->MissionManager->findById($value_time->id_mission);
                                $client = $this->ClientManager->findById($value_time->id_client);
                                $section = $this->SectionManager->findById($value_time->id_section);
                                $data[$value->date_feuille]['timesheet'][$key2]['pourcentage'] = $value_time->pourcentage;
                                $data[$value->date_feuille]['timesheet'][$key2]['duree'] = $value_time->duree;
                                $data[$value->date_feuille]['timesheet'][$key2]['duree_cumule'] = $value_time->duree_cumule;
                                $data[$value->date_feuille]['timesheet'][$key2]['sous_section'] = $sous_section;
                                $data[$value->date_feuille]['timesheet'][$key2]['mission'] = $mission;
                                $data[$value->date_feuille]['timesheet'][$key2]['client'] = $client;
                                $data[$value->date_feuille]['timesheet'][$key2]['section'] = $section;
                            }
                        }
                        else
                        {
                            $data[$value->date_feuille]['timesheet']=array();
                        }
                    }
                    if ($value->type=='conge')
                    {
                        $tmp_cong = $this->CongeManager->getcongebyid($value->id);
                        if ($tmp_cong) 
                        {
                            foreach ($tmp_cong as $key_cong => $value_cong)
                            {
                                $data[$value->date_feuille]['conge'][$key_cong]['id'] = $value_cong->id;
                                $data[$value->date_feuille]['conge'][$key_cong]['motif'] = $value_cong->motif;
                                $data[$value->date_feuille]['conge'][$key_cong]['date_debut'] = $value_cong->date_debut;
                                $data[$value->date_feuille]['conge'][$key_cong]['date_fin'] = $value_cong->date_fin;
                                $data[$value->date_feuille]['conge'][$key_cong]['validation'] = $value_cong->validation;
                                $data[$value->date_feuille]['conge'][$key_cong]['date_retour'] = $value_cong->date_retour ;
                                $data[$value->date_feuille]['conge'][$key_cong]['reste_conge'] = intval($value_cong->reste_conge) ;
                            }
                        }
                        else
                        {
                            $data[$value->date_feuille]['conge']=array();
                        }
                    }
                    if ($value->type=='absence') 
                    {
                        $tmp_absence = $this->AbsenceManager->getabsencebyid($value->id);
                        if ($tmp_absence) 
                        {
                            foreach ($tmp_absence as $key_absence => $value_absence)
                            {
                                $data[$value->date_feuille]['absence'][$key_absence]['id'] = $value_absence->id;
                                $data[$value->date_feuille]['absence'][$key_absence]['type'] = intval($value_absence->type) ;
                                $data[$value->date_feuille]['absence'][$key_absence]['motif'] = $value_absence->motif;
                                $data[$value->date_feuille]['absence'][$key_absence]['date_debut'] = $value_absence->date_debut;
                                $data[$value->date_feuille]['absence'][$key_absence]['date_fin'] = $value_absence->date_fin;
                                $data[$value->date_feuille]['absence'][$key_absence]['duree'] = $value_absence->duree;
                                $data[$value->date_feuille]['absence'][$key_absence]['validation'] = $value_absence->validation;
                            }
                        }
                        else
                        {
                            $data[$value->date_feuille]['anbsence']=array();
                        }
                    } 
                    
                   // $data[$key]['personnel'] = $personnel;
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
