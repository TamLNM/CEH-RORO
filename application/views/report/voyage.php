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
	.ibox .ibox-footer {
	    padding: 10px 25px 5px 25px;
	}
	.modal_input{
		border-bottom: dotted 1px; 
		width: 70%;
	}
	.cash_input{
		border-bottom: dotted 1px; 
		width: 60%;
	}
	label{
		padding-right: 0px!important;
	}

	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
	#contenttable tbody tr.total_r{
		background: #fff0db !important;
	}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BIÊN BẢN KẾT TOÁN TÀU</div>
				<div class="button-bar-group mr-3">			
					

					<button id="Export" class="btn btn-outline-dark btn-sm btn-loading mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Export" title="Export">
						<span class="btn-icon"><i class="ti-export"></i>Export</span>
					</button>

					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu" title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e py-2">
				<div class="row ibox mb-0 border-e pb-1 pt-1">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="row-transfer-left">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-3">
								<div class="row">
									<input id="VoyageKey" class="form-control form-control-sm" type="text" hidden="">
									<input id="Email" class="form-control form-control-sm" type="text" hidden="">

									<label class="ml-3" style="width: 5.5rem; margin-top: 0.4rem">Thông tin tàu</label>		
									<input id="VesselName" placeholder="Tên tàu | Chuyến nhập | Chuyến xuất" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 16.5rem" type="text" readonly="true">

									<!-- -->
									<button id="chooseVessel" class="btn btn-success btn-icon-only btn-circle btn-sm btn-air ml-2" style="height: 1.65rem; width: 1.65rem" title="Chọn tàu">
										<i class="ti-plus"></i>
									</button>

									<button id="nochooseVessel" class="btn btn-danger btn-icon-only btn-circle btn-sm btn-air ml-2" style="height: 1.65rem; width: 1.65rem" title="Bỏ chọn">
										<i class="ti-close"></i>
									</button>
								</div>
								<div class="row form-group">
									<div class="ml-3 mt-3">
										<label class="mt-1 radio radio-info">
			                                <input type="radio" name="ClassID" checked class="css-checkbox" value="0">
			                                <span class="input-span"></span>Cả hai
			                            </label>	
										<label class="mt-1 ml-3 radio radio-info">
			                                <input type="radio" name="ClassID" class="css-checkbox" value="1">
			                                <span class="input-span"></span>Nhập tàu
			                            </label>	
										<label class="mt-1 ml-3 radio radio-info">
			                                <input type="radio" name="ClassID" class="css-checkbox" value="2">
			                             	<span class="input-span"></span>Xuất tàu
			                            </label>
			                        </div>
								</div>
							</div>								
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="ml-3" style="width: 6rem; margin-top: 0.4rem">ETA/ ETD</label>		
									<input id="ETA" placeholder="ETA" readonly="true" autocomplete="off" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 12rem" type="text">
									<input id="ETD" placeholder="ETD" readonly="true" autocomplete="off" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 12rem" type="text">
								</div>					
								<div class="row form-group">
									<button class="btn btn-outline-danger btn-fix btn-rounded btn-sm ml-3" id="exportReport">
		                                <span class="btn-icon"><i class="la la-mail-forward"></i>Xuất báo cáo</span>
		                            </button>

		                            <button class="btn btn-outline-success btn-fix btn-rounded btn-sm ml-3" id="confirmButton">
		                                <span class="btn-icon"><i class="la la-check"></i>Hoàn tất khai thác</span>
		                            </button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-12 table-responsive" id="tableBoth">
					<table id="contenttable3" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>							
								<th col-name="BillOfLading_BookingNo">Số vận đơn/ Booking</th>
								<th col-name="ClassID"> Nhập/ xuất tàu</th>	
								<th col-name="JobModeInID">Phương thức vào</th>							
								<th col-name="JobModeOutID">Phương thức ra</th>	
								<th col-name="DateIn">Ngày đến</th>													
								<th col-name="DateOut">Ngày rời</th>							
								<th col-name="Sequence">Sequence</th>
								<th col-name="CargoWeightGetIn" style="width:20px;">TL Hàng nhập</th>
								<th col-name="CargoWeightGetOut" style="width:20px;">TL Hàng xuất</th>
								<th col-name="RemainCargoWeight" style="width:20px;">TL Hàng tồn</th>
								<th col-name="UnitID">Đơn vị tính</th>							
							</tr>
						</thead>							
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-12 table-responsive" id="tableIn">
					<table id="contenttable2" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>							
								<th col-name="BillOfLading_BookingNo">Số vận đơn/ Booking</th>
								<th col-name="ClassID"> Nhập/ xuất tàu</th>	
								<th col-name="JobModeInID">Phương thức vào</th>							
								<th col-name="DateIn">Ngày đến</th>							
								<th col-name="Sequence">Sequence</th>
								<th col-name="CargoWeightGetIn" style="width:20px;">TL Hàng nhập</th>
								<th col-name="RemainCargoWeight" style="width:20px;">TL Hàng tồn</th>
								<th col-name="UnitID">Đơn vị tính</th>							
							</tr>
						</thead>							
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-12 table-responsive" id="tableOut">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
							<tr style="width: 100%">
								<th class="editor-cancel" col-name="STT">STT</th>							
								<th col-name="BillOfLading_BookingNo">Số vận đơn/ Booking</th>
								<th col-name="ClassID"> Nhập/ xuất tàu</th>	
								<th col-name="JobModeOutID">Phương thức ra</th>							
								<th col-name="DateOut">Ngày rời</th>							
								<th col-name="Sequence">Sequence</th>
								<th col-name="CargoWeightGetOut" style="width:20px;">TL Hàng xuất</th>
								<th col-name="RemainCargoWeight" style="width:20px;">TL Hàng tồn</th>
								<th col-name="UnitID">Đơn vị tính</th>							
							</tr>
						</thead>							
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>		
	</div>
