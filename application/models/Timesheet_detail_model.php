<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Timesheet_detail_model extends CI_Model {
    protected $table = 'detail_feuille_temps';

    public function add($timesheet_detail) {
        $this->db->set($this->_set($timesheet_detail))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $timesheet_detail) {
        $this->db->set($this->_set($timesheet_detail))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($timesheet_detail) {
        return array(
            
            'libelle' => $timesheet_detail['libelle'],
            'pourcentage' => $timesheet_detail['pourcentage'],
            'duree' => $timesheet_detail['duree'],
            'sous_tache' => $timesheet_detail['sous_tache'],
            'id_mission' => $timesheet_detail['id_mission'],
            'id_entete' => $timesheet_detail['id_entete']
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
    public function findAll_by_entete($id_entete)
    {
        $requete="select detail.* from detail_feuille_temps as detail
                    where detail.id_entete= '".$id_entete."' "; 
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
    
    public function getresumesemaine($date_cherche,$id_personnel)
    {
        $requete="select detail.* 
                    from detail_feuille_temps as detail
                    inner join entete_feuille_temps as entete on entete.id=detail.id_entete
                    where entete.date_feuille='".$date_cherche."'"; 
		return $this->db->query($requete)->result();                 
    }	
    
}
