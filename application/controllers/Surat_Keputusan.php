<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Surat_Keputusan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('SuratKeputusan_model');
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
            'surat'   => $this->SuratKeputusan_model->getAll()->result(),
            'surat2' => $this->SuratKeputusan_model->getAllFileUpload()->result()
        );

        $this->load->view('header', $data);
        $this->load->view('surat_keputusan/list_surat_keputusan');
        $this->load->view('footer');
    }

    public function create()
    {
        $username = $this->session->userdata('username');

        $data = array(
            'pengguna' => $this->session->userdata('username'), //untuk nama user
            'surat'      => $this->SuratKeputusan_model->getAll()->result(),
            'user'      => $this->User_model->getName($username)
        );

        $this->load->view('header', $data);
        $this->load->view('surat_keputusan/tambah_surat_keputusan');
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
            $result = $this->SuratKeputusan_model->get_surat_by_id($id);

            $bulan = date('m');
            $month = getRomawi($bulan);
            $year = date('Y');
            $kode = "$result->kode_unik_surat/$month/$year";

            $countres = $this->SuratKeputusan_model->angka($kode);
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
                if ($this->SuratKeputusan_model->insert($data1) == TRUE) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat Keputusan berhasil ditambahkan</div>');
                    redirect(base_url('Surat_Keputusan/index'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat Keputusan gagal disimpan</div>');
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
        $row = $this->SuratKeputusan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'id'     => set_value('id', $row->id),
                'nama_surat'  => set_value('nama_surat', $row->nama_surat),
                'jenis_surat'   => set_value('nama', $row->jenis_surat),
                'kode'  => set_value('kode', $row->kode_surat),
                'title'  => 'Edit Surat Keputusan',
                'pengguna' =>  $this->session->userdata('username'),
                'surat' => $this->SuratKeputusan_model->getAll()->result(),
                'user'      => $this->User_model->getName($username)
            );

            $this->load->view('header', $data);
            $this->load->view('surat_keputusan/edit_surat_keputusan');
            $this->load->view('footer');
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('SuratKeputusan'));
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
                if ($this->SuratKeputusan_model->update($this->input->post('id', TRUE), $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat Keputusan berhasil diubah</div>');
                    redirect(base_url('Surat_Keputusan/index'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat Keputusan gagal diubah</div>');
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
                    redirect(base_url('Surat_Keputusan/update'));
                } else {
                    if ($this->SuratKeputusan_model->update($this->input->post('id', TRUE), $data)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Surat Keputusan berhasil diubah</div>');
                        redirect(base_url('Surat_Keputusan/index'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Surat Keputusan gagal diubah</div>');
                        $this->update($this->input->post('id', TRUE));
                    }
                }
            }
        }
    }

    public function delete()
    {
        $id = $this->input->post('id');

        $this->SuratKeputusan_model->delete($id);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Data Berhasil Dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>');
        }
        redirect('Surat_Keputusan');
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_surat', 'Nama Surat', 'required');
        $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
    }
}
