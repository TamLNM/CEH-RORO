<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
	<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
 	<!-- Socket -->
    <script src="<?=base_url('/sockets/node_modules/socket.io-client/dist/socket.io.js');?>"></script>

    <script type="text/javascript">
        var socket = io.connect('https://demororo.cehsoft.com/');
   	</script>

<style>
	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-4 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-5 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-12 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-22 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-32 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-42 .dropdown-menu .dropdown-item .sub-text,
	#contenttable2_wrapper .dataTables_scroll #cell-context-52 .dropdown-menu .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">NHẬP LIỆU - HÀNG RỜI</div>
				<div class="button-bar-group mr-3">			
					<a  class="btn mt-2" id="downloadFileForImport">
						<i style="color: #365899;"><u>Tải file import mẫu...</u></i>
					</a>

					<label id="imgLabel" for="import" class="btn btn-outline-info btn-sm mt-2">
						<span class="btn-icon"><i class="ti-import"></i>Import</span>
					</label>
     				<input id="import" name="import" style="visibility: hidden; width: 1px" type="file">

					<button id="Export" class="btn btn-outline-dark btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Export"
										 	title="Export">
						<span class="btn-icon"><i class="ti-export"></i>Export</span>
					</button>

					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" 
											data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu"
										 	title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" 
										title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
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
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid">rowguid</th>											
							<th col-name="VoyageKey">VoyageKey</th>	
							<th col-name="BillOfLading">Số vận đơn</th>		
							<th col-name="JobModeID">Phương án</th>
							<th col-name="MethodID">Phương thức</th>
							<th col-name="CargoWeight">Trọng lượng hàng</th>
							<th col-name="UnitID">Đơn vị tính</th>
							<th col-name="Sequence">Sequence</th>
							<th col-name="CntrNo">Số Cont</th>
							<th col-name="ClassID">Nhập/ xuất tàu</th>
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							<th col-name="CommodityDescription">Mô tả</th>					
						</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive" id="tableOut">
					<table id="contenttable2" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid">rowguid</th>											
							<th col-name="VoyageKey">VoyageKey</th>	
							<th col-name="BookingNo">Số booking</th>	
							<th col-name="JobModeID">Phương án</th>
							<th col-name="MethodID">Phương thức</th>
							<th col-name="CargoWeight">Trọng lượng hàng</th>
							<th col-name="UnitID">Đơn vị tính</th>
							<th col-name="Sequence">Sequence</th>
							<th col-name="CntrNo">Số Cont</th>
							<th col-name="ClassID">Nhập/ xuất tàu</th>
							<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
							<th col-name="CommodityDescription">Mô tả</th>	
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
<div class="modal fade" id="vessel-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 2%; padding-top: 2%">
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
									<th col-name="VesselID">Mã tàu</th>
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

<!-- Add more row modal --> 
<div class="modal fade" id="add-row-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%; top: 200px">
	<div class="modal-dialog" role="document" style="width: 300px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row form-group">
						<label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Số dòng</label>
						<input id="rowsNumeric" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Số dòng" type="number" value="1">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-add-row" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Drop down list for contenttable -->
