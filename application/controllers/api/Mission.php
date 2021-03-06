<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Mission extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mission_model', 'DeboursManager');
        $this->load->model('mission_model', 'MissionManager');
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

        $idparam=$this->get('parametre');
        $menu=$this->get('menu');        
        $id_client=$this->get('id_client');

       
        if($idcl )
        {
            
            $menu = $this->DeboursManager->findAllByClient($idcl,$idparam);
                if ($menu) {
                    foreach ($menu as $key => $value) {
                       
                        $data[$key]['id'] = $value->id;
                        $data[$key]['code'] = $value->code;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['associe_resp'] = $value->associe_resp;
                        $data[$key]['senior_manager'] = $value->senior_manager;
                        $data[$key]['chef_mission'] = $value->chef_mission;
                        $data[$key]['nom_client'] = $value->nom_client;

                    }
                }        


        }
       

		if ($id) {
			$debours = $this->DeboursManager->findById($id);
			//$type_indicateur = $this->Type_indicateurManager->findById($indicateur->type_indicateur_id);
            $data[$key]['id'] = $value->id;
            $data[$key]['code'] = $value->code;
            $data[$key]['libelle'] = $value->libelle;
            $data[$key]['associe_resp'] = $value->associe_resp;
            $data[$key]['senior_manager'] = $value->senior_manager;
            $data[$key]['chef_mission'] = $value->chef_mission;
           
		
        } 
        
        if(!$id & !$idcl)
        {
          //  $data = $this->DeboursManager->findAll();
            $data=array();
        }
        if($menu=="getallmission" )
        {
            
            $tmp = $this->DeboursManager->findAll();
                if ($tmp) {
                    $data=$tmp;
                } 

        }
        
        if($menu=="getmissionbyclient" )
        {
            
            $tmp = $this->MissionManager->getmissionbyclient($id_client);
            if ($tmp)
            {                
                foreach ($tmp as $key => $value) {
                       
                    $data[$key]['id'] = $value->id;
                    $data[$key]['code'] = $value->code;
                    $data[$key]['libelle'] = $value->libelle;
                    $data[$key]['associe_resp'] = $value->associe_resp;
                    $data[$key]['senior_manager'] = $value->senior_manager;
                    $chef_mission = $this->PersonnelManager->findById($value->chef_mission);
                    $data[$key]['chef_mission'] = $chef_mission;

                }
            } 
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
        $datedeb = $this->convertDateAngular($this->post('date_deb_prevue'));
        $datefin = $this->convertDateAngular($this->post('date_fin_prevue'));
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'code' => $this->post('code'),
                    'libelle' => $this->post('libelle'),
                    'associe_resp' => $this->post('associe_resp'),
                    'associate_director' => $this->post('associate_director'),
                    'director' => $this->post('director'),
                    'senior_manager' => $this->post('senior_manager'),
                    'chef_mission' => $this->post('chef_mission'),
                    'produit' => $this->post('produit'),
                    'id_contrat' => $this->post('id_contrat'),
                    'date_deb_prevue' => $datedeb,
                    'date_fin_prevue' => $datefin
                
                  
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
                    'code' => $this->post('code'),
                    'libelle' => $this->post('libelle'),
                    'associe_resp' => $this->post('associe_resp'),
                    'associate_director' => $this->post('associate_director'),
                    'director' => $this->post('director'),
                    'senior_manager' => $this->post('senior_manager'),
                    'chef_mission' => $this->post('chef_mission'),
                    'produit' => $this->post('produit'),
                    'id_contrat' => $this->post('id_contrat'),
                    'date_deb_prevue' => $datedeb,
                    'date_fin_prevue' => $datefin
                
                
                
                   
                  

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
