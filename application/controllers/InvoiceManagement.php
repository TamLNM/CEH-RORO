<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceManagement extends CI_Controller {

    public $data;
    private $ceh;
    private $_responseXML = '';

    function __construct() {
        parent::__construct();

        if( empty($this->session->userdata('UserID')) && strpos( $this->uri->uri_string(), md5( 'downloadInvPDF' ) ) === false ){
            redirect(md5('user') . '/' . md5('login'));
        }
        
        $this->load->model("task_model", "mdltask");
        $this->load->model("order_model", "mdlOrder");

        $this->ceh = $this->load->database('mssql', TRUE);
    }

    public function _remap($method) {
        $methods = get_class_methods($this);

        $skip = array("_remap", "__construct", "get_instance");
        $a_methods = array();

        if(($method == 'index')) {
            $method = md5('index');
        }

        foreach($methods as $smethod) {
            if (!in_array($smethod, $skip)) {
                $a_methods[] = md5($smethod);
                if($method == md5($smethod) || $method == $smethod) {
                    $this->$smethod();
                    break;
                }
            }
        }

        if(!in_array($method, $a_methods)) {
            show_404();
        }
    }

    private function strReplaceAssoc(array $replace, $subject) {
        return str_replace(array_keys($replace), array_values($replace), $subject);
    }
    
    private function newGuid()
    {
        $data = openssl_random_pseudo_bytes( 16 );
        $data[6] = chr( ord( $data[6] ) & 0x0f | 0x40 ); // set version to 0100
        $data[8] = chr( ord( $data[8] ) & 0x3f | 0x80 ); // set bits 6-7 to 10

        return vsprintf( '%s%s-%s-%s-%s-%s%s%s', str_split( bin2hex( $data ), 4 ) );
    }

    public function ccurl($funcname, $servicename, $xmlbody) {
        try
        {
            $test_mode = $this->config->item("VNPT_TEST_MODE");
            $subdomain = ($test_mode == "1") ? "itchcmadmindemo" : "itchcmadmin";

            $headers = array(
                "Content-Type: application/soap+xml;charset=UTF-8",
                'SOAPAction: "http://tempuri.org/'.$funcname.'"',
                "Host: $subdomain.vnpt-invoice.com.vn"
            );

            $xml12 = $this->config->item('xmlv1.2');
//            $xmlfomart = htmlentities($xml);
            $xmlsend = str_replace('XML_BODY', $xmlbody , $xml12);

            $curlOptions = array(
                CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
                CURLOPT_TIMEOUT => 120, // timeout on response
                CURLOPT_URL => "https://$subdomain.vnpt-invoice.com.vn/$servicename.asmx",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $xmlsend
            );
            
            $curl = curl_init();
            curl_setopt_array($curl, $curlOptions);
            $this->_responseXML = curl_exec($curl); //??? -> _responseXML = false??

            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if((int)$http_code != 200 || !$this->_responseXML){
                $this->data['error'] = 'Thất bại: Giao dịch với Hệ Thống Hóa Đơn Điện Tử!';
                return false;
            }

            // if (!curl_errno($curl)) {
            //     $info = curl_getinfo($curl);
            //     log_message('error', $info['total_time'].' seconds to send a request to '.$info['url']."\n");
            // }

        }catch (Exception $e){
            $this->data['error'] = $e->getMessage();
        }
        return true;
    }

    public function importAndPublish(){
        $datas = $this->input->post('datas') ? $this->input->post('datas') : array();
        $cusTaxCode = $this->input->post('cusTaxCode') ? $this->input->post('cusTaxCode') : '';
        $cusAddr = $this->input->post('cusAddr') ? htmlspecialchars($this->input->post('cusAddr')) : '';
        $cusName = $this->input->post('cusName') ? htmlspecialchars($this->input->post('cusName')) : '';
        $sum_amount = $this->input->post('sum_amount') ? (int)str_replace(",", "", $this->input->post('sum_amount')) : '';
        $vat_amount = $this->input->post('vat_amount') ? (int)str_replace(",", "", $this->input->post('vat_amount')) : '';
        $total_amount = $this->input->post('total_amount') ? (int)str_replace(",", "", $this->input->post('total_amount')) : '';

        /*
        $inv_type = $this->input->post('inv_type') ? $this->input->post('inv_type') : 'VND';
        $exchange_rate = $this->input->post('exchange_rate') ? (float)str_replace(",", "", $this->input->post('exchange_rate')) : '';

        $currencyInDetails = isset( $datas[0]["C URRENCYID"] ) ? $datas[0]["CURRENCYID"] : "VND";

        if( $inv_type == $currencyInDetails )
        {
            $exchange_rate = '';
        }

        if( $exchange_rate != '' ){
            $sum_amount = $sum_amount * $exchange_rate;
            $total_amount = $total_amount * $exchange_rate;
            $vat_amount = $vat_amount * $exchange_rate;
        }

        $dvt = $inv_type == "VND" ? " đồng" : " đô la Mỹ"; */

        $dvt = " đồng";
        $amount_in_words = $this->funcs->convert_number_to_words($total_amount);
        $amount_in_words .= $dvt;
        $amount_in_words = htmlspecialchars($amount_in_words);
        
        /**/
        $exchange_rate = 0;
        $inv_type = 'VND';
        /**/

        $pincode = $this->mdltask->generatePinCode()[0];
        
        $invData = <<<EOT
                <Inv>
                    <key>$pincode</key>
                    <Invoice>
                        <CusCode>$cusTaxCode</CusCode>
                        <CusName>$cusName</CusName>
                        <CusAddress>$cusAddr</CusAddress>
                        <CusPhone></CusPhone>
                        <CusTaxCode>$cusTaxCode</CusTaxCode>
                        <PaymentMethod>TM/CK</PaymentMethod>
                        <KindOfService></KindOfService>
                        <Products>
                            PRODUCT_CONTENT
                        </Products>
                        <Total>$sum_amount</Total>
                        <VATRate>10</VATRate>
                        <VATAmount>$vat_amount</VATAmount>
                        <Amount>$total_amount</Amount>
                        <AmountInWords>$amount_in_words</AmountInWords>
                        <DiscountAmount>$exchange_rate</DiscountAmount>
                        <Extra1>$inv_type</Extra1>
                    </Invoice>
                </Inv>
EOT;

        $product_content = <<<EOT
                <Product>
                    <ProdName>TRFDesc</ProdName>
                    <ProdUnit>UnitID</ProdUnit>
                    <ProdQuantity>CargoWeight</ProdQuantity>
                    <ProdPrice>Price</ProdPrice>
                    <Amount>Total</Amount>
                </Product>
EOT;
        
        $strFinal = '';
        foreach ($datas as $item) { //UNIT_AMT
            if(is_array($item)){
                $temp = $item['TRFDesc'];

                /*
                $sz = isset( $item["ISO_SZTP"] ) ? $this->getContSize( $item["ISO_SZTP"] ) : ( isset( $item["SZ"] ) ? $item["SZ"] : '' );

                if( $sz != '' ){
                    $temp .= " (".$sz.$item['FE'].")";
                }
                */

                //encode content of TRF_DESC because it contain <,> ..
                $item['TRFDesc'] = htmlspecialchars( $temp ); // VIE -> add function

                //$item['UNIT_RATE'] = (int)str_replace(",", "", $item['UNIT_RATE']);
                $item['RateID'] = (int)str_replace(",", "", $item['RateID']);

                //$item['AMT'] = (int)str_replace(",", "", $item['AMOUNT']);
                //unset($item['AMOUNT']);
                $item['Price'] = (int)str_replace(",", "", $item['Price']);

                $strFinal .= $this->strReplaceAssoc($item, $product_content);
            }
        }

        if($strFinal == ''){
            $this->data['results'] = "nothing to publish";
            echo json_encode($this->data);
            exit;
        }

        $xmlInvData = "<![CDATA[<Invoices>".str_replace("PRODUCT_CONTENT", $strFinal, $invData)."</Invoices>]]>";

        $p_acc = $this->config->item('VNPT_PUBLISH_INV_ID');
        $p_pwd = $this->config->item('VNPT_PUBLISH_INV_PWD');

        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        $inv_pattern = $this->config->item('INV_PATTERN');
        $inv_serial = $this->config->item('INV_SERIAL');

        $xmlphrase = <<<EOT
                <ImportAndPublishInv xmlns="http://tempuri.org/">
                    <Account>$p_acc</Account>
                    <ACpass>$p_pwd</ACpass>
                    <xmlInvData>INV_CONTENT</xmlInvData>
                    <username>$srv_acc</username>
                    <password>$srv_pwd</password>
                    <pattern>$inv_pattern</pattern>
                    <serial>$inv_serial</serial>
                    <convert>0</convert>
                </ImportAndPublishInv>
EOT;

        $xmlbody = str_replace("INV_CONTENT", $xmlInvData, $xmlphrase);
        //remove all space between tag
        $xmlbody = preg_replace('/(\>)(\s)+(\<)/','$1$3', $xmlbody);
        
        $isSuccess = $this->ccurl("ImportAndPublishInv", "PublishService", $xmlbody);
        if( $isSuccess ){
            $responseContent = $this->getResultData("ImportAndPublishInv");
            $responses = explode(":", $responseContent);
            if(count($responses) > 0){
                if($responses[0] == "ERR"){
                    $this->data['error'] = $this->getERR_ImportAndPublish($responses[1]);
                }elseif($responses[0] == "OK"){
                    $invinfo = explode(";", $responses[1]);

                    if( count( $invinfo ) > 0 ){
                        $this->data['pattern'] = $invinfo[0];
                        $this->data['serial'] = explode("-", $invinfo[1])[0];
                        $this->data['fkey'] = $pincode;
                        $this->data['invno'] = explode("_", $invinfo[1])[1];
                        if($this->data['fkey']){
                            $this->confirmPaymentFkey($this->data['fkey']);
                        }
                    }
                }
            }else{
                $this->data['error'] = $responseContent;
            }
        }

        echo json_encode($this->data);
        exit;
    }

    public function downloadInvPDF(){
        $pattern = $this->input->get('pattern') ? $this->input->get('pattern') : '';
        $serial = $this->input->get('serial') ? $this->input->get('serial') : '';
        $number = $this->input->get('number') ? $this->input->get('number') : '';
        $fkey = $this->input->get('fkey') ? $this->input->get('fkey') : '';

        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        $funcName = $fkey != "" ? "downloadInvPDFFkey" : "downloadInvPDF";
        $tagFindingInfo = $fkey != "" ? "<fkey>$fkey</fkey>" : "<token>$pattern;$serial;$number</token>";
        $xmlcontent = <<<EOT
        <$funcName xmlns="http://tempuri.org/">
          $tagFindingInfo
          <userName>$srv_acc</userName>
          <userPass>$srv_pwd</userPass>
        </$funcName>
EOT;
        $isSuccess = $this->ccurl($funcName, "PortalService", $xmlcontent);
        if($isSuccess){
            $responseContent = $this->getResultData($funcName);

            $errContent = '';
            switch ($responseContent) {
                case 'ERR:1':
                    $errContent = "Tài khoản đăng nhập sai!";
                    break;
                case 'ERR:6':
                    $errContent = "Không tìm thấy hóa đơn";
                    break;
                case 'ERR:7':
                    $errContent = "User name không phù hợp, không tìm thấy company tương ứng cho user.";
                    break;
                case 'ERR:11':
                    $errContent = "Hóa đơn chưa thanh toán nên không xem được";
                    break;
                case 'ERR:':
                    $errContent = "Lỗi khác!";
                    break;
            }

            if( $errContent != '' ){
                echo "<div style='width: 100vw;text-align: center;margin: -8px 0 0 -8px;font-weight: 600;font-size: 27px;color: white;background-color:#614040;line-height: 2;'>".$errContent."</div>";
                exit();
            }

            $name = $fkey != "" ? "$fkey.pdf" : "$number.pdf";
            $content = base64_decode($responseContent);
            header('Content-Type: application/pdf');
            header('Content-Length: '.strlen( $content ));
            header('Content-disposition: inline; filename="' . $name . '"');
            echo $content;
        }
        else{
            echo $this->_responseXML;
        }
    }

    public function confirmPayment(){
        $fkeys = $this->input->post('fkeys') ? $this->input->post('fkeys') : '';
        $this->confirmPaymentFkey($fkeys);

        echo json_encode($this->data);
        exit;
    }

    public function cancelInv(){
        $fkey = $this->input->post('fkey') ? $this->input->post('fkey') : '';
        
        $p_acc = $this->config->item('VNPT_PUBLISH_INV_ID');
        $p_pwd = $this->config->item('VNPT_PUBLISH_INV_PWD');
        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        // bỏ gạch nợ hóa đơn trước khi hủy hóa đơn đó
        $isUnConfirm = $this->unConfirmPaymentFkey( $fkey, $srv_acc, $srv_pwd );
        if( !$isUnConfirm ){
            echo json_encode( $this->data );
            exit;
        }

        $xmlcontent = <<<EOT
        <cancelInv xmlns="http://tempuri.org/">
            <Account>$p_acc</Account>
            <ACpass>$p_pwd</ACpass>
            <fkey>$fkey</fkey>
            <userName>$srv_acc</userName>
            <userPass>$srv_pwd</userPass>
        </cancelInv>
EOT;
        $isSuccess = $this->ccurl("cancelInv", "BusinessService", $xmlcontent);
        
        if( $isSuccess ){
            $responseContent = $this->getResultData("cancelInv");
            $responses = explode(":", $responseContent);

            if( count( $responses ) > 0 ){
                if( $responses[0] == "ERR" ){
                    $this->data['error'] = $this->getERR_CancelInv( $responses[1] );
                }else{
                    $this->data['success'] = true;
                }
            }else{
                $this->data['error'] = $responseContent;
            }
        }

        echo json_encode( $this->data );
        exit;
    }

    public function confirmPaymentFkey($fkeys){
        $srv_acc = $this->config->item('VNPT_SRV_ID');
        $srv_pwd = $this->config->item('VNPT_SRV_PWD');

        $strfkey = is_array($fkeys) ? implode("_", $fkeys) : $fkeys;
        $xmlphrase = <<<EOT
                <confirmPaymentFkey xmlns="http://tempuri.org/">
                  <lstFkey>$strfkey</lstFkey>
                  <userName>$srv_acc</userName>
                  <userPass>$srv_pwd</userPass>
                </confirmPaymentFkey>
EOT;
        $isSuccess = $this->ccurl("confirmPaymentFkey", "BusinessService", $xmlphrase);
        if($isSuccess){
            $responseContent = $this->getResultData("confirmPaymentFkey");
            if (strpos($responseContent, 'ERR') != false) {
                $this->data['error'] = $this->getERR_ConfirmPaymentFkey(explode(":", $responseContent)[1]);
            }elseif(strpos($responseContent, 'OK') != false){
                $this->data['error'] = $responseContent;
            }
        }
    }

    private function unConfirmPaymentFkey( $fkeys, $srv_acc, $srv_pwd ){
        $strfkey = is_array($fkeys) ? implode("_", $fkeys) : $fkeys;
        $xmlphrase = <<<EOT
                <UnConfirmPaymentFkey xmlns="http://tempuri.org/">
                  <lstFkey>$strfkey</lstFkey>
                  <userName>$srv_acc</userName>
                  <userPass>$srv_pwd</userPass>
                </UnConfirmPaymentFkey>
EOT;
        $isSuccess = $this->ccurl("UnConfirmPaymentFkey", "BusinessService", $xmlphrase);

        $resultString = "";
        if( $isSuccess ){
            $responseContent = $this->getResultData("UnConfirmPaymentFkey");

            $errContent = '';
            switch ($responseContent) {
                case "ERR:1":
                    $errContent = "Tài khoản đăng nhập sai";
                    break;
                case "ERR:6": $errContent = "Không tìm thấy hóa đơn tương ứng chuỗi đưa vào";
                    break;
                case "ERR:7": $errContent = "Không bỏ gạch nợ được";
                    break;
            }
        }

        if( $resultString != '' ){
            $this->data["error"] = $resultString;
            return FALSE;
        }else{
            return TRUE;
        }
    }

    private function getResultData($funcname){
        if(!$this->_responseXML || $this->_responseXML == ""){
            return "";
        }
        $funcresult = $funcname."Result";
        $regx = <<<EOT
        /\<$funcresult\>(.*)\<\/$funcresult\>/
EOT;

        preg_match($regx, $this->_responseXML , $result);
        return count($result) > 1 ? $result[1] : "";
    }

    private function getERR_ImportAndPublish($errnumber){
        $result = '';
        switch($errnumber){
            case "1":
                $result = "Tài khoản đăng nhập sai hoặc không có quyền thêm khách hàng";
                break;
            case "3": $result = "Dữ liệu xml đầu vào không đúng quy định";
                break;
            case "7": $result = "User name không phù hợp, không tìm thấy company tương ứng cho user.";
                break;
            case "20": $result = "Pattern và serial không phù hợp, hoặc không tồn tại hóa đơn đã đăng kí có sử dụng Pattern và serial truyền vào";
                break;
            case "5": $result = "Không phát hành được hóa đơn.";
                break;
            case "10": $result = "Lô có số hóa đơn vượt quá max cho phép";
                break;
        }
        return $result;
    }

    private function getERR_ConfirmPaymentFkey($errnumber){
        $result = '';
        switch($errnumber){
            case "1":
                $result = "Tài khoản đăng nhập sai";
                break;
            case "6": 
                $result = "Không tìm thấy hóa đơn tương ứng chuỗi đưa vào";
                break;
            case "7": 
                $result = "Không gạch nợ được";
                break;
            case "13": 
                $result = "Hóa đơn đã được gạch nợ";
                break;
        }
        return $result;
    }

    private function getERR_CancelInv($errnumber){
        $result = '';

        switch( $errnumber ){
            case "1":
                $result = "Tài khoản đăng nhập sai";
                break;
            case "2": $result = "Không tồn tại hóa đơn cần hủy";
                break;
            case "8": $result = "Hóa đơn đã được thay thế rồi, hủy rồi";
                break;
            case "9": $result = "Trạng thái hóa đơn ko được hủy";
                break;
            default: $result = "[$errnumber] Unknown error";
        }

        return $result;
    }

    private function getContSize( $sztype ){
        if( !isset( $sztype ) ){
            return "";
        }

        switch(substr($sztype,0,1)){
            case "2":
                return 20;
            case "4":
                return 40;
            case "L":
            case "M":
            case "9":
                return 45;
            default: return "";
        }

        return "";
    }
}
