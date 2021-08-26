<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_model extends CI_Model
{
    protected $table = 'contrat';


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
            'num_contrat'                  =>      $client['num_contrat'],
            'date_contrat'               =>      $client['date_contrat'],
            'id_client'               =>      $client['id_client'],
            'montant_ht'               =>      $client['montant_ht'],
            'monnaie'               =>      $client['monnaie'],           
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
                        ->order_by('num_contrat', 'asc')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findAllByClient($id_client)
    {
     
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id', 'desc')
                        ->where("id_client", $id_client)
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
