<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detaildebours_model extends CI_Model
{
    protected $table = 'det_demande_debours';


    public function add($debours)
    {
        $this->db->set($this->_set($debours))
                 ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $debours)
    {
        $this->db->set($this->_set($debours))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($debours)
    {
        return array(
            'id_debours'                  =>      $debours['id_debours'],
            'id_pers'               =>      $debours['id_pers'],
            'id_demande'               =>      $debours['id_demande'],
            'nbre_jours'               =>      $debours['nbre_jours'],
            'nbre_heure'               =>      $debours['nbre_heure'],
            'pu'               =>      $debours['pu'],
            'date_debut'               =>      $debours['date_debut'],
            'date_fin'               =>      $debours['date_fin'],
            'id_region'               =>      $debours['id_region'],
            'localite'               =>      $debours['localite'],
            'montant'               =>      $debours['montant'],
            'id_grade'               =>      $debours['id_grade'],
            'montant_retourne'               =>      $debours['montant_retourne'],
            'explication'               =>      $debours['explication']                                                                                                              
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
                        ->order_by('num_demande', 'asc')
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

    public function findAllByDemande($id_demande)
    {
              
        
        $requete="SELECT m.id,m.id_debours ,m.id_pers,m.id_demande,m.nbre_jours,m.nbre_heure,m.pu,m.date_debut,"
        ."m.date_fin,m.id_region,m.localite,m.montant,m.id_grade,m.montant_retourne,m.explication,d.libelle as libdebours  FROM "
          ."det_demande_debours as m,debours as d "
          ."where d.id=m.id_debours"
          ." and m.id_demande=".$id_demande;
          
         
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
