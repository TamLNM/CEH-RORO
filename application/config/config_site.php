<?php
	defined('BASEPATH') OR exit('');
	
	// UNICODE values
	define('UNICODE', 'UNICODE');

	$config['YARD_ID'] = "ITC";

	$config['EIR_NO_QUEUE'] = '';
	$config['APP_ID'] = 'VBILLING';
	$config['defaultLang'] = 'vietnamese';

	$config['TEMP_DRAFT_NO'] = '4170';

	$config['VNPT_SRV_ID'] = 'itchcmservice';
	$config['VNPT_SRV_PWD'] = '123456aA@';

	$config['VNPT_PUBLISH_INV_ID'] = 'itchcmadmin';
	$config['VNPT_PUBLISH_INV_PWD'] = 'aA@123456';

	$config['INV_PATTERN'] = '01GTKT0/001'; //
	$config['INV_SERIAL'] = 'SP/19E';

	$config["VNPT_TEST_MODE"] = "1";

	$config['xmlv1.2'] = '<?xml version="1.0" encoding="utf-8"?><soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope"><soap12:Body>XML_BODY</soap12:Body></soap12:Envelope>';


	//mail
	$config['SYS_MAIL_ADDR'] = 'no-reply@sp-itc.com.vn';
	$config['SYS_MAIL_PASS'] = 'NoSupport@123';
	$config['SYS_MAIL_HOST'] = 'mail.sp-itc.com.vn';
	$config['SYS_MAIL_PORT'] = '25';
?>
