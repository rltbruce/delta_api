<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_entete_model extends CI_Model {
    protected $table = 'entete_feuille_temps';

    public function add($timesheet_entete) {
        $this->db->set($this->_set($timesheet_entete))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $timesheet_entete) {
        $this->db->set($this->_set($timesheet_entete))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($timesheet_entete) {
        return array(
            'date_feuille'           =>      $timesheet_entete['date_feuille'],
            'id_pers'    =>      $timesheet_entete['id_pers']                       
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
    public function gettimesheet_entetebysemaine($date_debut_semaine,$date_fin_semaine,$id_personnel)
    {
        $requete="select entete.* from entete_feuille_temps as entete
                    where entete.id_pers='".$id_personnel."' and entete.date_feuille BETWEEN '".$date_debut_semaine."' and '".$date_fin_semaine."' "; 
		return $this->db->query($requete)->result();                 
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('date_feuille')
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
    
}
