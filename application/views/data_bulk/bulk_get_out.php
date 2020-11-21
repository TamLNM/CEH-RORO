<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">HÀNG RỜI GET-OUT</div>
				<div class="button-bar-group mr-3">			
					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>					
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-3">
								<div class="row">
									<input id="VoyageKey" class="form-control form-control-sm" type="text" hidden>

									<label class="ml-3" style="width: 5.5rem; margin-top: 0.4rem">Thông tin tàu</label>		
									<input id="VesselName" placeholder="Tên tàu | Chuyến nhập | Chuyến xuất" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 16.5rem" type="text">

									<!-- -->
									<button id="chooseVessel" class="btn btn-success btn-icon-only btn-circle btn-sm btn-air ml-2" style="height: 1.65rem; width: 1.65rem" title="Chọn tàu">
										<i class="ti-plus"></i>
									</button>

									<button id="nochooseVessel" class="btn btn-danger btn-icon-only btn-circle btn-sm btn-air ml-2" style="height: 1.65rem; width: 1.65rem" title="Bỏ chọn">
										<i class="ti-close"></i>
									</button>

									<input hidden id="VoyageKey">
								</div>
								<div class="row">
									<div class="ml-3 mt-2">
										<label class="mt-1 radio radio-info">
			                                <input type="radio" name="ClassID" class="css-checkbox" value="1" />
			                                <span class="input-span"></span>Nhập tàu
			                            </label>	
										<label class="mt-1 ml-3 radio radio-info">
			                                <input type="radio" checked name="ClassID" class="css-checkbox" value="2" />
			                             	<span class="input-span"></span>Xuất tàu
			                            </label>

			                            <label class="mt-1 ml-5 radio radio-warning">
			                                <input type="radio" name="IsLocalForeign" class="css-checkbox" value="1" />
			                                <span class="input-span"></span><span style="margin-left: 0;">Hàng nội</span>
			                            </label>	
										<label class="mt-1 ml-3 radio radio-warning">
			                                <input type="radio" checked name="IsLocalForeign" class="css-checkbox" value="2" />
			                                <span class="input-span"></span>Hàng ngoại
			                        	</label>
			                        </div>
								</div>
							</div>								
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 mb-3">
								<div class="row">
									<label class="ml-3" style="width: 6rem; margin-top: 0.4rem">ETA/ ETD</label>		
									<input id="ETA" placeholder="ETA" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 12rem" type="text">
									<input id="ETD" placeholder="ETD" style="border-radius: 5px; margin-left: 1rem; padding-left: 7.5px; border-color: rgba(0, 0, 0, .1); border-width: 1px; height: 2rem; width: 12rem" type="text">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="tableIn">
					<div class="row">
						<div class="col-6">
							<table id="tblStockBulk" class="table table-striped display nowrap" cellspacing="0">
								<thead>
								<tr>
									<th class="editor-cancel" col-name="STT">STT</th>
									<th col-name="rowguid">rowguid</th>
									<th col-name="BillOfLadingORBookingNo">Số vận đơn/ booking</th>
									<th col-name="BillOfLading">Số vận đơn</th>
									<th col-name="BookingNo">Số booking</th>
									<th col-name="CargoWeight">Trọng lượng hàng (dự kiến)</th>
									<th col-name="UnitID">Đơn vị tính</th>
									<th col-name="CommodityDescription">Mô tả</th>
								</tr>
								</thead>
								<tbody>
									<!--
									<?php if(count($stockBulkList) > 0) {$i = 1; ?>
										<?php foreach($stockBulkList as $item) {  ?>
											<tr>
												<td style="text-align: center"><?=$i;?></td>
												<td><?=$item['rowguid'];?></td>
												<td><?=$item['VoyageKey'];?></td>
												<td>
													<?php 
														if ($item['BillOfLading']){
															echo ($item['BillOfLading']);
														}
														else if ($item['BookingNo']){
															echo ($item['BookingNo']);
														}
													?>
												</td>
												<td><?=$item['BillOfLading'];?></td>
												<td><?=$item['BookingNo'];?></td>
												<td><?=$item['CargoWeight'];?></td>
												<td><?=$item['UnitID'];?></td>
												<td><?=$item['CommodityDescription'];?></td>									
											</tr>
										<?php $i++; }  ?>
									<?php } ?>
									-->
								</tbody>
							</table>
						</div>
						<div class="col-6">
							<table id="tblStockOutBulk" class="table table-striped display nowrap" cellspacing="0">
								<thead>
								<tr>
									<th class="editor-cancel" col-name="STT">STT</th>
									<th col-name="EirNo">Số lệnh</th>
									<th col-name="Sequence">Sequence</th>
									<th col-name="CargoWeightGetOut">Trọng lượng xe ra</th>
									<th col-name="UnitID">Đơn vị tính</th>
									<th col-name="DateOut">Ngày ra</th>
									<th col-name="RemainCargoWeight">Trọng lượng còn lại</th>
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
									<th col-name="VesselName">Tên tàu</th>
									<th col-name="InboundVoyage">Chuyến nhập</th>
									<th col-name="OutboundVoyage">Chuyến xuất</th>
									<th col-name="ETA">ETA</th>
									<th col-name="ETD">ETD</th>
									<th col-name="Status">Status</th>
									<th col-name="InLane">Chuyến nhập</th>
									<th col-name="OutLane">Chuyến xuất</th>
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
		var _stockColumns	= ["STT", "rowguid", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "CargoWeight", "UnitID", "CommodityDescription"],
			_stockOutColumns = ["STT", "EirNo", "Sequence", "CargoWeightGetOut", "UnitID", "DateOut", "RemainCargoWeight"];
			_vesselColumns 	= ["STT", "VoyageKey", "VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "Status", "InLane", "OutLane"],
			tblStockBulk 	= $("#tblStockBulk"),
			tblStockOutBulk	= $("#tblStockOutBulk"),
			tblVessel		= $("#tblVessel"),
			vesselModal 	= $("#vessel-modal"),
			parentMenuList  = {};

		/* Load data for Parent Menu */
		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'DataBulk'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		/* Initial table format */
		tblStockBulk.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _stockColumns.getIndexs(["STT"]) },	
				{ className: "text-center", targets: _stockColumns.getIndexs( [ "VoyageKey", "BillOfLadingORBookingNo", "CargoWeight", "UnitID", "CommodityDescription"] )},		
				{ className: "hiden-input", targets: _stockColumns.getIndexs( [ "BillOfLading", "BookingNo", "rowguid" ])},
			],
			order: [[ _stockColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
                style: 'single',
                info: false,
            },
            rowReorder: false,
            arrayColumns: _stockColumns,
            buttons: [],
		});
		//tblStockBulk.editableTableWidget({editor: $("#status, #httt, #editor-input")});

		tblStockOutBulk.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _stockOutColumns.getIndexs(["STT"]) },	
				{ className: "text-center", targets: _stockOutColumns.getIndexs( [ "EirNo", "Sequence", "CargoWeightGetOut", "UnitID", "DateOut", "RemainCargoWeight"] )},		
			],
			order: [[ _stockOutColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
                style: 'single',
                info: false,
            },
            rowReorder: false,
            arrayColumns: _stockOutColumns,
            buttons: [],
		});

		/* Initial vessel table */	
		tblVessel.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _vesselColumns.indexOf('STT')},		
				{ className: "text-center", targets: _vesselColumns.getIndexs(["VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "InLane", "OutLane"])},
				{ className: "hiden-input", targets: _vesselColumns.getIndexs(["VoyageKey", "VesselID", "Status"])},
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

		$("#VesselSearch").on('click', function(){
			tblVessel.waitingLoad();
			var formData = {
				'action': 		'view',
				'childAction': 	'loadVesselFilterList',
				'VBType': 		$("input[type='radio'][name='VesselFilter']:checked").val(),
				'VesselName':   $("#VesselNameFilter").val(),
				'Year': 		'',
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

		$("#nochooseVessel").on('click', function(){
			tblStockBulk.dataTable().fnClearTable();
			tblStockOutBulk.dataTable().fnClearTable();
			
			$("#VesselName").val('');
			$("#ETA").val('');
			$("#ETD").val('');
		});

		$("#search").on('click', function(){
			loadStockBulkData();
		});

		$(document).on("dblclick", "#tblVessel tbody tr",  function(){
       		var VesselData = tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey  = VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName = VesselData[_vesselColumns.indexOf("VesselName")],
       			ETA  	   = VesselData[_vesselColumns.indexOf("ETA")],
       			ETD        = VesselData[_vesselColumns.indexOf("ETD")],
       			InboundVoyage  = VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage = VesselData[_vesselColumns.indexOf("OutboundVoyage")];
         		
			$("#VesselName").val(VesselName + ' | ' + InboundVoyage + ' | ' + OutboundVoyage);
			$("#VoyageKey").val(VoyageKey);
			$("#ETA").val(ETA);
			$("#ETD").val(ETD);
			loadStockBulkData();
       		vesselModal.modal('hide');
       	});
       		
       	$("#apply-vessel").on('click', function(){
       		var VesselData = tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey  = VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName = VesselData[_vesselColumns.indexOf("VesselName")],
       			ETA  	   = VesselData[_vesselColumns.indexOf("ETA")],
       			ETD        = VesselData[_vesselColumns.indexOf("ETD")],
       			InboundVoyage  = VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage = VesselData[_vesselColumns.indexOf("OutboundVoyage")];
         		
			$("#VesselName").val(VesselName + ' | ' + InboundVoyage + ' | ' + OutboundVoyage);
			$("#ETA").val(ETA);
			$("#ETD").val(ETD);
			$("#VoyageKey").val(VoyageKey);
			loadStockBulkData();
       	});

       	$(document).on("click", "#tblStockBulk td",  function(){
            var data 	 = tblStockBulk.getSelectedRows().data().toArray()[0],
            	stockRef = data[_stockColumns.indexOf('rowguid')],
            	formData = {
            		'action': 'view',
            		'child_action': 'loadStockOutBulkList',
            		'StockRef': stockRef,	
            	};

            tblStockOutBulk.waitingLoad();
            $.ajax({
				url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkGetOut'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					tblStockOutBulk.dataTable().fnClearTable();
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_stockOutColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;
									case "UnitID":
										val = "<input class='hiden-input' value='" + rData[colname] + "'>" + rData['UnitName'];
										break;
									case "DateOut":
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

				    if(rows.length > 0){
						tblStockOutBulk.dataTable().fnAddData(rows);
			    	}
				},
				error: function(err){
					tblStockOutBulk.dataTable().fnClearTable();
					console.log(err);
				}
			});
        });

       	$("input[type=radio][name=ClassID]").on('change', function(){
        	if ($("#VesselName").val()){
        		$("#search").trigger('click');
        	}
        });

        $("input[type=radio][name=IsLocalForeign]").on('change', function(){
        	if ($("#VesselName").val()){
        		$("#search").trigger('click');
        	}
        });

        $("input[type=radio][name=ClassID]").on('change', function(){
        	if ($("#VesselName").val()){
        		$("#search").trigger('click');
        	}
        });

        $("input[type=radio][name=IsLocalForeign]").on('change', function(){
        	if ($("#VesselName").val()){
        		$("#search").trigger('click');
        	}
        });

        function loadStockBulkData(){
        	var formData = {
					'action': 		  'view',
					'child_action':   'loadStockBulkList',
					'VoyageKey': 	  $("#VoyageKey").val(),
					'IsLocalForeign': $("input[type=radio][name=IsLocalForeign]:checked").val(),
					'ClassID': 		  $("input[type=radio][name=ClassID]:checked").val(),
				};

			tblStockBulk.waitingLoad();

			$.ajax({
				url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkGetOut'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					tblStockBulk.dataTable().fnClearTable();
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_stockColumns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;
									case "BillOfLadingORBookingNo":
										if (rData['BillOfLading']){
											val = rData['BillOfLading'];
										}
										else if (rData['BookingNo']){
											val = rData['BookingNo'];
										}
										break;
									case "UnitID":
										val = "<input class='hiden-input' value='" + rData[colname] + "'>" + rData['UnitName'];
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
					tblStockBulk.dataTable().fnClearTable();
				    if(rows.length > 0){
						tblStockBulk.dataTable().fnAddData(rows);
			    	}
				},
				error: function(err){
					tblStockBulk.dataTable().fnClearTable();
					console.log(err);
				}
			});
        }
	});
</script>
