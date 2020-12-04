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
     * @method : POST
     * @url : pengguna/registrasi
     */
    public function registrasi_post()
    {
        header("Access-Control-Allow-Origin: *");
    }
}
