<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Detaildebours extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('detaildebours_model', 'DeboursManager');
        $this->load->model('personnel_model', 'PersonnelManager');
        $this->load->model('region_model', 'RegionManager');
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
            
            $menu = $this->DeboursManager->findAllByDemande($idcl);
                if ($menu) {
                    foreach ($menu as $key => $value) {
                        $pers = $this->PersonnelManager->findById($value->id_pers);
                        $reg = $this->RegionManager->findById($value->id_region);
                        $data[$key]['id'] = $value->id;
                        $data[$key]['id_debours'] = $value->id_debours;
                        $data[$key]['libdebours'] = $value->libdebours;
                        $data[$key]['id_pers'] = $value->id_pers;
                        $data[$key]['id_demande'] = $value->id_demande;
                        $data[$key]['nbre_jours'] = $value->nbre_jours;
                        $data[$key]['nbre_heure'] = $value->nbre_heure;
                        $data[$key]['pu'] = $value->pu;
                        $data[$key]['date_debut'] = $value->date_debut;
                        $data[$key]['date_fin'] = $value->date_fin;
                        $data[$key]['id_region'] = $value->id_region;
                        $data[$key]['localite'] = $value->localite;
                        $data[$key]['montant'] = $value->montant;
                        $data[$key]['id_grade'] = $value->id_grade;
                        $data[$key]['montant_retourne'] = $value->montant_retourne;
                        $data[$key]['explication'] = $value->explication;
                        $data[$key]['nompersonnel'] = $pers->nom;
                        $data[$key]['nomregion'] = $reg->libelle;
                     


                        //Mission

                        //fin mission

                    }
                }        


        }
       

		if ($id) {
			$debours = $this->DeboursManager->findById($id);
			//$type_indicateur = $this->Type_indicateurManager->findById($indicateur->type_indicateur_id);
            $data[$key]['id'] = $value->id;
            $data[$key]['id_debours'] = $value->id_debours;
            $data[$key]['id_pers'] = $value->id_pers;
            $data[$key]['id_demande'] = $value->id_demande;
            $data[$key]['nbre_jours'] = $value->nbre_jours;
            $data[$key]['nbre_heure'] = $value->nbre_heure;
            $data[$key]['pu'] = $value->pu;
            $data[$key]['date_debut'] = $value->date_debut;
            $data[$key]['date_fin'] = $value->date_fin;
            $data[$key]['id_region'] = $value->id_region;
            $data[$key]['localite'] = $value->localite;
            $data[$key]['montant'] = $value->montant;
            $data[$key]['id_grade'] = $value->id_grade;
            $data[$key]['montant_retourne'] = $value->montant_retourne;
            $data[$key]['explication'] = $value->explication;
         
            
		
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
                    'id_debours' => $this->post('id_debours'),
                    'id_pers' => $this->post('id_pers'),
                    'id_demande' => $this->post('id_demande'),
                    'nbre_jours' => $this->post('nbre_jours'),
                    'nbre_heure' => $this->post('nbre_heure'),
                    'pu' => $this->post('pu'),
                    'date_debut' => $this->post('date_debut'),
                    'date_fin' => $this->post('date_fin'),
                    'id_region' => $this->post('id_region'),
                    'localite' => $this->post('localite'),
                    'montant' => $this->post('montant'),
                    'id_grade' => $this->post('id_grade'),
                    'montant_retourne' => $this->post('montant_retourne'),
                    'explication' => $this->post('explication')
                 
                  
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
                    'id_debours' => $this->post('id_debours'),
                    'id_pers' => $this->post('id_pers'),
                    'id_demande' => $this->post('id_demande'),
                    'nbre_jours' => $this->post('nbre_jours'),
                    'nbre_heure' => $this->post('nbre_heure'),
                    'pu' => $this->post('pu'),
                    'date_debut' => $this->post('date_debut'),
                    'date_fin' => $this->post('date_fin'),
                    'id_region' => $this->post('id_region'),
                    'localite' => $this->post('localite'),
                    'montant' => $this->post('montant'),
                    'id_grade' => $this->post('id_grade'),
                    'montant_retourne' => $this->post('montant_retourne'),
                    'explication' => $this->post('explication')
                
                   
                  

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
