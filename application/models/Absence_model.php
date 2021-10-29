<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absence_model extends CI_Model {
    protected $table = 'absence';

    public function add($absence) {
        $this->db->set($this->_set($absence))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $absence) {
        $this->db->set($this->_set($absence))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($absence) {
        return array(            
            'type' => $absence['type'],
            'motif' => $absence['motif'],
            'date_debut' => $absence['date_debut'],
            'date_fin' => $absence['date_fin'],
            'date_fin' => $absence['date_fin'],
            'duree' => $absence['duree'],
            'id_personnel_absent' => $absence['id_personnel_absent'],
            'id_personnel_validation' => $absence['id_personnel_validation'],
            'validation' => $absence['validation']
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function getabsencebypersonnel($id_personnel_absent)
    {
        $requete="select abs.*"
                    ." from absence as abs "
                    ."where abs.id_personnel_absent='".$id_personnel_absent."' order by abs.date_debut desc"; 
                    $query = $this->db->query($requete);
                    return $query->result();                 
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('date_debut')
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
    
    public function findpersonnelById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get('personnel');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    
    public function getabsencebyid($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id', (int) $id)
                        ->order_by('date_debut')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    
	
    
}
