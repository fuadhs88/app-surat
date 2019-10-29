<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }
    public function index()
    {
        $this->load->view('auth/login');
    }

    public function proses()
    {
        // Melakukan validasi input username dan password
        $this->form_validation->set_rules('username', 'username', 'required|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');
        // Jika validasi input username dan password bernilai false maka user/admin diminta melakukan input ulang
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Aplikasi Surat';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer'); // Menampilkan halaman utama login
        } else {
            // Input username dan password dengan fungsi POST 
            $username = $this->input->post('username') . "@uib.ac.id";
            $password = $this->input->post('password');

            $ldapconn = ldap_connect("uib.ac.id"); // jika gagal akan mereturn value FALSE  

            if ($ldapconn) {
                // menyatukan aplikasi dengan server LDAP  
                $ldapbind = @ldap_bind($ldapconn, $username, $password);
                // verify binding  
                if ($ldapbind) {
                    $cek = $this->User_model->getData($username);
                    if ($cek->num_rows() > 0) {
                        foreach ($cek->result() as $qad) {
                            if ($qad->blokir == 'N') {
                                $sess_data['username'] = $username;
                                $sess_data['nama'] = $qad->nama;
                                $sess_data['biro'] = $qad->id_biro;
                                $sess_data['level'] = $qad->level;
                                $sess_data['id_user'] = $qad->id_user;
                                $this->session->set_userdata($sess_data);
                                $this->session->set_flashdata('pesan', 'Hello ' . $qad->nama);
                                $this->session->set_flashdata('tipe', 'success');
                                if ($qad->level == "Admin") {
                                    redirect(base_url('admin'));
                                } else {
                                    redirect(base_url('user'));
                                }
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>User Belum Aktif atau masih diblokir oleh Admin</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>');
                                redirect(base_url('auth'));
                            }
                        }
                    } else {
                        $data = array(
                            'email' => $username,
                            'nama' => ucfirst($this->input->post('username'))
                        );
                        if ($this->User_model->insert($data)) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>User berhasil divalidasi</strong>Mohon menunggu validasi dari admin
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>');
                            redirect(base_url('auth'));
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>User gagal diregistrasi</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>');
                            redirect(base_url('auth'));
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Username atau Password yang anda masukkan salah!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>');
                    redirect(base_url('auth'));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi Masalah Pada Server</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>');
                redirect(base_url('auth'));
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Anda berhasil logout</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('auth');
    }
}
