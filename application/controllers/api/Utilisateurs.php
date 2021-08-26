<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Utilisateurs extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('utilisateurs_model', 'UserManager');

        $this->load->model('region_model', 'RegionManager');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
    }

    



    public function index_get() 
    {
        $header = $this->input->request_headers();
        //find by id
        $id = $this->get('id');
        $enabled = $this->get('enabled');
        $profil = $this->get('profil');
        $type_get = $this->get('type_get');

       /* if ($profil == 1) 
        {
            $data = array(
                'nom' => $this->post('nom'),
                'prenom' => $this->post('prenom'),
                'email' => $this->post('email'),
                'password' => sha1($this->post('password'))
      
            );

         

            $data = $this->UserManager->update_profil($id, $data);
           
        }*/

        if ($id) 
        {
            $user = $this->UserManager->findById($id);
            if ($user) 
            {
                $data['id'] = $user->id;
                $data['nom'] = $user->nom;
                $data['prenom'] = $user->prenom;
               // $data['sigle'] = $user->sigle;
                $data['token'] = $user->token;
                $data['email'] = $user->email;
                $data['enabled'] = $user->enabled;
             //   $data['id_region'] = $user->id_region;
      
                $data['roles'] = unserialize($user->roles);
            }
            else
            {
                $data = array();
            }
            
    
                
        }

        if ($enabled == 1) 
        {
            $nbr = 0 ;
            $user = $this->UserManager->findAllByEnabled(0);          
            $data = $user[0];   
        }
        
        if ($type_get == "findAll") 
        {
            if (isset($header['Authorization'])) 
            {
                $usr_token = $this->UserManager->findBytoken($header['Authorization']);
                if (count($usr_token) > 0 && $usr_token) 
                {
                    $usr = $this->UserManager->findAll();
                    if ($usr)
                    {
                        foreach ($usr as $key => $value) 
                        {
                            $data[$key]['id'] = $value->id;
                            $data[$key]['nom'] = $value->nom;
                            $data[$key]['prenom'] = $value->prenom;
                        //   $data[$key]['sigle'] = $value->sigle;
                            $data[$key]['token'] = $value->token;
                            $data[$key]['email'] = $value->email;
                            $data[$key]['enabled'] = $value->enabled;
                            $id_region = $value->id_region;
                    
                            $region = $this->RegionManager->findById($id_region);
                          //  $data[$key]['region'] = $region->nom;
                            $data[$key]['roles'] = unserialize($value->roles);


                        }
                    }
                    else
                    {
                        $data = array();
                    }
                }
                else 
                {
                    $data = array();
                }
            }
            else 
            {
                $data = array();
            }
            
        }
        
       

        //authentification
        $email = $this->get('email');
        $pwd = sha1($this->get('pwd'));
        $site = $this->get('site');

        if ($email && $pwd) {
            $value = $this->UserManager->sign_in($email, $pwd);
            if ($value)
            {
                $data = array();
                $data['id'] = $value[0]->id;
                $data['nom'] = $value[0]->nom;
                $data['prenom'] = $value[0]->prenom;
           //     $data['sigle'] = $value[0]->sigle;
                $data['token'] = $value[0]->token;
                $data['email'] = $value[0]->email;
                $data['enabled'] = $value[0]->enabled;
         
                $data['roles'] = unserialize($value[0]->roles);

                

            }else{
                $data = array();
            }
        }

        //find by email
        $fndmail = $this->get('courriel');
        if ($fndmail) {
            $data = $this->UserManager->findByMail($fndmail);
            if (!$data)
                $data = array();
        }

        //find by mdp
        $fndmdp = $this->get('mdp');
        if ($fndmdp) {
            $data = $this->UserManager->findByPassword($fndmdp);
            if (!$data)
                $data = array();
        }

        //mise a jour mdp
        $courriel = $this->get('courriel');
        $reinitpwd = sha1($this->get('reinitpwd'));
        $reinitpwdtoken = $this->get('reinitpwdtoken');

        if ($courriel && $reinitpwd && $reinitpwdtoken) {
            $data = $this->UserManager->reinitpwd($courriel, $reinitpwd, $reinitpwdtoken);
            if (!$data)
                $data = array();
        }

        //status success + data
        if (count($data)) {
            $this->response([
                'status' => TRUE,
                'response' => $data,
                'message' => 'Get data success',
            ], REST_Controller::HTTP_OK);
        } 
        else 
        {
            $this->response([
                'status' => FALSE,
                'response' => array(),
                'message' => 'No data were found'
            ], REST_Controller::HTTP_OK);
        }
    }

    public function index_post() {
        
     
        $id = $this->post('id') ;
        $gestion_utilisateur = $this->post('gestion_utilisateur') ;
        $supprimer = $this->post('supprimer') ;
        $profil = $this->post('profil') ;

        if ($gestion_utilisateur == 1) 
        {

            if ($supprimer == 0) 
            {
                $getrole = $this->post('roles');
                $data = array(
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),         
                 //   'sigle' => $this->post('sigle'),
                    'email' => $this->post('email'),                 
                    'enabled' => $this->post('enabled'),
                    'roles' => serialize($getrole)
                  
                );

                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }

                $update = $this->UserManager->update($id, $data);
                
                if(!is_null($update))
                {
                    $this->response([
                        'status' => TRUE,
                        'response' => $update,
                        'message' => 'Update data success'
                            ], REST_Controller::HTTP_OK);
                }
                else
                {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }
            }
            else
            {
                    //si suppression
            }
            
        }
        else
        {
            if ($profil == 1) 
            {
                $data = array(
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    //'cin' => $this->post('cin'),
                    'email' => $this->post('email'),
                    'password' => sha1($this->post('password'))
          
                );

                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }

                $dataId = $this->UserManager->update_profil($id, $data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found 2'
                            ], REST_Controller::HTTP_OK);
                }
            }
            else 
            {
                $getrole = array("USER");
                $data = array(
                    'nom' => $this->post('nom'),
                    'prenom' => $this->post('prenom'),
                    'sigle' => $this->post('sigle'),
                    'email' => $this->post('email'),
                  //  'id_region' => $this->post('id_region'),
                  //  'id_district' => $this->post('id_district'),
                    'password' => sha1($this->post('password')),
                    'enabled' => 0,
                    'token' => bin2hex(openssl_random_pseudo_bytes(32)),
                    'roles' => serialize($getrole)
                );

                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }

                $dataId = $this->UserManager->add($data);
                if (!is_null($dataId)) {
                    $this->response([
                        'status' => TRUE,
                        'response' => $dataId
                            ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_OK);
                }
            }
           
                
            

        }
        
    }

    public function index_put($id) {
        $data = array(
            'nom' => $this->put('nom'),
            'prenom' => $this->put('prenom'),
            'telephone' => $this->put('telephone'),
            'email' => $this->put('email'),
            'username' => $this->put('username'),
            'password' => $this->put('password'),
            'fonction' => $this->put('fonction'),
            'cin' => $this->put('cin'),
            'enabled' => $this->put('enabled'),
            'token' => bin2hex(openssl_random_pseudo_bytes(32))
        );

        if (!$data || !$id) {
            $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $update = $this->UserManager->update($id, $data);
        
        if(!is_null($update))
        {
            $this->response([
                'status' => TRUE,
                'response' => 1,
                'message' => 'Update data success'
                    ], REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response([
                'status' => FALSE,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_delete($id) {
        
        if (!$id) {
            $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }

        $delete = $this->UserManager->delete($id);
        
        if (!is_null($delete)) {
            $this->response([
                'status' => TRUE,
                'response' => 1,
                'message' => "Delete data success"
                    ], REST_Controller::HTTP_OK);
        } 
        else 
        {
            $this->response([
                'status' => FALSE,
                'response' => 0,
                'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */