<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />

<style>
	@media (max-width: 767px) {
		.f-text-right    {
			text-align: right;
		}
	}
	.no-pointer{
		pointer-events: none;
	}
	.tabVesselVisitNotSelected{
		border: 2px solid #f1f1f1;
		border-radius: 5px; 	
		background-color: #ffffff;
		color: #c9c9c9;
	}
	.tabVesselVisitSelected{
		border: 2px solid #418fb9;
	  	border-radius: 5px;	
		background-color: #418fb9;
		color: #ffffff;
		font-weight: bold;
	}
	.nav-tabs{
		margin-bottom: 0!important;
		border-bottom: none!important;
	}

    .nav-tabs .nav-link.active{
    	color: #0b4660 !important;
    	font-weight: 600!important;
    	font-size: 16px!important;
    }

    .nav-tabs .nav-link{
    	font-size: 15px!important;
    }
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">KẾ HOẠCH TÀU</div>
				<div class="button-bar-group mr-3">				
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" 
										title="Khởi tạo lại form trống">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm mới</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1"
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu"
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>

					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dòng"
										title="Xóa những dòng đang chọn">
						<span class="btn-icon"><i class="fa fa-trash"></i>Xóa dòng</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-3 pb-0 bg-f9 border-e">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<ul class="nav nav-tabs">
	                        <li class="nav-item">
	                            <a class="nav-link active" href="#tab-vessel-visit-planning" data-value="tab-vessel-visit-planning" data-toggle="tab"><i class="mr-2"></i>KẾ HOẠCH TÀU CẬP BẾN</a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" href="#tab-vessel-visit-confirm" data-value="tab-vessel-visit-confirm" data-toggle="tab"><i class="mr-2"></i>XÁC NHẬN TÀU CẬP BẾN</a>
	                        </li>
	                    </ul>
					</div>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-vessel-visit-planning">
						<div class="row border-e has-block-content bg-white pb-1">
							<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-3">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row form-group" style="height: 50px">
										<input id="VoyageKey" hidden class="form-control form-control-sm" placeholder="Mã chuyến tàu" type="text">
										<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Mã tàu</label>
										<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Hãng tàu</label>		
										<!--
										<select id="VesselID" class="selectpicker col-md-6 col-sm-6 col-xs-6" data-width="100%" data-style="btn-default btn-sm" title="Mã tàu">
											<?php if(count($vesselList) > 0)?>
												<?php foreach($vesselList as $item) {  ?>
													<option value="<?=$item['VesselID']?>"><?=$item['VesselID'];?></option>
											<?php }?>
										</select>
										-->
										<div class="col-md-6 col-sm-6 col-xs-6">											
											<div class="input-group">
												<input class="form-control form-control-sm" id="VesselID" type="text" placeholder="Mã tàu">
												<span class="input-group-addon bg-white btn text-warning" id="chooseVessel" title="Chọn" data-toggle="modal" data-target="" style="padding: 0 .5rem"><i class="fa fa-search"></i></span>
											</div>
										</div>

										<div class="col-md-6 col-sm-6 col-xs-6">
											<input id="OprID" hidden class="form-control form-control-sm" type="text">
											<input id="OprName" style="background-color: #f1f1f1" class="form-control form-control-sm" placeholder="Hãng khai thác" type="text">
										</div>
									</div>
									<div class="row form-group" style="height: 50px">
										<label class="col-md-8 col-sm-8 col-xs-8 col-form-label">Tên tàu</label>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<input id="VesselName" class="form-control form-control-sm" placeholder="Tên tàu" type="text" style="background-color: #f1f1f1">
										</div>
									</div>
									<div class="row form-group" style="height: 50px">
										<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">IMO</label>
										<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Bến</label>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<input id="IMO" class="form-control form-control-sm" placeholder="IMO" type="text"style="background-color: #f1f1f1">
										</div>
										<select id="BerthID" class="selectpicker col-md-6 col-sm-6 col-xs-6" data-width="100%" data-style="btn-default btn-sm" title="Mã bến">
											<?php if(count($berthList) > 0)?>
												<?php foreach($berthList as $item) {  ?>
													<option value="<?=$item['BerthID']?>"><?=$item['BerthID'];?></option>
											<?php }?>
										</select>	
									</div>
									<form id='inputForm'><div class="row form-group" style="height: 50px">
										<label class="col-md-6 col-sm-6 col-xs-6 col-form-label pr-0">Chuyến nhập</label>
										<label class="col-md-6 col-sm-6 col-xs-6 col-form-label pr-0">Chuyến xuất</label>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<input id="InboundVoyage" class="form-control form-control-sm" placeholder="Chuyến nhập" type="text">
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<input id="OutboundVoyage" class="form-control form-control-sm" placeholder="Chuyến xuất" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
								<div class="row form-group" style="height: 50px">
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Bitt</label>
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Mạn cập</label>
									<select id="BittID" class="selectpicker col-md-6 col-sm-6 col-xs-6" data-width="100%" data-style="btn-default btn-sm" title="Mã bitt">
										<?php if(count($bittList) > 0)?>
											<?php foreach($bittList as $item) {  ?>
												<option value="<?=$item['BittID']?>"><?=$item['BittID'];?></option>
										<?php }?>
									</select>
									<div class="col-md-6 col-sm-6 col-xs-6 mt-1">
										<label class="radio radio-success">
                                               <input type="radio" checked style="margin-left: 10px" name="AlongSide" class="css-checkbox" value="L" />
                                                <span class="input-span"></span>Trái
                                        </label>	
                                        <label class="radio radio-success ml-3">
                                               <input type="radio" name="AlongSide" class="css-checkbox" value="R" />
                                                <span class="input-span"></span>Phải
                                        </label>										
									</div>
								</div>
								<div class="row form-group" style="height: 50px">
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Hành trình đến</label>
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Hành trình rời</label>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<select id="InLane" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hành trình đến">
											<?php if(count($laneList) > 0)?>
												<?php foreach($laneList as $item) {  ?>
													<option value="<?=$item['LaneID']?>"><?=$item['LaneName'];?></option>
											<?php }?>
										</select>
									</div>	
									<div class="col-md-6 col-sm-6 col-xs-6">
										<select id="OutLane" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Hành trình đến">
											<?php if(count($laneList) > 0)?>
												<?php foreach($laneList as $item) {  ?>
													<option value="<?=$item['LaneID']?>"><?=$item['LaneName'];?></option>
											<?php }?>
										</select>
									</div>
								</div>
								<div class="row form-group" style="height: 50px">
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Cảng trước</label>
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Cảng sau</label>
									<input hidden id="LastPortID" value="">
									<input hidden id="NextPortID" value="">
									<select id="LastPortName" class="selectpicker col-md-6 col-sm-6 col-xs-6" data-width="100%" data-style="btn-default btn-sm" title="Cảng trước">
										<?php if(count($portList) > 0)?>
											<?php foreach($portList as $item) {  ?>
												<option value="<?=$item['PortName']?>"><?=$item['PortName'];?></option>
										<?php }?>
									</select>
									<select id="NextPortName" class="selectpicker col-md-6 col-sm-6 col-xs-6" data-width="100%" data-style="btn-default btn-sm" title="Cảng sau">
										<?php if(count($portList) > 0)?>
											<?php foreach($portList as $item) {  ?>
												<option value="<?=$item['PortName']?>"><?=$item['PortName'];?></option>
										<?php }?>
									</select>		
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
								<div class="row form-group" style="height: 50px">
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">ETA</label>
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">ETB</label>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input id="ETA" class="form-control form-control-sm" placeholder="ETA">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input id="ETB" class="form-control form-control-sm" placeholder="ETB">
									</div>
								</div>	
								<div class="row form-group" style="height: 50px">
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">ETW</label>
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">ETC</label>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input id="ETW" class="form-control form-control-sm" placeholder="ETW">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input id="ETC" class="form-control form-control-sm" placeholder="ETC">
									</div>
								</div>		
								<div class="row form-group" style="height: 50px">
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">ETD</label>
									<label class="col-md-6 col-sm-6 col-xs-6 col-form-label pr-0">Ghi chú</label>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<input id="ETD" class="form-control form-control-sm" placeholder="ETD">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-6">
										<textarea id="Remark" rows="1" cols="50"></textarea>
									</div>
								</div>	
							</div>
						</div>
						<!-- -->
						<div class="row ibox-footer border-top-0 bg-white border-e mt-1">
							<div class="col-md-12 col-sm-12 col-xs-12 table-responsive pt-3">
								<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
									<thead>
										<tr>
											<th class="editor-cancel" col-name="STT">STT</th>
											<th col-name="VoyageKey">Voyage Key</th>
											<th col-name="VesselID">Mã tàu</th>
											<th col-name="VesselName">Tên tàu</th>
											<th col-name="OprID"></th>
											<th col-name="OprName">Hãng khai thác</th>
											<th col-name="IMO">IMO</th>
											<th col-name="InboundVoyage">Chuyến nhập</th>
											<th col-name="OutboundVoyage">Chuyến xuất</th>		
											<th col-name="BerthID">Bến</th>		
											<th col-name="BittID">Bitt</th>		
											<th col-name="AlongSide">Mạn cập</th>		
											<th col-name="InLane">Hành trình đến</th>		
											<th col-name="OutLane">Hành trình rời</th>		
											<th col-name="LastPortID"></th>		
											<th col-name="LastPortName">Cảng trước</th>
											<th col-name="NextPortID"></th>			
											<th col-name="NextPortName">Cảng sau</th>
											<th col-name="ETA" class="ETA">ETA</th>
											<th col-name="ETB" class="ETB">ETB</th>
											<th col-name="ETW" class="ETW">ETW</th>
											<th col-name="ETC" class="ETC">ETC</th>
											<th col-name="ETD" class="ETD">ETD</th>
											<th col-name="Remark">Ghi chú</th>
										</tr>
									</thead>
									<tbody>										
										<?php if(count($vesselVisitList) > 0) {
											  		$i = 1; ?>
											<?php foreach($vesselVisitList as $item){  ?>
												<?php if (!($item['Status']) || ($item['Status'] == 0)){ ?>
												<tr>
													<td col-name="STT"><?=$i;?></td>
													<td hidden col-name="VoyageKey"><?=$item['VoyageKey'];?></td>
													<td col-name="VesselID"><?=$item['VesselID'];?></td>
													<td col-name="VesselName"><?=$item['VesselName'];?></td>
													<td hidden col-name="OprID"><?=$item['OprID'];?></td>
													<td col-name="OprName"><?=$item['OprName'];?></td>
													<td col-name="IMO"><?=$item['IMO'];?></td>
													<td col-name="InboundVoyage"><?=$item['InboundVoyage'];?></td>					
													<td col-name="OutboundVoyage"><?=$item['OutboundVoyage'];?></td>
													<td col-name="BerthID"><?=$item['BerthID'];?></td>								
													<td col-name="BittID"><?=$item['BittID'];?></td>		
													<td col-name="AlongSide"><?=($item['AlongSide'] == 'L'? 'Trái':'Phải');?></td>
													<td col-name="InLane"><?=$item['InLane'];?></td>								
													<td col-name="OutLane"><?=$item['OutLane'];?></td>
													<td hidden col-name="LastPortID"><?=$item['LastPortID'];?></td>
													<td col-name="LastPortName"><?=$item['LastPortName'];?></td>
													<td hidden col-name="NextPortID"><?=$item['NextPortID'];?></td>	
													<td col-name="NextPortName"><?=$item['NextPortName'];?></td>				
													<td col-name="ETA"><?=$item['ETA'];?></td>			
													<td col-name="ETB"><?=$item['ETB'];?></td>			
													<td col-name="ETW"><?=$item['ETW'];?></td>			
													<td col-name="ETC"><?=$item['ETC'];?></td>			
													<td col-name="ETD"><?=$item['ETD'];?></td>			
													<td col-name="Remark"><?=$item['Remark'];?></td>			
												</tr>
												<?php $i++; } ?>
											<?php } ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</form></div>
					</div>
					<!---->							
					<div class="tab-pane fade" id="tab-vessel-visit-confirm">
						<div class="row border-e has-block-content bg-white pb-1" style="padding-top: 10px">
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-3">
								<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
									<table id="contenttableconfirm" class="table table-striped display nowrap" cellspacing="0" style="width: 99%">
										<thead>
											<tr>
												<th class="editor-cancel" col-name="STT">STT</th>
												<th col-name="Status">Trạng thái</th>
												<th col-name="VesselID">Mã tàu</th>
												<th col-name="VesselName">Tên tàu</th>
												<th col-name="InOutBoundVoyage">CN - CX</th>
												<th hidden col-name="StatusNum"></th>
												<th hidden col-name="VoyageKey"></th>
												<th hidden col-name="InboundVoyage"></th>
												<th hidden col-name="OutboundVoyage"></th>
												<th hidden col-name="ETB"></th>
												<th hidden col-name="ETD"></th>
												<th hidden col-name="BerthID"></th>
												<th hidden col-name="BittID"></th>
												<th hidden col-name="LastPortID"></th>
												<th hidden col-name="LastPortName"></th>
												<th hidden col-name="NextPortID"></th>
												<th hidden col-name="NextPortName"></th>
												<th hidden col-name="ATA"></th>
												<th hidden col-name="ATB"></th>
												<th hidden col-name="ATWD"></th>
												<th hidden col-name="ATCD"></th>
												<th hidden col-name="ATWL"></th>
												<th hidden col-name="ATCL"></th>
												<th hidden col-name="ATD"></th>
											</tr>
										</thead>									
										<tbody>
										<!--
											<?php if(count($vesselVisitConfirmList) > 0) {
												  		$i = 1; ?>
												<?php foreach($vesselVisitConfirmList as $item){  ?>
													<tr>
														<td col-name="STT"><?=$i;?></td>
														<td col-name="Status">
															<?php
																$status = $item['Status'];
																switch ($status) {
																	case '0':
																		echo ('');
																		break;
																	case '1':
																		echo ('A');
																		break;
																	case '2':
																		echo ('B');
																		break;
																	case '3':
																		echo ('W');
																		break;	
																	case '4':
																		echo ('C');
																		break;	
																	case '5':
																		echo ('W');
																		break;	
																	case '6':
																		echo ('C');
																		break;
																	case '7':
																		echo ('D');
																		break;
																}
															?>
														</td>
														<td col-name="VesselID"><?=$item['VesselID'];?></td>
														<td col-name="VesselName"><?=$item['VesselName'];?></td>
														<td col-name="InOutBoundVoyage"><?=$item['InboundVoyage'];?> - <?=$item['OutboundVoyage'];?></td>
														<td hidden col-name="StatusNum"><?=$item['Status'];?></td>
														<td hidden col-name="VoyageKey"><?=$item['VoyageKey'];?></td>
														<td hidden col-name="InboundVoyage"><?=$item['InboundVoyage'];?></td>
														<td hidden col-name="OutboundVoyage"><?=$item['OutboundVoyage'];?></td>
														<td hidden col-name="ETB"><?=$item['ETB'];?></td>
														<td hidden col-name="ETD"><?=$item['ETD'];?></td>
														<td hidden col-name="BerthID"><?=$item['BerthID'];?></td>
														<td hidden col-name="BittID"><?=$item['BittID'];?></td>
														<td hidden col-name="LastPortID"><?=$item['LastPortID'];?></td>
														<td hidden col-name="LastPortName"><?=$item['LastPortName'];?></td>
														<td hidden col-name="NextPortID"><?=$item['NextPortID'];?></td>
														<td hidden col-name="NextPortName"><?=$item['NextPortName'];?></td>
														<td hidden col-name="ATA"><?=$item['ATA'];?></td>
														<td hidden col-name="ATB"><?=$item['ATB'];?></td>
														<td hidden col-name="ATWD"><?=$item['ATWD'];?></td>
														<td hidden col-name="ATCD"><?=$item['ATCD'];?></td>
														<td hidden col-name="ATWL"><?=$item['ATWL'];?></td>
														<td hidden col-name="ATCL"><?=$item['ATCL'];?></td>
														<td hidden col-name="ATD"><?=$item['ATD'];?></td>
													</tr>
													<?php $i++; }  ?>
											<?php } ?>
										-->
										</tbody>
									</table>
								</div>	
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-5">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="row form-group">
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mr-2">
                                                <input id="chbATA" type="checkbox">ATA
                                                <span class="input-span"></span>
                                        </label>
                                        <input id="ATA" class="hiden-input">
										<input id="ATAView" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">

										<!-- -->
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mr-2 ml-4">
                                                <input id="chbATB" type="checkbox">ATB
                                                <span class="input-span"></span>
                                        </label>
                                        <input id="ATB" class="hiden-input">
										<input id="ATBView" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">
									</div>
									<div class="row form-group">
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mr-2">
                                                <input id="chbATWD" type="checkbox">
                                                <span class="input-span"></span>ATWD
                                        </label>
                                        <input id="ATWD" class="hiden-input">
										<input id="ATWDView" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">

										<!-- -->
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mr-2 ml-4">
                                                <input id="chbATCD" type="checkbox">ATCD
                                                <span class="input-span"></span>
                                        </label>
                                        <input id="ATCD" class="hiden-input">
										<input id="ATCDView" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">
									</div>
									<div class="row form-group">
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mr-2">
                                                <input id="chbATWL" type="checkbox">ATWL
                                                <span class="input-span"></span>
                                        </label>
                                        <input id="ATWL" class="hiden-input">
										<input id="ATWLView" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">

										<!-- -->
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mt-2 mr-2 ml-4">
                                            <input id="chbATCL" type="checkbox">ATCL
                                            <span class="input-span"></span>
                                        </label>							
                                        <input id="ATCL" class="hiden-input">		
										<input id="ATCLView" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">
									</div>
									<div class="row form-group">
										<label class="checkbox checkbox-grey checkbox-success col-xs-1 col-sm-1 col-xs-1 mt-2 mr-2">
                                                <input id="chbATD" type="checkbox">ATD
                                                <span class="input-span"></span>
                                        </label>	
                                        <input id="ATD" class="hiden-input">								
										<input id="ATDView"  class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm ml-4" placeholder="" type="text">
									</div>
								</div>
							</div>
						</div>
						<!-- -->
						<div class="row ibox-footer border-top-0 bg-white border-e has-block-content">
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-3">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row form-group">
										<input id="VoyageKeyConfirm" hidden class="form-control form-control-sm" placeholder="Mã chuyến tàu" type="text">
										<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">Tàu</label>
										<input id="VesselIDConfirm" hidden class="form-control form-control-sm" placeholder="Mã tàu" type="text">
										<input id="VesselNameConfirm" class="col-md-8 col-sm-8 col-xs-8 form-control form-control-sm" placeholder="Tên tàu" type="text" style="background-color: #f1f1f1">		
									</div>
									<div class="row form-group">
										<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">CN/CX</label>
										<input id="InboundVoyageConfirm" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm mr-1" placeholder="Chuyến nhập" type="text" style="background-color: #f1f1f1">	
										<input id="OutboundVoyageConfirm" class="col-md-4 col-sm-4 col-xs-4 form-control form-control-sm" placeholder="Chuyến xuất" type="text" style="background-color: #f1f1f1">	
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-3">
								<div class="col-md-12 col-sm-12 col-xs-12">									
									<div class="row form-group">
										<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">ETB</label>
										<input id="ETBConfirm" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm" placeholder="ETB" type="text" style="background-color: #f1f1f1">	
									</div>
									<div class="row form-group">
										<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">ETD</label>
										<input id="ETDConfirm" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm" placeholder="ETD" type="text" style="background-color: #f1f1f1">
									</div>									
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-6 mt-3">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="row form-group">
										<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">Bến</label>
										<input id="BerthIDConfirm" class="col-md-8 col-sm-8 col-xs-8 form-control form-control-sm" placeholder="Mã bến" type="text" style="background-color: #f1f1f1">
									</div>
									<div class="row form-group">
										<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">Bitt</label>
										<input id="BittIDConfirm" class="col-md-8 col-sm-8 col-xs-8 form-control form-control-sm" placeholder="Cảng sau" type="text" style="background-color: #f1f1f1">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>

<!-- Vessel modal-->
<div class="modal fade" id="vessel-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 5%">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-1">Danh mục tàu</h5>
			</div>
			<div class="modal-body" style="padding: 0px 15px 15px 15px">
				<div class="row ibox-footer border-top-0 mt-3">
					<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
						<table id="tblVessel" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
							<thead>
								<tr style="width: 100%">
									<th col-name="STT">STT</th>
									<th col-name="VoyageKey"></th>
									<th col-name="VesselID">Mã tàu</th>
									<th col-name="VesselName">Tên tàu</th>
									<th col-name="OprName">Hãng khai thác</th>
									<th col-name="IMO">IMO</th>
								</tr>
							</thead>
							<tbody>							
								<?php if(count($vesselList) > 0) {$i = 1; ?>
									<?php foreach($vesselList as $item) {  ?>
										<tr>
											<td><?=$i;?></td>
											<td><?=$item['VoyageKey'];?></td>
											<td><?=$item['VesselID'];?></td>
											<td><?=$item['VesselName'];?></td>
											<td><?=$item['OprName'];?></td>
											<td><?=$item['IMO'];?></td>							
										</tr>
									<?php $i++; }  ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<!--
				<div>
					<button class="btn btn-sm btn-rounded btn-success btn-labeled btn-labeled-left btn-icon" id="refreshVesselList">
						<span class="btn-label"><i class="ti-reload"></i></span>Tải lại</button>
				</div>				
				-->

				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-vessel" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns 	= ["STT", "VoyageKey", "VesselID", "VesselName", "OprID", "OprName", "IMO", "InboundVoyage", "OutboundVoyage", "BerthID", "BittID", "AlongSide", "InLane", "OutLane", "LastPortID", "LastPortName", "NextPortID", "NextPortName", "ETA", "ETB", "ETW", "ETC", "ETD", "Remark"],
			_confirmColumns = ["STT", "Status", "VesselID", "VesselName", "InOutBoundVoyage", 'StatusNum', "VoyageKey", "InboundVoyage", "OutboundVoyage", "ETB", "ETD", "BerthID", "BittID", "LastPortID", "LastPortName", "NextPortID", "NextPortName", "ATA", "ATB", "ATWD", "ATCD", "ATWL", "ATCL", "ATD"],
			_vesselColumns 	= ["STT", "VoyageKey", "VesselID", "VesselName", "InboundVoyage", "OutboundVoyage"],
			checkBoxList = ['chbATA', 'chbATB', 'chbATWD', 'chbATCD', 'chbATWL', 'chbATCL', 'chbATD'],
			tbl			= $("#contenttable"),
			tblConfirm	= $("#contenttableconfirm"),
			tblVessel 	= $("#tblVessel"),
			portList	= {},
			vesselList  = {}
			vesselVisitConfirmList = {},
			parentMenuList 	= {},
			input_type  = 'add',
			vesselModal = $("#vessel-modal");
			target		= '';

		// Set date time picker for input
		$('#ETA, #ETB, #ETW, #ETC, #ETD').datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:00',
			timeInput: true,
			onSelect: function () {
				/* Do nothing */
			}	
		});

		var _ATIndex = ['ATAView', 'ATBView', 'ATWDView', 'ATCDView', 'ATWLView', 'ATCLView', 'ATDView'];
		$('#ATAView, #ATBView, #ATWDView, #ATCDView, #ATWLView, #ATCLView, #ATDView').datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',
			timeFormat: 'HH:mm:00',
			timeInput: true,
			onSelect: function () {
				if ($('#VesselNameConfirm').val() == ""){
					toastr['error']("Vui lòng chọn dữ liệu tàu cần xác nhận!");
					return;
				}

				var ATView				= $(this).attr('id'),
					ATViewID 			= '#' + ATView,
					ATViewValue 		= $(ATViewID).val(),
					AT 					= ATView.replace('View', ''),
					ATID				= '#'  + AT,
					ATValue 			= $(ATID).val(),
					currentCheckboxID	= '#chb' + AT,
					index 				= _ATIndex.indexOf(ATView);			
					
				if (index == 0){ /* ATA */
					var nextATView     		= _ATIndex[parseInt(index) + 1],
						nextATViewID   		= '#' + nextATView,
						nextATViewValue 	= $(nextATViewID).val(),
						nextAT 	   			= nextATView.replace('View', ''),
						nextCheckboxID 		= '#chb' + nextAT;

					if (!($(currentCheckboxID).is(':checked'))){
						$(currentCheckboxID).prop('checked', true);
					}

					if ($(nextCheckboxID).is(':checked')){
						if (ATViewValue >= nextATViewValue){
							toastr['error']("Vui lòng chọn " + AT + " < " + nextAT + "!");
							$(ATViewID).val(getDateTime(ATValue));
							return; 
						}
					}

					$(ATID).val(getSQLDateTimeFormat(ATViewValue));

					/* Change status */
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('A');


					/* Update data*/
					var arrDataConfirm = [{
						'VoyageKey': $("#VoyageKeyConfirm").val(),
						'ATA': getSQLDateTimeFormat(ATViewValue),
						'Status': parseInt(index) + 1,
					}];

					var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData)
					return;
				}	

				if (index == 6){ /* ATD */
					var	befATView     		= _ATIndex[parseInt(index) - 1],
						befATViewID   		= '#' + befATView,
						befATViewValue 		= $(befATViewID).val(),
						befAT 	   			= befATView.replace('View', ''),
						befCheckboxID 		= '#chb' + befAT;

					if ($(befCheckboxID).is(':checked')){
						if (ATViewValue <= befATViewValue){
							toastr['error']("Vui lòng chọn " + befAT + " < " + AT + "!");
							$(ATViewID).val(getDateTime(ATValue));
							return; 
						}
					}

					if (!($(currentCheckboxID).is(':checked'))){
						if ($(befCheckboxID).is(':checked')){
							$(currentCheckboxID).prop('checked', true);
						}
						else{
							toastr['error']("Vui lòng khởi tạo theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
							$(ATViewID).val('');
							return;
						}
					}

					$(ATID).val(getSQLDateTimeFormat(ATViewValue));

					/* Change status */
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('D');
					
					/* Update data*/
					var arrDataConfirm = [{
						'VoyageKey': $("#VoyageKeyConfirm").val(),
						'ATD': getSQLDateTimeFormat(ATViewValue),
						'Status': parseInt(index) + 1,
					}];

					var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData)
					return;
				}
				
				var nextATView     		= _ATIndex[parseInt(index) + 1],
					nextATViewID   		= '#' + nextATView,
					nextATViewValue 	= $(nextATViewID).val(),
					nextAT 	   			= nextATView.replace('View', ''),
					nextCheckboxID 		= '#chb' + nextAT,
					befATView     		= _ATIndex[parseInt(index) - 1],
					befATViewID   		= '#' + befATView,
					befATViewValue 		= $(befATViewID).val(),
					befAT 	   			= befATView.replace('View', ''),
					befCheckboxID 		= '#chb' + befAT;

				if ($(nextCheckboxID).is(':checked')){
					if (ATViewValue >= nextATViewValue){
						toastr['error']("Vui lòng chọn " + AT + " < " + nextAT + "!");
						$(ATViewID).val(getDateTime(ATValue));
						return; 
					}
				}

				if ($(befCheckboxID).is(':checked')){
					if (ATViewValue <= befATViewValue){
						toastr['error']("Vui lòng chọn " + befAT + " < " + AT + "!");
						$(ATViewID).val(getDateTime(ATValue));
						return; 
					}
				}

				if (!($(currentCheckboxID).is(':checked'))){
					if ($(befCheckboxID).is(':checked')){
						$(currentCheckboxID).prop('checked', true);
					}
					else{
						toastr['error']("Vui lòng khởi tạo theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
						$(ATViewID).val('');
						return;
					}
				}

				$(ATID).val(getSQLDateTimeFormat(ATViewValue));

				/* Change status */
				var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")"),
					arrDataConfirm;

				/* Update data*/
				switch(index){
					case 1:
						arrDataConfirm = [{
							'VoyageKey': $("#VoyageKeyConfirm").val(),
							'ATB': getSQLDateTimeFormat(ATViewValue),
							'Status': parseInt(index) + 1,
						}];
						tblConfirm.DataTable().cell('B').data();
						break;
					case 2:
						arrDataConfirm = [{
							'VoyageKey': $("#VoyageKeyConfirm").val(),
							'ATWD': getSQLDateTimeFormat(ATViewValue),
							'Status': parseInt(index) + 1,
						}];
						tblConfirm.DataTable().cell('W').data();
						break;
					case 3:
						arrDataConfirm = [{
							'VoyageKey': $("#VoyageKeyConfirm").val(),
							'ATCD': getSQLDateTimeFormat(ATViewValue),
							'Status': parseInt(index) + 1,
						}];
						tblConfirm.DataTable().cell('C').data();
						break;
					case 4:
						arrDataConfirm = [{
							'VoyageKey': $("#VoyageKeyConfirm").val(),
							'ATWL': getSQLDateTimeFormat(ATViewValue),
							'Status': parseInt(index) + 1,
						}];
						tblConfirm.DataTable().cell('W').data();
						break;
					case 5:
						arrDataConfirm = [{
							'VoyageKey': $("#VoyageKeyConfirm").val(),
							'ATCL': getSQLDateTimeFormat(ATViewValue),
							'Status': parseInt(index) + 1,
						}];
						tblConfirm.DataTable().cell('C').data();
						break;
					default:
						break;
				}					

				var fData = {
					'action': 'edit',
					'child_action': 'updatedata',
					'data': arrDataConfirm
				};

				postSaveConfirm(fData);
				
			}	
		});

		$('#ATAView, #ATBView, #ATWDView, #ATCDView, #ATWLView, #ATCLView, #ATDView').on('blur', function(){
			var ATView				= $(this).attr('id'),
				ATViewID 			= '#' + ATView,
				ATViewValue 		= $(ATViewID).val(),
				AT 					= ATView.replace('View', ''),
				ATID				= '#'  + AT,
				ATValue 			= $(ATID).val(),
				currentCheckboxID	= '#chb' + AT;
			
			if ($(currentCheckboxID).is(':checked')){
				$(ATViewID).val(getDateTime(ATValue));
			}	
		});

		$('#ATA, #ATB, #ATWD, #ATCD, #ATWL, #ATCL, #ATD').datetimepicker();
		
		var dataTable = tbl.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},
				{ className: "text-center", targets: _columns.getIndexs(['VesselID', 'VesselName', 'OprName', 'IMO', 'InboundVoyage', 'OutboundVoyage',  'BerthID', 'BittID', 'AlongSide', 'InLane', 'OutLane', 'LastPortName', 'NextPortName', 'ETA', 'ETB', 'ETW', 'ETC', 'ETD', 'Remark'])},
				{ className: "hiden-input", targets: _columns.getIndexs(['VoyageKey', 'OprID', 'LastPortID', 'NextPortID'])},	
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns,
		});

		var dataTableConfirm = tblConfirm.newDataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _confirmColumns.indexOf('STT')},
				{ className: "text-center", targets: _confirmColumns.getIndexs(['Status', 'VesselID', 'VesselName', 'InOutBoundVoyage'])},
				{
					className: "hiden-input",
					targets: _confirmColumns.getIndexs(['StatusNum', 'VoyageKey', 'InboundVoyage', 'OutboundVoyage', 'ETB', 'ETD', 'BerthID', 'BittID', 'LastPortID', 'LastPortName', 'NextPortID', 'NextPortName', 'ATA', 'ATB', 'ATWD', 'ATCD', 'ATWL', 'ATCL', 'ATD'])
				},		
			],
			order: [[ _confirmColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            buttons: [],
            rowReorder: false,
            arrayColumns: _confirmColumns,
		});

		/* Initial vessel table */	
		tblVessel.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _vesselColumns.indexOf('STT')},		
				{ className: "text-center", targets: _vesselColumns.getIndexs(["VesselName", "InboundVoyage", "OutboundVoyage"])},
				{ className: "hiden-input", targets: _vesselColumns.getIndexs(["VoyageKey", "VesselID"])},
			],
			order: [[ _vesselColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            buttons: [],
            rowReorder: false,
            arrayColumns: _vesselColumns,
		});

		$('#vessel-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		// Load Port List: PortID, PortName
		<?php if(isset($portList) && count($portList) >= 0){?>
			portList = <?= json_encode($portList);?>;
		<?php } ?>

		/**/
		<?php if(isset($vesselVisitConfirmList) && count($vesselVisitConfirmList) >= 0){?>
			vesselVisitConfirmList = <?= json_encode($vesselVisitConfirmList);?>;
		<?php } ?>

		/**/
		<?php if(isset($vesselList) && count($vesselList) >= 0){?>
			vesselList = <?= json_encode($vesselList);?>;
		<?php } ?>

		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Vessel'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}
		
		/* Vessel ID click event */
		$("#chooseVessel").on('click', function(){
			vesselModal.modal('show');
		});

		$(document).on("dblclick", "#tblVessel tbody tr",  function(){
       		var VesselID	= tblVessel.getSelectedRows().data().toArray()[0][_vesselColumns.indexOf("VesselID")];
       		$("#VesselID").val(VesselID);;
       		vesselModal.modal('hide');

       		$("#inputForm").trigger("reset");
			$('#BerthID').val("");
			$('#BerthID').selectpicker("refresh");
			$('#BittID').val("");
			$('#BittID').selectpicker("refresh");
			$('#LastPortName').val("");
			$('#LastPortName').selectpicker("refresh");
			$('#NextPortName').val("");
			$('#NextPortName').selectpicker("refresh");
			<?php foreach($vesselList as $item) { ?>
				if ($("#VesselID").val() == '<?=$item['VesselID'];?>')
				{
					$("#VesselName").val('<?=$item['VesselName']?>');
					$("#IMO").val('<?=$item['IMO']?>');
					$("#OprID").val('<?=$item['OprID']?>');
					$("#OprName").val('<?=$item['OprName']?>');
				}
			<?php }?>

			// Load data to table
			tbl.waitingLoad();

			var formData = {
				'action': 'view',
				'vesselID': $('#VesselID').val(),
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;							
									case "AlongSide":
										if (rData['AlongSide'] = "L")
											val='<input class="hiden-input" value="'+rData['L']+'">' + 'Trái'
										else 
											val='<input class="hiden-input" value="'+rData['R']+'">' + 'Phải'
										break;
									case "ETA":
									case "ETB":
									case "ETW":
									case "ETC":
									case "ETD":
										val = getDateTime(rData[colname]);
										break;
									default:
										val = rData[colname];
										break;	
								}
								r.push(val);
							});
							rows.push(r);
						}
					}

					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
					};
				},
				error: function(err){
				}
			});
     	});

     	$("#apply-vessel").on("click", function(){
     		var tblVesselSelectedRows 	= tblVessel.getSelectedRows().data().toArray()[0],
     			VesselID 				= tblVesselSelectedRows[_vesselColumns.indexOf("VesselID")];
       		$("#VesselID").val(VesselID);

       		$("#inputForm").trigger("reset");
			$('#BerthID').val("");
			$('#BerthID').selectpicker("refresh");
			$('#BittID').val("");
			$('#BittID').selectpicker("refresh");
			$('#LastPortName').val("");
			$('#LastPortName').selectpicker("refresh");
			$('#NextPortName').val("");
			$('#NextPortName').selectpicker("refresh");
			<?php foreach($vesselList as $item) { ?>
				if ($("#VesselID").val() == '<?=$item['VesselID'];?>')
				{
					$("#VesselName").val('<?=$item['VesselName']?>');
					$("#IMO").val('<?=$item['IMO']?>');
					$("#OprID").val('<?=$item['OprID']?>');
					$("#OprName").val('<?=$item['OprName']?>');
				}
			<?php }?>

			// Load data to table
			tbl.waitingLoad();

			var formData = {
				'action': 'view',
				'vesselID': $('#VesselID').val(),
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;							
									case "AlongSide":
										if (rData['AlongSide'] = "L")
											val='<input class="hiden-input" value="'+rData['L']+'">' + 'Trái'
										else 
											val='<input class="hiden-input" value="'+rData['R']+'">' + 'Phải'
										break;
									case "ETA":
									case "ETB":
									case "ETW":
									case "ETC":
									case "ETD":
										val = getDateTime(rData[colname]);
										break;
									default:
										val = rData[colname];
										break;	
								}
								r.push(val);
							});
							rows.push(r);
						}
					}

					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
					};
				},
				error: function(err){
				}
			});
     	});

		/* ETB change */
		$("#ETB").on('change', function(event){
			ETA = $("#ETA").val();

			if (ETA == ''){
				toastr['error']("Vui lòng nhập ETA trước!");
				$("#ETB").val('');
				return;
			}

			if (this.value < ETA){
				toastr['error']("Vui lòng nhập ETB > ETA!");
				$("#ETB").val('');
				return;
			}
		});

		/* ETW change */
		$("#ETW").on('change', function(){
			ETB = $("#ETB").val();

			if (ETB == ''){
				toastr['error']("Vui lòng nhập ETB trước!");
				$("#ETW").val('');
				return;
			}

			if (this.value < ETB){
				toastr['error']("Vui lòng nhập ETW > ETB!");
				$("#ETW").val('');
				return;
			}
		});

		/* ETW change */
		$("#ETC").on('change', function(){
			ETW = $("#ETW").val();

			if (ETW == ''){
				toastr['error']("Vui lòng nhập ETW trước!");
				$("#ETC").val('');
				return;
			}

			if (this.value < ETW){
				toastr['error']("Vui lòng nhập ETC > ETW!");
				$("#ETC").val('');
				return;
			}
		});

		/* ETC change */
		$("#ETD").on('change', function(){
			ETC = $("#ETC").val();

			if (ETC == ''){
				toastr['error']("Vui lòng nhập ETC trước!");
				$("#ETD").val('');
				return;
			}

			if (this.value < ETC){
				toastr['error']("Vui lòng nhập ETD > ETC!");
				$("#ETD").val('');
				return;
			}
		});

		// Set Last Port Name and Next Port Name when Vessel ID change
		$("#LastPortName").change(function(){
			<?php foreach($portList as $item) { ?>
				if ('<?=$item['PortName']?>' == $("#LastPortName").val()){
					$("#LastPortID").val('<?=$item['PortID']?>');					
				}
			<?php }?>
		});

		$("#NextPortName").change(function(){
			<?php foreach($portList as $item) { ?>
				if ('<?=$item['PortName']?>' == $("#NextPortName").val())
					$("#NextPortID").val('<?=$item['PortID']?>');			
			<?php }?>
		});

		// "Thêm mới" Button Click Event
		$('#addrow').on('click', function(){
			$('#inputForm').trigger('reset');
			$('#VesselID').val("");
			$('#VesselName').val("");
			$('#OprID').val("");
			$('#OprName').val("");
			$('#IMO').val("");			
			$('#BerthID').selectpicker("refresh");
			$('#BittID').selectpicker("refresh");
			$('#LastPortName').selectpicker("refresh");
			$('#NextPortName').selectpicker("refresh");

			// Load data to table
			tbl.waitingLoad();

			var formData = {
				'action': 'view',
				'vesselID': '',
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];

							if (!(rData['Status']) || (rData['Status'] == 0)){
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;							
										case "AlongSide":
											if (rData['AlongSide'] = "L")
												val='<input class="hiden-input" value="'+rData['L']+'">' + 'Trái'
											else 
												val='<input class="hiden-input" value="'+rData['R']+'">' + 'Phải'
											break;
										case "ETA":
										case "ETB":
										case "ETW":
										case "ETC":
										case "ETD":
											val = getDateTime(rData[colname]);
											break;
										default:
											val = rData[colname];
											break;	
									}
									r.push(val);
								});
								rows.push(r);
							}
						}
					}

					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
					};
				},
				error: function(err){
				}
			});

			input_type = "add";
		});

		/*
		// Get current Date-Time String
		function returnDateTimeFormatString(d){
			year 	= d.getFullYear();
			month 	= d.getMonth() + 1;
			day 	= d.getDate();
			hour 	= d.getHours(),
			min  	= d.getMinutes(),
			sec  	= d.getSeconds(),
			fillMonth = '',
			fillDay	  = '',
			fillHour  = '',
			fillMin   = '',
			fillSec   = '';
			
			if (month < 10)
				fillMonth = '0';
			if (day < 10)
				fillDay = '0';
			if (hour < 10)
				fillHour = '0';
			if (min < 10)
				fillMin = '0';
			if (sec < 10)
				fillSec = '0';

			return (year + fillMonth + month + fillDay + day + "T" + fillHour + hour + fillMin + min + fillSec + sec);
		}
		*/

		/* Get SQL Date Time Format */
		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		/* Button "Lưu": Click Event*/
		$('#save').on('click', function(){
			if (numTab == 1){
				var d = new Date();
				year 	= d.getFullYear();
				month 	= d.getMonth() + 1;
				day 	= d.getDate();
				hour 	= d.getHours(),
				min  	= d.getMinutes(),
				sec  	= d.getSeconds();

				var VesselID 	= $('#VesselID').val(),
					VesselName	= $('#VesselName').val(),
					OprID		= $('#OprID').val(),
					InboundVoyage  = $('#InboundVoyage').val(),
					OutboundVoyage = $('#OutboundVoyage').val(),
					BerthID		= $('#BerthID').val(),
					BittID		= $('#BittID').val(),
					AlongSide 	= $("input[type='radio'][name='AlongSide']:checked").val(),
					InLane		= $("#InLane").val(),
					OutLane		= $("#OutLane").val(),
					LastPort	= $('#LastPortID').val(),
					NextPort	= $('#NextPortID').val(),
					ETA			= getSQLDateTimeFormat($("#ETA").val()),
					ETB			= getSQLDateTimeFormat($("#ETB").val()),
					ETW			= getSQLDateTimeFormat($("#ETW").val()),
					ETC			= getSQLDateTimeFormat($("#ETC").val()),
					ETD			= getSQLDateTimeFormat($("#ETD").val()),
					Remark		= $('#Remark').val(),
					VoyageKey	= $('#VoyageKey').val() ? $('#VoyageKey').val() : (VesselID + year + month + day + hour + min + sec);

				if (VesselID == ""){
					toastr["error"]('Vui lòng nhập Mã tàu!');	
					return;
				}

				if (VesselName == ""){
					toastr["error"]('Vui lòng nhập Tên tàu!');	
					return;
				}

				if (OprID == ""){
					toastr["error"]('Vui lòng chọn Hãng khai thác!');	
					return;
				}

				if (BerthID == ""){
					toastr["error"]('Vui lòng chọn Bến!');	
					return;
				}

				if (BittID == ""){
					toastr["error"]('Vui lòng chọn Bitt!');	
					return;
				}
				
				/*
				if (LastPort == ""){
					toastr["error"]('Vui lòng chọn Cảng trước!');	
					return;
				}

				if (NextPort == ""){
					toastr["error"]('Vui lòng chọn Cảng sau!');	
					return;
				}

				if (LastPort === NextPort){
					toastr["error"]("Vui lòng chọn cảng trước khác cảng sau!");
					return;
				}
				*/
				
				if (!ETA){
					toastr["error"]('Vui lòng nhập ETA!');	
					return;
				}

				if (!ETB){
					toastr["error"]('Vui lòng nhập ETB!');	
					return;
				}

				if (!ETW){
					toastr["error"]('Vui lòng nhập ETW!');	
					return;
				}

				if (!ETC){
					toastr["error"]('Vui lòng nhập ETC!');	
					return;
				}

				if (!ETD){
					toastr["error"]('Vui lòng nhập ETD!');	
					return;
				}

				var firstVesselVistArr = [{
					'VoyageKey': 	VoyageKey,
					'VesselID': 	VesselID,
					'VesselName': 	VesselName,
					'OprID': 		OprID,
					'InboundVoyage': InboundVoyage,
					'OutboundVoyage': OutboundVoyage,
					'BerthID': 		BerthID,
					'BittID': 		BittID,
					'AlongSide':	AlongSide,
					'InLane': 		InLane,
					'OutLane': 		OutLane,
					'LastPort': 	LastPort,
					'NextPort': 	NextPort,
					'ETA': 			ETA,
					'ETB': 			ETB,
					'ETW': 			ETW,
					'ETC': 			ETC,				
					'ETD': 			ETD,				
					'Remark': 		Remark,				
				}];

				$.confirm({
				    title: 'Thông báo!',
				    type: 'orange',
				    icon: 'fa fa-warning',
				    content: 'Tất cả các thay đổi sẽ được lưu lại!\nTiếp tục?',
				    buttons: {
				        ok: {
				            text: 'Xác nhận lưu',
				            btnClass: 'btn-warning',
				            keys: ['Enter'],
				            action: function(){
				                saveData(firstVesselVistArr);
				            }
				        },
				        cancel: {
				            text: 'Hủy bỏ',
				            btnClass: 'btn-default',
				            keys: ['ESC']
				        }
				    }
				});
			}
			else if (numTab == 2){
				/* Do nothing */
			}
			
		});

		function saveData(formData){
			if (numTab == 1){
				var fData = {
					'action': input_type,
					'numTab': numTab,
					'data': formData,
				};
			}
			else if (numTab == 2){
				var fData = {
					'action': 'edit',
					'numTab': numTab,
					'data': formData,
				};
			}			
			postSave(fData);
		}

		function postSave(formData){
			var saveBtn = $('#save');
        	
			$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    if(formData.action == 'edit'){
                    	toastr["success"]("Cập nhật thành công!");
                    	//location.reload();
                 		return;
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");	
                    	//location.reload();
                    	return;
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		// Button Delete: Click Event
		$('#delete').on('click', function(){
			if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }
            else{
            	tbl.confirmDelete(function(data){
            		postDel(data);
            	});
            }
		});

		function postDel(data){
			var delData = data.map(p=>p[_columns.indexOf("VoyageKey")]);
			var fdel = {
					'action': 'delete',
					'data': delData
				};
			console.log(fdel);

			$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
                    tbl.DataTable().rows('.selected').remove().draw(false); // Delete row in table
                	tbl.updateSTT(_columns.indexOf("STT"));
               		toastr["success"]("Xóa dữ liệu thành công!");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		// Row click event
		tbl.on("click", function(){
			var data            =  tbl.getSelectedData();

			var VoyageKey 		=  data[0][_columns.indexOf("VoyageKey")],		
				VesselID 		=  data[0][_columns.indexOf("VesselID")],			
				VesselName 		=  data[0][_columns.indexOf("VesselName")],
				OprID 			=  data[0][_columns.indexOf("OprID")], 
				OprName			=  data[0][_columns.indexOf("OprName")], 
				IMO				=  data[0][_columns.indexOf("IMO")], 
				InboundVoyage 	=  data[0][_columns.indexOf("InboundVoyage")], 
				OutboundVoyage 	=  data[0][_columns.indexOf("OutboundVoyage")], 
				BerthID 		=  data[0][_columns.indexOf("BerthID")], 
				BittID 			=  data[0][_columns.indexOf("BittID")], 
				AlongSide 		=  data[0][_columns.indexOf("AlongSide")], 
				InLane 			=  data[0][_columns.indexOf("InLane")], 
				OutLane 		=  data[0][_columns.indexOf("OutLane")], 
				LastPortID		=  data[0][_columns.indexOf("LastPortID")], 
				LastPortName	=  data[0][_columns.indexOf("LastPortName")], 
				NextPortID		=  data[0][_columns.indexOf("NextPortID")],
				NextPortName	=  data[0][_columns.indexOf("NextPortName")], 
				ETA 			=  data[0][_columns.indexOf("ETA")], 
				ETB 			=  data[0][_columns.indexOf("ETB")],
				ETW 			=  data[0][_columns.indexOf("ETW")], 				
				ETC 			=  data[0][_columns.indexOf("ETC")],
				ETD 			=  data[0][_columns.indexOf("ETD")],
				Remark 			=  data[0][_columns.indexOf("Remark")];

			// Set input type equals edit
			input_type = 'edit';

			// Set value for input tab
			$('#VoyageKey').val(VoyageKey);
			$('#VesselID').val(VesselID);
			$('#VesselID').selectpicker("refresh");

			$('#VesselName').val(VesselName);
			$('#OprID').val(OprID);
			$('#OprName').val(OprName);
			$('#IMO').val(IMO);
			$('#InboundVoyage').val(InboundVoyage);
			$('#OutboundVoyage').val(OutboundVoyage);

			$('#BerthID').val(BerthID);
			$('#BerthID').selectpicker("refresh");	
			$('#BittID').val(BittID);
			$('#BittID').selectpicker("refresh");	

			$('#InLane').val(InLane);
			$('#OutLane').val(OutLane);

			$('#LastPortID').val(LastPortID);
			$('#LastPortName').val(LastPortName);
			$('#LastPortName').selectpicker("refresh");	

			$('#NextPortID').val(NextPortID);
			$('#NextPortName').val(NextPortName);
			$('#NextPortName').selectpicker("refresh");

			$('#ETA').val(ETA);
			$('#ETB').val(ETB);
			$('#ETW').val(ETW);
			$('#ETC').val(ETC);
			$('#ETD').val(ETD);
			$('#Remark').val(Remark);
		});

		/*
		$("#VesselVisitPlan").on('click', function(){
			$("#VesselVisitPlan")[0].classList.remove("tabVesselVisitNotSelected");
			$("#VesselVisitPlan").addClass('tabVesselVisitSelected');
			$("#VesselVisitConfirm")[0].classList.remove('tabVesselVisitSelected');
			$("#VesselVisitConfirm").addClass('tabVesselVisitNotSelected');
		});

		$("#VesselVisitConfirm").on('click', function(){
			// Set status of tab
			$("#VesselVisitPlan")[0].classList.remove("tabVesselVisitSelected");
			$("#VesselVisitPlan").addClass('tabVesselVisitNotSelected');
			$("#VesselVisitConfirm")[0].classList.remove('tabVesselVisitNotSelected');
			$("#VesselVisitConfirm").addClass('tabVesselVisitSelected');

			var formData = {
				'action': '',
				'screen': 'VesselVisitConfirm',
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
			});
		});
		*/

		var arrIndex = 0;

		$(document).on("click", "#contenttableconfirm tbody tr",  function(){
		//tblConfirm.on('click', function(){
			var data            =  tblConfirm.getSelectedData(),
				Status 			=  data[0][_confirmColumns.indexOf("Status")],
				StatusNum		=  data[0][_confirmColumns.indexOf("StatusNum")],
				VoyageKey 		=  data[0][_confirmColumns.indexOf("VoyageKey")],			
				VesselID 		=  data[0][_confirmColumns.indexOf("VesselID")],			
				VesselName 		=  data[0][_confirmColumns.indexOf("VesselName")],				
				VesselName 		=  data[0][_confirmColumns.indexOf("VesselName")],
				InOutBoundVoyage=  data[0][_confirmColumns.indexOf("InOutBoundVoyage")],							
				InboundVoyage 	=  data[0][_confirmColumns.indexOf("InboundVoyage")],
				OutboundVoyage	=  data[0][_confirmColumns.indexOf("OutboundVoyage")],	
				ETB 			=  data[0][_confirmColumns.indexOf("ETB")], 
				ETD 			=  data[0][_confirmColumns.indexOf("ETD")], 				
				BerthID 		=  data[0][_confirmColumns.indexOf("BerthID")], 
				BittID	 		=  data[0][_confirmColumns.indexOf("BittID")], 
				LastPortID		=  data[0][_confirmColumns.indexOf("LastPortID")], 
				LastPortName	=  data[0][_confirmColumns.indexOf("LastPortName")],				
				NextPortID		=  data[0][_confirmColumns.indexOf("NextPortID")], 
				NextPortName	=  data[0][_confirmColumns.indexOf("NextPortName")],					
				ATA				=  data[0][_confirmColumns.indexOf("ATA")], 
				ATB				=  data[0][_confirmColumns.indexOf("ATB")], 
				ATWD			=  data[0][_confirmColumns.indexOf("ATWD")],
				ATCD			=  data[0][_confirmColumns.indexOf("ATCD")], 
				ATWL 			=  data[0][_confirmColumns.indexOf("ATWL")], 
				ATCL 			=  data[0][_confirmColumns.indexOf("ATCL")],
				ATD 			=  data[0][_confirmColumns.indexOf("ATD")];

			arrIndex = StatusNum;

			$('#Status').val(Status);
			$('#StatusNum').val(StatusNum);
			$('#VoyageKeyConfirm').val(VoyageKey);
			$('#VesselID').val(VesselID);
			$('#VesselNameConfirm').val(VesselName);
			$('#InboundVoyageConfirm').val(InboundVoyage);
			$('#OutboundVoyageConfirm').val(OutboundVoyage);
			$('#InOutBoundVoyage').val(InOutBoundVoyage);
			$('#ETBConfirm').val(getDateTime(ETB));
			$('#ETDConfirm').val(getDateTime(ETD));
			$('#BerthIDConfirm').val(BerthID);
			$('#BittIDConfirm').val(BittID);

			// Uncheck all checkbox
			$("#chbATA").prop('checked', false);
			$("#chbATB").prop('checked', false);
			$("#chbATWD").prop('checked', false);
			$("#chbATCD").prop('checked', false);
			$("#chbATWL").prop('checked', false);
			$("#chbATCL").prop('checked', false);
			$("#chbATD").prop('checked', false);

			$('#ATAView').val(getDateTime(ATA));
			$('#ATA').val(ATA);
			if (1 <= StatusNum){
				$("#chbATA").prop('checked', true);
			}

			$('#ATBView').val(getDateTime(ATB));
			$('#ATB').val(ATB);
			if (2 <= StatusNum){
				$("#chbATB").prop('checked', true);
			}

			$('#ATWDView').val(getDateTime(ATWD));
			$('#ATWD').val(ATWD);
			if (3 <= StatusNum){
				$("#chbATWD").prop('checked', true);
			}

			$('#ATCDView').val(getDateTime(ATCD));
			$('#ATCD').val(ATCD);
			if (4 <= StatusNum){
				$("#chbATCD").prop('checked', true);
			}

			$('#ATWLView').val(getDateTime(ATWL));
			$('#ATWL').val(ATWL);
			if (5 <= StatusNum){
				$("#chbATWL").prop('checked', true);
			}

			$('#ATCLView').val(getDateTime(ATCL));
			$('#ATCL').val(ATCL);
			if (6 <= StatusNum){
				$("#chbATCL").prop('checked', true);
			}

			$('#ATDView').val(getDateTime(ATD));
			$('#ATD').val(ATD);
			if (7 <= StatusNum){
				$("#chbATD").prop('checked', true);
			}
		});

		var numTab = 1;
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		  target = $(e.target).attr("href"); // Activated tab

		  if (target == "#tab-vessel-visit-confirm"){ /* XNTCB */
		  	numTab = 2;

		  	$('button[id="addrow"]').prop('disabled', true);
		  	$('button[id="delete"]').prop('disabled', true);
		  	//$('button').prop('disabled', true); // Disable all button
		  	
		  	/* Reset value */
		  	$("#ATA").val('');
		  	$("#ATB").val('');
		  	$("#ATWD").val('');
		  	$("#ATCD").val('');
		  	$("#ATWL").val('');
		  	$("#ATCL").val('');
		  	$("#ATD").val('');

		  	$("#ATAView").val('');
		  	$("#ATBView").val('');
		  	$("#ATWDView").val('');
		  	$("#ATCDView").val('');
		  	$("#ATWLView").val('');
		  	$("#ATCLView").val('');
		  	$("#ATDView").val('');

		  	$("#chbATA").prop('checked', false);
		  	$("#chbATB").prop('checked', false);
		  	$("#chbATWD").prop('checked', false);
		  	$("#chbATCD").prop('checked', false);
		  	$("#chbATWL").prop('checked', false);
		  	$("#chbATCL").prop('checked', false);
		  	$("#chbATD").prop('checked', false);

		  	$('#VesselNameConfirm').val('');
			$('#InboundVoyageConfirm').val('');
			$('#OutboundVoyageConfirm').val('');
			$('#InOutBoundVoyage').val('');
			$('#ETBConfirm').val('');
			$('#ETDConfirm').val('');
			$('#BerthIDConfirm').val('');
			$('#BittIDConfirm').val('');

		  	/* Load data for Vessel Visit Confirm table */
		  	tblConfirm.waitingLoad();

		  	var formData = {
				'action': 'view',
				'child_action': 'loadDataForVesselVisitConfirmTable',
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];							
							$.each(_confirmColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;							
									case "Status":
										if (rData[colname] == '0'){
											val = '';
										}
										else if (rData[colname] == '1'){
											val = 'A';
										}
										else if (rData[colname] == '2'){
											val = 'B';
										}
										else if (rData[colname] == '3'){
											val = 'W';										
										}
										else if (rData[colname] == '4'){
											val = 'C';	
										}
										else if (rData[colname] == '5'){
											val = 'W';
										}
										else if (rData[colname] == '6'){
											val = 'C';
										}
										else if (rData[colname] == '7'){
											val = 'D';
										}
										break;
									case "InOutBoundVoyage":
										val = rData['InboundVoyage'] + ' - ' + rData['OutboundVoyage'];
										break;
									case "StatusNum":
										val = rData['Status'];
										break;
									default:
										val = rData[colname];
										break;	
								}
								r.push(val);
							});
							rows.push(r);
						}
					}

					tblConfirm.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tblConfirm.dataTable().fnAddData(rows);
					}
				},
				error: function(err){
				}
			});
		  }
		  else{ /* KHTCB */
		  	numTab = 1;

		  	$('button').prop('disabled', false);

		  	$("#inputForm").trigger("reset");
		  	$("#VesselID").val('');
		  	$("#OprID").val('');
		  	$("#OprName").val('');
		  	$("#VesselName").val('');
		  	$("#IMO").val('');
			$('#BerthID').val("");
			$('#BerthID').selectpicker("refresh");
			$('#BittID').val("");
			$('#BittID').selectpicker("refresh");
			$('#LastPortName').val("");
			$('#LastPortName').selectpicker("refresh");
			$('#NextPortName').val("");
			$('#NextPortName').selectpicker("refresh");

		  	/* Load data for Vessel Visit table */
		  	tbl.waitingLoad();

		  	var formData = {
				'action': 'view',
				'child_action': 'loadDataForVesselVisitTable',
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];							

							if (!(rData['Status']) || rData['Status'] == 0){
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = i+1; 
											break;							
										case "AlongSide":
											if (rData[colname] == 'L'){
												val = 'Trái';
											}
											else if (rData[colname] == 'R'){
												val = 'Phải';
											}
											break;
										default:
											val = rData[colname];
											break;									
									}
									r.push(val);
								});
								rows.push(r);
							}							
						}
					}
					tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
					}
				},
				error: function(err){
				}
			});
		  }
		});

		/* ******* */
		$("#chbATA").change(function(){ // A
			if ($('#VesselNameConfirm').val() == ""){
				toastr['error']("Vui lòng chọn dữ liệu tàu cần xác nhận!");
				$("#chbATA").prop('checked', false);
				return;
			}

			arrIndex = 0;
			for (i = 0; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}

			var indexValue = 1;

			if(!($('#chbATA').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
				if (indexValue != arrIndex || ($("#chbATB").is(':checked'))){
					$("#chbATA").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(0);
			        
			        /* ** */
			        $("#ATA").val('');
			        $("#ATAView").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATA') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATA').val());


					// Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),
						'ATA': 			$('#ATA').val(),				
						'Status': 		0,
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
				if ((parseInt(arrIndex) + 1) != indexValue){
					// FAIL
					$("#chbATA").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
				}
				else{
					// OK
					var date = new Date();
			        $('#ATA').datetimepicker('setDate', date);
			        $('#ATAView').datetimepicker('setDate', date);

			        // Set table cell value
			        var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('A');

			       	/* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(1);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATA') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATA').val());
			        /* ** */

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATA': 			$('#ATA').val(),
						'Status': 		1, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		
		});

		$("#chbATB").change(function(){ // B
			var indexValue = 2;

			arrIndex = 0;
			for (i = 0; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}

			if(!($('#chbATB').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
				if (indexValue != arrIndex || ($("#chbATWD").is(':checked'))){
					$("#chbATB").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('A');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(1);

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATA') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATA').val());

  			        /* ** */
			        $("#ATBView").val('');
			        $("#ATB").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATB') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATB').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),
						'ATB': 			$('#ATB').val(),				
						'Status': 		1, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
				if ((parseInt(arrIndex) + 1) != indexValue){
					$("#chbATB").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
				}
				else{
					var date = new Date();
					$('#ATBView').datetimepicker('setDate', date);
					$('#ATB').datetimepicker('setDate', date);

					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('B');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(2);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATB') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATB').val());
			        /* ** */

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATB': 			$('#ATB').val(),
						'Status': 		2, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		});

		$("#chbATWD").change(function(){ // W
			var indexValue = 3;
			
			arrIndex = 0;
			for (i = 0; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}

			if(!($('#chbATWD').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
				if (indexValue != arrIndex || ($("#chbATCD").is(':checked'))){
					$("#chbATWD").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('B');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(2);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATB') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATB').val());

  			        /* ** */
			        $("#ATWDView").val('');
			        $("#ATWD").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATWD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATWD').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATWD': 		$('#ATWD').val(),
						'Status': 		2, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
				if ((parseInt(arrIndex) + 1) != indexValue){
					$("#chbATWD").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
				}
				else{			
					var date = new Date();		
					$('#ATWDView').datetimepicker('setDate', date);
					$('#ATWD').datetimepicker('setDate', date);

					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('W');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(3);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATWD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATWD').val());
			        /* ** */

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),	
						'ATWD': 		$('#ATWD').val(),			
						'Status': 		3,
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		});

		$("#chbATCD").change(function(){ // C
			var indexValue = 4;

			arrIndex = 0;
			for (i = 0; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}

			if(!($('#chbATCD').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
				if (indexValue != arrIndex || ($("#chbATWL").is(':checked'))){
					$("#chbATCD").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('W');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(3);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATWD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATWD').val());

  			        /* ** */
			        $("#ATCDView").val('');
			        $("#ATCD").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATCD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCD').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),
						'ATCD': 		$('#ATCD').val(),				
						'Status': 		3,
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
				if ((parseInt(arrIndex) + 1) != indexValue){
					$("#chbATCD").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
					arrIndex--;
				}
				else{					
					var date = new Date();		
					$('#ATCDView').datetimepicker('setDate', date);
					$('#ATCD').datetimepicker('setDate', date);

					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('C');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(4);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATCD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCD').val());
			        /* ** */

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATCD': 		$('#ATCD').val(),
						'Status': 		4, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		});

		$("#chbATWL").change(function(){ // W
			var indexValue = 5;
			
			arrIndex = 0;
			for (i = 0; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}

			if(!($('#chbATWL').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
				if (indexValue != arrIndex || ($("#chbATCL").is(':checked'))){
					$("#chbATWL").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('C');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(4);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATCD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCD').val());

  			        /* ** */
			        $("#ATWLView").val('');
			        $("#ATWL").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATWL') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATWL').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),
						'ATWL': 		$('#ATWL').val(),				
						'Status': 		4,
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
				if ((parseInt(arrIndex) + 1) != indexValue){
					$("#chbATWL").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
				}
				else{
					var date = new Date();
					$('#ATWLView').datetimepicker('setDate', date);
					$('#ATWL').datetimepicker('setDate', date);

					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('W');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(5);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATWL') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATWL').val());
			        /* ** */

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATWL': 		$('#ATWL').val(),
						'Status': 		5, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		});

		$("#chbATCL").change(function(){ // C
			var indexValue = 6;
			
			arrIndex = 0;
			for (i = 0; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}
console.log(arrIndex);
			if(!($('#chbATCL').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
console.log(arrIndex);
				if (indexValue != arrIndex || ($("#chbATD").is(':checked'))){
					$("#chbATCL").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('W');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(5);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATWL') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATWL').val());

			        /* ** */
			        $("#ATCL").val('');
			        $("#ATCLView").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATCL') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCL').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),
						'ATCL': 		$('#ATCL').val(),				
						'Status': 		5, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
console.log(arrIndex);
				if ((parseInt(arrIndex) + 1) != indexValue){
					$("#chbATCL").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
				}
				else{
					var date = new Date();
					$('#ATCLView').datetimepicker('setDate', date);
					$('#ATCL').datetimepicker('setDate', date);

					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('C');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(6);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATCL') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCL').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATCL': 		$('#ATCL').val(),
						'Status': 		6, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		});

		$("#chbATD").change(function(){ // D
			var indexValue = 7,
				i = 0;
			
			arrIndex = 0;

			for (; i < checkBoxList.length; i++){
				if (!($('#' + checkBoxList[i]).is(':checked'))){
					arrIndex = parseInt(i);		
					i = checkBoxList.length;
				}
			}
			if (i == checkBoxList.length)
				arrIndex = 7;

			if(!($('#chbATD').is(':checked'))){
				arrIndex++;
				// Uncheck
				// If user uncheck, the website will check the index
				if (indexValue != arrIndex){
					$("#chbATD").prop('checked', true);
					toastr['error']("Vui lòng bỏ check theo thứ tự: ATD -> ATCL -> ATWL -> ATCD -> ATWD -> ATB -> ATA!");
				}
				else
				{
					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('C');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(6);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATCL') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCL').val());
			        
			        /* ** */
			        $("#ATD").val('');
			        $("#ATDView").val('');
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATCL').val());

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),	
						'ATD': 			$('#ATD').val(),			
						'Status': 		6, // {1: A, 2: B, 3: C, 4: D, 5: W}
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
			else{
				arrIndex--;
				if ((parseInt(arrIndex) + 1) != indexValue){
					$("#chbATD").prop('checked', false);
					toastr['error']("Vui lòng check theo thứ tự: ATA -> ATB -> ATWD -> ATCD -> ATWL -> ATCL -> ATD!");
				}
				else{	
					var date = new Date();				
					$('#ATDView').datetimepicker('setDate', date);
					$('#ATD').datetimepicker('setDate', date);

					var cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('Status') + ")");
			        tblConfirm.DataTable().cell(cell).data('D');

			        /* ** */
			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('StatusNum') + ")");
			        tblConfirm.DataTable().cell(cell).data(7);

			        cell = tblConfirm.find("tbody tr.selected td:eq( " + _confirmColumns.indexOf('ATD') + ")");
			        tblConfirm.DataTable().cell(cell).data($('#ATD').val());
			        /* ** */

			        // Update database
			        var arrDataConfirm = [{
						'VoyageKey': 	$('#VoyageKeyConfirm').val(),				
						'ATD': 			$('#ATD').val(),
						'Status': 		7, 
					}];

			        var fData = {
						'action': 'edit',
						'child_action': 'updatedata',
						'data': arrDataConfirm
					};

					postSaveConfirm(fData);
				}
			}
		});	

		function postSaveConfirm(formData){        	
			$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
                    toastr["success"]("Cập nhật thành công!");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		$('#InLane, #OutLane').on('change', function(){
			var InLane 	= $("#InLane").val(),
				OutLane = $("#OutLane").val();

			if ((InLane) && (OutLane)){
				/* Load data for Next Port and Last Port */

				var formData = {
					'action': 'view',
					'child_action': 'loadPortDataByInOutLane',
					'InLane': InLane,
					'OutLane': OutLane,
				};

				$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVesselVisit'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                	var options = [];
                	for (i = 0; i < data.list.length; i++){
                		option = "<option value='" + data.list[i]['PortID'] + "'>" + data.list[i]['PortName']  +"</option>";
                		options.push(option);
                	}
                	$('#LastPortName').html(options);
					$('#LastPortName').selectpicker('refresh');
					$('#NextPortName').html(options);
					$('#NextPortName').selectpicker('refresh');
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
			}
		});
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>