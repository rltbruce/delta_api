<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Document_model extends CI_Model
{
    protected $table = 'documents';


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
            'repertoire'      =>  $document['repertoire'],
            'id_sous_tache'      =>  $document['id_sous_tache'],
            'type_link'      =>  $document['type_link'],
            'id_link_mere'      =>  $document['id_link_mere'],
            'type_document'      =>  $document['type_document']
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

    public function getallsous_tache()
    {
        $requete="select sous.* from sous_tache as sous"; 
		return $this->db->query($requete)->result();                 
    }
    public function findAll()
    {
        $requete="select doc.* from documents as doc"; 
		return $this->db->query($requete)->result();                 
    }

    public function getmaxiddocument()
    {
        $requete="select max(doc.id) as id from documents as doc"; 
		return $this->db->query($requete)->result();                 
    }
    public function getdocumentBymission($id_mission)
    {
        $requete="select doc.* from documents as doc
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
    public function findsoustacheById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get('sous_tache');
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
