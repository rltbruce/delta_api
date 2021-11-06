<?php
//harizo
defined('BASEPATH') OR exit('No direct script access allowed');

// afaka fafana refa ts ilaina
require APPPATH . '/libraries/REST_Controller.php';

class Chat extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('chat_model', 'ChatManager');
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
        $id_pesonnel_autre = $this->get('id_pesonnel_autre'); 
        $id_pesonnel_moi = $this->get('id_pesonnel_moi');
        $id_user_autre = $this->get('id_user_autre'); 
        $id_user_moi = $this->get('id_user_moi');
        $id_user = $this->get('id_user');
        $data=array();

        if ($menu=='getmaxidchat')
        {
             $tmp = $this->ChatManager->getmaxidchat(); 
             if ($tmp)
             {
                 $data=$tmp;
             }
         }
         if ($menu=='getnumbermessagechatpasvu')
        {
             $tmp = $this->ChatManager->getnumbermessagechatpasvu($id_user); 
             if ($tmp)
             {
                 $data=$tmp;
             }
         }
         if ($menu=='getnumbermessagechatpasvubyuser')
        {
             $tmp = $this->ChatManager->getnumbermessagechatpasvubyuser($id_user_moi,$id_user_autre); 
             if ($tmp)
             {
                 $data=$tmp;
             }
         }
           if ($menu=='getmessageBydiscution')
           {
                $tmp = $this->ChatManager->getmessageBydiscution($id_pesonnel_autre,$id_pesonnel_moi); 
                if ($tmp)
                {
                    foreach ($tmp as $key => $value)
                   {
                        $data[$key]['id']        =$value->id;
                        $data[$key]['message']        =$value->message;
                        $data[$key]['date']=$value->date;
                        $data[$key]['id_send']=$value->id_send;
                        $data[$key]['id_receive']     =$value->id_receive;
                        $data[$key]['type_message']     =$value->type_message;
                        $data[$key]['repertoire']     =$value->repertoire;
                        $data[$key]['pas_supprimer']     =$value->pas_supprimer;
                   }
                }
            } 

           /* if ($id)
            {
                $data = array();
                $document = $this->ChatManager->findById($id);
                $data['id'] = $document->id;
                $data['code'] = $document->code;
                $data['nom'] = $document->nom;
            }*/
            

            if ($menu=='findall')
            {
               $tmp = $this->ChatManager->findAll(); 
               if ($tmp)
               {
                   //$data=$tmp;
                   foreach ($tmp as $key => $value)
                   {
                        $data[$key]['id']        =$value->id;
                        $data[$key]['message']        =$value->message;
                        $data[$key]['date']=$value->date;
                        $data[$key]['id_send']=$value->id_send;
                        $data[$key]['id_receive']     =$value->id_receive;
                        $data[$key]['repertoire']     =$value->repertoire;
                        $data[$key]['pas_supprimer']     =$value->pas_supprimer;
                   }

               }    
            }
          /*  if ($type_get=='findAll')
            {
                $data = $this->ChatManager->findAll();
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
                $data = array(                    
                    'message'         =>  $this->post('message'),
                    //'date'=>  $this->post('date'),
                    'id_send'=>  $this->post('id_send'),
                    'id_receive'      =>  $this->post('id_receive'),
                    'repertoire'      =>  $this->post('repertoire'),
                    'pas_supprimer'      =>  $this->post('pas_supprimer'),
                    'vue'      =>  0
                );
                
                if (!$data) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                            ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $dataId = $this->ChatManager->add($data);
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
                $data = array(                      
                    'message'         =>  $this->post('message'),
                    //'date'=>  $this->post('date'),
                    'id_send'=>  $this->post('id_send'),
                    'id_receive'      =>  $this->post('id_receive'),
                    'repertoire'      =>  $this->post('repertoire'),
                    'pas_supprimer'      =>  $this->post('pas_supprimer')
                );
                if (!$data || !$id) {
                    $this->response([
                        'status' => FALSE,
                        'response' => 0,
                        'message' => 'No request found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
                $update = $this->ChatManager->update($id, $data);
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
            $delete = $this->ChatManager->delete($id);         
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
