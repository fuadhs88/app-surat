<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public $table = 'user';
    public $id = 'id';

    public function getAll()
    {
        return $this->db->get('user');
    }
    public function getData($email)
    {
        $this->db->select('email, level, blokir,nama');
        $this->db->from('user');
        $this->db->where('email', $email);
        return $this->db->get();
    }

    public function getName($username)
    {
        $this->db->where('email', $username);
        return $this->db->get('user')->row();
    }

    public function insert($data)
    {
        return $this->db->insert('user', $data);
    }

    public function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }

    public function update($id, $data)
    {
        $this->db->where($this->id, $id);
        return $this->db->update('user', $data);
    }
}
