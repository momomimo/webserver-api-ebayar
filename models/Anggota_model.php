<?php

class Anggota_model extends CI_Model
{
    public function getanggota($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_anggota')->result_array();
        } else {
            return $this->db->get_where('tbl_anggota', ['id_anggota' => $id])->result_array();
        }
    }
    public function deleteanggota($id)
    {
        $this->db->delete('tbl_anggota', ['id_anggota' => $id]);

        return $this->db->affected_rows();
    }

    public function tambahanggota($data)
    {
        $this->db->insert('tbl_anggota', $data);

        return $this->db->affected_rows();
    }
    public function updateanggota($data, $id)
    {
        $this->db->update('tbl_anggota', $data, ['id_anggota' => $id]);

        return $this->db->affected_rows();
    }
}