</div>

<!-- Vessel modal-->
<div class="modal fade" id="vessel-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 5%; padding-top: 2%">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-1">Danh mục tàu</h5>
				<button id="VesselSearch" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
									data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
								 	title="Nạp dữ liệu">
					<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
				</button>
			</div>
			<div class="modal-body" style="padding: 0px 15px 15px 15px">
				<div class="row mb-0 border-e border-top-0 pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="col-md-2 col-sm-4 col-xs-4 col-form-label">Tàu</label>
										<input id="VesselNameFilter" class="col-md-8 col-sm-10 col-xs-10 form-control form-control-sm" placeholder="Tên tàu" type="text">
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Năm</label>
										<div class="col-md-8 col-sm-10 col-xs-10 input-group input-group-sm">
											<select id="YearFilter" data-width="100%" data-style="btn-default btn-sm"
													title="Năm"
													style="width: 80%; border-radius: 2px; border-color: rgba(0, 0, 0, .1);">
													<option value="">Tất cả</option>
												<?php for ($i = 2016; $i < 2026; $i++){ ?>
													<option value="<?=$i?>">
														<?=$i?>		
													</option>
												<?php } ?>												
											</select>
										</div>										
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
										<label class="radio radio-success ml-5 mt-1">
					                        <input type="radio" checked name="VesselFilter" class="css-checkbox" value="1" />
					                            <span class="input-span"></span>Đến cảng
					                    </label>								

										<label class="radio radio-success ml-3 mt-1 mr-3">
					                       <input type="radio" name="VesselFilter" class="css-checkbox" value="2" />
					                            <span class="input-span"></span>Rời cảng
					                    </label>   
									</div>
								</div>
							</div>
					</div>
				</div>
				<div class="row ibox-footer border-top-0 mt-3">
					<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
						<table id="tblVessel" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
							<thead>
								<tr style="width: 100%">
									<th col-name="STT">STT</th>
									<th col-name="VoyageKey"></th>
									<th col-name="VesselID">Mã tàu</th>
									<th col-name="VesselName">Tên tàu</th>
									<th col-name="InboundVoyage">Chuyến nhập</th>
									<th col-name="OutboundVoyage">Chuyến xuất</th>
									<th col-name="ETA">ETA</th>
									<th col-name="ETD">ETD</th>
									<th col-name="Status">Status</th>
									<th col-name="InLane">Chuyến nhập</th>
									<th col-name="OutLane">Chuyến xuất</th>
									<th col-name="Email">Email</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
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
		var tbl 				= $("#contenttable"),
			tbl2 				= $("#contenttable2"),
			tbl3 				= $("#contenttable3"),
			tblCustomer			= $("#tblCustomer"),
			tblVessel			= $("#tblVessel"),
			_columns 			= ["STT", "BillOfLading_BookingNo", "ClassID", "JobModeOutID", "DateOut", "Sequence", "CargoWeightGetOut", "RemainCargoWeight", "UnitID"],
			_columns2 			= ["STT", "BillOfLading_BookingNo", "ClassID", "JobModeInID", "DateIn", "Sequence", "CargoWeightGetIn", "RemainCargoWeight", "UnitID"],
			_columns3 			= ["STT", "BillOfLading_BookingNo", "ClassID", "JobModeInID", "JobModeOutID", "DateIn", "DateOut", "Sequence", "CargoWeightGetIn", "RemainCargoWeight", "UnitID"],
			_vesselColumns 		= ["STT", "VoyageKey", "VesselID", "VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "Status", "InLane", "OutLane", "Email"],
			_customerColumns 	= ["STT", "CusID", "CusName", "Address","CusTypeID", "CusTypeName", "PaymentTypeID", "PaymentTypeName"],
			vesselModal 		= $("#vessel-modal"),
			customerModal  		= $("#customer-modal"),
			UserID,
			updateMNFBulkList 	= [],
			portsEmployeeEmailList = [],
			vesselOwnerEmailList = [],
			customerList 		= {},
			jobModeList 		= {},
			methodList 			= {},
			parentMenuList 		= {};

		/* Load data for Port Employee Email List */
		<?php if(isset($portsEmployeeEmailList) && count($portsEmployeeEmailList) >= 0){?>
			portsEmployeeEmailList = <?= json_encode($portsEmployeeEmailList);?>;
		<?php } ?>

		/* Load data for Vessel Owner Email list */
		<?php if(isset($vesselOwnerEmailList) && count($vesselOwnerEmailList) >= 0){?>
			vesselOwnerEmailList = <?= json_encode($vesselOwnerEmailList);?>;
		<?php } ?>

		/* Load data for job mode list */
		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		/* Load data for method list */
		<?php if(isset($methodList) && count($methodList) >= 0){?>
			methodList = <?= json_encode($methodList);?>;
		<?php } ?>

		/* Load data for method list */
		<?php if(isset($portList) && count($portList) >= 0){?>
			portList = <?= json_encode($portList);?>;
		<?php } ?>

		/* Load data for User */
		<?php if(isset($GroupID) && count($GroupID) >= 0){?>
			GroupID = <?= json_encode($GroupID);?>;
		<?php } ?>

		/* Load data for Parent Menu list */
		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Order'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		/* Initial contenttable table */	
		tbl.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},		
				{ className: "text-center", targets: _columns.getIndexs([ "BillOfLading_BookingNo", "ClassID", "JobModeOutID", "DateOut", "Sequence", "CargoWeightGetOut", "RemainCargoWeight", "UnitID"])},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			"ordering": false,
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
            arrayColumns: _columns,
		});

		tbl2.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns2.indexOf('STT')},		
				{ className: "text-center", targets: _columns2.getIndexs(["BillOfLading_BookingNo", "ClassID", "JobModeInID", "DateIn", "Sequence", "CargoWeightGetIn", "RemainCargoWeight", "UnitID"])},
			],
			order: [[ _columns2.indexOf('STT'), 'asc' ]],
			"ordering": false,
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
            arrayColumns: _columns2,
		});

		tbl3.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns3.indexOf('STT')},		
				{ className: "text-center", targets: _columns3.getIndexs(["BillOfLading_BookingNo", "ClassID", "JobModeInID", "JobModeOutID", "DateIn", "DateOut", "Sequence", "CargoWeightGetIn", "RemainCargoWeight", "UnitID"])},
			],
			order: [[ _columns3.indexOf('STT'), 'asc' ]],
			"ordering": false,
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
            arrayColumns: _columns3,
		});

		/* Initial vessel table */	
		tblVessel.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _vesselColumns.indexOf('STT')},		
				{ className: "text-center", targets: _vesselColumns.getIndexs(["VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "InLane", "OutLane"])},
				{ className: "hiden-input", targets: _vesselColumns.getIndexs(["VoyageKey", "VesselID", "Status", "Email"])},
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

		/* Change ClassID selected radio event */
		$("#tableIn").hide();
		$("#tableOut").hide();
	    $('input[type=radio][name=ClassID]').change(function() {
			$("#tableIn").hide();
			$("#tableOut").hide();
			$("#tableBoth").hide();

	    	if (this.value == 0){	    		
	    		$("#tableBoth").show();
				return;
	    	}

	    	if (this.value == 1){	    		
				$("#tableIn").show();
				return;
	    	}

	    	if (this.value == 2){	    		
	    		$("#tableOut").show();
	    		return;
	    	}

	    });

		$("#VesselSearch").on('click', function(){
			tblVessel.waitingLoad();
			var formData = {
				'action': 		'view',
				'childAction': 	'loadVesselFilterList',
				'VBType': 		$("input[type='radio'][name='VesselFilter']:checked").val(),
				'VesselName':   $("#VesselNameFilter").val(),
				'Year': 		$("#YearFilter").val(),
				'VIType': 		3
			};			

		    $.ajax({
				url: "<?=site_url(md5('Data') . '/' . md5('dtManifest'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					tblVessel.dataTable().fnClearTable();
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_vesselColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;
									case "ETA":
									case "ETD":
										val = getDateTime(rData[colname]);
										break;
									default:
										val = (rData[colname] ? rData[colname] : '');
										break;	
								}
								r.push(val);
							});
							rows.push(r);
						}
					}
					tblVessel.dataTable().fnClearTable();
				    if(rows.length > 0){
						tblVessel.dataTable().fnAddData(rows);
			    	}
			    
				},
				error: function(err){
					tblVessel.dataTable().fnClearTable();
					console.log(err);
				}
			});
		});

		/* Choose vessel */
		$("#chooseVessel").on('click', function(){
			$('#vessel-modal').modal("show");
			$("#VesselSearch").trigger('click');
		});

		$(document).on("dblclick", "#tblVessel tbody tr",  function(){
       		var VesselData = tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey  = VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName = VesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage  = VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage = VesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			ETA = VesselData[_vesselColumns.indexOf("ETA")],
       			ETD = VesselData[_vesselColumns.indexOf("ETD")],
       			Email = VesselData[_vesselColumns.indexOf("Email")],
       			formData = {
					'action': 					'view',
					'VoyageKey': 				VoyageKey,
					'IsLocalForeign': 			'',
					'ClassID': 					'',
				};
			$("#ETA").val(ETA);
			$("#ETD").val(ETD);
			$("#VesselName").data('VoyageKey',VoyageKey).data('InboundVoyage',InboundVoyage).data('OutboundVoyage',OutboundVoyage).val(VesselName+" | "+InboundVoyage+" | "+OutboundVoyage);
			$("#VoyageKey").val(VoyageKey);
			$("#Email").val(Email);

			$("#search").trigger('click');
       		vesselModal.modal('hide');
       	});

       	$("#apply-vessel").on("click", function(){
       		var VesselData = tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey  = VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName = VesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage  = VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage = VesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			ETA = VesselData[_vesselColumns.indexOf("ETA")],
       			ETD = VesselData[_vesselColumns.indexOf("ETD")],
       			Email = VesselData[_vesselColumns.indexOf("Email")],

       			formData = {
					'action': 					'view',
					'VoyageKey': 				VoyageKey,
					'IsLocalForeign': 			'',
					'ClassID': 					'',
				};

			$("#ETA").val(ETA);
			$("#ETD").val(ETD);
			$("#VesselName").data('VoyageKey',VoyageKey).data('InboundVoyage',InboundVoyage).data('OutboundVoyage',OutboundVoyage).val(VesselName+" | "+InboundVoyage+" | "+OutboundVoyage);
			$("#VoyageKey").val(VoyageKey);
			$("#Email").val(Email);
			
			$("#search").trigger('click');
       	});

		function number_fm(amount, decimalCount = 2, decimal = ".", thousands = ",") {
		  	try {
			    decimalCount = Math.abs(decimalCount);
			    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

			    const negativeSign = amount < 0 ? "-" : "";

			    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
			    let j = (i.length > 3) ? i.length % 3 : 0;

			    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "").replace(/\.00$/, '');
		  	} 
		  	catch (e) {
		    	console.log(e)
		  	}
		};

		$("#search").on('click', function(){
			if (!($("#VesselName").val())){
				toastr['error']("Vui lòng chọn tàu!");
				return;
			}

			if ($("input[type=radio][name=ClassID]:checked").val() == 0){
				find_v_for_both();
				return;
			}

			if ($("input[type=radio][name=ClassID]:checked").val() == 1){
				find_v_for_in();
				return;
			}

			if ($("input[type=radio][name=ClassID]:checked").val() == 2){
				find_v_for_out();
				return;
			}
		});

		function find_v_for_both(){
			tbl3.waitingLoad();

			var VoyageKey		= $("#VesselName").data('VoyageKey'),
				InboundVoyage	= $("#VesselName").data('InboundVoyage'),
				OutboundVoyage	= $("#VesselName").data('OutboundVoyage'),
				formData 		= {
					'VoyageKey': VoyageKey,
					'InboundVoyage': InboundVoyage,
					'OutboundVoyage': OutboundVoyage,
				};

			$.ajax({
		    	url: "<?=site_url(md5('Report') . '/' . md5('getVesselReportForBoth'));?>",
		        dataType: 'json',
		        data: formData,
		        type: 'POST',
		        success: function (data) {
		            tbl3.DataTable().clear().draw();

		        	if(data.deny) {
		                toastr["error"](data.deny);
		                return;
		            }

		            if(data.dataInList  && data.dataInList.length > 0){
		            	var remainCargoWeight = 0,
		            		index = 1;

		            	$(data.dataInList).each(function(i,item){
		            		var row = [];
		            		
		            		remainCargoWeight += parseFloat(item['CargoWeightGetIn']);

		            		row[0]=index++;
		            		row[1]=(item['BillOfLading']||"")+(item['BookingNo']||"")+(item['CargoWeight']?" - "+number_fm(item['CargoWeight'])+" "+(item['UnitID_I']||""):"");
		            		row[2]=item['ClassID']+""=='1'?"Nhập":"Xuất";
		            		row[3]=item['JobModeInID'];
		            		row[4]='';
		            		row[5]=getDateTime(item['DateIn']);
		            		row[6]='';
		            		row[7]=item['Sequence'];
		            		row[8]=number_fm(item['CargoWeightGetIn']);
		            		row[9]='';
		            		row[10]=number_fm(remainCargoWeight);                    		
		            		row[11]=item['UnitID_I'];

		            		$("#contenttable3").DataTable().row.add(row).draw();
		            		$("#contenttable3 tr:nth-child("+row[0]+")").attr("endrow",(item['BillOfLading']||"")+(item['BookingNo']||"")).attr('CargoWeight',item['CargoWeight']);
		            	});
		            }

		            if(data.dataOutList && data.dataOutList.length > 0){
		            	$(data.dataOutList).each(function(i,item){
		            		var row = [];

		            		row[0] = index++;
		            		row[1] = (item['BillOfLading']||"")+(item['BookingNo']||"")+(item['CargoWeight']?" - "+number_fm(item['CargoWeight'])+" "+(item['UnitID_I']||""):"");
		            		row[2] = item['ClassID']+""=='1' ? "Nhập" : "Xuất";
		            		row[3] = '';
		            		row[4] = item['JobModeOutID'];
		            		row[5] = '';
		            		row[6] = getDateTime(item['DateIn']);
		            		row[7] = item['Sequence'];
		            		row[8] = '';
		            		row[9] = number_fm(item['CargoWeightGetOut']);
		            		row[10] = number_fm(item['RemainCargoWeight']);                    		
		            		row[11] = item['UnitID_I'];

		            		$("#contenttable3").DataTable().row.add(row).draw();
		            		$("#contenttable3 tr:nth-child("+row[0]+")").attr("endrow",(item['BillOfLading']||"")+(item['BookingNo']||"")).attr('CargoWeight',item['CargoWeight']);
		            	});		     
		            }

		           	if (data.totalIn){		    
			            Object.keys(data.totalIn).map(function(objectKey, index) {
							var value = data.totalIn[objectKey];

						    $("<tr class=total_r><td colspan=8 align=right>Tổng Cộng : </td><td style='text-align: center'>"+ number_fm(value) +"</td><td></td><td colspan=2>Tồn : " + number_fm(remainCargoWeight) +"</td></tr>").insertAfter($("#contenttable3 tr[endrow='"+objectKey+"']").last());
						});
					}

		           	if (data.totalOut){
						Object.keys(data.totalOut).map(function(objectKey, index) {
							var value = data.totalOut[objectKey];

						    $("<tr class=total_r><td colspan=8 align=right>Tổng Cộng : </td><td style='text-align: center'>"+ number_fm(value) +"</td><td></td><td colspan=2>Tồn : " + number_fm('123') +"</td></tr>").insertAfter($("#contenttable3 tr[endrow='"+objectKey+"']").last());
						});
					}
		        },
		        error: function(err){
		            tbl3.DataTable().clear().draw();
		        	toastr["error"]("Error!");
		        	console.log(err);
		        }
		    });


		}

		function find_v_for_in(){
			tbl2.waitingLoad();
			
			var VoyageKey		= $("#VesselName").data('VoyageKey'),
				InboundVoyage	= $("#VesselName").data('InboundVoyage'),
				OutboundVoyage	= $("#VesselName").data('OutboundVoyage'),
				ClassID			= $("input[name='ClassID']:checked").val(),
				formData 		= {
					'VoyageKey': VoyageKey,
					'ClassID': 	 ClassID,
					'InboundVoyage': InboundVoyage,
					'OutboundVoyage': OutboundVoyage,
				};

			$.ajax({
		    	url: "<?=site_url(md5('Report') . '/' . md5('getVesselReportForIn'));?>",
		        dataType: 'json',
		        data: formData,
		        type: 'POST',
		        success: function (data) {
		            tbl2.DataTable().clear().draw();

		            if(data.deny) {
		                toastr["error"](data.deny);
		                return;
		            }

		            if(data.list.length>0){
		            	var remainCargoWeight = 0,
		            		index = 1;

		            	$(data.list).each(function(i,item){
		            		var row = [];
		            		
		            		remainCargoWeight += parseFloat(item['CargoWeightGetIn']);

		            		row[0]=index++;
		            		row[1]=(item['BillOfLading']||"")+(item['BookingNo']||"")+(item['CargoWeight']?" - "+number_fm(item['CargoWeight'])+" "+(item['UnitID_I']||""):"");
		            		row[2]=item['ClassID']+""=='1'?"Nhập":"Xuất";
		            		row[3]=item['JobModeInID'];
		            		row[4]=getDateTime(item['DateIn']);
		            		row[5]=item['Sequence'];
		            		row[6]=number_fm(item['CargoWeightGetIn']);
		            		row[7]=number_fm(remainCargoWeight);                    		
		            		row[8]=item['UnitID_I'];

		            		$("#contenttable2").DataTable().row.add(row).draw();
		            		$("#contenttable2 tr:nth-child("+row[0]+")").attr("endrow",(item['BillOfLading']||"")+(item['BookingNo']||"")).attr('CargoWeight',item['CargoWeight']);
		            	});

		            	Object.keys(data.total).map(function(objectKey, index) {
							var value = data.total[objectKey];

						    $("<tr class=total_r><td colspan=6 align=right>Tổng Cộng : </td><td style='text-align: center'>"+ number_fm(value) +"</td><td colspan=2>Tồn : " + number_fm(remainCargoWeight) +"</td></tr>").insertAfter($("#contenttable2 tr[endrow='"+objectKey+"']").last());
						});
		            }
		        },
		        error: function(err){
		            tbl2.DataTable().clear().draw();
		        	toastr["error"]("Error!");
		        	console.log(err);
		        }
		    });
		}

		function find_v_for_out(){
			tbl.waitingLoad();

			var VoyageKey		= $("#VesselName").data('VoyageKey'),
				InboundVoyage	= $("#VesselName").data('InboundVoyage'),
				OutboundVoyage	= $("#VesselName").data('OutboundVoyage'),
				ClassID			= $("input[name='ClassID']:checked").val();

			$.ajax({
		    	url: "<?=site_url(md5('Report') . '/' . md5('getVesselReportForOut'));?>",
		        dataType: 'json',
		        data: {"VoyageKey": VoyageKey, "ClassID": ClassID, "OutboundVoyage": OutboundVoyage, "InboundVoyage": InboundVoyage},
		        type: 'POST',
		        success: function (data) {
		            $("#contenttable").DataTable().clear().draw();

		            if(data.deny) {
		                toastr["error"](data.deny);
		                return;
		            }

		            if(data.list.length>0){
		            	$(data.list).each(function(i,item){
		            		var row = [];
		            		
		            		row[0]=i+1;
		            		row[1]=(item['BillOfLading']||"")+(item['BookingNo']||"")+(item['CargoWeight']?" - "+number_fm(item['CargoWeight'])+" "+(item['UnitID_I']||""):"");
		            		row[2]=item['ClassID']+""=='1'?"Nhập":"Xuất";
		            		row[3]=item['JobModeOutID'];
		            		row[4]=item['DateOut'];
		            		row[5]=item['Sequence'];
		            		row[6]=number_fm(item['CargoWeightGetOut']);
		            		row[7]=number_fm(item['RemainCargoWeight']);                    		
		            		row[8]=item['UnitID_O'];

		            		$("#contenttable").DataTable().row.add(row).draw();
		            		$("#contenttable tr:nth-child("+row[0]+")").attr("endrow",(item['BillOfLading']||"")+(item['BookingNo']||"")).attr('CargoWeight',item['CargoWeight']);
		            	});
		            }

		            Object.keys(data.total).map(function(objectKey, index) {
						var value = data.total[objectKey];
					    $("<tr class=total_r><td colspan=6 align=right>Tổng Cộng : </td><td>"+number_fm(value)+"</td><td colspan=2>Tồn : "+number_fm(parseFloat($("#contenttable tr[endrow='"+objectKey+"']").last().attr('CargoWeight')-parseFloat(value)))+"</td></tr>").insertAfter($("#contenttable tr[endrow='"+objectKey+"']").last());
					});
		        },
		        error: function(err){
		            $("#contenttable").DataTable().clear().draw();
		        	toastr["error"]("Error!");
		        	console.log(err);
		        }
		    });
		}

		$("#Export").on('click', function(){
			fnExcelReport();
		});

		// Export excel
		function fnExcelReport()
		{
		    var tab_text="<table border='2px'>";
		    var textRange; var j=0;
		    tab = document.getElementById('contenttable'); // id of table
		    //alert($(tab).find("thead tr").html());
		    var theader="";
		    $(tab).find("thead tr th").each(function(){
		    	theader+="<td width=200><b>"+$(this).html()+"</b></td>";
		    });
		    tab_text+="<tr bgcolor='#FFFFFF'>"+theader+"</tr>";
		    for(j = 0 ; j < tab.rows.length ; j++) 
		    {     
		        tab_text+="<tr>"+tab.rows[j].innerHTML+"</tr>";
		        //tab_text=tab_text+"</tr>";
		    }

		    tab_text=tab_text+"</table>";
		    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE "); 

		    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		    {
		        txtArea1.document.open("txt/html","replace");
		        txtArea1.document.write(tab_text);
		        txtArea1.document.close();
		        txtArea1.focus(); 
		        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		    }  
		    else                 //other browser not tested on IE 11
		        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

		    return (sa);
		}

		$("#exportReport").on('click', function(){
			if (!($("#VoyageKey").val())){
				toastr['error']("Vui lòng chọn tàu để xuất báo cáo!");
				return;
			}

			var url = '<?=site_url(md5('Report') . '/' . md5('exportVesselReportFile'));?>';
			
			url += ('/' + $("#VoyageKey").val());
			url += ('/' + $("input[type=radio][name=ClassID]:checked").val());
			window.open(url);
		});

		$("#confirmButton").on('click', function(){
			if (!($("#VesselName").val())){
				toastr['error']("Vui lòng chọn tàu!");
				return;
			}

		
			if (GroupID == 'GroupAdmin'){
				var emailList = [];

				for (i = 0; i < vesselOwnerEmailList.length; i++){
					var objData = { 'Email': vesselOwnerEmailList[i]['Email'], };
					emailList.push(objData);
				}

				$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Xác nhận việc hoàn tất khai thác tàu' + $("#VoyageKey").val() + '!\nTiếp tục?',
		            buttons: {
		                ok: {
		                    text: 'Xác nhận',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
								toastr['success']("Xác nhận thành công!");
		                        sendMailByAdmin(emailList);
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
			
			if (GroupID == 'GroupVesselOwner'){
				/* Get email list */
				var strEmail = $("#Email").val(),
					emailList = [];

				for (i = strEmail.length; i >= 0; i--){
					var firstPos = strEmail.lastIndexOf('; '),
						lastPos  = strEmail.length;

					if (firstPos == -1){
						firstPos = -2;
					}
					
					var temp = strEmail.substring(firstPos + 2, lastPos);

					strEmail = strEmail.substring(0, firstPos);
					i = firstPos;		

					var objData = {	'Email': temp, };
					emailList.push(objData);
				}

				for (i = 0; i < vesselOwnerEmailList.length; i++){
					var objData = { 'Email': vesselOwnerEmailList[i]['Email'], };
					emailList.push(objData);
				}

				for (i = 0; i < portsEmployeeEmailList.length; i++){
					var objData = { 'Email': portsEmployeeEmailList[i]['Email'], };
					emailList.push(objData);
				}

				$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Xác nhận biên bản kết toán và hoàn tất khai thác tàu' + $("#VoyageKey").val() + '!\nTiếp tục?',
		            buttons: {
		                ok: {
		                    text: 'Xác nhận',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
								toastr['success']("Xác nhận thành công!");
		                        confirmByVesselOwner(emailList);
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
		});

		function sendMailByAdmin(emailList){
			var reportURL  = '<?=site_url(md5('Report') . '/' . md5('exportVesselReportFile'));?>',
				confirmURL = '<?=site_url(md5('Report') . '/' . md5('BaoCao_tau'));?>';
			
			reportURL += ('/' + $("#VoyageKey").val());
			reportURL += ('/' + $("input[type=radio][name=ClassID]:checked").val());

			var vesselName = $("#VesselName").val(),
				formData = {
					'action': 'view',
					'child_action': 'sendMailByAdmin',
					'Email': emailList,
					'VoyageKey': $("#VoyageKey").val(),
					'VesselName': vesselName.substring(0, vesselName.indexOf('|')),
					'ReportURL': reportURL,
					'ConfirmURL': confirmURL,
				};

			$.ajax({
				url: "<?=site_url(md5('Report') . '/' . md5('BaoCao_tau'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
				},
				error: function(err){
					console.log(err);
					return;
				}
			});
		}

		function confirmByVesselOwner(emailList){
			var reportURL  = '<?=site_url(md5('Report') . '/' . md5('exportVesselReportFileForGuess'));?>';
			
			reportURL += ('/' + $("#VoyageKey").val());
			reportURL += ('/' + $("input[type=radio][name=ClassID]:checked").val());

			var vesselName = $("#VesselName").val(),
				formData = {
					'action': 'view',
					'child_action': 'sendMailAfterConfirm',
					'Email': emailList,
					'VoyageKey': $("#VoyageKey").val(),
					'VesselName': vesselName.substring(0, vesselName.indexOf('|')),
					'ReportURL': reportURL,
				};

			$.ajax({
				url: "<?=site_url(md5('Report') . '/' . md5('BaoCao_tau'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
				},
				error: function(err){
					console.log(err);
					return;
				}
			});
		}
	});
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>						