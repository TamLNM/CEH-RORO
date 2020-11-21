<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/third_party/phpqrcode/qrlib.php";

class Qrmaker {
    public function __construct() {
        
    }
    public function make_base64_url($code){
    	return 'data:image/png;base64,'.(base64_encode(QRcode::png($code)));
    }
    public function make_png($code,$file){
    	return QRcode::png($code,$file);
    }
}