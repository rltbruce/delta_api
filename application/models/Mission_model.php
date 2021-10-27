<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mission_model extends CI_Model
{
    protected $table = 'mission';


    public function add($client)
    {
        $this->db->set($this->_set($client))
                 ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $client)
    {
        $this->db->set($this->_set($client))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($client)
    {
        return array(
            'code'                  =>      $client['code'],
            'libelle'               =>      $client['libelle'],
            'associe_resp'               =>      $client['associe_resp'],
            'senior_manager'               =>      $client['senior_manager'],
            'chef_mission'               =>      $client['chef_mission'],
            'produit'               =>      $client['produit'],
            'id_contrat'               =>      $client['id_contrat'],
           
          //  'fax'               =>      $client['fax']           
        );
    }


    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }

    public function findAll()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('code', 'asc')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

    public function findAllByClient($id_contrat)
    {
              
        
        $requete="SELECT m.id,m.code as code,m.libelle,m.associe_resp,m.senior_manager,m.chef_mission,m.produit  FROM "
          ."mission as m,contrat as c "
          ." where c.id=m.id_contrat "
          ." and c.id=".$id_contrat;
          
         
          $query= $this->db->query($requete);
          if( $query)
          {
          return $query->result();
          }else
          {
              return null;
          }





    }
    
    public function getmissionbyclient($id_client)
    {
        $requete="select mis.* FROM mission as mis"
          ." inner join contrat as cont on cont.id=mis.id_contrat"
          ." inner join client as cli on cli.id=cont.id_client"
          ." where cli.id=".$id_client;          
         
          $query= $this->db->query($requete);
          if( $query)
          {
          return $query->result();
          }else
          {
              return null;
          }
    }

}
