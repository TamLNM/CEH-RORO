<?php
defined('BASEPATH') OR exit('');

class data_bulk_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }


    public function loadAllColForBulkManifestScreen($VoyageKey = '', $IsLocalForeign = '', $ClassID = '')
    {

        $this->ceh->select('A.rowguid as rowguid, VoyageKey, BillOfLading, BookingNo, A.JobModeID as JobModeID, JobModeName, A.MethodID as MethodID, MethodName, CargoWeight, A.UnitID as UnitID, UnitName, Sequence, CntrNo, A.ClassID as ClassID, ClassName, IsLocalForeign, CommodityDescription, IsInOrdEirBulk, A.CargoTypeID as CargoTypeID, CargoTypeName');

        if ($VoyageKey != '')
            $this->ceh->where('VoyageKey', $VoyageKey);

        if ($IsLocalForeign != '')
            $this->ceh->where('IsLocalForeign', $IsLocalForeign);

        if ($ClassID != '')
            $this->ceh->where('A.ClassID', $ClassID);

        $this->ceh->order_by('BookingNo', 'ASC');
        $this->ceh->order_by('BillOfLading', 'ASC');
        $this->ceh->join('BS_JOB_MODE B', 'A.JobModeID = B.JobModeID', 'left');
        $this->ceh->join('BS_METHOD C', 'A.MethodID = C.MethodID', 'left');
        $this->ceh->join('BS_UNIT D', 'A.UnitID = D.UnitID', 'left');
        $this->ceh->join('BS_CLASS E', 'A.ClassID = E.ClassID', 'left');
        $this->ceh->join('BS_CARGOTYPE F', 'A.CargoTypeID = F.CargoTypeID');

        $stmt = $this->ceh->get('DT_MNF_LD_BULK A');
        return $stmt->result_array();         
    }

    public function saveBulkManifest($datas, $VoyageKey = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($VoyageKey != '')
                $item['VoyageKey'] = $VoyageKey;

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] = $item['UpdateTime'];

            if(isset($item['CommodityDescription'])){
                $item['CommodityDescription'] = UNICODE.$item['CommodityDescription'];
            }

            if ($item['ClassID'] == 1){
                $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('BillOfLading', $item['BillOfLading'])
                                        ->where('YardID', $item['YardID'])
                                        ->limit(1)->get('DT_MNF_LD_BULK')->row_array();               
            }
            else{
                $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                        ->where('BookingNo', $item['BookingNo'])
                                        ->where('YardID', $item['YardID'])
                                        ->limit(1)->get('DT_MNF_LD_BULK')->row_array();
            }     

            if(count($checkitem) > 0){
                    /* Do nothing */
            }
            else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('DT_MNF_LD_BULK', $item);

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

    public function updateBulkManifest($datas, $VoyageKey = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($VoyageKey != '')
                $item['VoyageKey'] = $VoyageKey;

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');

            if(isset($item['CommodityDescription'])){
                $item['CommodityDescription'] = UNICODE.$item['CommodityDescription'];
            }

            $checkitem = $this->ceh->where('rowguid', $item['rowguid'])->limit(1)->get('DT_MNF_LD_BULK')->row_array();         

            if(count($checkitem) > 0){
                $this->ceh->where('rowguid', $checkitem['rowguid'])->update('DT_MNF_LD_BULK', $item);
            }
            else{
               /* Do nothing */
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

    public function deleteBulkManifest($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $this->ceh->where('rowguid', $item)->delete('DT_MNF_LD_BULK');             
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

    public function updateStockBulkData($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($item['BillOfLading'] != ''){
                $this->ceh->where('VoyageKey', $item['VoyageKey'])
                    ->where('BillOfLading', $item['BillOfLading'])
                    ->update('DT_STOCK_BULK', $item);
            }   
            
            if ($item['BookingNo'] != ''){
                $this->ceh->where('VoyageKey', $item['VoyageKey'])
                    ->where('BookingNo', $item['BookingNo'])
                    ->update('DT_STOCK_BULK', $item);
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

    public function saveStockBulk($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            if(isset($item['CommodityDescription'])){
                $item['CommodityDescription'] = UNICODE.$item['CommodityDescription'];
            }

            $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                ->where('BookingNo', $item['BookingNo'])
                                ->limit(1)->get('DT_STOCK_BULK')->row_array();

            if(count($checkitem) > 0){
                /* Do nothing */
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('DT_STOCK_BULK', $item);
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

    public function updateMNFBulkStatus($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if ($item['ClassID'] == 1){
                $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                ->where('BillOfLading', $item['BillOfLading'])
                                ->limit(1)->get('DT_MNF_LD_BULK')->row_array();
                
                if(count($checkitem) > 0){
                    $this->ceh->where('VoyageKey', $checkitem['VoyageKey'])
                            ->where('BillOfLading', $checkitem['BillOfLading'])
                            ->set('IsInOrdEirBulk', 1)
                            ->update('DT_MNF_LD_BULK');
                }
            }
            else{
                $checkitem = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                ->where('BookingNo', $item['BookingNo'])
                                ->limit(1)->get('DT_MNF_LD_BULK')->row_array();
                
                if(count($checkitem) > 0){
                    $this->ceh->where('VoyageKey', $checkitem['VoyageKey'])
                            ->where('BookingNo', $checkitem['BookingNo'])
                            ->set('IsInOrdEirBulk', 1)
                            ->update('DT_MNF_LD_BULK');
                }
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

    public function loadStockBulkList($VoyageKey = '', $IsLocalForeign = '', $ClassID = ''){
        $this->ceh->select('A.rowguid as rowguid, VoyageKey , BillOfLading, BookingNo, CargoWeight, A.UnitID as UnitID, UnitName, CommodityDescription');

        if ($VoyageKey != ''){
            $this->ceh->where('VoyageKey', $VoyageKey);
        }

        if ($ClassID != ''){
            $this->ceh->where('ClassID', $ClassID);
        }

        if ($IsLocalForeign != ''){
            $this->ceh->where('IsLocalForeign', $IsLocalForeign);
        }

        $this->ceh->join('BS_UNIT B', 'A.UnitID = B.UnitID');
        $this->ceh->order_by('VoyageKey', 'ASC'); 
        $stmt = $this->ceh->get('DT_STOCK_BULK A');
        return $stmt->result_array(); 
    }

    public function loadStockBulkInList($stockRef = ''){
        $this->ceh->select('EirNo, Sequence, CargoWeightGetIn, A.UnitID as UnitID, UnitName, IsFinish');

        if ($stockRef != ''){
            $this->ceh->where('StockRef', $stockRef);
        }

        $this->ceh->join('BS_UNIT B', 'A.UnitID = B.UnitID', 'left');        
        $this->ceh->order_by('EirNo', 'ASC'); 
        $this->ceh->order_by('Sequence', 'ASC'); 
        $stmt = $this->ceh->get('DT_STOCKIN_BULK A');
        return $stmt->result_array(); 
    }

    public function saveJobQuayForBulkIn($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            if(isset($item['Remark'])){
                $item['Remark'] = UNICODE.$item['Remark'];
            }

            $stockRef = $this->ceh->select('rowguid')
                                    ->where('VoyageKey', $item['VoyageKey'])
                                    ->where('BillOfLading', $item['BillOfLading'])
                                    ->limit(1)
                                    ->get('DT_STOCK_BULK')
                                    ->row_array();

            $sequence = 0;
            $checkSeq = $this->ceh->select('max(Sequence) as maxSequence')
                                    ->where('ClassID', $item['ClassID'])
                                    ->where('StockRef', $stockRef['rowguid'])
                                    ->where('BookingNo is NULL')
                                    ->where('CargoType', 'B')
                                    ->limit(1)
                                    ->get('JOB_QUAY')
                                    ->row_array();

            if (intval(@$checkSeq['maxSequence']) > 0){
                $sequence = $checkSeq['maxSequence'] + 1;
            }

            if (count($stockRef) > 0){
                $stockRef = $stockRef['rowguid'];
                $item['Sequence'] = $sequence;

                $checkExistJobQuay = $this->ceh->where('VoyageKey', $item['VoyageKey'])
                                    ->where('ClassID', $item['ClassID'])
                                    ->where('BillOfLading', $item['BillOfLading'])
                                    ->where('IsLocalForeign', $item['IsLocalForeign'])
                                    ->where('StockRef', $stockRef)
                                    ->limit(1)
                                    ->get('JOB_QUAY')
                                    ->row_array();

                if (count($checkExistJobQuay) > 0){
                    $item['StockRef'] = $stockRef;
                    $this->ceh->where('VoyageKey', $checkExistJobQuay['VoyageKey'])
                                    ->where('ClassID', $checkExistJobQuay['ClassID'])
                                    ->where('IsLocalForeign', $checkExistJobQuay['IsLocalForeign'])                            
                                    ->where('BillOfLading', $checkExistJobQuay['BillOfLading'])
                                    ->where('StockRef', $stockRef)
                                    ->update('JOB_QUAY', $item);
                } 
                else{
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $item['StockRef'] = $stockRef;
                    $item['Sequence'] = $sequence;
                    $this->ceh->insert('JOB_QUAY', $item);
                }
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

    public function saveJobQuayForBulkOut($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            if ($item['ClassID'] == 1){
                if ($item['VINNo'] != ''){
                    $checkitem = $this->ceh->select("VoyageKey, StockRef, VINNo, BillOfLading, BookingNo, TruckNumber")
                                                        ->where('TruckNumber', $item['TruckNumber'])
                                                        ->where('StockRef', $item['StockRef'])
                                                        ->where('VoyageKey', $item['VoyageKey'])
                                                        ->where('VINNo', $item['VINNo'])
                                                        ->where('BillOfLading', $item['BillOfLading'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('JOB_QUAY')->row_array();

                    if(count($checkitem) > 0){
                        $this->ceh->where('StockRef', $checkitem["StockRef"])
                                ->where('VoyageKey', $checkitem['VoyageKey'])
                                ->where('VINNo', $checkitem["VINNo"])
                                ->where('BillOfLading', $checkitem["BillOfLading"])
                                ->update('JOB_QUAY', $item);
                    }else{
                        $item['CreatedBy'] = $item['ModifiedBy'];                     
                        $this->ceh->insert('JOB_QUAY', $item);
                    }
                }
                else{
                    $gateSequence = $this->ceh->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('FinishDate is NULL')
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

                    $sequence = 0;
                    if (count($gateSequence) > 0){
                        $sequence = $gateSequence['Sequence'];
                    }

                    $checkitem = $this->ceh->select("VoyageKey, StockRef, VINNo, BillOfLading, BookingNo, YardID")
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('StockRef', $item['StockRef'])
                                    ->where('VoyageKey', $item['VoyageKey'])
                                    ->where('BillOfLading', $item['BillOfLading'])
                                    ->where('Sequence', $sequence)
                                    ->where('YardID', $item['YardID'])
                                    ->limit(1)->get('JOB_QUAY')->row_array();

                    if(count($checkitem) > 0){
                        $this->ceh->where('StockRef', $checkitem["StockRef"])
                                ->where('TruckNumber', $checkitem['TruckNumber'])
                                ->where('VoyageKey', $checkitem['VoyageKey'])
                                ->where('BillOfLading', $checkitem["BillOfLading"])
                                ->where('YardID', $checkitem['YardID'])
                                ->where('StockRef', $checkitem['StockRef'])
                                ->update('JOB_QUAY', $item);
                    }else{
                        /*
                        $item['Sequence'] = 1;
                        if (intval(@$checkSeq['maxSequence']) > 0){
                            $item['Sequence'] = $checkSeq['maxSequence'] + 1;
                        }
                        */
                        $item['Sequence'] = $sequence;
                        $item['CreatedBy'] = $item['ModifiedBy'];
                        $this->ceh->insert('JOB_QUAY', $item);   
                    }
                }              
            }
            else{
                if ($item['VINNo'] != ''){
                    $checkitem = $this->ceh->select("VoyageKey, StockRef, VINNo, BillOfLading, BookingNo, TruckNumber")
                                                        ->where('TruckNumber', $item['TruckNumber'])
                                                        ->where('StockRef', $item['StockRef'])
                                                        ->where('VoyageKey', $item['VoyageKey'])
                                                        ->where('VINNo', $item['VINNo'])
                                                        ->where('BookingNo', $item['BookingNo'])
                                                        ->where('YardID', $item['YardID'])
                                                        ->limit(1)->get('JOB_QUAY')->row_array();                   

                    if(count($checkitem) > 0){
                        $this->ceh->where('StockRef', $checkitem["StockRef"])
                                ->where('TruckNumber', $checkitem['TruckNumber'])
                                ->where('VoyageKey', $checkitem['VoyageKey'])
                                ->where('VINNo', $checkitem["VINNo"])
                                ->where('BookingNo', $checkitem["BookingNo"])
                                ->update('JOB_QUAY', $item);
                    }else{                          
                        $item['CreatedBy'] = $item['ModifiedBy'];
                        $this->ceh->insert('JOB_QUAY', $item);
                    }
                }
                else{
                    $gateSequence = $this->ceh->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('FinishDate is NULL')
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

                    $sequence = 0;
                    if (count($gateSequence) > 0){
                        $sequence = $gateSequence['Sequence'];
                    }

                    $checkitem = $this->ceh->select("VoyageKey, StockRef, VINNo, BillOfLading, BookingNo, YardID")
                                    ->where('TruckNumber', $item['TruckNumber'])
                                    ->where('StockRef', $item['StockRef'])
                                    ->where('VoyageKey', $item['VoyageKey'])
                                    ->where('BookingNo', $item['BookingNo'])
                                    ->where('Sequence', $sequence)
                                    ->where('YardID', $item['YardID'])
                                    ->limit(1)->get('JOB_QUAY')->row_array();

                    if(count($checkitem) > 0){
                        $this->ceh->where('StockRef', $checkitem["StockRef"])
                                ->where('TruckNumber', $checkitem['TruckNumber'])
                                ->where('VoyageKey', $checkitem['VoyageKey'])
                                ->where('BookingNo', $checkitem["BookingNo"])
                                ->where('YardID', $checkitem['YardID'])
                                ->where('StockRef', $checkitem['StockRef'])
                                ->update('JOB_QUAY', $item);
                    }else{
                        $item['Sequence'] = $sequence;
                        $item['CreatedBy'] = $item['ModifiedBy'];
                        $this->ceh->insert('JOB_QUAY', $item);   
                    }
                }              
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

    public function saveStockInBulk($datas, $TruckNumber = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $gateSequence = $this->ceh->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $TruckNumber)
                                    ->where('FinishDate is NULL')
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

            $sequence = 0;
            if (count($gateSequence) > 0){
                $sequence = $gateSequence['Sequence'];
            }

            $item['Sequence']   = $sequence;
            $item['CreatedBy']  = $item['ModifiedBy'];
            $this->ceh->insert('DT_STOCKIN_BULK', $item);
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
    
    public function loadStockBulkOutList($stockRef = ''){
        $this->ceh->select('EirNo, Sequence, CargoWeightGetOut, A.UnitID as UnitID, UnitName, DateOut, RemainCargoWeight');

        if ($stockRef != ''){
            $this->ceh->where('StockRef', $stockRef);
        }

        $this->ceh->join('BS_UNIT B', 'A.UnitID = B.UnitID');        
        $this->ceh->order_by('EirNo', 'ASC'); 
        $this->ceh->order_by('Sequence', 'ASC'); 
        $stmt = $this->ceh->get('DT_STOCKOUT_BULK A');
        return $stmt->result_array(); 
    }

    public function saveStockOutBulk($datas, $TruckNumber = ''){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        
        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            
            $eirNo = $item['EirNo'];
            $stockRef = $item['StockRef'];

            $gateSequence = $this->ceh->where('EirNo', $item['EirNo'])
                                    ->where('TruckNumber', $TruckNumber)
                                    ->where('FinishDate is NULL')                                   
                                    ->limit(1)
                                    ->get('JOB_GATE')
                                    ->row_array();

            $sequence = 0;
            if (count($gateSequence) > 0){
                $sequence = $gateSequence['Sequence'];
            }


            $item['Sequence']   = $sequence;
            $item['CreatedBy']  = $item['ModifiedBy'];

            $cargoWeight = ($this->ceh->select('CargoWeight')
                                        ->where('EirNo', $eirNo)
                                        ->where('Sequence', $sequence)
                                        ->where('TruckNumber', $TruckNumber)
                                        ->get('BS_TRUCK_WEIGHT')
                                        ->row_array())['CargoWeight'];

            $currentSumCargoWeight = ($this->ceh->select('sum(CargoWeight) as currentSumCargoWeight')
                                    ->where('A.EirNo', $item['EirNo'])
                                    ->where('A.EirNo = B.EirNo')
                                    ->where('A.Sequence = B.Sequence')
                                    ->where('A.TruckNumber = B.TruckNumber')
                                    ->where('B.FinishDate is NOT NULL')                                   
                                    ->limit(1)                                    
                                    ->get('BS_TRUCK_WEIGHT A, JOB_GATE B')
                                    ->row_array())['currentSumCargoWeight'];

            $sumCargoWeight = ($this->ceh->select('CargoWeight')
                                    ->where('EirNo', $item['EirNo'])
                                    ->limit(1)
                                    ->get('ORD_EIR_BULK')
                                    ->row_array())['CargoWeight'];
        
            $item['CargoWeightGetOut'] = $cargoWeight;
            $item['RemainCargoWeight'] = $sumCargoWeight - $currentSumCargoWeight - $cargoWeight;
            $this->ceh->insert('DT_STOCKOUT_BULK', $item);
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

    public function saveStockInBulkDataByTally($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['CreatedBy']  = $item['ModifiedBy'];
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];
            
            $checkSeq = $this->ceh->select('max(Sequence) as Sequence')
                                ->where('TruckNumber', $item['TruckNumber'])
                                ->where('ClassID', 1)
                                ->where('BookingNo is NULL')
                                ->limit(1)
                                ->get('JOB_QUAY')
                                ->row_array();

            $sequence = -1;
            if (intval(@$checkSeq['Sequence']) > 0){
                $sequence = $checkSeq['Sequence'];

                $item['Sequence'] = $sequence;
                $this->ceh->insert('DT_STOCKIN_BULK', $item);
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

    public function saveStockOutBulkDataByTallyWithClassIn($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['CreatedBy']  = $item['ModifiedBy'];
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $cargoWeightGetOut = $this->ceh->where('EirNo', $item['EirNo'])
                                            ->where('Sequence', $item['Sequence'])
                                            ->where('TruckNumber', $item['TruckNumber'])
                                            ->limit(1)
                                            ->get('BS_TRUCK_WEIGHT')
                                            ->row_array();

            if (intval(@$cargoWeightGetOut['CargoWeight']) > 0){
                $item['CargoWeightGetOut'] = $cargoWeightGetOut['CargoWeight'];
            }

            $sumCargoWeight = $this->ceh->select('CargoWeight')
                                            ->where('EirNo', $item['EirNo'])
                                            ->limit(1)
                                            ->get('ORD_EIR_BULK')
                                            ->row_array()['CargoWeight'];

            $currentSumCargoWeight = 0;
            $checkCurrentSumCargoWeight = $this->ceh->select('SUM(CargoWeight) as currentSumCargoWeight')
                                            ->where('EirNo', $item['EirNo'])
                                            ->limit(1)
                                            ->get('BS_TRUCK_WEIGHT')
                                            ->row_array();

            if (intval(@$checkCurrentSumCargoWeight['currentSumCargoWeight']) > 0){
                $currentSumCargoWeight = $checkCurrentSumCargoWeight['currentSumCargoWeight'];
            }

            $checkSeq = $this->ceh->select('max(Sequence) as maxSequence')
                                            ->where('EirNo', $item['EirNo'])
                                            ->where('TruckNumber', $item['TruckNumber'])
                                            ->limit(1)
                                            ->get('BS_TRUCK_WEIGHT')
                                            ->row_array();

            $sequence = 0;
            if (intval(@$checkSeq['maxSequence']) > 0){
                $sequence = $checkSeq['maxSequence'];
            }

            $item['RemainCargoWeight'] = $sumCargoWeight - $currentSumCargoWeight;
            $item['Sequence'] = $sequence;
            
            $this->ceh->insert('DT_STOCKOUT_BULK', $item);
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

    public function saveStockOutBulkDataByTallyWithClassOut($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['CreatedBy']  = $item['ModifiedBy'];
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $item['CreateTime'] =  $item['UpdateTime'];

            $checkSeq = $this->ceh->select('max(Sequence) as Sequence')
                                ->where('EirNo', $item['EirNo'])
                                ->where('TruckNumber', $item['TruckNumber'])
                                ->limit(1)
                                ->get('DT_STOCKOUT_BULK')
                                ->row_array();

            $sequence = 1;
            if (intval(@$checkSeq['Sequence']) > 0){
                $sequence = $checkSeq['Sequence'];
            }

            $item['Sequence'] = $sequence;
            $this->ceh->insert('DT_STOCKOUT_BULK', $item);
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

    public function loadAllColStockBulkForOrderIn($BillOfLading = ''){
        $this->ceh->select('A.rowguid as rowguid, A.VoyageKey as VoyageKey, A.ClassID as ClassID, ClassName, BillOfLading, BookingNo, CargoWeight, JobModeInID, C.JobModeName as JobModeInName, MethodInID, D.MethodName as MethodInName, JobModeOutID, E.JobModeName as JobModeOutName, MethodOutID, F.MethodName as MethodOutName, CommodityDescription, A.UnitID as UnitID, UnitName');

        $this->ceh->join('BS_CLASS B', 'A.ClassID = B.ClassID');
        $this->ceh->join('BS_JOB_MODE C', 'A.JobModeInID = C.JobModeID', 'left');
        $this->ceh->join('BS_METHOD D', 'A.MethodInID = D.MethodID', 'left');
        $this->ceh->join('BS_JOB_MODE E', 'A.JobModeOutID = E.JobModeID', 'left');
        $this->ceh->join('BS_METHOD F', 'A.MethodOutID = F.MethodID', 'left');
        $this->ceh->join('BS_UNIT G', 'A.UnitID = G.UnitID');

        $this->ceh->where('A.ClassID', 1);
        $this->ceh->where('A.BillOfLading', $BillOfLading);

        $this->ceh->order_by('A.BillOfLading', 'ASC'); 
        $stmt = $this->ceh->get('DT_STOCK_BULK A');
        return $stmt->result_array();   
    }

    public function getCargoInWeightByBL($BillOfLading = ''){
        $checkCargoInWeight = $this->ceh->select('SUM(B.CargoWeightGetIn) as sumCargoInWeight')
                    ->where('A.BillOfLading', $BillOfLading)
                    ->join('DT_STOCKIN_BULK B', 'A.rowguid = B.StockRef')
                    ->limit(1)
                    ->get('DT_STOCK_BULK A')
                    ->row_array();
                    
        if (intval(@$checkCargoInWeight['sumCargoInWeight']) > 0){
            return $checkCargoInWeight['sumCargoInWeight'];
        }
        else{
            return -1;
        }

    }
}