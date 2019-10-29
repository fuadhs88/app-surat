<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('SuratUser_model');
    }

    public function index()
    {
        if ($this->session->userdata('username') != "" && $this->session->userdata('level') == "User") { } else {
            show_404();
        }

        $username = $this->session->userdata('username');

        $data = array(
            'user'  => $this->User_model->getName($username),
            'surat' => $this->SuratUser_model->getAll()->result(),
        );

        $this->load->view('header', $data);
        $this->load->view('surat_user/list_surat_user');
        $this->load->view('footer');
    }

    public function create()
    {
        $username = $this->session->userdata('username');

        $data = array(
            'user'  => $this->User_model->getName($username),
            'surat' => $this->SuratUser_model->getAll()->result(),
        );

        $this->load->view('header', $data);
        $this->load->view('surat_user/tambah_surat_user');
        $this->load->view('footer');
    }

    public function create_action()
    {
        if (empty($_FILES['surat']['name'])) {
            $this->form_validation->set_rules('surat', 'Document Surat', 'required');
        }

        $this->form_validation->set_rules('nama_surat', 'Nama Surat', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', 'Mohon Isi data dengan lengkap');
            redirect(base_url('User/create'));
        } else {
            if ($_FILES['surat']['size'] > 2097152) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File gagal diupload.Pastikan Ukuran file 2 MB</div>');
                redirect(base_url('User/create'));
            } else {
                $data = array(
                    'nama_surat'        => $this->input->post('nama_surat', TRUE),
                    'keterangan'        => $this->input->post('keterangan', TRUE),
                );
                $id = $this->SuratUser_model->insert($data);


                $config['upload_path']      = './surat_user';
                $config['allowed_types']    = 'pdf';
                $config['max_size'] = '2048';
                $config['file_name'] = 'Surat' . $id.'.pdf';
                $config['overwrite'] = TRUE;
                $surat = 'Surat' . $id.'.pdf';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('surat')) {
                    $data1 = array(
                        'filename'  => $surat
                    );

                    if ($this->SuratUser_model->update($id, $data1))
                    { 
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil ditambahkan</div>');
                        redirect(base_url('User/index'));
                    }
                    else
                    {
                        $this->SuratUser_model->delete($id);
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File gagal diupload. Pastikan Ukuran file 2 MB</div>');
                        redirect(base_url('User/create'));
                    }
                } else {
                    $this->SuratUser_model->delete($id);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File gagal diupload.Pastikan Ukuran file 2 MB</div>');
                    redirect(base_url('User/create'));
                }
            }
        }
    }

    public function update($id)
    {
        if (!isset($this->session->userdata['username'])) {
            redirect(base_url("auth"));
        }
        $row = $this->SuratUser_model->get_by_id($id);

        $username = $this->session->userdata('username');

        if ($row) {
            $data = array(
                'id'     => set_value('id', $row->id),
                'nama_surat'  => set_value('nama_surat', $row->nama_surat),
                'filename'   => set_value('filename', $row->filename),
                'keterangan'  => set_value('kode', $row->keterangan),
                'user'  => $this->User_model->getName($username),
                'surat' => $this->SuratUser_model->getAll()->result(),
            );

            $this->load->view('header', $data);
            $this->load->view('surat_user/edit_surat_user');
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('User'));
        }
    }

    public function update_action()
    {
        $file = $_FILES['surat']['name'];

        $id = $this->input->post('id', TRUE);
        $data = array(
            'nama_surat'    => $this->input->post('nama_surat'),
            'keterangan'    => $this->input->post('keterangan'),
        );

        if ($this->form_validation->run() == TRUE) {
            $this->update($this->input->post('id', TRUE));
        } 
        else 
        {
            if (empty($_FILES['surat']['name']))
            {
                if($this->SuratUser_model->update($this->input->post('id', TRUE), $data)) 
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil Diiubah</div>');
                    redirect(base_url('User/index'));
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat gagal Diiubah</div>');
                    $this->update($this->input->post('id', TRUE));
                }
            }
            else
            {
                $config['upload_path']      = './surat_user';
                $config['allowed_types']    = 'pdf';
                $config['max_size'] = '2048';
                $config['file_name'] = 'Surat' . $id.'.pdf';
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('surat')) 
                {
                    if($this->SuratUser_model->update($this->input->post('id', TRUE), $data)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat berhasil Diiubah</div>');
                        redirect(base_url('User/index'));
                    }
                    else
                    {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat gagal Diiubah</div>');
                        $this->update($this->input->post('id', TRUE));
                    }
                }
                else 
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File gagal diupload.Pastikan Ukuran file 2 MB</div>');
                    $this->update($this->input->post('id', TRUE));
                }
            }  
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');

        $this->SuratUser_model->delete($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data Berhasil Dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        }
        redirect('User');
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}
