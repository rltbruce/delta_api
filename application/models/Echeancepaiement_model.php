<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Echeancepaiement_model extends CI_Model
{
    protected $table = 'echeance_paiement';


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
            'libelle'                  =>      $client['libelle'],
            'pourcentage'               =>      $client['pourcentage'],
            'date_facture'               =>      $client['date_facture'],
            'id_mission'               =>      $client['id_mission'],
            'date_em_facture'               =>      $client['date_em_facture'],   
            'num_facture'               =>      $client['num_facture'],   
            'montant_facture'               =>      $client['montant_facture'], 
            'date_saisie'               =>      $client['date_saisie'],    
            'nbre_jours'               =>      $client['nbre_jours'],                                                                      
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

    public function findAllByClient($id_client,$param)
    {
     
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id', 'desc')
                        ->where("id_mission", $id_client)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllByMission($id_mission)
    {
              
        
        $requete="SELECT m.id,m.libelle,m.pourcentage,m.date_facture,m.id_mission,m.date_em_facture,m.num_facture,"
        ."m.montant_facture,m.date_saisie,nbre_jours  FROM "
          ."echeance_paiement as m "
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
