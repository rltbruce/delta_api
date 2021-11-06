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
    
    public function getfeuilletempsbydate_debu_fin($date_debut,$date_fin,$id_personnel)
    {
        $requete="select entete.* from entete_feuille_temps as entete
                    where entete.id_pers='".$id_personnel."' and entete.date_feuille BETWEEN '".$date_debut."' and '".$date_fin."' "; 
		return $this->db->query($requete)->result();                 
    }
    
    public function gettimesheet_entetebydate_personnel($date_debut,$date_fin,$id_personnel)
    {
        $sql=" 

        select detail.*

            from
        (select 
                entete.id as id, 
                entete.date_feuille as date_feuille,
                null as date_debut,
                null as date_fin, 
                'timesheet' as type 

            from entete_feuille_temps as entete            
    
                where entete.id_pers = ".$id_personnel."
                    and date_feuille between '".$date_debut."' and '".$date_fin."' 
        UNION 
        select 
                cong.id as id, 
                cong.date_debut as date_feuille,
                cong.date_debut as date_debut,
                cong.date_fin as date_fin, 
                'conge' as type 

            from conge as cong            
    
                where cong.date_retour between'".$date_debut."' and'".$date_fin."'
                    or  cong.date_debut between'".$date_debut."' and'".$date_fin."' 
                    and cong.id_personnel_conge = ".$id_personnel." 
                    and cong.validation != 2 
                    and cong.date_retour is not null      
        UNION  
        select 
                cong.id as id, 
                cong.date_debut as date_feuille,
                cong.date_debut as date_debut,
                cong.date_fin as date_fin, 
                'conge' as type 

            from conge as cong            
    
                where cong.date_fin between'".$date_debut."' and'".$date_fin."'
                    or cong.date_debut between'".$date_debut."' and'".$date_fin."'  
                    and cong.id_personnel_conge = ".$id_personnel." 
                    and cong.validation != 2 
                    and cong.date_retour is null      
        UNION

        select 
                abse.id as id, 
                abse.date_debut as date_feuille,
                abse.date_debut as date_debut,
                abse.date_fin as date_fin, 
                'absence' as type 

            from absence as abse            
    
                where abse.date_fin between'".$date_debut."' and'".$date_fin."'
                    or abse.date_debut between'".$date_debut."' and'".$date_fin."'
                    and abse.validation != 2 
                    and abse.id_personnel_absent = ".$id_personnel." 
    
             ) detail order by date_feuille
         ";
        return $this->db->query($sql)->result();                  
    }	
    
}
