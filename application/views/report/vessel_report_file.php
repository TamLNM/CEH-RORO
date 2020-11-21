<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="origin-when-crossorigin" id="meta_referrer" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?=$title;?></title>
    <!--    favicon-->
    <link rel="icon" href="<?=base_url('assets/img/icons/favicon.ico');?>" type="image/ico">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="<?=base_url('assets/vendors/jquery-ui/jquery-ui.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/line-awesome/css/line-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/themify-icons/css/themify-icons.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.css');?>" rel="stylesheet" />

    <!-- PLUGINS STYLES-->
    <link href="<?=base_url('assets/vendors/dataTables/datatables.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/vendors/dataTables/jquery.dataTables.min.css');?>" rel="stylesheet" />
    <!--    DATATABLES SCROLL-->
    <link href="<?=base_url('assets/vendors/dataTables/scroller.dataTables.min.css');?>" rel="stylesheet" />

    <link href="<?=base_url('assets/vendors/toastr/toastr.min.css');?>" rel="stylesheet" type="text/css" />

    <!--    CUSTOMIZE FOR DATATABLES-->
    <link href="<?=base_url('assets/css/custom.datatables.css');?>" rel="stylesheet" />

    <!-- THEME STYLES-->
    <link href="<?=base_url('assets/css/main.min.css');?>" rel="stylesheet" />
    <link href="<?=base_url('assets/css/ro2.css');?>" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
	
	<!-- CORE PLUGINS-->
    <script src="<?=base_url('assets/vendors/popper.js/dist/umd/popper.min.js');?>"></script>
    
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery/dist/jquery2-1-4.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-ui/jquery-ui.js');?>"></script>
    <script src="<?=base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/metisMenu/dist/metisMenu.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/jquery-confirm/jquery-confirm.min.js');?>"></script>

    <script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
    
    <script src="<?=base_url('assets/js/contextmenu.js');?>"></script>

    <link href="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.css');?>" rel="stylesheet" />
    <script src="<?=base_url('assets/vendors/datetimepicker/jquery-ui-timepicker-addon.js');?>"></script>

    <!--    custom for eblling js-->
    <script src="<?=base_url('assets/js/ro2.js');?>"></script>
    <script src="<?=base_url('assets/js/datatables.ext.js');?>"></script>
    
    <!-- PAGE LEVEL PLUGINS-->
    <script src="<?=base_url('assets/vendors/dataTables/datatables.min.js');?>"></script>

    <!--    TABLES SCROLL-->
    <script src="<?=base_url('assets/vendors/dataTables/dataTables.scroller.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/key_table.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/mindmup-editabletable.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/numeric-input-example.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/autofill.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/scroller.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/select.min.js');?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/vendors/dataTables/extensions/buttons.min.js');?>"></script>

    <!-- Toastr js -->
    <script src="<?=base_url('assets/vendors/toastr/toastr.min.js');?>"></script>

    <!-- Loader -->
    <script src="<?=base_url('assets/vendors/loaders/blockui.min.js');?>"></script>
    <script src="<?=base_url('assets/vendors/loaders/progressbar.min.js');?>"></script>

    <!-- Socket -->
    <script src="<?=base_url('/sockets/node_modules/socket.io-client/dist/socket.io.js');?>"></script>

    <script type="text/javascript">
        var socket = io.connect('https://demororo.cehsoft.com/');
    </script>
	
	<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />

	<style>
		body {
		  background: rgb(204,204,204); 
		}
		page {
			background: white;
			display: block;
			margin: 0 auto;
			margin-bottom: 0.5cm;
			box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
			font-family: 'Times New Roman';
		}
		page[size="A4"] {  
		  width: 21cm;
		  height: 29.7cm; 
		}
		page[size="A4"][layout="landscape"] {
		  width: 29.7cm;
		  height: 21cm;  
		}
		page[size="A3"] {
		  width: 29.7cm;
		  height: 42cm;
		}
		page[size="A3"][layout="landscape"] {
		  width: 42cm;
		  height: 29.7cm;  
		}
		page[size="A5"] {
		  width: 14.8cm;
		  height: 21cm;
		}
		page[size="A5"][layout="landscape"] {
		  width: 21cm;
		  height: 14.8cm;  
		}
		@media print {
			body, page {
		    	margin: 0;
		    	box-shadow: 0;
			}
		}
		.title{
			text-align: center;
		}
		table {
			border-collapse: collapse;
		 	border: 2px solid black;
		 	margin-top: 10px;
		 	margin-bottom: 10px;
		}
		th, td {
		 	border: 1px solid black;
		 	padding-top: 5px;
		 	padding-bottom: 5px;
		}
	</style>
