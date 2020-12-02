<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . '\libraries\REST_Controller.php';

class Pengguna extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Tambah pengguna baru
     * @method : POST
     */
    public function tambah_pengguna_post()
    {
        # code...
    }
    /**
     * Tampilkan semua data pengguna
     * @method : GET
     */
    public function fetch_pengguna_get()
    {
        header("Access-Control-Allow-Origin: *");
        $data = array('returned');
        $this->response($data);
    }
}
