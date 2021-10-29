<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Contrat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contrat_model', 'DeboursManager');
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

       // $data = $this->DeboursManager->findAll();
       $idcl=$this->get('idcl');
       $idparam=$this->get('parametre');
        if($idcl)
        {
            
            $menu = $this->DeboursManager->findAllByClient($idcl,$idparam);
                if ($menu) {
                    foreach ($menu as $key => $value) {
                       
                        $data[$key]['id'] = $value->id;
                        $data[$key]['num_contrat'] = $value->num_contrat;
                        $data[$key]['date_contrat'] = $value->date_contrat;
                        $data[$key]['id_client'] = $value->id_client;
                        $data[$key]['montant_ht'] = $value->montant_ht;
                        $data[$key]['monnaie'] = $value->monnaie;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['date_debut'] = $value->date_debut;
                        $data[$key]['date_fin'] = $value->date_fin;
                        $mission = $this->MissionManager->findAllByClient($value->id,$idparam);
                        if($mission)
                        {
                        $data[$key]['mission']=$mission;
                        }else
                        {
                            $data[$key]['mission']=array();
                        }

                    }
                }        


        }else{
            $data = array();
        }

        if ($id) {
			$debours = $this->DeboursManager->findById($id);
			//$type_indicateur = $this->Type_indicateurManager->findById($indicateur->type_indicateur_id);
			$data['id'] = $debours->id;
			$data['num_contrat'] = $debours->num_contrat;
			$data['date_contrat'] = $debours->date_contrat;
            $data['id_client'] = $debours->id_client;
            $data['montant_ht'] = $debours->montant_ht;
            $data['monnaie'] = $debours->monnaie;
		
		} /*else{
               
                $data = array();

        }*/
        
        if(!$id & !$idcl)
        {
            $data = $this->DeboursManager->findAll();
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
        $datecontrat = $this->convertDateAngular($this->post('date_contrat'));
        $datedebut = $this->convertDateAngular($this->post('date_debut'));
        $datefin = $this->convertDateAngular($this->post('date_fin'));
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'num_contrat' => $this->post('num_contrat'),
                    'date_contrat' => $datecontrat,
                    'id_client' => $this->post('id_client'),
                    'montant_ht' => intval($this->post('montant_ht')),
                    'monnaie' => $this->post('monnaie'),
                    'libelle' => $this->post('libelle'),
                    'date_debut' => $datedebut,
                    'date_fin' => $datefin,
                  
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
                    'num_contrat' => $this->post('num_contrat'),
                    'date_contrat' => $datecontrat,
                    'id_client' => $this->post('id_client'),
                    'montant_ht' => intval($this->post('montant_ht')),
                    'monnaie' => $this->post('monnaie'),
                    'libelle' => $this->post('libelle'),
                    'date_debut' => $datedebut,
                    'date_fin' => $datefin,
                  

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
