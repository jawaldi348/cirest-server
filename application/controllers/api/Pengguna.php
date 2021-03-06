<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '\libraries\REST_Controller.php';

class Pengguna extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mpengguna');
    }
    /**
     * Registrasi Pengguna
     * ---------------------------
     * @param: fullname
     * @param: email address
     * @param: username
     * @param: password
     * ---------------------------
     * @method : POST
     * @link : pengguna/registrasi
     */
    public function registrasi_post()
    {
        header("Access-Control-Allow-Origin: *");
        # XSS Filtering
        $_POST = $this->security->xss_clean($_POST);

        #Form Validation
        $this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[80]|is_unique[pengguna.email]', array('is_unique' => 'This %s already exists please enter another email address'));
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[pengguna.username]|alpha_numeric|max_length[20]', array('is_unique' => 'This %s already exists please enter another username'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            // Form Validation Errors
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );
            // $this->response($message, 400);
            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $insert_data = [
                'fullname' => $this->input->post('fullname', TRUE),
                'email' => $this->input->post('email', TRUE),
                'username' => $this->input->post('username', TRUE),
                'password' => md5($this->input->post('password', TRUE)),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            // Tambah data pengguna ke database
            $output = $this->Mpengguna->store_pengguna($insert_data);
            if ($output > 0 and !empty($output)) {
                // Success 200 Code Send
                $message = [
                    'status' => true,
                    'message' => "Registrasi pengguna berhasil"
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                $message = [
                    'status' => false,
                    'message' => 'Tidak bisa registrasi akun pengguna'
                ];
                $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    /**
     * User Login API
     * ---------------------------
     * @param: username or email
     * @param: password
     * ---------------------------
     * @method: POST
     * @link: pengguna/login
     */
    public function login_post()
    {
        header("Access-Control-Allow-Origin: *");
        # XSS Filtering
        $_POST = $this->security->xss_clean($_POST);

        #Form Validation
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[100]');
        if ($this->form_validation->run() == FALSE) {
            // Form Validation Errors
            $message = array(
                'status' => false,
                'error' => $this->form_validation->error_array(),
                'message' => validation_errors()
            );
            // $this->response($message, 400);
            $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            // Load login function
            $output = $this->Mpengguna->user_login($this->input->post('username'), $this->input->post('password'));
            if (!empty($output) and $output != FALSE) {
                $return_data = [
                    'user_id' => $output->id,
                    'fullname' => $output->fullname,
                    'email' => $output->email,
                    'created_at' => $output->created_at
                ];
                // Login berhasil
                $message = [
                    'status' => true,
                    'data' => $return_data,
                    'message' => "Login pengguna berhasil"
                ];
                $this->response($message, REST_Controller::HTTP_OK);
            } else {
                // Login gagal
                $message = [
                    'status' => false,
                    'message' => 'Invalid username dan password'
                ];
                $this->response($message, REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
