<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Historique_doc extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('historique_doc_model', 'Historique_docManager');
        $this->load->model('utilisateurs_model', 'UtilisateursManager');
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
        $id_document = $this->get('id_document'); 
        $data=array();
           if ($menu=='gethistoriqueBydocument')
           {
                $tmp = $this->Historique_docManager->gethistoriqueBydocument($id_document); 
                if ($tmp)
                {
                    foreach ($tmp as $key => $value)
                   {
                        $utilisateur = $this->UtilisateursManager->findById($value->id_utilisateur);
                        $data[$key]['id']        =$value->id;
                       // $data[$key]['type_histoire']        =$value->type_histoire;
                        $data[$key]['utilisateur'] =$utilisateur;
                        $data[$key]['date_histoire']=$value->date_histoire;
                        $data[$key]['observation']     =$value->observation;
                        $data[$key]['id_document']     =$value->id_document;
                   }
                }
            } 

            if ($id)
            {
                $data = array();
                $historique_doc = $this->Historique_docManager->findById($id);
                $data['id'] = $historique_doc->id;
                $data['code'] = $historique_doc->code;
                $data['nom'] = $historique_doc->nom;
            }
            

            if ($menu=='findall')
            {
               $tmp = $this->Historique_docManager->findAll(); 
               if ($tmp)
               {
                   //$data=$tmp;
                   foreach ($tmp as $key => $value)
                   {
                        $utilisateur = $this->UtilisateursManager->findById($value->id_utilisateur);
                        $data[$key]['id']        =$value->id;
                        //$data[$key]['type_histoire']        =$value->type_histoire;
                        $data[$key]['utilisateur'] =$utilisateur;
                        $data[$key]['date_histoire']=$value->date_histoire;
                        $data[$key]['observation']     =$value->observation;
                        $data[$key]['id_document']     =$value->id_document;
                   }

               }    
            }
          /*  if ($type_get=='findAll')
            {
                $data = $this->Historique_docManager->findAll();
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
                $data = array(                    
                    //'type_histoire'         =>  $this->post('type_histoire'),
                    'id_utilisateur'  =>  $this->post('id_utilisateur'),
                    'date_histoire'=>  $this->post('date_histoire'),
                    'observation'      =>  $this->post('observation'),
                    'id_document'      =>  $this->post('id_document')
                );
                
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->Historique_docManager->add($data);
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
                $data = array(                    
                    //'type_histoire'         =>  $this->post('type_histoire'),
                    'id_utilisateur'  =>  $this->post('id_utilisateur'),
                    'date_histoire'=>  $this->post('date_histoire'),
                    'observation'      =>  $this->post('observation'),
                    'id_document'      =>  $this->post('id_document')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->Historique_docManager->update($id, $data);
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
            $delete = $this->Historique_docManager->delete($id);         
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
