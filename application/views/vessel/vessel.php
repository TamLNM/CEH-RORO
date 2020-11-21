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

	input[type="text"]:focus{
		background-color: #f6fcff;
	}

	/*
	#imgLabel{
		border: none;
		padding: 5px;
		border-radius: 5px;
		background-color: #0b4660;
		color: white;
	}
	*/
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">ĐỊNH NGHĨA THÔNG TIN TÀU</div>
				<div class="button-bar-group mr-3">
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>				
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
			<div class="ibox-body pt-1 pb-1 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-3 col-sm-3 col-xs-3 col-form-label">Mã tàu</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="VesselIDFilter" class="form-control form-control-sm" placeholder="Mã tàu" type="text">
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-3 col-sm-2 col-xs-2 col-form-label">Tên tàu</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="VesselNameFilter" class="form-control form-control-sm" placeholder="Tên tàu" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Ô màn hình thứ 2 -->		
			<form class="ibox-body mt-0 pt-0 pb-0 bg-f9 border-e" id="inputForm">
			<!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 pl-0 pr-0">
						<div class="ibox-body pt-3 pb-3 bg-f9">
							<div class="row ibox mb-0 border-e">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-6" style="height: 35px;">
											<div class="row form-group" style="text-align: center; background-color: #0b4660; color: #ffffff;">
												<label class="col-md-12 col-sm-6 col-xs-6 col-form-label">
													<b>THÔNG TIN CHUNG</b>
												</label>
											</div>											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px;">
											<div class="row form-group">
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Loại tàu</label>
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Mã tàu</label>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<select id="VesselType" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Loại tàu">
														<option value="1" selected>Tàu RoRo</option>
														<option value="2">Tàu Container</option>
														<option value="3">Tàu bách hóa</option>				
													</select>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="VesselID" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Mã tàu" type="text">
												</div>
												
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px;">
											<div class="row form-group">
												<label class="col-md-12 col-sm-12 col-xs-12 col-form-label">Tên tàu</label>
												<div class="col-md-12 col-sm-12 col-xs-10">
													<input id="VesselName" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Tên tàu" type="text">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px;">
											<div class="row form-group">
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Hãng</label>
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Quốc gia</label>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<select id="OprID" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Tên hãng">
														<?php if(count($oprList) > 0)?>
															<?php foreach($oprList as $item) {  ?>
																<option value="<?=$item['OprID']?>"><?=$item['OprName'];?></option>
														<?php }?>
													</select>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6 pr-6">
													<select id="NationID" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Quốc gia">
														<?php if(count($nationList) > 0)?>
															<?php foreach($nationList as $item) {  ?>
																<option value="<?=$item['NationID']?>"><?=$item['NationName'];?></option>
														<?php }?>
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px">
											<div class="row form-group">
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Call Sign</label>
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">Inmarsat</label>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="CallSign" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control form-control-sm input-required" placeholder="Call Sign" type="text">
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="Inmarsat" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control form-control-sm input-required" placeholder="Inmarsat" type="text">
												</div>
											</div>
										</div>
									</div>
							
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="row form-group">
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">LLoyd</label>
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">IMO</label>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="LLoyd"  style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control form-control-sm" placeholder="LLoyd" type="text">
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="IMO" class="form-control form-control-sm" placeholder="IMO" type="text">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 pl-0 pr-0">
						<div class="ibox-body pt-3 pb-3 bg-f9">
							<div class="row ibox mb-0 border-e">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height: 35px;">
											<div class="row form-group" style="text-align: center; background-color: #0b4660; color: #ffffff">
												<label class="col-md-12 col-sm-12 col-xs-12 col-form-label">
													<b>KÍCH THƯỚC - SỨC CHỨA</b>
												</label>
											</div>
											
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px">
											<div class="row form-group">
												<label class="col-md-6 col-sm-2 col-xs-2 col-form-label">LOA</label>
												<label class="col-md-6 col-sm-2 col-xs-2 col-form-label">LBP</label>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="LOA" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="LOA" type="text">
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="LBP" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="LBP" type="text">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px">
											<div class="row form-group">
												<label class="col-md-12 col-sm-12 col-xs-12 col-form-label">Max Beam</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input id="MaxBeam" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Max Beam" type="text">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px">
											<div class="row form-group">
												<label class="col-md-12 col-sm-12 col-xs-12 col-form-label">Antena Height</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input id="AntenaHeight" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Antena Height" type="text">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-1" style="height: 60px">
											<div class="row form-group">
												<label class="col-md-12 col-sm-12 col-xs-12 col-form-label">Độ sâu</label>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<input id="Depth" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Độ sâu" type="text">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="row form-group">
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">GRT</label>
												<label class="col-md-6 col-sm-6 col-xs-6 col-form-label">DWT</label>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="GRT" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="GRT" type="text">
												</div>
												<div class="col-md-6 col-sm-6 col-xs-6">
													<input id="DWT" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="DWT" type="text">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 pl-0 pr-0">
						<div class="ibox-body pt-3 pb-3 bg-f9">
							<div class="row ibox mb-0 border-e pb-1 pt-0">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="row form-group" style="text-align: center; background-color: #0b4660; color: #ffffff">
												<label class="col-md-12 col-sm-12 col-xs-12 col-form-label">
													<b>HÌNH ẢNH</b>
												</label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="row form-group">
												<img id="vessel-image" style="width: 140px; height: 130px; border: solid wheat; cursor: pointer; margin-right: auto; margin-left: auto;">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
											<div class="row form-group">
													<div style="margin-left: auto; margin-right: auto">
														<input hidden type="file" id="change-vessel-image" accept="image/x-png,image/gif,image/jpeg, image/jpg">
													</div>
													<!--
													<label id="imgLabel" for="change-vessel-image" class="btn" style=" margin-right: auto; margin-left: auto;">
														Chọn hình ảnh
													</label>
     												<input id="change-vessel-image" name="change-vessel-image" style="visibility: hidden;" type="file">
     												-->
											</div>											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>		

			<!-- -->
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="VesselID">Mã tàu</th>
							<th col-name="VesselName">Tên tàu</th>
							<th col-name="VesselType">Loại tàu</th>
							<th col-name="OprID">Hãng khai thác</th>
							<th col-name="NationID">Quốc gia</th>
							<th col-name="CallSign">Call Sign</th>
							<th col-name="Inmarsat">Inmarsat</th>		
							<th col-name="LLoyd">LLoyd</th>		
							<th col-name="IMO">IMO</th>		
							<th col-name="LOA">LOA</th>		
							<th col-name="LBP">LBP</th>		
							<th col-name="MaxBeam">Max Beam</th>		
							<th col-name="AntenaHeight">Antena Height</th>		
							<th col-name="Depth">Độ sâu</th>		
							<th col-name="GRT">GPT</th>		
							<th col-name="DWT">DWT</th>
						</tr>
						</thead>
						<tbody>
							<!--
							<?php if(count($vesselList) > 0) {
								  		$i = 1; ?>
								<?php foreach($vesselList as $item){  ?>
									<tr>
										<td col-name="STT"><?=$i;?></td>
										<td col-name="VesselID"><?=$item['VesselID'];?></td>
										<td col-name="VesselName"><?=$item['VesselName'];?></td>
										<td col-name="VesselType"><?=$item['VesselType'];?></td>
										<td col-name="OprID"><?=$item['OprID'];?></td>
										<td col-name="NationID"><?=$item['NationID'];?></td>					
										<td col-name="CallSign"><?=$item['CallSign'];?></td>
										<td col-name="Inmarsat"><?=$item['Inmarsat'];?></td>
										<td col-name="LLoyd"><?=$item['LLoyd'];?></td>		
										<td col-name="IMO"><?=$item['IMO'];?></td>									
										<td col-name="LOA"><?=$item['LOA'];?></td>									
										<td col-name="LBP"><?=$item['LBP'];?></td>									
										<td col-name="MaxBeam"><?=$item['MaxBeam'];?></td>
										<th col-name="AntenaHeight"><?=$item['AntenaHeight'];?></th>										
										<td col-name="Depth"><?=$item['Depth'];?></td>				
										<td col-name="GRT"><?=$item['GRT'];?></td>				
										<td col-name="DWT"><?=$item['DWT'];?></td>				
									</tr>
									<?php $i++; }  ?>
							<?php } ?>
							-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>	

