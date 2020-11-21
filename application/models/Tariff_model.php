<?php
defined('BASEPATH') OR exit('');

class tariff_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }


    /* TRF Code Database Query */
    public function loadTRFCodesList(){
    	$this->ceh->select('TRFCode, TRFCodeName, A.UnitID as UnitID, RevenueAccount, TaxAccount, HasVAT, UnitName');
    	$this->ceh->join('BS_UNIT B', 'A.UnitID = B.UnitID');
        $this->ceh->order_by('TRFCode', 'ASC');
        $stmt = $this->ceh->get('TRF_CODE A');
        return $stmt->result_array();
    }

    public function saveTRFCodes($datas){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            if(isset($item['TRFCodeName']))
                $item['TRFCodeName'] = UNICODE.$item['TRFCodeName'];

            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->select("TRFCode")->where('TRFCode', $item['TRFCode'])
                                                        ->limit(1)
                                                        ->get('TRF_CODE')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('TRFCode', $checkItem["TRFCode"])->update('TRF_CODE', $item);
            }else{
                //insert database

                //$item['YardID'] = $item['YardID'];

                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('TRF_CODE', $item);
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

    public function deleteTRFCodes($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('TRFCode', $item)->delete('TRF_CODE');      
            array_push($result['success'], 'Xóa thành công:'.$item);
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

    /* TRF Standard Database Query */ 
    public function loadTRFStandardList($fromDay = '', $toDay = '', $remark = ''){
        $this->ceh->select('A.rowguid as rowguid, A.TRFCode as TRFCode, TRFCodeName, TRFDesc, A.MethodID as MethodID, MethodName, A.TransitID as TransitID, TransitName, A.JobTypeID as JobTypeID, JobTypeName, A.JobModeID as JobModeID, JobModeName, A.ClassID as ClassID, ClassName, Price, A.ServiceID as ServiceID, ServiceName, A.CarTypeID as CarTypeID, CarTypeName, A.RateID as RateID, ExchangeRate, VAT, ApplyDate, ExpireDate, IncludeVAT, A.Remark as Remark, A.CargoTypeID as CargoTypeID, CargoTypeName, VAT');

        if ($fromDay != ''){
            $this->ceh->where('ApplyDate =', $fromDay);
        }


        if ($toDay != ''){
            if ($toDay == '*'){
                //$this->ceh->like('ExpireDate', $toDay);
            }
            else{ 
                $this->ceh->where('ExpireDate', $toDay);
            }
        }
        
        if ($remark != ''){
            $this->ceh->like('A.Remark', $remark);
        }

        $this->ceh->join('BS_METHOD B', 'A.MethodID = B.MethodID', 'left');
        $this->ceh->join('BS_TRANSIT C', 'A.TransitID = C.TransitID', 'left');
        $this->ceh->join('BS_JOB_TYPE D', 'A.JobTypeID = D.JobTypeID', 'left');
        $this->ceh->join('BS_JOB_MODE E', 'A.JobModeID = E.JobModeID', 'left');
        $this->ceh->join('BS_CLASS F', 'A.ClassID = F.ClassID', 'left');
        $this->ceh->join('BS_SERVICE G', 'A.ServiceID = G.ServiceID', 'left');
        $this->ceh->join('BS_CAR_TYPE H', 'A.CarTypeID = H.CarTypeID', 'left');
        $this->ceh->join('BS_CARGOTYPE I', 'A.CargoTypeID = I.CargoTypeID');
        $this->ceh->join('TRF_CODE J', 'A.TRFCode = J.TRFCode');
        $this->ceh->join('BS_INV_RATE K', 'A.RateID = K.RateID');

        $this->ceh->order_by('TRFCode', 'ASC');
        $stmt = $this->ceh->get('TRF_STANDARD A');;
        return $stmt->result_array();
    }

    public function loadDistinctTRFStandardList(){
        $this->ceh->distinct();
        $this->ceh->select('ApplyDate, ExpireDate, Remark');
        $this->ceh->order_by('ApplyDate', 'ASC');
        $stmt = $this->ceh->get('TRF_STANDARD');
        return $stmt->result_array();
    }

    public function loadMethodList(){
        $this->ceh->select('MethodID, MethodName');
        $this->ceh->order_by('MethodID', 'ASC');
        $stmt = $this->ceh->get('BS_METHOD');
        return $stmt->result_array();
    }

    public function loadTransitList(){
        $this->ceh->select('TransitID, TransitName');
        $this->ceh->order_by('TransitID', 'ASC');
        $stmt = $this->ceh->get('BS_TRANSIT');
        return $stmt->result_array();
    }

    public function loadJobTypeList(){
        $this->ceh->select('JobTypeID, JobTypeName');
        $this->ceh->order_by('JobTypeID', 'ASC');
        $stmt = $this->ceh->get('BS_JOB_TYPE');
        return $stmt->result_array();
    }

    public function loadJobModeList(){
        $this->ceh->select('JobModeID, JobModeName');
        $this->ceh->order_by('JobModeID', 'ASC');
        $stmt = $this->ceh->get('BS_JOB_MODE');
        return $stmt->result_array();
    }

    public function loadClassList(){
        $this->ceh->select('ClassID, ClassName');
        $this->ceh->order_by('ClassID', 'ASC');
        $stmt = $this->ceh->get('BS_CLASS');
        return $stmt->result_array();
    }

    public function loadServiceList(){
        $this->ceh->select('ServiceID, ServiceName');
        $this->ceh->order_by('ServiceID', 'ASC');
        $stmt = $this->ceh->get('BS_SERVICE');
        return $stmt->result_array();
    }

    public function loadCarTypeList(){
        $this->ceh->select('CarTypeID, CarTypeName');
        $this->ceh->order_by('CarTypeID', 'ASC');
        $stmt = $this->ceh->get('BS_CAR_TYPE');
        return $stmt->result_array();
    }

    public function loadInvRataList(){
        $this->ceh->select('RateID');
        $this->ceh->order_by('RateID', 'ASC');
        $stmt = $this->ceh->get('BS_INV_RATE');
        return $stmt->result_array();
    }

    public function insertTRFStandard($datas, $applyDate = '', $expireDate = '', $remark = ''){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['ApplyDate'] = $applyDate;
            $item['ExpireDate'] = $expireDate;
            $item['Remark'] = $remark;

            if(isset($item['TRFDesc']))
                $item['TRFDesc'] = UNICODE.$item['TRFDesc'];

            if(isset($item['rowguid']))
                unset($item['rowguid']);
    
            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->where('TRFCode', $item['TRFCode'])
                                    ->where('MethodID', $item['MethodID'])
                                    ->where('TransitID', $item['TransitID'])
                                    ->where('JobTypeID', $item['JobTypeID'])
                                    ->where('JobModeID', $item['JobModeID'])
                                    ->where('ClassID', $item['ClassID'])
                                    ->where('ServiceID', $item['ServiceID'])  
                                    ->where('CarTypeID', $item['CarTypeID'])  
                                    ->where('RateID', $item['RateID'])  
                                    ->where('VAT', $item['VAT'])  
                                    ->limit(1)
                                    ->get('TRF_STANDARD')->row_array();

            if(count($checkItem) > 0){
                /* Do nothing */
            }else{                
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('TRF_STANDARD', $item);
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

     public function updateTRFStandard($datas, $applyDate = '', $expireDate = '', $remark = ''){ 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['ApplyDate'] = $applyDate;
            $item['ExpireDate'] = $expireDate;
            $item['Remark'] = $remark;

            if(isset($item['TRFDesc']))
                $item['TRFDesc'] = UNICODE.$item['TRFDesc'];

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('TRF_STANDARD')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('rowguid', $item['rowguid'])->update('TRF_STANDARD', $item);
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

    public function deleteTRFStandard($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->where('rowguid', $item)->delete('TRF_STANDARD');      
            array_push($result['success'], 'Xóa thành công:'.$item);
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

    public function loadTRFStandardListForDiscountScreen(){
        $this->ceh->select('A.TRFCode as TRFCode, TRFCodeName, TRFDesc, A.MethodID as MethodID, MethodName, A.TransitID as TransitID, TransitName, A.JobTypeID as JobTypeID, JobTypeName, A.JobTypeID as JobModeID, JobModeName, A.ClassID as ClassID, ClassName, Price, A.ServiceID as ServiceID, ServiceName, A.CarTypeID as CarTypeID, CarTypeName, RateID, VAT, ApplyDate, ExpireDate, IncludeVAT, A.Remark as Remark');
        $this->ceh->join('BS_METHOD B', 'A.MethodID = B.MethodID', 'left');
        $this->ceh->join('BS_TRANSIT C', 'A.TransitID = C.TransitID', 'left');
        $this->ceh->join('BS_JOB_TYPE D', 'A.JobTypeID = D.JobTypeID', 'left');
        $this->ceh->join('BS_JOB_MODE E', 'A.JobModeID = E.JobModeID', 'left');
        $this->ceh->join('BS_CLASS F', 'A.ClassID = F.ClassID', 'left');
        $this->ceh->join('BS_SERVICE G', 'A.ServiceID = G.ServiceID', 'left');
        $this->ceh->join('BS_CAR_TYPE H', 'A.CarTypeID = H.CarTypeID', 'left');
        $this->ceh->join('TRF_CODE I', 'A.TRFCode = I.TRFCode', 'left');
        $this->ceh->order_by('A.TRFCode', 'ASC');
        $stmt = $this->ceh->get('TRF_STANDARD A');
        return $stmt->result_array();
    }

    /* TRF Discount Database Query */
    public function insertTRFDiscount($datas, $applyDate = '', $expireDate = '', $discountID = '', $discountName = '', 
        $cusID = '', $cusTypeID = '')
    { 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['DiscountID'] = $discountID;
            $item['DiscountName'] = $discountName;
            $item['CusID'] = $cusID;
            $item['CusTypeID'] = $cusTypeID;
            $item['ApplyDate'] = $applyDate;
            $item['ExpireDate'] = $expireDate;

            if(isset($item['TRFDesc']))
                $item['TRFDesc'] = UNICODE.$item['TRFDesc'];

            if(isset($item['DiscountName']))
                $item['DiscountName'] = UNICODE.$item['DiscountName'];

            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            //$item['VAT'] = number_format($item['VAT'], 0);

            $checkItem = $this->ceh->where('DiscountID', $item['DiscountID'])
                                    ->where('CusID', $item['CusID'])
                                    ->where('ApplyDate =', $item['ApplyDate'])
                                    ->where('ExpireDate =', $item['ExpireDate'])
                                    ->where('TRFCode', $item['TRFCode'])
                                    ->where('MethodID', $item['MethodID'])
                                    ->where('TransitID', $item['TransitID'])
                                    ->where('JobTypeID', $item['JobTypeID'])
                                    ->where('JobModeID', $item['JobModeID'])
                                    ->where('ClassID', $item['ClassID'])
                                    ->where('ServiceID', $item['ServiceID'])  
                                    ->where('CarTypeID', $item['CarTypeID'])  
                                    ->where('RateID', $item['RateID'])  
                                    ->where('VAT', intval($item['VAT']))
                                    ->where('BrandID', $item['BrandID'])
                                    ->where('PaymentTypeID', $item['PaymentTypeID'])
                                    ->limit(1)
                                    ->get('TRF_DISCOUNT')->row_array();
            if(count($checkItem) > 0){
                /* Do nothing */
            }else{
                $item['CreatedBy'] = $item['ModifiedBy'];
                $item['CreateTime'] = $item['UpdateTime'];
                $this->ceh->insert('TRF_DISCOUNT', $item);
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

    public function updateTRFDiscount($datas, $applyDate = '', $expireDate = '', $discountID = '', $discountName = '', 
        $cusID = '', $cusTypeID = '')
    { 
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $item['DiscountID'] = $discountID;
            $item['DiscountName'] = $discountName;
            $item['CusID'] = $cusID;
            $item['CusTypeID'] = $cusTypeID;
            $item['ApplyDate'] = $applyDate;
            $item['ExpireDate'] = $expireDate;

            if(isset($item['TRFDesc']))
                $item['TRFDesc'] = UNICODE.$item['TRFDesc'];

            if(isset($item['DiscountName']))
                $item['DiscountName'] = UNICODE.$item['DiscountName'];

            if(isset($item['rowguid'])){
                unset($item['rowguid']);
            }

            $item['YardID'] = $this->session->userdata("YardID");
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['UpdateTime'] = date('Y-m-d H:i:s');
            $checkItem = $this->ceh->where('rowguid', $item['rowguid'])
                                    ->limit(1)
                                    ->get('TRF_DISCOUNT')->row_array();
            if(count($checkItem) > 0){
                $this->ceh->where('rowguid', $checkItem["rowguid"])->update('TRF_DISCOUNT', $item);
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

    public function loadPaymentType(){
        $this->ceh->select('PaymentTypeID, PaymentTypeName');
        $this->ceh->order_by('PaymentTypeID', 'ASC');
        $stmt = $this->ceh->get('BS_INV_PAYMENT_TYPE');
        return $stmt->result_array();
    }

    public function loadBrandList(){
        $this->ceh->select('BrandID, BrandName');
        $this->ceh->order_by('BrandID', 'ASC');
        $stmt = $this->ceh->get('BS_CAR_BRAND');
        return $stmt->result_array();
    }

    public function loadDistinctTRFDiscountList(){
        $this->ceh->distinct();
        $this->ceh->select('DiscountID, DiscountName, CusID, CusTypeID, ApplyDate, ExpireDate');
        $this->ceh->order_by('DiscountID', 'ASC');
        $stmt = $this->ceh->get('TRF_DISCOUNT');
        return $stmt->result_array();
    }

    public function loadTRFDiscountList($discountID = '', $cusID = '', $cusTypeID = '', $applyDate = '', $expireDate = '')
    {
        $this->ceh->select('A.rowguid as rowguid, DiscountID, DiscountName, CusID, CusTypeID, ApplyDate, ExpireDate, TRFCode, TRFDesc, A.MethodID as MethodID, MethodName, A.TransitID as TransitID, TransitName, A.JobTypeID as JobTypeID, JobTypeName, A.JobTypeID as JobModeID, JobModeName, A.ClassID as ClassID, ClassName, Price, A.ServiceID as ServiceID, ServiceName, A.CarTypeID as CarTypeID, CarTypeName, RateID, VAT, ApplyDate, ExpireDate, A.BrandID as BrandID, BrandName, A.PaymentTypeID as PaymentTypeID, PaymentTypeName');

        if ($discountID != ''){
            $this->ceh->where('DiscountID', $discountID);
        }

        if ($cusID != ''){
            $this->ceh->where('CusID', $cusID);
        }

        if ($cusTypeID != ''){
            $this->ceh->where('CusTypeID', $cusTypeID);
        }

        if ($applyDate != ''){
            $this->ceh->where('ApplyDate =', $applyDate);
        }
        
        if ($expireDate != '*'){
            $this->ceh->where('ExpireDate =', $expireDate);
        }

        $this->ceh->join('BS_METHOD B', 'A.MethodID = B.MethodID', 'left');
        $this->ceh->join('BS_TRANSIT C', 'A.TransitID = C.TransitID', 'left');
        $this->ceh->join('BS_JOB_TYPE D', 'A.JobTypeID = D.JobTypeID', 'left');
        $this->ceh->join('BS_JOB_MODE E', 'A.JobModeID = E.JobModeID', 'left');
        $this->ceh->join('BS_CLASS F', 'A.ClassID = F.ClassID', 'left');
        $this->ceh->join('BS_SERVICE G', 'A.ServiceID = G.ServiceID', 'left');
        $this->ceh->join('BS_CAR_TYPE H', 'A.CarTypeID = H.CarTypeID', 'left');
        $this->ceh->join('BS_CAR_BRAND I', 'A.BrandID = I.BrandID', 'left');
        $this->ceh->join('BS_INV_PAYMENT_TYPE J', 'A.PaymentTypeID = J.PaymentTypeID', 'left');
        $this->ceh->order_by('TRFCode', 'ASC');
        $stmt = $this->ceh->get('TRF_DISCOUNT A');
        return $stmt->result_array();
    }

    public function deleteTRFDiscount($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);
        $result['error'] = array();
        $result['success'] = array();

        foreach ($datas as $item) {
            $this->ceh->like('rowguid', $item)->delete('TRF_DISCOUNT');
            array_push($result['success'], 'Xóa thành công:'.$item);
            /*
                ->where('DiscountID', $item['DiscountID'])
                ->where('CusID', $item['CusID'])
                ->where('ApplyDate', $item['ApplyDate'])
                ->where('ExpireDate', $item['ExpireDate'])
                ->where('TRFCode', $item['TRFCode'])
                ->where('MethodID', $item['MethodID'])
                ->where('TransitID', $item['TransitID'])
                ->where('JobTypeID', $item['JobTypeID'])
                ->where('JobModeID', $item['JobModeID'])
                ->where('ClassID', $item['ClassID'])
                ->where('ServiceID', $item['ServiceID'])
                ->where('BrandID', $item['BrandID'])
                ->where('CarTypeID', $item['CarTypeID'])
                ->where('RateID', $item['RateID'])
                ->where('VAT', $item['VAT'])
                ->where('PaymentTypeID', $item['PaymentTypeID'])
            */
                
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

}