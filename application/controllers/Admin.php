<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        if ($this->session->userdata('username') != "" && $this->session->userdata('level') == "Admin") { } else {
            show_404();
        }

        $username = $this->session->userdata('username');

        $data['user'] = $this->User_model->getName($username);

        $data1['users'] = $this->User_model->get_by_status('Y');

        $this->load->view('header', $data, $data1);
        $this->load->view('admin/dashboard', $data1);
        $this->load->view('footer');
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