<script type="text/javascript">
	$(document).ready(function () {
		var _columns 	= ["STT", "VesselID", "VesselName", "VesselType", "OprID", "NationID", "CallSign",  "Inmarsat", "LLoyd", "IMO", "LOA", "LBP", "MaxBeam", "AntenaHeight", "Depth", "GRT", "DWT"],
			tbl 		= $('#contenttable'),
			oprList		= {},
			nationList 	= {},
			parentMenuList 	= {},
			input_type 	= "add";

		<?php if(isset($oprList) && count($oprList) >= 0){?>
			oprList = <?= json_encode($oprList);?>;
		<?php } ?>

		<?php if(isset($nationList) && count($nationList) >= 0){?>
			nationList = <?= json_encode($nationList);?>;
		<?php } ?>		

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
		
		var dataTable = tbl.newDataTable({
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},
				{ className: "text-center", targets: _columns.getIndexs(["VesselID", "VesselName", "VesselType", "OprID", "NationID", "CallSign",  "Inmarsat", "LLoyd", "IMO", "LOA", "LBP", "MaxBeam", "AntenaHeight", "Depth", "GRT", "DWT"])},		
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns
		});

		if(isMobile.any()){
			$('#vessel-id-list').selectpicker('mobile');
		}

		$('#addrow').on('click', function(){
			$('#inputForm').trigger('reset');
			$('#OprID').selectpicker("refresh");
			$('#NationID').selectpicker("refresh");
			$("#change-vessel-image").val("");
			$("#inputForm").show();
			input_type = "add";
		});

		$('#search').on('click', function () {
			tbl.waitingLoad();
			var btn = $(this);
			btn.button('loading');

			var formData = {
				'action': 'view',
				'child_action': '',
				'vesselId': $('#VesselIDFilter').val(),
				'vesselName': $('#VesselNameFilter').val(),
				'vessel-image': $('#vessel-image').attr('src') ? $('#vessel-image').attr('src') : 1,
				'image-name': $('#VesselID').val() ? $('#VesselID').val() : '',
			};

			$.ajax({
				url: "<?=site_url(md5('Vessel') . '/' . md5('vsVessel'));?>",
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
									case "VesselType":
										if (rData[colname] == 1){
											val = '<input class="hiden-input" value="1">Tàu RoRo';
										}
										else{
											if (rData[colname] == 2){
												val = '<input class="hiden-input" value="2">Tàu Container';
											}
											else{
												val = '<input class="hiden-input" value="2">Tàu bách hóa';
											}
										}
									break;
									case "OprID":
										val='<input class="hiden-input" value="'+rData['OprID']+'">' + rData['OprName'];
										break;
									case "NationID":
										val='<input class="hiden-input" value="'+rData['NationID']+'">' + rData['NationName'];
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
					btn.button('reset');
					}
				},
				error: function(err){
					btn.button('reset');
				}
			});
		});


		$('#save').on('click', function(){
			var VesselID 	= $('#VesselID').val(),
				VesselName	= $('#VesselName').val(),
				VesselType	= $('#VesselType').val(),
				OprID		= $('#OprID').val(),
				NationID	= $('#NationID').val(),
				CallSign	= $('#CallSign').val(),
				Inmarsat	= $('#Inmarsat').val(),
				LLoyd		= $('#LLoyd').val(),
				IMO 		= $('#IMO').val(),
				LOA 		= $('#LOA').val(),
				LBP			= $('#LBP').val(),
				MaxBeam		= $('#MaxBeam').val(),
				AntenaHeight = $('#AntenaHeight').val(),
				Depth		= $('#Depth').val(),
				GRT			= $('#GRT').val(),
				DWT			= $('#DWT').val();
			
			if (VesselID == ""){
				toastr["error"]('Vui lòng nhập Mã tàu!');	
				return;
			}

			if (VesselName == ""){
				toastr["error"]('Vui lòng nhập Tên tàu!');	
				return;
			}

			if (VesselType == ""){
				toastr["error"]('Vui lòng nhập Loại tàu!');	
				return;
			}

			if (NationID == ""){
				toastr["error"]('Vui lòng chọn Quốc gia!');	
				return;
			}

			if (OprID == ""){
				toastr["error"]('Vui lòng chọn Hãng khai thác!');	
				return;
			}

			if (CallSign == ""){
				toastr["error"]('Vui lòng nhập Call Sign!');	
				return;
			}

			if (IMO == ""){
				toastr["error"]('Vui lòng nhập IMO!');	
				return;
			}


			var vesselArr = [{
				'VesselID': 	VesselID,
				'VesselName': 	VesselName,
				'VesselType': 	VesselType,
				'OprID': 		OprID,
				'NationID': 	NationID,
				'CallSign': 	CallSign,
				'Inmarsat': 	Inmarsat,
				'LLoyd': 		LLoyd,
				'IMO': 			IMO,
				'LOA': 			LOA,
				'LBP': 			LBP,
				'MaxBeam': 		MaxBeam,
				'Depth': 		Depth,
				'GRT': 			GRT,
				'DWT': 			DWT,
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
		                        saveData(vesselArr);
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC']
		                }
		            }
		    });
		});

		function saveData(formData){
			var fData = {
					'action': input_type,
					'data': formData,
					'imgSrc': $('#vessel-image').attr('src'),
					'imgName': $('#VesselID').val(),
				};
			postSave(fData);
		}

		function postSave(formData){
			var saveBtn = $('#save');
        	
			$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVessel'));?>",
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
                    	$('#search').trigger('click');
                    	return;
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
                    	$('#search').trigger('click');
                    	return;                    	
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		// Delete rows
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
			var delData = data.map(p=>p[_columns.indexOf("VesselID")]);

			var fdel = {
					'action': 'delete',
					'data': delData
				};

			$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVessel'));?>",
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

		tbl.on("click", function(){ // Double click
			var data            =  tbl.getSelectedData();

			var VesselID 		=  data[0][_columns.indexOf("VesselID")],			
				VesselName 		=  data[0][_columns.indexOf("VesselName")],
				VesselType 		=  data[0][_columns.indexOf("VesselType")], 
				OprID 			=  data[0][_columns.indexOf("OprID")], 
				NationID 		=  data[0][_columns.indexOf("NationID")], 
				CallSign 		=  data[0][_columns.indexOf("CallSign")], 
				Inmarsat 		=  data[0][_columns.indexOf("Inmarsat")], 
				LLoyd 			=  data[0][_columns.indexOf("LLoyd")], 
				IMO 			=  data[0][_columns.indexOf("IMO")], 
				LOA 			=  data[0][_columns.indexOf("LOA")], 
				LBP 			=  data[0][_columns.indexOf("LBP")], 
				MaxBeam 		=  data[0][_columns.indexOf("MaxBeam")], 
				AntenaHeight 	=  data[0][_columns.indexOf("AntenaHeight")], 
				Depth 			=  data[0][_columns.indexOf("Depth")], 
				GRT 			=  data[0][_columns.indexOf("GRT")], 
				DWT 			=  data[0][_columns.indexOf("DWT")];

			$('#VesselID').val(VesselID);
			$('#VesselName').val(VesselName);
			$('#VesselType').val(VesselType);

			$('#OprID').val($(OprID).val());
			$('#OprID').selectpicker("refresh");

			$('#NationID').val($(NationID).val());
			$('#NationID').selectpicker("refresh");

			$('#CallSign').val(CallSign);
			$('#Inmarsat').val(Inmarsat);
			$('#LLoyd').val(LLoyd);
			$('#IMO').val(IMO);
			$('#LOA').val(LOA);
			$('#LBP').val(LBP);
			$('#MaxBeam').val(MaxBeam);
			$('#AntenaHeight').val(AntenaHeight);
			$('#Depth').val(Depth);
			$('#GRT').val(GRT);
			$('#DWT').val(DWT);

			// Change type from "add" to "edit"
			input_type = 'edit';

			//
			$('#vessel-image').attr("src", "");
			$("#change-vessel-image").val("");

			$('#vessel-image').parent().blockUI();

			var imgData = {
				'action': 'view',
				'child_action': 'load_image',
				'image_name': data[0][_columns.indexOf("VesselID")],
			};

			$.ajax({
                url: "<?=site_url(md5('Vessel') . '/' . md5('vsVessel'));?>",
                dataType: 'json',
                data: imgData,
                type: 'POST',
                success: function (data) {

                	$('#vessel-image').parent().unblock();

                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
                    $('#vessel-image').attr('src', "<?=base_url('/assets/img/vessel_images/')?>" + data.image);
                },
                error: function(err){
                	$('#vessel-image').parent().unblock();

                	toastr["error"]("Error!");
                	console.log(err);
                }
            });

            //$('#vessel-image').attr('src', imgData['img']);
		});

		
		$('#change-vessel-image').on("change", function (e) {
			var input = this;
			var url = $(this).val();

			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
			{
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#vessel-image').attr('src', e.target.result);
				};

				reader.readAsDataURL(input.files[0]);
			}
			else
			{
				//$('#vessel-image').attr('src', "<?=base_url('/assets/images/users/noavatar.png')?>");
			}
			
		});
	
		$('#vessel-image').click(function(){
			$('#change-vessel-image').click();
		});

		/*
		$('#vessel-image').on("error", function(){
        	$(this).attr('src', "<?=base_url('/assets/img/vessel_images/default_vessel_image.png')?>");
    	});
    	*/


	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>