</head>

<page size="A4" class="col-12">
	<div class="row">
		<div class="col-4">
			<div class="row form-group" style="text-align: center;">
				<div style="margin-left: auto; margin-right: auto">
					<img id="btn-search-ship" class="pointer" src="<?=base_url('assets/img/Logo_CEH.jpg');?>" style="margin-top: 15px; cursor: pointer; width: 70%; height: 80%" title="CEH"/>
				</div>
			</div>
		</div>
		<div class="col-8">
			<div class="row form-group">
				<div style="margin-left: auto; margin-right: auto; text-align: center;">
					CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM<br>
					VIETNAM SOCIALIST REPUBLIC<br>
					Độc lập - Tự do - Hạnh phúc<br>
					<span style="border-bottom: solid 1px #000000; padding-bottom: 7px;">Independence - Freedom - Hapiness</span><br>
				</div>
			</div>
		</div>
		<div class="col-12 mt-3 mb-2">
			<div class="row form-group" >	
				<div style="margin-left: auto; margin-right: auto; text-align: center;">
					<span id="mainTittle" style="font-size: 18px; font-weight: bold"></span><br>
					<span style="font-size: 15px;">REPORT ON RECEIPT OF CARGO</span>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="row ml-5">
				<label class="col-form-label ml-3">Tên tàu (Vessel Name): 
					<span style="font-size: 15px; font-weight: bold"><?=$VesselName;?></span><br>
			</div>
			<div class="row ml-5">
				<label class="col-form-label ml-3">
					Chuyến nhập (InboundVoyage): <b><?=$InboundVoyage;?></b><br>
				</label>
			</div>
			<div class="row ml-5">
				<label class="col-form-label ml-3">
					Cảng xếp hàng (POL): <b><?=$LastPort;?></b><br>
				</label>
			</div>
			<div class="row ml-5">
				<label class="col-form-label ml-3">
					Ngày đến (Commenced Discharging):<span style="margin-left: 10px;">
					<span id="ATA" style="font-weight: bold"></span><br>
				</label>
			</div>
		</div>
		<div class="col-6">
			<div class="row ml-5">
				<label class="col-form-label ml-3">Quốc tịch (Nationality): <b><?=$NationName;?></b><br></span></label>
			</div>
			<div class="row ml-5">
				<label class="col-form-label ml-3">
					Chuyến xuất (OutboundVoyage): <b><?=$OutboundVoyage;?></b><br>
				</label>
			</div>
			<div class="row ml-5">
				<label class="col-form-label ml-3">
					Cảng bốc dở hàng (POD): <b><?=$NextPort;?></b><br>
				</label>
			</div>
			<div class="row ml-5">
				<label class="col-form-label ml-3">
					Ngày rời (Completed Discharging):<span style="margin-left: 10px;">
					<span id="ATD" style="padding-left: 50px; font-weight: bold;"></span><br>	
				</label>
			</div>
		</div>
		<div class="col-12 mt-3 mb-3">
			<table style="width: 100%">
				<tr>
					<td colspan="3" class="title"><b>SỐ LƯỢNG HÀNG GHI TRONG LƯỢNG KHAI<br>Number of packages mentioned in manifest</b></td>
					<td colspan="2" class="title"><b>SỐ LƯỢNG HÀNG THỰC NHẬN<br>Number of packages received</b></td>
				</tr>
				<tr>
					<td colspan="2" class="title" style="width: 29%;">Số ĐHVT<br>No. B/L (Booking)</td>
					<td class="title" style="width: 18%;">Trọng lượng dự kiến<br>Expected Weight</td>
					<td class="title" style="width: 18%;">Trọng lượng thực tế<br>Reality Weight</td>
					<td class="title">Mô tả<br>Description</td>
				</tr>
				<tr>
					<td colspan="2" style="padding-left: 5px;">
						<?php if ($numericIn > 0){ ?>
							<span style="font-weight: bold; font-size: 15px;">Nhập khẩu (Import)</span>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 1){
										echo($item->BillOfLading.' ('.$item->JobModeInID.')'.'<br>');
									}
								}
							} ?>
						<?php } ?>

						<?php if ($numericIn > 0 && $numericOut > 0){ 
							echo('<br>');
						}?>

						<?php if ($numericOut > 0){ ?>
							<span style="font-weight: bold; font-size: 15px;">Xuất khẩu (Export)</span><br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 2){
										echo($item->BookingNo.' ('.$item->JobModeInID.')'.'<br>');
									}
								}
							} ?>
						<?php } ?>

					</td>
					<td class="title">
						<?php if ($numericIn > 0){ ?>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 1){
										echo($item->ExpectedWeight.' '.$item->UnitID.'<br>');
									}
								}
							} ?>
						<?php } ?>

						<?php if ($numericIn > 0 && $numericOut > 0){ 
							echo('<br>');
						}?>

						<?php if ($numericOut > 0){ ?>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 2){
										echo($item->ExpectedWeight.' '.$item->UnitID.'<br>');
									}
								}
							} ?>
						<?php } ?>
					</td>
					<td class="title">
						<?php if ($numericIn > 0){ ?>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 1){
										echo($item->RealityWeight.' '.$item->UnitID.'<br>');
									}
								}
							} ?>
						<?php } ?>

						<?php if ($numericIn > 0 && $numericOut > 0){ 
							echo('<br>');
						}?>

						<?php if ($numericOut > 0){ ?>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 2){
										echo($item->RealityWeight.' '.$item->UnitID.'<br>');
									}
								}
							} ?>
						<?php } ?>
					</td>

					<td style="padding-left: 10px;">
						<?php if ($numericIn > 0){ ?>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 1){
										echo($item->CommodityDescription.'<br>');
									}
								}
							} ?>							
						<?php } ?>

						<?php if ($numericIn > 0 && $numericOut > 0){ 
							echo('<br>');
						}?>

						<?php if ($numericOut > 0){ ?>
							<br>
							<?php if(count($dataList) > 0) {
								foreach($dataList as $item) {
									if ($item->ClassID  == 2){
										echo($item->CommodityDescription.'<br>');
									}
								}
							} ?>
						<?php } ?>
					</td>
				</tr>
				<tr style="font-weight: bold">
					<td rowspan="2" style="text-align: center;"><b>TỔNG CỘNG<br>(TOTAL)</b></td>
					<td style="text-align: center">Nhập khẩu (Import)</td>
					<td class="title"><span id='totalExpectedWeightIn'></span></td>
					<td class="title"><span id='totalRealityWeightIn'></span></td>
					<td rowspan="2"></td>
				</tr>
				<tr style="font-weight: bold">
					<td style="text-align: center">Xuất khẩu (Export)</td>
					<td class="title"><span id='totalExpectedWeightOut'></span></td>
					<td class="title"><span id='totalRealityWeightOut'></span></td>
				</tr>
			</table>
			<div style="text-align: left;">
				<span style="font-style: italic">
					<u>* WEIGHT AND QUALITY OF CARGO SHOULD BE BASED ON DRAFT SURVEY REPORT</u>
				</span>
			</div>
			<div class="row pl-3">
				<span style="font-style: italic">
					<u>* ALL CARGO DISCHARGED BY SHORE CRANE</u>
				</span>
			</div>
		</div>
		<div class="col-6 mt-3" style="text-align: center;">
			<b>CONDITIONS AND EXCEPTIONS OF RECEIPT</b><br>
			* Cargo received as per number of packages in<br>
			apparent good condition without liability for contents<br>
			* Weight as per manifest (including cargo in bulk)<br>
			without liability for discrepancy<br>
			* Cargo outturn report hereattached, if any.<br>
		</div>
		<div class="col-6 mt-3" style="text-align: center;">
			<b>ĐIỀU KIỆN NHẬN HÀNG</b><br>
			* Hàng nhận theo số lượng kiện, bao bì nguyên vẹn<br>
			Không chịu trách nhiệm bên trong bao bì<br>
			* Trong lượng ghi theo lượt khai của tàu <br>
			(kể cả hàng rời), không chịu trách nhiệm về hao hụt<br>
			* Hàng hư hỏng có biên bản riêng
		</div>

		<div class="col-12 mt-3">
			<div class="row form-group">
				<div class="col-6" style="text-align: center">
					<label class="col-form-label" style="margin-left: auto; margin-right: 10px;" id="leftCurrentDate"></label><br>
					<b>Thuyền trưởng</b><br>
					<i>Ship's representative</i><br>
				</div>
				<div class="col-6" style="text-align: center">
					<label class="col-form-label" style="margin-left: auto; margin-right: 10px;" id="rightCurrentDate"></label><br>
					<b>Đại diện cảng</b><br>
					<i>Docks office's representative</i>
				</div>
			</div>
		</div>
	</div>
