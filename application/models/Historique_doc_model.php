<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Historique_doc_model extends CI_Model
{
    protected $table = 'historique_doc';


    public function add($document)
    {
        $this->db->set($this->_set($document))
                            ->set('date_histoire', 'NOW()', false)
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

            //'type_histoire'         =>  $document['type_histoire'],
            'observation'     =>  $document['observation'],
            'id_utilisateur'  =>  $document['id_utilisateur'],
            'id_document'      =>  $document['id_document']
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
        $requete="select doc.* from historique_doc as doc"; 
		return $this->db->query($requete)->result();                 
    }

    public function gethistoriqueBydocument($id_document)
    {
        $requete="select doc.* from historique_doc as doc
                    where doc.id_document='".$id_document."'"; 
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
