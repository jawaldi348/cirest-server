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
    /**
     * @param: username or email address
     * @param: passwor
     */
    public function user_login($username, $password)
    {
        $this->db->where('email', $username);
        $this->db->or_where('username', $username);
        $q = $this->db->get($this->tabel_pengguna);
        if ($q->num_rows()) {
            $user_pass = $q->row('password');
            if (md5($password) === $user_pass) {
                return $q->row();
            }
            return FALSE;
        } else {
            return FALSE;
        }
    }
}
