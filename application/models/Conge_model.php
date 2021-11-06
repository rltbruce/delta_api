<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conge_model extends CI_Model {
    protected $table = 'conge';

    public function add($conge) {
        $this->db->set($this->_set($conge))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $conge) {
        $this->db->set($this->_set($conge))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($conge) {
        return array(     
            'motif' => $conge['motif'],
            'date_debut' => $conge['date_debut'],
            'date_fin' => $conge['date_fin'],
            'id_personnel_conge' => $conge['id_personnel_conge'],
            'id_personnel_validation' => $conge['id_personnel_validation'],
            'validation' => $conge['validation'],
            'date_retour' => $conge['date_retour'],
            'reste_conge' => $conge['reste_conge']
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
    public function getcongebypersonnel($id_personnel_conge)
    {
        $requete="select abs.*"
                    ." from conge as abs "
                    ."where abs.id_personnel_conge='".$id_personnel_conge."' order by abs.date_debut desc"; 
                    $query = $this->db->query($requete);
                    return $query->result();                 
    }
    public function testcongebydate_debut($id_personnel_conge,$date_debut)
    {
        $requete="select abs.*"
                    ." from conge as abs "
                    ."where abs.id_personnel_conge='".$id_personnel_conge."' "
                    ."and '".$date_debut."' BETWEEN date_debut and date_fin order by abs.date_debut desc"; 
                    $query = $this->db->query($requete);
                    return $query->result();                 
    }
    public function getmaxidcongevalidebypersonnel($id_personnel_conge,$annee_now)
    {
        $requete="select abs.*"
                    ." from conge as abs "
                    ."where abs.id_personnel_conge='".$id_personnel_conge."' "
                    ."and id=(select max(con.id) from conge as con "
                    ."where con.id_personnel_conge='".$id_personnel_conge."' and validation=1 "
                    ."and TO_CHAR(con.date_debut :: DATE, 'yyyy')='".$annee_now."') order by abs.date_debut desc"; 
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
    public function getcongeencouretvalidebydate($date_feuille,$id_personnel)
    {        
        $sql=" 

                select detail.*

                    from
                (select 
                        cong.id as id, 
                        cong.date_debut as date_debut,
                        cong.date_fin as date_fin 

                    from conge as cong            
            
                        where cong.id_personnel_conge = ".$id_personnel." 
                            and cong.date_retour is null
                            and cong.validation!=2
                            and '".$date_feuille."' between date_debut and date_fin 
            
                        group by cong.id 
                UNION 
                select 
                        cong.id as id, 
                        cong.date_debut as date_debut,
                        cong.date_fin as date_fin 

                    from conge as cong            
            
                        where cong.id_personnel_conge = ".$id_personnel." 
                            and cong.date_retour is not null
                            and cong.validation!=2
                            and '".$date_feuille."' between date_debut and date_retour 
            
                        group by cong.id 
                UNION 

                select 
                        abse.id as id, 
                        abse.date_debut as date_debut,
                        abse.date_fin as date_fin 

                    from absence as abse            
            
                        where abse.id_personnel_absent = ".$id_personnel."
                            and abse.validation!=2 
                            and '".$date_feuille."' between abse.date_debut and abse.date_fin 
            
                        group by abse.id ) detail
                 ";
        return $this->db->query($sql)->result();              
    }
    
    
    public function getcongebyid($id) {
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
    public function getabsencebydate($date_cherche,$id_personnel) {
        $sql=" 

                select detail.*

                    from
                (select 
                        cong.id as id, 
                        cong.date_debut as date_debut,
                        cong.date_fin as date_fin,
                        'conge' as type,  
                        0 as type_absence 

                    from conge as cong            
            
                        where cong.id_personnel_conge = ".$id_personnel." 
                            and cong.date_retour is null
                            and cong.validation!=2
                            and '".$date_cherche."' between date_debut and date_fin 
            
                        group by cong.id 
                UNION 
                select 
                        cong.id as id, 
                        cong.date_debut as date_debut,
                        cong.date_fin as date_fin,
                        'conge' as type,  
                        0 as type_absence 

                    from conge as cong            
            
                        where cong.id_personnel_conge = ".$id_personnel." 
                            and cong.date_retour is not null
                            and cong.validation!=2
                            and '".$date_cherche."' between date_debut and date_retour 
            
                        group by cong.id 
                UNION 

                select 
                        abse.id as id, 
                        abse.date_debut as date_debut,
                        abse.date_fin as date_fin,
                        'absence' as type,  
                        abse.type as type_absence
                    from absence as abse            
            
                        where abse.id_personnel_absent = ".$id_personnel." 
                            and abse.validation!=2
                            and '".$date_cherche."' between abse.date_debut and abse.date_fin 
            
                        group by abse.id ) detail
                 ";
        return $this->db->query($sql)->result();                
    }
    
}
