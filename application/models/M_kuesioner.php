<?php
class M_kuesioner extends CI_Model
{
    function getKuesioner($kd_quis = null)
    {
        if ($kd_quis == null) {
            return $this->db->query("SELECT q.*,j.jenis_quisioner From t_quisioner q join t_jenis_quisioner j on q.id_jenis_quisioner=j.id_jenis_quisioner AND q.status='1' ORDER BY quisioner ASC")->result_array();
        } else {
            return $this->db->get_where('t_quisioner', ['kd_quisioner' => $kd_quis])->result_array();
        }
    }

    function deleteKuesioner($kd_quis)
    {
        $this->db->delete('t_quisioner', ['kd_quisioner' => $kd_quis]);
        return $this->db->affected_rows();
    }

    function createKuesioner($data)
    {
        $this->db->select('*');
        $this->db->from('t_quisioner');
        $this->db->set($data);
        $this->db->insert('t_quisioner');
        return $this->db->affected_rows();
    }
    function updateKuesioner($data, $kd_quis)
    {
        $this->db->update('t_quisioner', $data, ['kd_quisioner' => $kd_quis]);
        return $this->db->affected_rows();
    }
}
