<?php
class Mpengguna extends CI_Model
{
    protected $tabel_pengguna = 'pengguna';
    /**
     * Registrasi Pengguna
     * @param: {array} Data Pengguna
     */
    public function store_pengguna(array $data)
    {
        $this->db->insert($this->tabel_pengguna, $data);
        return $this->db->insert_id();
    }
}
