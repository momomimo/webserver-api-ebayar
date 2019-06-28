<?php

class Idterminal_model extends CI_Model
{
    public function getidterminal($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_terminal')->result_array();
        } else {
            return $this->db->get_where('tbl_terminal', ['id' => $id])->result_array();
        }
    }
    public function deleteidterminal($id)
    {
        $this->db->delete('tbl_terminal', ['id' => $id]);

        return $this->db->affected_rows();
    }

    public function tambahidterminal($data)
    {
        $this->db->insert('tbl_terminal', $data);

        return $this->db->affected_rows();
    }
    public function updateidterminal($data, $id)
    {
        $this->db->update('tbl_terminal', $data, ['id' => $id]);

        return $this->db->affected_rows();
    }
}
