<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Document extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('document_model', 'DocumentManager');
        $this->load->model('utilisateurs_model', 'UtilisateursManager');
        $this->load->model('mission_model', 'MissionManager');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    public function index_get() {
        $id = $this->get('id');
        $menu = $this->get('menu');
        $id_utilisateur = $this->get('id_utilisateur'); 
        $id_mission = $this->get('id_mission');
        $data=array();
        if ($menu=='getallsous_tache')
        {
             $tmp = $this->DocumentManager->getallsous_tache(); 
             if ($tmp)
             {
                 $data=$tmp;
             }
         }
        if ($menu=='getmaxiddocument')
        {
             $tmp = $this->DocumentManager->getmaxiddocument(); 
             if ($tmp)
             {
                 $data=$tmp;
             }
         }
           if ($menu=='getdocumentBymission')
           {
                $tmp = $this->DocumentManager->getdocumentBymission($id_mission); 
                if ($tmp)
                {
                    foreach ($tmp as $key => $value)
                   {
                        $utilisateur = $this->UtilisateursManager->findById($value->id_utilisateur);
                        $prepare_par = $this->UtilisateursManager->findById($value->prepare_par);
                        $sous_tache = $this->DocumentManager->findsoustacheById($value->id_sous_tache);
                        $link = $this->DocumentManager->findById($value->id_link_mere);
                        $data[$key]['id']        =$value->id;
                        $data[$key]['description']        =$value->description;
                        $data[$key]['prepare_par']    =$prepare_par;
                        $data[$key]['utilisateur'] =$utilisateur;
                        $data[$key]['date_preparation']=$value->date_preparation;
                        $data[$key]['date_insertion']=$value->date_insertion;
                        $data[$key]['sous_tache']     =$sous_tache;
                        $data[$key]['link']     =$link;
                        $data[$key]['repertoire']     =$value->repertoire;
                        $data[$key]['type_link']     = intVal($value->type_link);
                        $data[$key]['type_document']     =intVal($value->type_document);
                   }
                }
            } 

            if ($id)
            {
                $data = array();
                $document = $this->DocumentManager->findById($id);
                $data['id'] = $document->id;
                $data['code'] = $document->code;
                $data['nom'] = $document->nom;
            }
            

            if ($menu=='findall')
            {
               $tmp = $this->DocumentManager->findAll(); 
               if ($tmp)
               {
                   //$data=$tmp;
                   foreach ($tmp as $key => $value)
                   {
                        $utilisateur = $this->UtilisateursManager->findById($value->id_utilisateur);
                        $data[$key]['id']        =$value->id;
                        $data[$key]['description']        =$value->description;
                        $data[$key]['prepare_par']    =$utilisateur;
                        $data[$key]['utilisateur'] =$utilisateur;
                        $data[$key]['date_preparation']=$value->date_preparation;
                        $data[$key]['date_insertion']=$value->date_insertion;
                        $data[$key]['id_mission']     =$value->id_mission;
                        $data[$key]['repertoire']     =$value->repertoire;
                   }

               }    
            }
          /*  if ($type_get=='findAll')
            {
                $data = $this->DocumentManager->findAll();
            }*/
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
                $data=array();
                if (intVal($this->post('type_link'))==1)
                {
                    $data = array(                    
                        'description'         =>  $this->post('description'),
                        'prepare_par'     =>  $this->post('prepare_par'),
                        'id_utilisateur'  =>  $this->post('id_utilisateur'),
                        'date_preparation'=>  $this->post('date_preparation'),
                        'date_insertion'=>  $this->post('date_insertion'),
                        'id_mission'      =>  $this->post('id_mission'),
                        'repertoire'      =>  $this->post('repertoire'),
                        'id_sous_tache'      =>  $this->post('id_sous_tache'),
                        'type_link'      =>  $this->post('type_link'),
                        'id_link_mere'      =>  null,
                        'type_document'      =>  $this->post('type_document')
                    );
                }
                else
                {
                    $data = array(                    
                        'description'         =>  $this->post('description'),
                        'prepare_par'     =>  $this->post('prepare_par'),
                        'id_utilisateur'  =>  $this->post('id_utilisateur'),
                        'date_preparation'=>  $this->post('date_preparation'),
                        'date_insertion'=>  $this->post('date_insertion'),
                        'id_mission'      =>  $this->post('id_mission'),
                        'repertoire'      =>  $this->post('repertoire'),
                        'id_sous_tache'      =>  $this->post('id_sous_tache'),
                        'type_link'      =>  $this->post('type_link'),
                        'id_link_mere'      =>  $this->post('id_link_mere'),
                        'type_document'      =>  $this->post('type_document')
                    );
                }
                
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->DocumentManager->add($data);
                if (!is_null($dataId)) {
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
                $data=array();
                if (intVal($this->post('type_link'))==1)
                {
                    $data = array(                    
                        'description'         =>  $this->post('description'),
                        'prepare_par'     =>  $this->post('prepare_par'),
                        'id_utilisateur'  =>  $this->post('id_utilisateur'),
                        'date_preparation'=>  $this->post('date_preparation'),
                        'date_insertion'=>  $this->post('date_insertion'),
                        'id_mission'      =>  $this->post('id_mission'),
                        'repertoire'      =>  $this->post('repertoire'),
                        'id_sous_tache'      =>  $this->post('id_sous_tache'),
                        'type_link'      =>  $this->post('type_link'),
                        'id_link_mere'      =>  null,
                        'type_document'      =>  $this->post('type_document')
                    );
                }
                else
                {
                    $data = array(                    
                        'description'         =>  $this->post('description'),
                        'prepare_par'     =>  $this->post('prepare_par'),
                        'id_utilisateur'  =>  $this->post('id_utilisateur'),
                        'date_preparation'=>  $this->post('date_preparation'),
                        'date_insertion'=>  $this->post('date_insertion'),
                        'id_mission'      =>  $this->post('id_mission'),
                        'repertoire'      =>  $this->post('repertoire'),
                        'id_sous_tache'      =>  $this->post('id_sous_tache'),
                        'type_link'      =>  $this->post('type_link'),
                        'id_link_mere'      =>  $this->post('id_link_mere'),
                        'type_document'      =>  $this->post('type_document')
                    );
                }
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->DocumentManager->update($id, $data);
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
            $delete = $this->DocumentManager->delete($id);         
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
