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
            
            'pourcentage' => $timesheet_detail['pourcentage'],
            'duree' => $timesheet_detail['duree'],
            'id_sous_section' => $timesheet_detail['id_sous_section'],
            'id_section' => $timesheet_detail['id_section'],
            'id_mission' => $timesheet_detail['id_mission'],
            'id_entete' => $timesheet_detail['id_entete'],
            'id_client' => $timesheet_detail['id_client']
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
    public function findAll_by_entete($id_entete,$id_personnel)
    {
        $requete="select detail.*, "
                    ."(select sum(det.duree) from detail_feuille_temps as det "
                    ."inner join entete_feuille_temps as entete on entete.id=det.id_entete"
                    ." where det.id<=detail.id  and det.id_sous_section= det.id_sous_section"
                    ." and entete.id_pers='".$id_personnel."'"
                    ." and det.id_section= detail.id_section"
                    ." and det.id_mission= detail.id_mission) as duree_cumule"
                    ." from detail_feuille_temps as detail "
                    ."inner join sous_section as sect on sect.id = detail.id_sous_section 
                    where detail.id_entete='".$id_entete."' order by sect.libelle asc"; 
                    $query = $this->db->query($requete);
                    return $query->result();                 
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
                    where entete.date_feuille='".$date_cherche."' and entete.id_pers='".$id_personnel."'"; 
		return $this->db->query($requete)->result();                 
    }
    
    public function getsectionbymission($id_mission)
    {
        $requete="select sect.* 
                    from prev_tache as tache
                    inner join section as sect on sect.id=tache.grand_tache
                    where tache.id_mission='".$id_mission."'"; 
		return $this->db->query($requete)->result();                 
    }
    
    public function getsous_sectionbysection($id_section)
    {
        $requete="select soussect.* 
                    from sous_section as soussect
                    where soussect.id_section='".$id_section."'"; 
		return $this->db->query($requete)->result();                 
    }
    public function getdureeanterieur($id_mission,$id_section,$id_sous_section)
    {
        $requete="select sum(detail_feuil.duree) as som 
                    from detail_feuille_temps as detail_feuil
                    where detail_feuil.id_section='".$id_section."'"
                    ." and detail_feuil.id_sous_section='".$id_sous_section."'" 
                    ." and detail_feuil.id_mission='".$id_mission."'";
		return $this->db->query($requete)->result();                 
    }
    public function prev_tache_test_existance_section($id_mission,$id_section)
    {
        $requete="select prev_tache.* from prev_tache
                    where prev_tache.grand_tache='".$id_section."'"
                    ." and prev_tache.id_mission='".$id_mission."'";
		return $this->db->query($requete)->result();                 
    }

    public function add_prev_tache($prev_tache) {
        $this->db->set($this->_set_prev_tache($prev_tache))
                            ->insert('prev_tache');
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_prev_tache($prev_tache) {
        return array(
            
            'grand_tache' => $prev_tache['grand_tache'],
            'id_mission' => $prev_tache['id_mission'],
            'nbre_heure' => $prev_tache['nbre_heure']
        );
    }	
    
}
