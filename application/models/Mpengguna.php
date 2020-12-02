<?php
class Mpengguna extends CI_Model
{
    public function store_pengguna($pengguna_data)
    {
        return $this->db->insert('pengguna', $pengguna_data);
    }
    public function fetch_all()
    {
        $query = $this->db->get('pengguna');
        // echo $this->db->last_query();
        foreach ($query->result() as $row) {
            $pengguna_data[] = [
                'username' => $row->username,
                'email' => $row->email,
                'fullname' => $row->fullname,
                'create' => $row->created_at,
                'update' => $row->updated_at
            ];
        }
        return $pengguna_data;
    }
}
