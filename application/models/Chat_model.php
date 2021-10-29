<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model
{
    protected $table = 'chat';


    public function add($chat)
    {
        $this->db->set($this->_set($chat))
                ->set('date', 'NOW()', false)
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $chat)
    {
        $this->db->set($this->_set($chat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($chat)
    {   
        if ($chat['repertoire']!='' && $chat['repertoire']!='undefined')
        {            
            return array(

                'message'  =>  $chat['message'],
                //'date'     =>  $chat['date'],
                'id_send'  =>  $chat['id_send'],
                'id_receive'=>  $chat['id_receive'],
                'repertoire'=>  $chat['repertoire'],
                'pas_supprimer'=>  $chat['pas_supprimer']
            );
        }
        else
        {
            return array(

                'message'  =>  $chat['message'],
                //'date'     =>  $chat['date'],
                'id_send'  =>  $chat['id_send'],
                'id_receive'=>  $chat['id_receive'],
                'pas_supprimer'=>  $chat['pas_supprimer']
            );
        }
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
        $requete="select cha.* from chat as cha"; 
		return $this->db->query($requete)->result();                 
    }

    public function getmessageBydiscution($id_pesonnel_autre,$id_pesonnel_moi)
    {
        $sql=" 

                select detail.id as id, 
                        detail.date as date, 
                        detail.id_send as id_send , 
                        detail.id_receive as id_receive, 
                        detail.message as message, 
                        detail.type_message as type_message, 
                        detail.repertoire as repertoire, 
                        detail.pas_supprimer as pas_supprimer

                    from
                (select 
                        chat_autre.id as id, 
                        chat_autre.date as date, 
                        chat_autre.id_send as id_send , 
                        chat_autre.id_receive as id_receive, 
                        chat_autre.message as message , 
                        'receive' as type_message, 
                        chat_autre.repertoire as repertoire, 
                        chat_autre.pas_supprimer as pas_supprimer

                    from chat as chat_autre
                        
                        where chat_autre.id_send = ".$id_pesonnel_autre." 
                            and chat_autre.id_receive = ".$id_pesonnel_moi."
                UNION 

                select 
                        chat_moi.id as id, 
                        chat_moi.date as date, 
                        chat_moi.id_send as id_send , 
                        chat_moi.id_receive as id_receive , 
                        chat_moi.message as message, 
                        'send' as type_message, 
                        chat_moi.repertoire as repertoire, 
                        chat_moi.pas_supprimer as pas_supprimer

                    from chat as chat_moi
                        
                        where chat_moi.id_send = ".$id_pesonnel_moi." 
                            and chat_moi.id_receive = ".$id_pesonnel_autre." ) as detail
                            order by detail.date ASC";
        return $this->db->query($sql)->result();                
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
    public function getmaxidchat()
    {
        $requete="select max(cha.id) as id from chat as cha"; 
		return $this->db->query($requete)->result();                 
    }
      

}
