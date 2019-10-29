<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratUser_model extends CI_Model
{
    public $table = 'file_upload_surat_user';
    public $id   = 'id';
    public function getAll()
    {
        return $this->db->get('file_upload_surat_user');
    }

    public function get_by_id($id)
    {
        $this->db->select("*");
        $this->db->where("id", $id);
        return $this->db->get($this->table)->row();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where($this->id, $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->delete($this->table);
    }
}
