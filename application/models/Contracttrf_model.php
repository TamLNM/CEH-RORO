<?php
defined('BASEPATH') OR exit('');

class Contracttrf_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $yard_id = '';

    function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
        $this->yard_id = $this->config->item('YARD_ID');
    }

    public function contractTemplate(){
        $this->ceh->select('NICK_NAME, OPR, LANE, PAYER_TYPE, PAYER, APPLY_DATE, PAYMENT_TYPE, REF_RMK');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('NICK_NAME', 'ASC');
        $stmt = $this->ceh->get('TRF_DIS');
        $stmt = $stmt->result_array();
        $result = array();
        foreach ($stmt as $item) {
            $ptemp = '';
            if(is_array($item)){
                foreach ($item as $n) {
                    $ptemp .= ($n === null) ? ":" : "$n:";
                }
            }
            array_push($result, substr($ptemp, 0, -1));

        }
        return array_unique($result);
    }

    public function loadTRFSource(){
        return $this->ceh->select("TRF_CODE, TRF_DESC")
                            ->where('YARD_ID', $this->yard_id)
                            ->get("TRF_CODES")->result_array();
    }

    public function loadTariffCodes(){
        return $this->ceh->where('YARD_ID', $this->yard_id)
                            ->get("TRF_CODES")
                            ->result_array();
    }

    public function tarrifTemplate(){
        $this->ceh->select('FROM_DATE, TO_DATE, NOTE');

        $this->ceh->where('YARD_ID', $this->yard_id);

        $this->ceh->order_by('FROM_DATE', 'DESC');
        $stmt = $this->ceh->get('TRF_STD');
        $stmt = $stmt->result_array();
        $result = array();
        foreach ($stmt as $item) {
            $ptemp = '';
            if(is_array($item)){
                foreach ($item as $n) {
                    $ptemp .= ($n === null) ? "-" : "$n-";
                }
            }
            array_push($result, substr($ptemp, 0, -1));

        }
        return array_unique($result);
    }

    public function loadTariffStandard($tariffTemp){
        $this->ceh->select('rowguid, TRANSIT_CD ,DMETHOD_CD , TRF_CODE ,IX_CD ,CARGO_TYPE ,JOB_KIND ,CNTR_JOB_TYPE ,CURRENCYID ,IsLocal ,AMT_F20 ,AMT_E20
                            , AMT_F40 ,AMT_E40, AMT_F45 ,AMT_E45 ,AMT_NCNTR ,VAT ,TRF_STD_DESC ,FROM_DATE ,TO_DATE ,NOTE ,INCLUDE_VAT
                            , FROM_DATE, TO_DATE');
        // $this->ceh->join('TRF_CODES t','t.TRF_CODE = ts.TRF_CODE');
        // $this->ceh->join('DELIVERY_MODE dm','dm.CJMode_CD = ts.CNTR_JOB_TYPE', 'left');

        $temp = explode("-", $tariffTemp);
        $fwhere = array(
            "FROM_DATE" => $temp[0] == "" ? null : $temp[0],
            "TO_DATE" => $temp[1] == "" ? null : $temp[1]
        );

        $stmt = $this->ceh->where($fwhere)->where("YARD_ID", $this->yard_id)->get('TRF_STD');
        return $stmt->result_array();
    }

    public function loadContract($contractTemp){
        $temp = explode(":", $contractTemp);
        $fwhere = array(
            "NICK_NAME" => $temp[0] == "" ? null : $temp[0],
            "OPR" => $temp[1],
            "LANE" => $temp[2],
            "PAYER_TYPE" => $temp[3],
            "PAYER" => $temp[4],
            "APPLY_DATE" => $temp[5],
            "PAYMENT_TYPE" => $temp[6],

            "YARD_ID" => $this->yard_id
        );

        $stmt = $this->ceh->where($fwhere)->get('TRF_DIS');
        $stmt = $stmt->result_array();
        return $stmt;
    }


    //SAVE TRF_CODE
    public function saveTRFCode($datas){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if(isset($item['TRF_DESC'])){
                $item['TRF_DESC'] = UNICODE.$item['TRF_DESC'];
            }

            if($rguid != ''){
                $stmt =  $this->ceh->where('rowguid', $rguid)
                                    ->where('YARD_ID', $this->yard_id)
                                    ->get('TRF_CODES');

                $existItem = $stmt->row_array();
            }

            $item['YARD_ID'] = $this->yard_id;

            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if(count($existItem) > 0)
            {
                //update database
                $this->ceh->where('rowguid', $rguid)->limit(1)->update('TRF_CODES', $item);
            }
            else
            {
                $checkitem = $this->ceh->select("rowguid")
                                        ->where('TRF_CODE', $item['TRF_CODE'])
                                        ->where('YARD_ID', $item["YARD_ID"])
                                        ->limit(1)
                                        ->get('TRF_CODES')->result_array();

                if(count($checkitem) > 0){
                    $this->ceh->where('rowguid', $checkitem["rowguid"])->update('TRF_CODES', $checkitem);
                }else{
                    //insert database
                    $item['CreatedBy'] = $item['ModifiedBy'];
                    $this->ceh->insert('TRF_CODES', $item);
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

    //SAVE TRF_STD
    public function saveTariffSTD($datas, $applyDate, $expireDate, $ref_mark){
        $this->ceh->trans_start();
        $this->ceh->trans_strict(FALSE);

        foreach ($datas as $key => $item) {
            $rguid = $item['rowguid'];
            unset($item['rowguid']);
            $existItem = array();

            if(isset($item['TRF_STD_DESC'])){
                $item['TRF_STD_DESC'] = UNICODE.$item['TRF_STD_DESC'];
            }

            $item['YARD_ID'] = $this->yard_id;

            $where = array(
                "TRF_CODE" => $item["TRF_CODE"],
                "DMETHOD_CD" => $item["DMETHOD_CD"],
                "IX_CD" => $item["IX_CD"],
                "CARGO_TYPE" => $item["CARGO_TYPE"],
                "JOB_KIND" => $item["JOB_KIND"],
                "CNTR_JOB_TYPE" => $item["CNTR_JOB_TYPE"],
                "TRANSIT_CD" => $item["TRANSIT_CD"],
                "IsLocal" => $item["IsLocal"],
                "CURRENCYID" => $item["CURRENCYID"],
                "FROM_DATE" => $applyDate,
                "TO_DATE" => $expireDate,

                "YARD_ID" => $item["YARD_ID"]
            );

            $existsTRF = $this->ceh->select("COUNT(*) COUNT_TRF")->where($where)->get("TRF_STD")->row_array();

            $item["FROM_DATE"] = $applyDate;
            $item["TO_DATE"] = $expireDate;
            $item['NOTE'] = UNICODE.$ref_mark;
            $item['ModifiedBy'] = $this->session->userdata("UserID");
            $item['update_time'] = date('Y-m-d H:i:s');

            if($existsTRF["COUNT_TRF"] > 0)
            {
                //update database
                $this->ceh->where($where)->update('TRF_STD', $item);
            }
            else
            {
                //insert database
                $item['CreatedBy'] = $item['ModifiedBy'];
                $this->ceh->insert('TRF_STD', $item);
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
}