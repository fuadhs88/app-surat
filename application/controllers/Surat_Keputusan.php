<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_Keputusan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        $username = $this->session->userdata('username');

        $data['user'] = $this->User_model->getName($username);

        $this->load->view('header', $data);
        $this->load->view('surat_keputusan/list_surat_keputusan');
        $this->load->view('footer');
    }
}
