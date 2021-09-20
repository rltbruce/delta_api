<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Timesheet_detail extends REST_Controller {

  
    public function __construct() {
        parent::__construct();
        $this->load->model('timesheet_detail_model', 'Timesheet_detailManager');
        $this->load->model('soussection_model', 'SoussectionManager');
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
    public function index_get()
    {
        $id = $this->get('id');
        $cle_etrangere = $this->get('cle_etrangere');
        $menu = $this->get('menu');
        $id_entete = $this->get('id_entete');
        $date_debut_semaine = $this->get('date_debut_semaine');
        $date_fin_semaine = $this->get('date_fin_semaine');        
        $id_personnel = $this->get('id_personnel');
        $data = array();
        
        if ($id)
        {
                
                $tmp = $this->Timesheet_detailManager->findById($id);
                $sous_tache = $this->SoussectionManager->findById($tmp->sous_tache);
                $mission = $this->MissionManager->findById($tmp->id_mission);
                $data['id'] = $tmp->id;
                $data['libelle'] = $tmp->libelle;
                $data['pourcentage'] = $tmp->pourcentage;
                $data['duree'] = $tmp->duree;
                $data['sous_tache'] = $sous_tache;
                $data['mission'] = $mission;
            
        }
        if ($cle_etrangere) 
        {
            $tmp = $this->Timesheet_detailManager->findAll_by_entete($cle_etrangere);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $sous_tache = $this->SoussectionManager->findById($value->sous_tache);
                    $mission = $this->MissionManager->findById($value->id_mission);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['sous_tache'] = $sous_tache;
                    $data[$key]['mission'] = $mission;
                }
            }
        }
        
        if ($menu=="findAll") 
        {
            
            $tmp = $this->Timesheet_detailManager->findAll();
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $sous_tache = $this->SoussectionManager->findById($value->sous_tache);
                    $mission = $this->MissionManager->findById($value->id_mission);
                    $data[$key]['id'] = $value->id;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['sous_tache'] = $sous_tache;
                    $data[$key]['mission'] = $mission;
                }
            }
        }
        if ($menu=="getresumesemaine") 
        {   
            setlocale(LC_TIME, "fr_FR");  
            for ($i = 0; $i <= 6; $i++)
            {                 
                $date_cherche= date('Y-m-d', strtotime($date_debut_semaine . '+'.$i.' day'));                
                $date_name=strftime("%A", strtotime($date_cherche));
                $jour=strval(strtoupper($date_name));
                $tmp = $this->Timesheet_detailManager->getresumesemaine($date_cherche,$id_personnel);
                if ($tmp) 
                {
                    foreach ($tmp as $key => $value)
                    {
                        $sous_tache = $this->SoussectionManager->findById($value->sous_tache);
                        $mission = $this->MissionManager->findById($value->id_mission);
                        $data[0][$jour][$key]['id'] = $value->id;
                        $data[0][$jour][$key]['libelle'] = $value->libelle;
                        $data[0][$jour][$key]['pourcentage'] = $value->pourcentage;
                        $data[0][$jour][$key]['duree'] = $value->duree;
                        $data[0][$jour][$key]['sous_tache'] = $sous_tache;
                        $data[0][$jour][$key]['mission'] = $mission;
                        $data[0][$jour][$key]['date_cherche'] = $date_cherche;
                        $data[0][$jour][$key]['date'] = $date_debut_semaine;
                    }
                }
                else
                {                    
                    $data[0][$jour]= null;
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
                    'libelle' => $this->post('libelle'),
                    'pourcentage' => $this->post('pourcentage'),
                    'duree' => $this->post('duree'),
                    'sous_tache' => $this->post('sous_tache'),
                    'id_mission' => $this->post('id_mission'),
                    'id_entete' => $this->post('id_entete')
                );
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Timesheet_detailManager->add($data);
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
                    'libelle' => $this->post('libelle'),
                    'pourcentage' => $this->post('pourcentage'),
                    'duree' => $this->post('duree'),
                    'sous_tache' => $this->post('sous_tache'),
                    'id_mission' => $this->post('id_mission'),
                    'id_entete' => $this->post('id_entete')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Timesheet_detailManager->update($id, $data);
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
            $delete = $this->Timesheet_detailManager->delete($id);
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
