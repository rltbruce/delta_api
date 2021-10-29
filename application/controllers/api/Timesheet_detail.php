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
        $this->load->model('client_model', 'ClientManager');
        $this->load->model('section_model', 'SectionManager');
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
        $id_entete = $this->get('id_entete');
        $date_debut_semaine = $this->get('date_debut_semaine');
        $date_fin_semaine = $this->get('date_fin_semaine');        
        $id_personnel = $this->get('id_personnel');     
        $id_mission = $this->get('id_mission');     
        $id_section = $this->get('id_section');    
        $id_sous_section = $this->get('id_sous_section');
        $data = array();
        
        if ($id)
        {
                
                $tmp = $this->Timesheet_detailManager->findById($id);
                $sous_section = $this->SoussectionManager->findById($tmp->id_sous_section);
                $mission = $this->MissionManager->findById($tmp->id_mission);
                $data['id'] = $tmp->id;
                //$data['libelle'] = $tmp->libelle;
                $data['pourcentage'] = $tmp->pourcentage;
                $data['duree'] = $tmp->duree;
                $data['sous_section'] = $sous_section;
                $data['mission'] = $mission;
            
        }
        if ($menu=="getdetailbyentete") 
        {
            $tmp = $this->Timesheet_detailManager->findAll_by_entete($id_entete,$id_personnel);
            if ($tmp) 
            {
                foreach ($tmp as $key => $value)
                {
                    $sous_section = $this->SoussectionManager->findById($value->id_sous_section);
                    $mission = $this->MissionManager->findById($value->id_mission);
                    $client = $this->ClientManager->findById($value->id_client);
                    $section = $this->SectionManager->findById($value->id_section);
                    $data[$key]['id'] = $value->id;
                    //$data[$key]['libelle'] = $value->libelle;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['duree_cumule'] = $value->duree_cumule;
                    $data[$key]['sous_section'] = $sous_section;
                    $data[$key]['mission'] = $mission;
                    $data[$key]['client'] = $client;
                    $data[$key]['section'] = $section;
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
                    $sous_section = $this->SoussectionManager->findById($value->id_sous_section);
                    $mission = $this->MissionManager->findById($value->id_mission);
                    $data[$key]['id'] = $value->id;
                    //$data[$key]['libelle'] = $value->libelle;
                    $data[$key]['pourcentage'] = $value->pourcentage;
                    $data[$key]['duree'] = $value->duree;
                    $data[$key]['sous_section'] = $sous_section;
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
                        $sous_section = $this->SoussectionManager->findById($value->id_sous_section);
                        $client = $this->ClientManager->findById($value->id_client);
                        $section = $this->SectionManager->findById($value->id_section);
                        $mission = $this->MissionManager->findById($value->id_mission);
                        $data[0][$jour][$key]['id'] = $value->id;
                        //$data[0][$jour][$key]['libelle'] = $value->libelle;
                        $data[0][$jour][$key]['pourcentage'] = $value->pourcentage;
                        $data[0][$jour][$key]['duree'] = $value->duree;
                        $data[0][$jour][$key]['section'] = $section;
                        $data[0][$jour][$key]['client'] = $client;
                        $data[0][$jour][$key]['sous_section'] = $sous_section;
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
        if ($menu=="getsectionbymission") 
        {
            
            $tmp = $this->Timesheet_detailManager->getsectionbymission($id_mission);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        if ($menu=="getsous_sectionbysection") 
        {
            
            $tmp = $this->Timesheet_detailManager->getsous_sectionbysection($id_section);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        if ($menu=="getdureeanterieur") 
        {
            
            $tmp = $this->Timesheet_detailManager->getdureeanterieur($id_mission,$id_section,$id_sous_section);
            if ($tmp) 
            {
                $data=$tmp;
            }
        }
        
        if ($menu=="getresumesemainewithconge") 
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
                        $sous_section = $this->SoussectionManager->findById($value->id_sous_section);
                        $client = $this->ClientManager->findById($value->id_client);
                        $section = $this->SectionManager->findById($value->id_section);
                        $mission = $this->MissionManager->findById($value->id_mission);
                        $data[0][$jour][$key]['id'] = $value->id;
                        //$data[0][$jour][$key]['libelle'] = $value->libelle;
                        $data[0][$jour][$key]['pourcentage'] = $value->pourcentage;
                        $data[0][$jour][$key]['duree'] = $value->duree;
                        $data[0][$jour][$key]['section'] = $section;
                        $data[0][$jour][$key]['client'] = $client;
                        $data[0][$jour][$key]['sous_section'] = $sous_section;
                        $data[0][$jour][$key]['mission'] = $mission;
                        $data[0][$jour][$key]['date_cherche'] = $date_cherche;
                        $data[0][$jour][$key]['date'] = $date_debut_semaine;
                        $data[0][$jour][$key]['type'] = 'timesheet';
                    }
                }
                else
                {   
                    $tmp_conge = $this->CongeManager->getabsencebydate($date_cherche,$id_personnel);
                    if ($tmp_conge)
                    {   //$data[0][$jour][0]['type'] =$tmp_conge;
                        foreach ($tmp_conge as $key => $value)
                        {
                         $data[0][$jour][0]['type'] = $value->type;
                         $data[0][$jour][0]['type_absence'] = $value->type_absence;
                        }
                    }else
                    {
                        $data[0][$jour]= null;
                    }  
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
                    'pourcentage' => $this->post('pourcentage'),
                    'duree' => $this->post('duree'),
                    'id_section' => $this->post('id_section'),
                    'id_sous_section' => $this->post('id_sous_section'),
                    'id_mission' => $this->post('id_mission'),
                    'id_entete' => $this->post('id_entete'),
                    'id_client' => $this->post('id_client')
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
                    $existance_section = $this->Timesheet_detailManager->prev_tache_test_existance_section($this->post('id_mission'),$this->post('id_section'));
                    if ($existance_section) {
                        $this->response([
                            'status' => TRUE,
                            'response' => $dataId,
                            'prev' => TRUE,
                            'message' => 'Data insert success'
                                ], REST_Controller::HTTP_OK);
                    }
                    else
                    {    
                        $data_prev_tache= array(
                            'grand_tache' => $this->post('id_section'),
                            'id_mission' => $this->post('id_mission'),
                            'nbre_heure' => 0
                        );                    
                        $prev_tach = $this->Timesheet_detailManager->add_prev_tache($data_prev_tache);
                        $this->response([
                            'status' => TRUE,
                            'response' => $dataId,
                            'prev' => FALSE,
                            'message' => 'Data insert success'
                                ], REST_Controller::HTTP_OK);
                    }
                    
                } else {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }         
            } else {
                $data = array(
                    'pourcentage' => $this->post('pourcentage'),
                    'duree' => $this->post('duree'),
                    'id_section' => $this->post('id_section'),
                    'id_sous_section' => $this->post('id_sous_section'),
                    'id_mission' => $this->post('id_mission'),
                    'id_entete' => $this->post('id_entete'),
                    'id_client' => $this->post('id_client')
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
