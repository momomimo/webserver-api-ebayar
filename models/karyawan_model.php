<?php

class Karyawan_model extends CI_Model
{
    public function getkaryawan($id = null)
    {
        if ($id === null) {
            return $this->db->get('ms_karyawan')->result_array();
        } else {
            return $this->db->get_where('ms_karyawan', ['kode_karyawan' => $id])->result_array();
        }
    }
    public function deletekaryawan($id)
    {
        $this->db->delete('ms_karyawan', ['kode_karyawan' => $id]);
        
        return $this->db->affected_rows();
    }

    public function tambahkaryawan($data)
    {
        $this->db->insert('ms_karyawan',$data);

        return $this->db->affected_rows();
    }
    public function updatekaryawan($data, $id)
    {
        $this->db->update('ms_karyawan', $data, ['kode_karyawan' => $id]);

        return $this->db->affected_rows();
    }
}

 