<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Demandedebours extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('demandedeb_model', 'DeboursManager');
        $this->load->model('detaildebours_model', 'DetailManager');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
      //  $this->load->model('typeindicateur_model', 'Type_indicateurManager');
    }
    public function convertDateAngular($daty){
		if(isset($daty) && $daty != ""){
			if(strlen($daty) >33) {
				$daty=substr($daty,0,33);
			}
			$xx  = new DateTime($daty);
			if($xx->getTimezone()->getName() == "Z"){
				$xx->add(new DateInterval("P1D"));
				return $xx->format("Y-m-d");
			}else{
				return $xx->format("Y-m-d");
			}
		}else{
			return null;
		}
	}
    public function index_get() {
        $id = $this->get('id');
		//$typeindicateur_id=$this->get('typeindicateur_id');
		$code=$this->get('code');
        $data = array();
        
        $idcl=$this->get('idcl');
        $param='mission';
        if($idcl )
        {
            
            $menu = $this->DeboursManager->findAllByMission($idcl,$param);
                if ($menu) {
                    foreach ($menu as $key => $value) {
                       
                        $data[$key]['id'] = $value->id;
                        $data[$key]['num_demande'] = $value->num_demande;
                        $data[$key]['date_demande'] = $value->date_demande;
                        $data[$key]['id_mission'] = $value->id_mission;
                        $data[$key]['id_demandeur'] = $value->id_demandeur;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['nom_client'] = $value->nom_client;
                        $data[$key]['nombre'] = $value->nombre;
                        $data[$key]['nompersonnel'] = $value->nom;
                       /* $detail = $this->DetailManager->findAllByDemande($value->id);
                        if($detail)
                        {
                        $data[$key]['detail']=$detail;
                        }else
                        {
                            $data[$key]['detail']=array();
                        }*/


                        //Mission

                        //fin mission

                    }
                }        


        }
       

		if ($id) {
			$debours = $this->DeboursManager->findById($id);
			//$type_indicateur = $this->Type_indicateurManager->findById($indicateur->type_indicateur_id);
            $data[$key]['id'] = $value->id;
            $data[$key]['num_demande'] = $value->num_demande;
            $data[$key]['date_demande'] = $value->date_demande;
            $data[$key]['id_mission'] = $value->id_mission;
            $data[$key]['id_demandeur'] = $value->id_demandeur;
            $data[$key]['nombre'] = $value->nombre;
            
		
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
        $datecontrat = $this->convertDateAngular($this->post('date_demande'));
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'num_demande' => $this->post('num_demande'),
                    'date_demande' =>  $datecontrat,
                    'id_mission' => $this->post('id_mission'),
                    'id_demandeur' => $this->post('id_demandeur'),
                    'nombre' => $this->post('nombre'),
                    'visa' => $this->post('visa'),
                    'date_visa' => $this->post('date_visa'),
                    'id_user' => $this->post('id_user'),
                    'date_paiement' => $this->post('date_paiement'),
                    'personne_visa' => $this->post('personne_visa'),
                    'date_autorisation' => $this->post('date_autorisation'),
                    'personne_permis' => $this->post('personne_permis'),
                    'personne_paiement' => $this->post('personne_paiement'),
                    'annuler' => $this->post('annuler'),
                 
                  
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
                    'num_demande' => $this->post('num_demande'),
                    'date_demande' =>  $datecontrat,
                    'id_mission' => $this->post('id_mission'),
                    'id_demandeur' => $this->post('id_demandeur'),
                 /*   'nombre' => $this->post('nombre'),
                    'visa' => $this->post('visa'),
                    'date_visa' => $this->post('date_visa'),
                    'id_user' => $this->post('id_user'),
                    'date_paiement' => $this->post('date_paiement'),
                    'personne_visa' => $this->post('personne_visa'),
                    'date_autorisation' => $this->post('date_autorisation'),
                    'personne_permis' => $this->post('personne_permis'),
                    'personne_paiement' => $this->post('personne_paiement'),
                    'annuler' => $this->post('annuler'),*/
                
                   
                  

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
