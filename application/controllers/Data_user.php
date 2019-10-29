<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_user extends CI_Controller
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

        $data = array(
            'list_user' => $this->User_model->getAll()->result(),
            'user'      => $this->User_model->getName($username)
        );

        $this->load->view('header', $data);
        $this->load->view('user/list_user');
        $this->load->view('footer');
    }

    public function update($id)
    {
        $row = $this->User_model->get_by_id($id);
        $username = $this->session->userdata('username');

        if ($row) {
            $data = array(
                'id'     => set_value('id', $row->id),
                'email'  => set_value('email', $row->email),
                'nama'   => set_value('nama', $row->nama),
                'blokir' => set_value('blokir', $row->blokir),
                'level'  => set_value('level', $row->level),
                'user'      => $this->User_model->getName($username)
            );

            $this->load->view('header', $data);
            $this->load->view('user/edit_user');
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Data Tidak ditemukan</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
            redirect(site_url('Data_user'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'nama'  => $this->input->post('nama', TRUE),
                'blokir' => $this->input->post('blokir', TRUE),
                'level' => $this->input->post('level', TRUE),
            );

            if ($this->User_model->update($this->input->post('id', TRUE), $data) == TRUE) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>User berhasil diubah</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
                redirect(base_url('Data_user'));
            } else {
                $this->session->set_flashdata('message', 'User gagal diubah');
                $this->update($this->input->post('id', TRUE));
            }
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');

        $this->User_model->delete($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data Berhasil Dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        }
        redirect('Data_user');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('level', 'Level', 'required');
        $this->form_validation->set_rules('blokir', 'Blokir', 'required');
    }
}