<div id="cell-context-1" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-2" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-3" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-4" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-5" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<!-- Drop down list for contenttable2 -->
<div id="cell-context-12" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-22" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-32" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-42" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-52" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns		= ["STT", "rowguid", "VoyageKey", "BillOfLading", "JobModeID", "MethodID", "CargoWeight", "UnitID", "Sequence", "CntrNo", "ClassID", "IsLocalForeign", "CommodityDescription"],
			_columns2 		= ["STT", "rowguid", "VoyageKey", "BookingNo", "JobModeID", "MethodID", "CargoWeight", "UnitID", "Sequence", "CntrNo", "ClassID", "IsLocalForeign", "CommodityDescription"],
			_vesselColumns 	= ["STT", "VoyageKey", "VesselID", "VesselName", "InboundVoyage", "OutboundVoyage", "ETA", "ETD", "Status", "InLane", "OutLane"],
			tbl 			= $("#contenttable"),
			tbl2 			= $("#contenttable2"),
			tblVessel 		= $("#tblVessel"),
			vesselModal 	= $("#vessel-modal"),
			jobModeList		= {},
			methodList 		= {},
			unitList 		= {},
			classList		= {},
			fQuayNew,
			localForeignList = {1: 'Nội', 2: 'Ngoại'},
			parentMenuList 	= {};

		/* Load data from Job-mode-table */
		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		/* Load data from Method table */
		<?php if(isset($methodList) && count($methodList) >= 0){?>
			methodList = <?= json_encode($methodList);?>;
		<?php } ?> 

		/* Load data from Method table */
		<?php if(isset($unitList) && count($unitList) >= 0){?>
			unitList = <?= json_encode($unitList);?>;
		<?php } ?> 

		/* Load data for Parent Menu */
		<?php if(isset($classList) && count($classList) >= 0){?>
			classList = <?=json_encode($classList);?>;
		<?php } ?>

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
		tbl.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.getIndexs(["STT"]) },	
				{ className: "text-center", targets: _columns.getIndexs( ["BillOfLading", "JobModeID", "MethodID", "CargoWeight", "UnitID", "ClassID", "IsLocalForeign", "CommodityDescription"] )},		
				{ className: "hiden-input", targets: _columns.getIndexs( ["rowguid", "VoyageKey", "CntrNo", "Sequence"] )},
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
		tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

		/* Initial table contenttable 2 format */
		tbl2.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns2.getIndexs(["STT"]) },	
				{ className: "text-center", targets: _columns2.getIndexs( ["BookingNo", "JobModeID", "MethodID", "CargoWeight", "UnitID", "ClassID", "IsLocalForeign", "CommodityDescription"] )},		
				{ className: "hiden-input", targets: _columns2.getIndexs( ["rowguid", "VoyageKey", "CntrNo", "Sequence"] )},		
			],
			order: [[ _columns2.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _columns2,
		});
		tbl2.editableTableWidget({editor: $("#status, #httt, #editor-input")});

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

		$("#chooseVessel").on('click', function(){
			$('#vessel-modal').modal("show");
			$('#VesselSearch').trigger('click');
			sumNumRows = 0;
			$("#YearFilter").val(new Date().getFullYear());

		});	

		$("#nochooseVessel").on('click', function(){
			$('#inputManifestForm').trigger("reset");
			tbl.dataTable().fnClearTable();
			$("#VesselName").val('');
			$("#InboundVoyage").val('');
			$("#OutboundVoyage").val('');
			$("#ETA").val('');
			$("#ETD").val('');
		});

		/* Add new rows */
		var numCount = 0;
       	// Add rows event
       	$('#addrow').on('click', function(){
       		if ($('#VoyageKey').val() == ''){
				toastr['error']('Vui lòng chọn tàu trước khi Thêm mới dòng!');
				return;
			}
            $('#add-row-modal').modal("show"); 
        });

       	var sumNumRows = 0;
        $("#apply-add-row").on("click", function(){
        	numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
        	sumNumRows += numRows;
        	if (numRows == 1){ // Table In
        		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
        			tbl.newRow();
	        		rowsExist = $("#contenttable").DataTable().rows().nodes().length;
					for (i = 0; i < rowsExist; i++){
						cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl.DataTable().cell(cell).data(i+1).draw(false);
					}
					
					var newData 	= tbl.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}

						/* Set value for JobModeID */
						var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("JobModeID") +")");					
						tbl.DataTable().cell(cell).data(
							'<input class="hiden-input" value="NTAU">NHẬP TÀU'
						).draw(false);

						/* Set value for MethodID */
						var cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("MethodID") +")");					
						tbl.DataTable().cell(cell).data(
							'<input class="hiden-input" value="TAU-BAI">TÀU BÃI'
						).draw(false); 
					}
        		}
        		else{
        			tbl2.newRow();
	        		rowsExist = $("#contenttable2").DataTable().rows().nodes().length;
					for (i = 0; i < rowsExist; i++){
						cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl2.DataTable().cell(cell).data(i+1).draw(false);
					}
					
					var newData 	= tbl2.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}

						var cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("JobModeID") +")");					
						tbl2.DataTable().cell(cell).data(
							'<input class="hiden-input" value="XGT">XUẤT GIAO THẲNG'
						).draw(false);

						var cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("MethodID") +")");					
						tbl2.DataTable().cell(cell).data(
							'<input class="hiden-input" value="XE-TAU">XUẤT GIAO THẲNG'
						).draw(false); 
					}
        		}
			}
			/* Add more than 1 row */
			else
			{	
        		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
        			numRowsExist = tbl.DataTable().rows().nodes().length;
					numRowHasAddNewClass = 0;
					index = 1;
					for (i = numRowsExist - 1; i >= 0 ; i--){
						var crRow = tbl.find("tbody tr:eq("+i+")");
						if(crRow.hasClass("addnew"))
							numRowHasAddNewClass++;
						else{
							cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
				        	tbl.DataTable().cell(cell).data(sumNumRows + index).draw(false);
				        	index++;
						}
					}
					tbl.newMoreRows(numRows, numRowHasAddNewClass);

					var newData 	= tbl.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}					
					}
        		}
				else{
					numRowsExist = tbl2.DataTable().rows().nodes().length;
					numRowHasAddNewClass = 0;
					index = 1;
					for (i = numRowsExist - 1; i >= 0 ; i--){
						var crRow = tbl2.find("tbody tr:eq("+i+")");
						if(crRow.hasClass("addnew"))
							numRowHasAddNewClass++;
						else{
							cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("STT") +")");
				        	tbl2.DataTable().cell(cell).data(sumNumRows + index).draw(false);
				        	index++;
						}
					}
					tbl2.newMoreRows(numRows, numRowHasAddNewClass);

					var newData 	= tbl2.getAddNewData();
					for (i = 0; i < newData.length; i++){
						/* Set value for ClassID */
						if (newData[i]['ClassID'] == ''){
							var id  	= $("input[name='ClassID']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("ClassID") +")");			
								classCellValue = classList.filter( p => p.ClassID == id).map( x => x.ClassName );

							tbl2.DataTable().cell(cell).data(
								'<input class="hiden-input" value="'+ id  +'">' + classCellValue
							).draw(false);
						}
							
						/* Set value for IsForeignLocal */
						if (newData[i]['IsLocalForeign'] == ''){
							var id  	= $("input[name='IsLocalForeign']:checked").val(),
								cell 	= tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("IsLocalForeign") +")");						
							if (id == 1){
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="1">Nội'
								).draw(false);
							}
							else{
								tbl2.DataTable().cell(cell).data(
									'<input class="hiden-input" value="2">Ngoại'
								).draw(false);
							}				
						}	

						var cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("JobModeID") +")");					
						tbl2.DataTable().cell(cell).data(
							'<input class="hiden-input" value="XGT">XUẤT GIAO THẲNG'
						).draw(false);

							var cell = tbl2.find("tbody tr:eq(" + i + ") td:eq("+ _columns2.indexOf("MethodID") +")");					
						tbl2.DataTable().cell(cell).data(
							'<input class="hiden-input" value="XE-TAU">XUẤT GIAO THẲNG'
						).draw(false); 				
					}
				}
			}
		});

		/* Change ClassID selected radio event */
		$("#tableIn").hide();
	    $('input[type=radio][name=ClassID]').change(function() {
			$("#tableIn").hide();
			$("#tableOut").hide();
	    	if (this.value == 1){	    		
				$("#tableIn").show();
	    	}
	    	else if (this.value == 2){	    		
	    		$("#tableOut").show();
	    	}
	    });

	    /*** SET DROPDOWN LIST FOR TABLE IN TAB IN ***/
	    /* Set dropdown list for ClassID */
	    tbl.setExtendDropdown({
			target: "#cell-context-1",
			source: classList,
			colIndex: _columns.indexOf("ClassID"), 
			onSelected: function(cell, value){
				var className = classList.filter( p => p.ClassID == value).map( x => x.ClassName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + className
				).draw(false);	
			}	
		});

		tbl2.setExtendDropdown({
			target: "#cell-context-12",
			source: classList,
			colIndex: _columns2.indexOf("ClassID"), 
			onSelected: function(cell, value){
				var className = classList.filter( p => p.ClassID == value).map( x => x.ClassName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + className
				).draw(false);	
			}	
		});

	    /* Set dropdown list for IsLocalForeign */
       	tbl.setExtendDropdown({
			target: "#cell-context-2",
			source: localForeignList,
			colIndex: _columns.indexOf("IsLocalForeign"),   
			onSelected: function(cell, value){   
				if (value == "Nội"){
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

       	tbl2.setExtendDropdown({
			target: "#cell-context-22",
			source: localForeignList,
			colIndex: _columns2.indexOf("IsLocalForeign"),   
			onSelected: function(cell, value){   
				if (value == "Nội"){
					tbl2.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl2.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		/* Set dropdown list for Job-Mode cell */
       	tbl.setExtendDropdown({
			target: "#cell-context-3",
			source: jobModeList,
			colIndex: _columns.indexOf("JobModeID"),   
			onSelected: function(cell, value){   
				var JobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + JobModeName
				).draw(false);			

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		tbl2.setExtendDropdown({
			target: "#cell-context-32",
			source: jobModeList,
			colIndex: _columns2.indexOf("JobModeID"),   
			onSelected: function(cell, value){   
				var JobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + JobModeName
				).draw(false);			

				var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		/* Set dropdown list for Method cell */
       	tbl.setExtendDropdown({
			target: "#cell-context-4",
			source: methodList,
			colIndex: _columns.indexOf("MethodID"),   
			onSelected: function(cell, value){   
				var MethodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + MethodName
				).draw(false);		

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		tbl2.setExtendDropdown({
			target: "#cell-context-42",
			source: methodList,
			colIndex: _columns.indexOf("MethodID"),   
			onSelected: function(cell, value){   
				var MethodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + MethodName
				).draw(false);		

				var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}	
			}	
		});

		/* Set dropdown list for Unit cell */
		tbl.setExtendDropdown({
			target: "#cell-context-5",
			source: unitList,
			colIndex: _columns.indexOf("UnitID"),  
			onSelected: function(cell, value){   
				var unitName = unitList.filter( p => p.UnitID == value).map( x => x.UnitName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value +'">' + unitName
				).draw(false);		

				var crRow = tbl.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}		
			}	
		});

		tbl2.setExtendDropdown({
			target: "#cell-context-52",
			source: unitList,
			colIndex: _columns2.indexOf("UnitID"),  
			onSelected: function(cell, value){   
				var unitName = unitList.filter( p => p.UnitID == value).map( x => x.UnitName );
				tbl2.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value +'">' + unitName
				).draw(false);		

				var crRow = tbl2.find("tbody tr:eq("+ cell[0]['_DT_CellIndex'].row +")");

				if(!crRow.hasClass("addnew")){
		        	tbl2.DataTable().row(crRow).nodes().to$().addClass("editing");
	        	}		
			}	
		});

		$(document).on("dblclick", "#tblVessel tbody tr",  function(){
       		var VesselData 		= tblVessel.getSelectedRows().data().toArray()[0],
       			VoyageKey		= VesselData[_vesselColumns.indexOf("VoyageKey")],
       			VesselName 		= VesselData[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage 	= VesselData[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage 	= VesselData[_vesselColumns.indexOf("OutboundVoyage")],
       			InLane 			= VesselData[_vesselColumns.indexOf("InLane")],
       			OutLane 		= VesselData[_vesselColumns.indexOf("OutLane")],
       			ETA 			= VesselData[_vesselColumns.indexOf("ETA")],
       			ETD 			= VesselData[_vesselColumns.indexOf("ETD")];

       		$("#VoyageKey").val(VoyageKey);
       		$("#VesselName").val(VesselName + " | " + InboundVoyage + " | " + OutboundVoyage);
       		$("#InboundVoyage").val(InboundVoyage);
       		$("#OutboundVoyage").val(OutboundVoyage);
       		$("#ETA").val(ETA);
       		$("#ETD").val(ETD);

       		$('#search').trigger('click');
       		vesselModal.modal('hide');
       	});

		$("#apply-vessel").on("click", function(){
       		var tblVesselSelectedRows = tblVessel.getSelectedRows().data().toArray()[0];
       			VoyageKey		= tblVesselSelectedRows[_vesselColumns.indexOf("VoyageKey")],
       			VesselName 		= tblVesselSelectedRows[_vesselColumns.indexOf("VesselName")],
       			InboundVoyage 	= tblVesselSelectedRows[_vesselColumns.indexOf("InboundVoyage")],
       			OutboundVoyage 	= tblVesselSelectedRows[_vesselColumns.indexOf("OutboundVoyage")],
       			InLane 			= tblVesselSelectedRows[_vesselColumns.indexOf("InLane")],
       			OutLane 		= tblVesselSelectedRows[_vesselColumns.indexOf("OutLane")],
       			ETA 			= tblVesselSelectedRows[_vesselColumns.indexOf("ETA")],
       			ETD 			= tblVesselSelectedRows[_vesselColumns.indexOf("ETD")];

       		$("#VoyageKey").val(VoyageKey);
       		$("#VesselName").val(VesselName + " | " + InboundVoyage + " | " + OutboundVoyage);
       		$("#InboundVoyage").val(InboundVoyage);
       		$("#OutboundVoyage").val(OutboundVoyage);
       		$("#ETA").val(ETA);
       		$("#ETD").val(ETD);

       		$('#search').trigger('click');
       		vesselModal.modal('hide');
       	});
       	
       	$('#search').on("click", function(){
			/* Load data to datatable */
			// Get data input
			var btn 					= $(this),
				VoyageKey				= $("#VoyageKey").val(),
				IsLocalForeign			= $("input[name='IsLocalForeign']:checked").val(),
				ClassID					= $("input[name='ClassID']:checked").val();

			if (VoyageKey == ''){
				toastr['error']('Vui lòng chọn tàu trước khi load dữ liệu!');
				return;
			}

			var formData = {
				'action': 					'view',
				'VoyageKey': 				VoyageKey,
				'IsLocalForeign': 			IsLocalForeign,
				'ClassID': 					'',
			};

			tbl.waitingLoad();
			tbl2.waitingLoad();
			//btn.button('loading');

			$.ajax({
				url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkManifest'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rowsIn = [], rowsOut = [], index1 = 1, index2 = 1;
					if(data.list.length > 0) {
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							if (data.list[i]['ClassID'] == 1){
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = index1++;
											break;
										case "IsLocalForeign":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nội";
											else
												val='<input class="hiden-input" value="2">' + "Ngoại";
											break;
										case "ClassID":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nhập";
											else
												val='<input class="hiden-input" value="2">' + "Xuất";
											break;
										case "JobModeID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'];
											break;
										case "MethodID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'];
											break;
										case "UnitID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['UnitName'];
											break;
										default:
											val = (rData[colname] == null) ? '' : rData[colname];
											break;	
									}
									r.push(val);
								});
								rowsIn.push(r);
							}
							else{
								$.each(_columns2, function(idx, colname){
									var val = "";
									switch(colname){
										case "STT": 
											val = index2++;
											break;
										case "IsLocalForeign":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nội";
											else
												val='<input class="hiden-input" value="2">' + "Ngoại";
											break;
										case "ClassID":
											if (rData[colname] == 1)
												val='<input class="hiden-input" value="1">' + "Nhập";
											else
												val='<input class="hiden-input" value="2">' + "Xuất";
											break;
										case "JobModeID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'];
											break;
										case "MethodID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'];
											break;
										case "UnitID":
											val = (rData[colname] == null) ? '' : '<input class="hiden-input" value="' + rData[colname] + '">' + rData['UnitName'];
											break;
										default:
											val = (rData[colname] == null) ? '' : rData[colname];
											break;	
									}
									r.push(val);
								});
								rowsOut.push(r);
							}
						}
					}
					tbl.dataTable().fnClearTable();
					tbl2.dataTable().fnClearTable();
		        	if (rowsIn.length > 0){
						tbl.dataTable().fnAddData(rowsIn);
		        	}
		        	if (rowsOut.length > 0){
						tbl2.dataTable().fnAddData(rowsOut);
		        	}	
		        	//btn.button('reset');
				},
				error: function(err){
					console.log(err);
					//btn.button('reset');
				}
			});
		});
		
		/* SAVE EVENT */
		$('#save').on('click', function(){
			if ($('#VoyageKey').val() == ''){
				toastr['error']('Vui lòng chọn tàu trước và thêm dữ liệu trước khi Lưu!');
				return;
			}

			if(
				tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0 &&
				tbl2.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0
			){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
            	if(tbl.getAddNewData().length > 0 || tbl2.getAddNewData().length > 0){            		
            		// BULK_IN
            		if ($('input[type=radio][name=ClassID]:checked').val() == 1){ 
            			newData = tbl.getAddNewData();

            			for (i = 0; i < newData.length; i++){
							if (newData[i]['BillOfLading'] == ''){
								toastr['error']("Vui lòng nhập Số vận đơn!");
								return;
							}
						}
            		}
            		// BULK_OUT
            		else{ 
            			newData = tbl2.getAddNewData();

            			for (i = 0; i < newData.length; i++){
							if (newData[i]['BookingNo'] == ''){
								toastr['error']("Vui lòng nhập Số booking!");
								return;
							}
						}
            		}	
	            }

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
		                        saveData();
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

		function saveData(){
			var newData = tbl.getAddNewData(),
				newStockBulkData = [],
				newQuayData = [],
				haveBookingNo = false,
				currentTime = getDateTimeFormatString(new Date()); 

			if ($('input[type=radio][name=ClassID]:checked').val() == 2){
				newData = tbl2.getAddNewData();
				haveBookingNo = true;
			}

			for (i = 0; i < newData.length; i++){
				var objStockData = {	
						'VoyageKey': 	$("#VoyageKey").val(),
						'BillOfLading': haveBookingNo ? '' : newData[i]['BillOfLading'],
						'BookingNo': 	haveBookingNo ? newData[i]['BookingNo'] : '',
						'ClassID': 		newData[i]['ClassID'],
						'IsLocalForeign': newData[i]['IsLocalForeign'],
						'CargoWeight': 	newData[i]['CargoWeight'],
						'JobModeInID': 	newData[i]['JobModeID'],
						'MethodInID': 	newData[i]['MethodID'],
						'UnitID': 		newData[i]['UnitID'],
						'JobModeOutID': '',
						'MethodOutID': 	'',
						'TransitID': 	'',
						'Area': 		'',
						'CommodityDescription': newData[i]['CommodityDescription'],
						'CntrNo': 		newData[i]['CntrNo'],
						'IsDifferent': 	'',
						'DeclareContent': '',
       					'OldVoyageKey': '',
       					'InvNo': 		'',
       					'OrderNo': 		'',
       					'CusID': 		'',
       					'POL': 			newData[i]['POL'],
       					'POD': 			newData[i]['POD'],
       					'FPOD': 		newData[i]['FPOD'],
       					'Remark': 		'',
					};
				newStockBulkData.push(objStockData);

				var objQuayData = {
						'VoyageKey': 	$("#VoyageKey").val(),
						'EirNo': 		'',
						'ClassID': 		newData[i]['ClassID'],
						'IsLocalForeign': newData[i]['IsLocalForeign'],
						'BillOfLading': haveBookingNo ? '' : newData[i]['BillOfLading'],
						'BookingNo': 	haveBookingNo ? newData[i]['BookingNo'] : '',
						'VINNo': '',
						'TransitID': '',
						'CarWeight': newData[i]['CargoWeight'],
						'JobTypeID': 'DF',
						'JobStatus': 'KT',
						'StartDate': currentTime,
						'FinishDate': '',
						'JobModeInID': 	newData[i]['JobModeID'],
						'MethodInID': 	newData[i]['MethodID'],
						'JobModeOutID': '',
						'MethodOutID': 	'',
						'KeyCheck': '',
						'Sequence': '',
						'TruckNumber': '',
						'Block': '',
						'Bay': '',
						'Row': '',
						'Tier': '',
						'Area': '',
						'PaymentTypeID': '',
						'BillCheck': '',
						'CargoType': 'B',
						'Remark': newData[i]['CommodityDescription'],
					};
				newQuayData.push(objQuayData);

				delete newData[i].rowguid;
			}

			if(newData.length > 0){
				var fnew = {
						'action': 'add',
		            	'child_action': '',
						'VoyageKey': $('#VoyageKey').val(),
						'data': newData,
					};
				postSave(fnew);

				/* Add stock Data */
				var fStockNew = {
						'action': 'add',
		            	'child_action': 'addStockBulk',
		            	'data': newStockBulkData,
					};
				postSave(fStockNew);

				if (!haveBookingNo){
					fQuayNew = {
						'action': 'add',
						'child_action': 'addQuayBulkInJob',
						'data': newQuayData,
					};
				}
			}

			var editData = tbl.getEditData();

			if ($('input[type=radio][name=ClassID]:checked').val() == 2){
				editData = tbl2.getEditData();
			}
			
			if(editData.length > 0){				
				var fedit = {
					'action': 'edit',
					'VoyageKey': $('#VoyageKey').val(),
					'data': editData,					
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			$.ajax({
                url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkManifest'));?>",
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
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");
                    	$('#search').trigger('click');
                    }

                    if(formData.action == 'add'){
                    	if (formData.child_action == ''){
                    		toastr["success"]("Thêm mới dữ liệu Hàng rời thành công!");
                    		return;                    		
                    	}

                    	if (formData.child_action == 'addStockBulk'){
                    		toastr["success"]("Thêm mới Stock thành công!");
                    		
                    		/* Save Job Quay */
                    		if ($('input[type=radio][name=ClassID]:checked').val() == 1){
                    			postSave(fQuayNew);
                    		}
                    	}

                    	if (formData.child_action == 'addQuayBulkInJob'){
                    		toastr["success"]("Thêm mới dữ liệu JOB QUAY thành công!");

                    		/* Socket to Tally */
                        	socket.emit('transferDataToJobQuay', JSON.stringify(formData.data));

                    		$('#search').trigger('click');
                    	}

                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		/* Delete event */
		$('#delete').on('click', function(){
			if(tbl.getSelectedRows().length == 0 && tbl2.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }
            else{
            	if (tbl.getSelectedRows().length > 0){
            		data = tbl.getSelectedRows().data().toArray()[0];

            		tbl.confirmDelete(function(data){
	            		postDel(data);
	            	});
            	}
            	else if (tbl2.getSelectedRows().length > 0){
            		data = tbl2.getSelectedRows().data().toArray()[0];

            		tbl2.confirmDelete(function(data){
	            		postDel(data);
	            	});
            	}            	
            }
		});

		function postDel(data){
			var delData = [];

			for (i = 0; i < data.length; i++){
				delData.push(data[i][_columns.indexOf('rowguid')]);
			}

			var fdel = {
					'action': 'delete',
					'data': delData,
				};

			$.ajax({
                url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkManifest'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    $("#search").trigger('click');
               		toastr["success"]("Xóa dữ liệu thành công!");
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		$("#downloadFileForImport").on('click', function(){
			if ($("input[name='ClassID']:checked").val() == 1){
				var url = '<?=site_url(md5('DataBulk') . '/' . md5('createXLSFormForManifestImportForClassIn'));?>';
				window.location.href = url;
			}
			else{
				var url = '<?=site_url(md5('DataBulk') . '/' . md5('createXLSFormForManifestImportForClassOut'));?>';
				window.location.href = url;
			}
		});

		$("#Export").on('click', function(){
			if ($("#VoyageKey").val() == ''){
                toastr["error"]("Vui lòng chọn tàu trước khi export dữ liệu!");
                return;
            }

	    	if ($("input[name='ClassID']:checked").val() == 1){
	    		var url = "<?=site_url(md5('DataBulk') . '/' . md5('createXLSForManifestExportWithClassIn'));?>";
	    		url += ('/' + $("#VoyageKey").val());
				window.location.href = url;
	    	}
	    	else{
	    		var url = "<?=site_url(md5('DataBulk') . '/' . md5('createXLSForManifestExportWithClassOut'));?>";
	    		url += ('/' + $("#VoyageKey").val());
				window.location.href = url;
	    	}
	    });

	    $("#import").on("change", function(){			
			var input = this;
			var url = $(this).val();
 
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0] && (ext == "xlsx" || ext =="xls"))
			{	
				var reader = new FileReader();
 
                //For Browsers other than IE.
                if (reader.readAsBinaryString) {
                    reader.onload = function (e) {
                    	// Check valid of Voyage Key
                    	if ($("#VoyageKey").val() == ''){
                    		toastr["error"]("Vui lòng chọn tàu trước khi import dữ liệu!");
                    		return;
                    	}

                    	ProcessExcel(e.target.result);
                    };
                    reader.readAsBinaryString(input.files[0]);
                    //$("#chooseVessel").trigger('click');
                }
                else{
                	reader.onload = function (e) {
                		// Check valid of Voyage Key
                    	if ($("#VoyageKey").val() == ''){
                    		toastr["error"]("Vui lòng chọn tàu trước khi import dữ liệu!");
                    		return;
                    	}

                        var data = "";
                        var bytes = new Uint8Array(e.target.result);
                        for (var i = 0; i < bytes.byteLength; i++) {
                            data += String.fromCharCode(bytes[i]);
                        }
                        ProcessExcel(data);
                    };
                    reader.readAsArrayBuffer(input.files[0]);
                }
			}
			else
			{
				toastr['error']("Vui lòng chọn file đúng định dạng");				
			}

			$("#import").val("");
		});	

		function ProcessExcel(data) {
        	//Read the Excel File data.
	        var workbook = XLSX.read(data, { type: 'binary' });
	 
	        //Fetch the name of First Sheet.
	        var firstSheet = workbook.SheetNames[0];
	 
	        //Read all rows from First Sheet into an JSON array.
	        var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);
	        
	        // Add data to manifest table
			var rows = [],
				VoyageKey = $("#VoyageKey").val(),				
				listAddEdit = [],
				formData = {
					'action': 		  'view',
					'VoyageKey': 	  VoyageKey,
					'IsLocalForeign': '',
					'ClassID': 		  '',
				};

			$.ajax({
				url: "<?=site_url(md5('DataBulk') . '/' . md5('dtBulkManifest'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var manifestList = data.list;
					if(excelRows.length > 0) {
						for (i = 0; i < excelRows.length; i++) {
							var rData = excelRows[i], 
								r = [];
							if (!rData['Số vận đơn/ booking']){
								continue;
							}

							listAddEdit[i] = 0;
							for (j = 0; j < manifestList.length; j++){
								if (!rData['Số vận đơn']){
									if (!manifestList[j]['BillOfLading'] && manifestList[j]['BookingNo'] == rData['Số booking']){
										listAddEdit[i] = 1;
										break;
									}
								}
								else{
									if (!rData['Số booking']){
										if (!manifestList[j]['BookingNo'] && manifestList[j]['BillOfLading'] == rData['Số vận đơn'])
										{
											listAddEdit[i] = 1;
											break;
										}
									}
								}					
							}	

							if ($("input[name='ClassID']:checked").val() == 1){
								$.each(_columns, function(idx, colname){
									var val = "";
									switch(colname){
										case "VoyageKey":
											val = VoyageKey;
											break;
										case "BillOfLading":
											val = rData['Số vận đơn/ booking'] ? rData['Số vận đơn/ booking'] : '';
											break;
										case "JobModeID":
											val = rData['Mã phương án (xem ở cột L - N)'] ? rData['Mã phương án (xem ở cột L - N)'] : '';
											break;
										case "MethodID":
											val = (rData['Mã phương thức (xem ở cột Q - S)'] ? rData['Mã phương thức (xem ở cột Q - S)'] : '');
											break;
										case "CargoWeight":
											val = (rData['Trọng lượng hàng'] ? rData['Trọng lượng hàng'] : '');
											break;
										case "UnitID":
											val = (rData['Đơn vị tính (xem ở cột U - W)'] ? rData['Đơn vị tính (xem ở cột U - W)'] : '');
											break;

										case "ClassID":
											val = (rData['Nhập/ xuất tàu (Nhập = 1, Xuất = 2)'] ? rData['Nhập/ xuất tàu (Nhập = 1, Xuất = 2)'] : '');
											break;
										case "IsLocalForeign":
											val = (rData['Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'] ? rData['Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'] : '');									
											break;
										case "CommodityDescription":
											val = (rData['Mô tả'] ? rData['Mô tả'] : '');				
											break;
										default:
											val = (rData[colname] ? rData[colname] : '');
											break;											
									}
									r.push(val);
								});
							}
							else{
								$.each(_columns2, function(idx, colname){
									var val = "";
									switch(colname){
										case "VoyageKey":
											val = VoyageKey;
											break;
										case "BookingNo":
											val = rData['Số vận đơn/ booking'] ? rData['Số vận đơn/ booking'] : '';
											break;
										case "JobModeID":
											val = rData['Mã phương án (xem ở cột L - N)'] ? rData['Mã phương án (xem ở cột L - N)'] : '';
											break;
										case "MethodID":
											val = (rData['Mã phương thức (xem ở cột Q - S)'] ? rData['Mã phương thức (xem ở cột Q - S)'] : '');
											break;
										case "CargoWeight":
											val = (rData['Trọng lượng hàng'] ? rData['Trọng lượng hàng'] : '');
											break;
										case "UnitID":
											val = (rData['Đơn vị tính (xem ở cột U - W)'] ? rData['Đơn vị tính (xem ở cột U - W)'] : '');
											break;

										case "ClassID":
											val = (rData['Nhập/ xuất tàu (Nhập = 1, Xuất = 2)'] ? rData['Nhập/ xuất tàu (Nhập = 1, Xuất = 2)'] : '');
											break;
										case "IsLocalForeign":
											val = (rData['Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'] ? rData['Hàng nội/ ngoại (Nội = 1, Ngoại = 2)'] : '');									
											break;
										case "CommodityDescription":
											val = (rData['Mô tả'] ? rData['Mô tả'] : '');				
											break;
										default:
											val = (rData[colname] ? rData[colname] : '');
											break;										
									}
									r.push(val);
								});
							}	
							rows.push(r);		
						}

						tbl.dataTable().fnClearTable();
						tbl2.dataTable().fnClearTable();
						if(rows.length > 0){
							if ($("input[name='ClassID']:checked").val() == 1){
								tbl.dataTable().fnAddData(rows);
							}
							else{
								tbl2.dataTable().fnAddData(rows);
							}
		                
							for (i = 0; i < excelRows.length; i++){
								crRow = tbl.find("tbody tr:eq(" + i + ")");
								crRow2 = tbl2.find("tbody tr:eq(" + i + ")");

								if (listAddEdit[i] == 0){
									if ($("input[name='ClassID']:checked").val() == 1){
										tbl.DataTable().rows(crRow).nodes().to$().addClass("addnew");	
									}
									else{
										tbl2.DataTable().rows(crRow2).nodes().to$().addClass("addnew");
									}
								}	
								else{
									if ($("input[name='ClassID']:checked").val() == 1){
										tbl.DataTable().rows(crRow).nodes().to$().addClass("editing");
									}
									else{
										tbl2.DataTable().rows(crRow2).nodes().to$().addClass("editing");
									}
								}
							}
						}
					}						

				},
				error: function(err){
					console.log(err);
				}
			});
	    };

	    function getDateTimeFormatString(d){
            year    = d.getFullYear();
            month   = d.getMonth() + 1;
            day     = d.getDate();
            hour    = d.getHours(),
            min     = d.getMinutes(),
            sec     = d.getSeconds(),
            fillMonth = '',
            fillDay   = '',
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

            return (year + '-' + fillMonth + month + '-' + fillDay + day + " " + fillHour + hour + ':' + fillMin + min + ':' + fillSec + sec);
        }

	});
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/6bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
