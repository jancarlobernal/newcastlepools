<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lotto extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // Lotto                                                                                    //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    
    public function generate() {

        $arrDraw = $this->Lotto_Model->selectCurrentDraw()[0];
        $drawId = $arrDraw['draw_id'];
        $prizeOrder = $arrDraw['prize_order'];

        $arrUpdate = array();

        if ($prizeOrder < 23) {

            $prizeOrder += 1;
            $arrUpdate = array(
                'status' => "Ongoing"
            );

            $arrInsert = array(
                'draw_id' => $drawId,
                'prize_order' => $prizeOrder,
                'numbers' => $this->randomize()
            );
            $this->Lotto_Model->insertResult($arrInsert);
            
        } else {

            $prizeOrder = 0;
            $arrUpdate = array(
                'status' => "Done",
                'ended' => date('Y-m-d G:i:s')
            );

            $arrInsert = array(
                'status' => "New",
                'prize_order' => $prizeOrder
            );
            $this->Lotto_Model->insertDraw($arrInsert);

        }
        
        $arrUpdate['prize_order'] = $prizeOrder;
        $this->Lotto_Model->updateDraw($drawId, $arrUpdate);

        echo json_encode($arrUpdate);

    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // Results                                                                                  //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function selectResultCurrent() {

        $arrPrize = array();
        $arrResult = array();

        $arrPrize = array(
            'Consolation' => array(),
            'Special' => array(),
            'Grand' => array()
        );

        foreach ($this->Lotto_Model->selectAllPrize() as $prize) {
            $arrPrize[$prize['type']][$prize['number']] = "";
        }

        foreach ($this->Lotto_Model->selectResultCurrent() as $row) {
            $arrResult[$row['draw_id']] = (!empty($arrResult[$row['draw_id']])) ? $arrResult[$row['draw_id']] : array(
                'draw_id' => $row['draw_id'],
                'draw_status' => $row['draw_status'],
                'draw_started' => $row['draw_started'],
                'draw_ended' => $row['draw_ended'],
                'prize' => $arrPrize
            );
            $arrResult[$row['draw_id']]['prize'][$row['prize_type']][$row['prize_number']] = $row['result_numbers'];
        }

        echo json_encode($arrResult);

    }

    public function selectResultHistory() {

        $data = json_decode(file_get_contents('php://input'), true);
        $arrColumns = array('draw_id');
        $arrData = $this->assignDataToArray($data, $arrColumns);

        $drawId = $arrData['draw_id'];
        $arrHistory = $this->Lotto_Model->selectResultHistory($drawId);
        $arrResult = array();

        foreach ($arrHistory as $row) {
            $arrResult[$row['draw_id']] = (!empty($arrResult[$row['draw_id']])) ? $arrResult[$row['draw_id']] : array(
                'draw_id' => $row['draw_id'],
                'draw_status' => $row['draw_status'],
                'draw_started' => $row['draw_started'],
                'draw_ended' => $row['draw_ended'],
                'prize' => array(
                    'Consolation' => array(),
                    'Special' => array(),
                    'Grand' => array()
                )
            );
            $arrResult[$row['draw_id']]['prize'][$row['prize_type']][$row['prize_number']] = $row['result_numbers'];
        }

        echo json_encode($arrResult);

    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    // Helper Functions                                                                         //
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function randomize() {
        return str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    public function assignDataToArray($data, $arrColumns) {
        foreach ($arrColumns as $col) {
            $arrData[$col] = (!empty($data[$col])) ? $data[$col] : null;
        }
        return $arrData;
    }

}

?>