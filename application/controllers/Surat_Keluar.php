<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_Keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('SuratKeluar_model');
        $this->load->helper('bulan');
    }

    public function index()
    {
        if ($this->session->userdata('username') != "" && $this->session->userdata('level') == "Admin") { } else {
            show_404();
        }

        $username = $this->session->userdata('username');

        $data = array(
            'user'  => $this->User_model->getName($username),
            'surat'   => $this->SuratKeluar_model->getAll()->result(),
            'surat2' => $this->SuratKeluar_model->getAllFileUpload()->result()
        );

        $this->load->view('header', $data);
        $this->load->view('surat_keluar/list_surat_keluar');
        $this->load->view('footer');
    }

    public function create()
    {
        $username = $this->session->userdata('username');

        $data = array(
            'pengguna' => $this->session->userdata('username'), //untuk nama user
            'surat' => $this->SuratKeluar_model->getAll()->result(),
            'user'      => $this->User_model->getName($username)
        );

        $this->load->view('header', $data);
        $this->load->view('surat_keluar/tambah_surat_keluar');
        $this->load->view('footer');
    }

    public function create_action()
    {
        $file = $_FILES['surat']['name'];

        if ($file = '') {
            $this->form_validation->set_rules('surat', 'Document Surat', 'required');
        }

        $this->_rules();

        if ($this->form_validation->run() == true) {
            $this->create();
        } else {
            $id = $this->input->post('tipe');
            $result = $this->SuratKeluar_model->get_surat_by_id($id);

            $bulan = date('m');
            $month = getRomawi($bulan);
            $year = date('Y');
            $kode = "$result->kode_unik_surat/$month/$year";

            $countres = $this->SuratKeluar_model->angka($kode);
            $totalcount = intval($countres->total);
            $no = $totalcount + 1;

            if ($no < 10) {
                $no = "00" . $no;
            } else if ($no >= 10 && $no < 100) {
                $no = "0" . $no;
            } else {
                $no = $no;
            }

            $kode = $no . '/' . $kode;
            $kodedocument = str_replace("/", "", $kode);

            $data1 = array(
                'nama_surat'    => $this->input->post('nama_surat'),
                'jenis_surat'   => $result->nama_surat,
                'kode_surat'    => $kode,
                'filename'      => $kodedocument . '.pdf',
                'tanggal'       => date('Y/m/d')
            );

            $config['upload_path']      = './file_surat';
            $config['allowed_types']    = 'pdf';
            $config['max_size'] = '2048';
            $config['file_name'] = $kodedocument . '.pdf';
            $config['overwrite'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('surat', $config)) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File gagal diupload.Pastikan Ukuran file 2 MB</div>');
                $this->create();
            } else {
                if ($this->SuratKeluar_model->insert($data1) == TRUE) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat keluar berhasil ditambahkan</div>');
                    redirect(base_url('Surat_Keluar/index'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat keluar gagal disimpan</div>');
                    $this->create();
                }
            }
        }
    }

    public function update($id)
    {
        $username = $this->session->userdata('username');

        if (!isset($this->session->userdata['username'])) {
            redirect(base_url("auth"));
        }

        $row = $this->SuratKeluar_model->get_by_id($id);

        if ($row) {
            $data = array(
                'id'     => set_value('id', $row->id),
                'nama_surat'  => set_value('nama_surat', $row->nama_surat),
                'jenis_surat'   => set_value('nama', $row->jenis_surat),
                'kode'  => set_value('kode', $row->kode_surat),
                'title'  => 'Edit Surat Keluar',
                'pengguna' =>  $this->session->userdata('username'),
                'surat' => $this->SuratKeluar_model->getAll()->result(),
                'user'      => $this->User_model->getName($username)
            );

            $this->load->view('header', $data);
            $this->load->view('surat_keluar/edit_surat_keluar');
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Surat_Keluar'));
        }
    }

    public function update_action()
    {
        $file = $_FILES['surat']['name'];

        if ($this->form_validation->run() == true) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'nama_surat'    => $this->input->post('nama_surat'),
            );

            $kode = $this->input->post('kode', TRUE);
            $kodedocument = str_replace("/", "", $kode);
            if ($file = '') {
                if ($this->SuratKeluar_model->update($this->input->post('id', TRUE), $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat keluar berhasil diubah</div>');
                    redirect(base_url('Surat_Keluar/index'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat keluar gagal diubah</div>');
                    $this->update($this->input->post('id', TRUE));
                }
            } else {
                $config['upload_path']      = './file_surat';
                $config['allowed_types']    = 'pdf';
                $config['max_size'] = '2048';
                $config['file_name'] = $kodedocument . '.pdf';
                $config['overwrite'] = TRUE;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('surat')) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">File gagal diupload.Pastikan Ukuran file 2 MB</div>');
                    redirect(base_url('Surat_Keluar/update'));
                } else {
                    if ($this->SuratKeluar_model->update($this->input->post('id', TRUE), $data)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat keluar berhasil diubah</div>');
                        redirect(base_url('Surat_Keluar/index'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat keluar gagal diubah</div>');
                        $this->update($this->input->post('id', TRUE));
                    }
                }
            }
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');

        $this->SuratKeluar_model->delete($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data Berhasil Dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        }
        redirect('Surat_Keluar');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_surat', 'Nama Surat', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
    }
}
