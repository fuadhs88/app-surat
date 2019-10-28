<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuratKeluar_model extends CI_Model
{
    public $table = 'file_upload';
    public $id    = 'id';

    public function getAll()
    {
        return $this->db->get('surat_keluar');
    }

    public function getAllFileUpload()
    {
        return $this->db->get('file_upload');
    }

    public function get_surat_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('surat_keluar')->row();
    }

    public function insert($data1)
    {
        return $this->db->insert('file_upload', $data1);
    }

    public function angka($kode)
    {
        $query = $this->db->query("SELECT MAX(LEFT(kode_surat,3)) as total FROM file_upload WHERE kode_surat LIKE '%" . $kode . "'");
        return $query->row();
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
        return $this->db->update('file_upload', $data);
    }
}