</page>

<script type="text/javascript">
	$(document).ready(function () {
		var dataList = {},
			currenDate = new Date(),
			year = currenDate.getFullYear(),
            month = currenDate.getMonth() + 1,
            day = currenDate.getDate(),
            totalExpectedWeightIn = 0,
            totalRealityWeightIn = 0,
            totalExpectedWeightOut = 0,
            totalRealityWeightOut = 0,
            ClassID,
            ATA
            ATD;

		<?php if(isset($dataList) && count($dataList) >= 0){?>
			dataList = <?= json_encode($dataList);?>;
		<?php } ?>

		<?php if(isset($ClassID) && count($ClassID) >= 0){?>
			ClassID = <?= json_encode($ClassID);?>;
		<?php } ?>

		<?php if(isset($ATA) && count($ATA) >= 0){?>
			ATA = <?= json_encode($ATA);?>;
		<?php } ?>

		<?php if(isset($ATD) && count($ATD) >= 0){?>
			ATD = <?= json_encode($ATD);?>;
		<?php } ?>

		for (i = 0; i < dataList.length; i++){
			if (dataList[i]['ClassID'] == 1){
				totalExpectedWeightIn += parseInt(dataList[i]['ExpectedWeight']);
				totalRealityWeightIn  += parseInt(dataList[i]['RealityWeight']);
			}
			else{
				totalExpectedWeightOut += parseInt(dataList[i]['ExpectedWeight']);
				totalRealityWeightOut  += parseInt(dataList[i]['RealityWeight']);
			}
		}
			

		$("#mainTittle").text('BIÊN BẢN KẾT TOÁN HÀNG VỚI TÀU');

		var str = 'HCMC, ';
		switch(day){
			case 1:
			case 21:
				str += (day + 'st ');
				break;
			case 2:
			case 22:
				str += (day + 'nd ');
				break;
			case 3:
			case 23: 
				str += (day + 'rd ');
				break;
			default:
				str += (day +'th ');
				break;
		}

		switch(month){
			case 1:
				str += 'Jan';
				break;
			case 2:
				str += 'Feb';
				break;
			case 3:
				str += 'Mar';
				break;
			case 4:
				str += 'Apr';
				break;
			case 5:
				str += 'Mar';
				break;
			case 6:
				str += 'Jun';
				break;
			case 7:
				str += 'Jul';
				break;
			case 8:
				str += 'Aug';
				break;
			case 9:
				str += 'Sep';
				break;
			case 10:
				str += 'Oct';
				break;
			case 11:
				str += 'Nov';
				break;
			case 12:
				str += 'Dec';
				break;
		}
		str += (' ' + year);
		$("#leftCurrentDate, #rightCurrentDate").text(str);
		$("#totalExpectedWeightIn").text(totalExpectedWeightIn + ' TNE');
		$("#totalRealityWeightIn").text(totalRealityWeightIn + ' TNE');
		$("#totalExpectedWeightOut").text(totalExpectedWeightOut + ' TNE');
		$("#totalRealityWeightOut").text(totalRealityWeightOut + ' TNE');

		if (ATA != -1){
			$("#ATA").text(ATA.slice(8, 10) + '/' + ATA.slice(5,7) + '/' + ATA.slice(0,4));
		}

		if (ATD != -1){
			console.log(ATD);
			$("#ATD").text(ATD.slice(8, 10) + '/' + ATD.slice(5,7) + '/' + ATD.slice(0,4));
		}
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>