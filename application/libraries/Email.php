<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!class_exists("PHPMailer"))
require_once("include/PHPMailerAutoload.php");

class Email extends PHPMailer {
    public function __construct() {
        parent::__construct();
    }
}