<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Echeance_paiement extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('echeancepaiement_model', 'DeboursManager');
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
        if ($id) {
			$debours = $this->DeboursManager->findById($id);
			//$type_indicateur = $this->Type_indicateurManager->findById($indicateur->type_indicateur_id);
			$data['id'] = $debours->id;
			$data['libelle'] = $debours->libelle;
			$data['pourcentage'] = $debours->pourcentage;
            $data['date_facture'] = $debours->date_facture;
            $data['id_mission'] = $debours->id_mission;
            $data['date_em_facture'] = $debours->date_em_facture;
            $data['num_facture'] = $debours->num_facture;
            $data['montant_facture'] = $debours->montant_facture;
            $data['date_saisie'] = $debours->date_saisie;

		
		} else{
               
                $data = array();

        }
		//$typeindicateur_id=$this->get('typeindicateur_id');
       // $code=$this->get('code');
       
        $data = array();

       // $data = $this->DeboursManager->findAll();
       $idcl=$this->get('idcl');
      // $idparam=$this->get('parametre');
        if($idcl)
        {
            
            $menu = $this->DeboursManager->findAllByMission($idcl);
           // $menu = $this->DeboursManager->findAll();
                if ($menu) {
                    foreach ($menu as $key => $value) {
                       
                        $data[$key]['id'] = $value->id;
                        $data[$key]['libelle'] = $value->libelle;
                        $data[$key]['pourcentage'] = $value->pourcentage;
                        $data[$key]['nbre_jours'] = $value->nbre_jours;
                        $data[$key]['date_facture'] = $value->date_facture;
                        $data[$key]['id_mission'] = $value->id_mission;
                        $data[$key]['date_em_facture'] = $value->date_em_facture;
                        $data[$key]['num_facture'] = $value->num_facture;
                        $data[$key]['montant_facture'] = $value->montant_facture;
                        $data[$key]['date_saisie'] = $value->date_saisie;
                        $data[$key]['edit'] =false;
                        

                    }
                }        


        }else{
            $data = array();
        }

     
        
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
        $datecontrat = $this->convertDateAngular($this->post('date_facture'));
        $dateemfact = $this->convertDateAngular($this->post('date_em_facture'));
        $datesaisie = $this->convertDateAngular($this->post('date_saisie'));
        if ($supprimer == 0) {
            if ($id == 0) {
                $data = array(
                    'libelle' => $this->post('libelle'),
                    'id_mission' => $this->post('id_mission'),
                    'date_facture' => $datecontrat,
                    'date_em_facture' => $datesaisie,
                    'date_saisie' => $dateemfact,
                    'pourcentage' => $this->post('pourcentage'),
                    'nbre_jours' => intval($this->post('nbre_jours')),
                    'montant_facture' => intval($this->post('montant_facture')),
                    'num_facture' => $this->post('num_facture')

                  
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
                    'libelle' => $this->post('libelle'),
                    'id_mission' => $this->post('id_mission'),
                    'date_facture' => $datecontrat,
                    'date_em_facture' => $datesaisie,
                    'date_saisie' => $dateemfact,
                    'pourcentage' => $this->post('pourcentage'),
                    'nbre_jours' => intval($this->post('nbre_jours')),
                    'montant_facture' => intval($this->post('montant_facture')),
                    'num_facture' => $this->post('num_facture')
                  

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
