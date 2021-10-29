<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prevsection_model extends CI_Model
{
    protected $table = 'prev_tache';


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
            'grand_tache'                  =>      $client['grand_tache'],
            'nbre_heure'               =>      $client['nbre_heure'],
            'id_mission'               =>      $client['id_mission'],
          

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
                        ->order_by('id', 'asc')
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

    public function findAllByMission($id_mission)
    {
              
        
        $requete="SELECT m.id,m.grand_tache,m.nbre_heure,m.id_mission  FROM "
          ."prev_tache as m "
          ." where m.id_mission=".$id_mission;
          
         
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
