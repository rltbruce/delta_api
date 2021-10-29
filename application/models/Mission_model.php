<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mission_model extends CI_Model
{
    protected $table = 'mission';


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
            'code'                  =>      $client['code'],
            'libelle'               =>      $client['libelle'],
            'associe_resp'               =>      $client['associe_resp'],
            'associate_director'               =>      $client['associate_director'],
            'director'               =>      $client['director'],
            'date_deb_prevue'               =>      $client['date_deb_prevue'],
            'date_fin_prevue'               =>      $client['date_fin_prevue'],
            'senior_manager'               =>      $client['senior_manager'],
            'chef_mission'               =>      $client['chef_mission'],
            'produit'               =>      $client['produit'],
            'id_contrat'               =>      $client['id_contrat'],
           
          //  'fax'               =>      $client['fax']           
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
                        ->order_by('code', 'asc')
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

    public function findAllByClient($id_contrat,$param)
    {
              
        if($param='contrat')
        {
        $requete="SELECT m.id,m.code as code,m.libelle,m.associe_resp,m.senior_manager,m.chef_mission,m.produit,cl.nom_client "
        .",m.associate_director,m.director,m.date_deb_prevue,m.date_fin_prevue FROM "
        ."mission as m,contrat as c,client as cl "
          ." where c.id=m.id_contrat and cl.id=c.id_client "
          ." and c.id=".$id_contrat;
        } 
        if($param='client')
        {
        $requete="SELECT m.id,m.code as code,m.libelle,m.associe_resp,m.senior_manager,m.chef_mission,m.produit,cl.nom_client  "
        .",m.associate_director,m.director,m.date_deb_prevue,m.date_fin_prevue FROM "
          ."mission as m,contrat as c,client as cl "
          ." where c.id=m.id_contrat and cl.id=c.id_client "
          ." and cl.id=".$id_contrat;
        } 
         
          $query= $this->db->query($requete);
          if( $query)
          {
          return $query->result();
          }else
          {
              return array();
          }





    }

}
