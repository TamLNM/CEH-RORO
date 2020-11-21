<?php
defined('BASEPATH') OR exit('');

class job_model extends CI_Model
{
    private $ceh;
    private $UC = 'UNICODE';
    private $YardID = '';

     function __construct() {
        parent::__construct();
        $this->ceh = $this->load->database('mssql', TRUE);
    }
}