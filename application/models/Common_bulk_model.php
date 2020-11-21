<?php
defined('BASEPATH') OR exit('');

class common_bulk_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function loadEquipmentTypeList(){
        $stmt = $this->ceh->get('BS_EQUIPMENT_TYPE');
        return $stmt->result_array();
    }

    /* BS_EQUIPMENT_TYPE */
    public function saveEquipmentType($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $key => $item) {
            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            if(isset($item['EquipmentTypeName'])){
                $item['EquipmentTypeName'] = UNICODE.$item['EquipmentTypeName'];
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreatedBy'] = $item['ModifiedBy'];

            $checkItem = $this->ceh->select("EquipmentTypeID")
                                    ->where('EquipmentTypeID', $item['EquipmentTypeID'])
                                    ->limit(1)
                                    ->get('BS_EQUIPMENT_TYPE')
                                    ->row_array();

            if(count($checkItem) > 0){
                /* Do nothing */
            }
            else{
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('BS_EQUIPMENT_TYPE', $item);
            }
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return TRUE;
        }

        return $result;
    }

    public function deleteEquipmentType($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $equipmentTypeID = $this->ceh->select('EquipmentTypeID')
                                    ->where('rowguid', $item)
                                    ->limit(1)
                                    ->get('BS_EQUIPMENT_TYPE')
                                    ->row_array()['EquipmentTypeID'];


            $checkExist = $this->ceh->select('count(rowguid) as countExist')
                                    ->limit(1)
                                    ->where('EquipmentTypeID', $equipmentTypeID)
                                    ->get("BS_EQUIPMENT")->row_array();

            if ($checkExist['countExist'] == 0){
                $this->ceh->where('rowguid', $item)->delete('BS_EQUIPMENT_TYPE');
                array_push($result['success'], 'Xóa thành công Mã loại thiết bị: '.$equipmentTypeID);
            }
            else{
                array_push($result['error'], 'Không thể xóa - đã phát sinh Thiết bị với Mã loại thiết bị: '.$equipmentTypeID);
            }               
        }

        $this->ceh->trans_complete();

        if($this->ceh->trans_status() === FALSE) {
            $this->ceh->trans_rollback();
            return FALSE;
        }
        else {
            $this->ceh->trans_commit();
            return $result;
        }
    } 

    /* BS_EQUIPMENT */
    public function loadEquipmentList(){
        $this->ceh->select('EquipmentTypeID, EquipmentID, EquipmentName, IsOwn, rowguid');
        $stmt = $this->ceh->get('BS_EQUIPMENT');
        return $stmt->result_array();
    }
	
	public function loadEquipmentDataByTruckNumber($TruckNumber = ''){
        $this->ceh->select('B.BillOfLading as BillOfLading, B.BookingNo as BookingNo, EquipmentTypeID, EquipmentID, EquipmentName, EquipmentWeight, StockRef');
        
        $this->ceh->join('JOB_QUAY B', 'A.EquipmentID = B.TruckNumber');
        
        $this->ceh->where('EquipmentID', $TruckNumber);

        $stmt = $this->ceh->get('BS_EQUIPMENT A');
        return $stmt->result_array();
    }

    public function loadTruckWeightDataWithEirNo($TruckNumber = ''){
        $this->ceh->select('max(A.Sequence) as maxSequence, A.EirNo as EirNo, B.TruckWeight as TruckWeight, A.BillOfLading as BillOfLading, FirstWeightScale, SecondWeightScale');

        $this->ceh->where('A.TruckNumber', $TruckNumber);

        $this->ceh->join('BS_TRUCK_WEIGHT B', 'A.TruckNumber = B.TruckNumber', 'left');

        $this->ceh->group_by('A.EirNo, B.TruckWeight, A.BillOfLading, FirstWeightScale, SecondWeightScale');

        $stmt = $this->ceh->get('JOB_GATE A');
        
        return $stmt->result_array();
    }
}
       