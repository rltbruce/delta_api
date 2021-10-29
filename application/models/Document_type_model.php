<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_type_model extends CI_Model
{
    protected $table = 'document_type';


    public function add($document)
    {
        $this->db->set($this->_set($document))
                            ->set('date_insertion', 'NOW()', false)
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $document)
    {
        $this->db->set($this->_set($document))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($document)
    {
        return array(

            'description'         =>  $document['description'],
            'prepare_par'     =>  $document['prepare_par'],
            'id_utilisateur'  =>  $document['id_utilisateur'],
            'date_preparation'=>  $document['date_preparation'],
            'id_mission'      =>  $document['id_mission'],
            'repertoire'      =>  $document['repertoire']
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
        $requete="select doc.* from document_type as doc"; 
		return $this->db->query($requete)->result();                 
    }

    public function getmaxid_document_type()
    {
        $requete="select max(doc.id) as id from document_type as doc"; 
		return $this->db->query($requete)->result();                 
    }
    public function getdocumentBymission($id_mission)
    {
        $requete="select doc.* from document_type as doc
                    where doc.id_mission='".$id_mission."'"; 
		return $this->db->query($requete)->result();                 
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
    public function findByIdtab($id)
    {   $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }
        else
        {
            return null;
        }                 
    }
      

}
