<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demandedeb_model extends CI_Model
{
    protected $table = 'demande_debours';


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
            'num_demande'                  =>      $debours['num_demande'],
            'date_demande'               =>      $debours['date_demande'],
            'id_mission'               =>      $debours['id_mission'],
            'id_demandeur'               =>      $debours['id_demandeur'],
    /* 'nombre'               =>      $debours['nombre'],
            'visa'               =>      $debours['visa'],
            'date_visa'               =>      $debours['date_visa'],
            'id_user'               =>      $debours['id_user'],
            'date_paiement'               =>      $debours['date_paiement'],
            'personne_visa'               =>      $debours['personne_visa'],
            'date_autorisation'               =>      $debours['date_autorisation'],
            'personne_permis'               =>      $debours['personne_permis'],
            'annuler'               =>      $debours['annuler'],
            'personne_paiement'               =>      $debours['personne_paiement']   */                                                                                                           
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

    public function findAllByMission($id_mission,$param)
    {
              
        
        $requete="SELECT m.id,m.num_demande ,m.date_demande,m.id_mission,m.id_demandeur,m.nombre,mi.libelle,c.nom_client,p.nom  FROM "
          ."demande_debours as m,mission as mi,client as c,contrat as cnt,personnel as p "
          ."where mi.id_contrat=cnt.id and c.id=cnt.id_client and m.id_mission=mi.id and m.id_demandeur=p.id"
          ." and m.id_mission=".$id_mission;
          
         
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
