<?php

class Lotto_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // view `result_history`                                                                    //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function selectResultHistory($drawId) {
        if (!empty($drawId)) {
            $this->db->where(array(
                'draw_id' => $drawId
            ));
        }
        $query = $this->db->get('result_history');
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // view `result_current`                                                                    //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function selectResultCurrent() {
        $query = $this->db->get('result_current');
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // table `result`                                                                           //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function insertResult($arrResult) {
        $query = $this->db->insert('result', $arrResult);
        return $this->db->affected_rows();
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // table `draw`                                                                             //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function selectCurrentDraw() {
        $where = array(
            'ended' => NULL 
        );
        $query = $this->db->where($where)->get('draw');
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    public function insertDraw($arrDraw) {
        $query = $this->db->insert('draw', $arrDraw);
        return $this->db->affected_rows();
    }

    public function updateDraw($drawId, $arrDraw) {
        $where = array(
            'draw_id' => $drawId
        );
        $query = $this->db->where($where)->update('draw', $arrDraw);
        return $this->db->affected_rows();
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // table `prize`                                                                            //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function selectAllPrize() {
        $query = $this->db->get('prize');
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }

    public function selectPrizeByOrder($order) {
        $where = array(
            'order' => $order
        );
        $query = $this->db->where($where)->get('prize');
        return ($query->num_rows() > 0) ? $query->result_array() : array();
    }
    
}

?>