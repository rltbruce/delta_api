<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prevhonoraire_model extends CI_Model
{
    protected $table = 'prev_honoraire';


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
            'nbre_jour'                  =>      $client['nbre_jour'],
            'nbre_heure'               =>      $client['nbre_heure'],
            'grade'               =>      $client['grade'],
            'nbre_homme'               =>      $client['nbre_homme'],
            'pu'               =>      $client['pu'],
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
              
        
        $requete="SELECT m.id,m.nbre_jour,m.nbre_heure,m.nbre_homme,m.grade,m.pu,m.grade,m.id_mission  FROM "
          ."prev_honoraire as m "
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
