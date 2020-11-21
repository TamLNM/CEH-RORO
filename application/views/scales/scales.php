
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<script type="text/javascript" src="https://unpkg.com/@zxing/library@latest"></script>

<style>
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">CÂN</div>
				<div class="button-bar-group mr-3">			
					<button id="search" hidden>
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
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
	                        <div class="row form-group">
	                        	<h5 style="margin-left: auto; margin-right: auto"><b>THÔNG TIN CÂN HÀNG</b></h5>
	                        </div>
	                        <div class="row form-group">
	                        	<div class="col-6">
	                        		<div class="row mt-2">	                        			
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Nhập/xuất</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
		                        			<label class="mt-1 radio radio-danger">
				                                <input type="radio" name="ClassID" class="css-checkbox" value="1" />
				                                <span class="input-span"></span>Nhập
				                            </label>	
											<label class="mt-1 ml-3 radio radio-danger">
				                                <input type="radio" checked name="ClassID" class="css-checkbox" value="2" />
				                             	<span class="input-span"></span>Xuất
				                            </label>
				                        </div>
	                        		</div>
	                        		<form id="inputForm"><div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Phiếu cân</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Số phiếu cân" type="text">
										</div>	
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Số lệnh</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="EirNo" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Số lệnh" type="text">
											<input hidden id="Sequence">
										</div>	
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Số xe</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8 input-group">
											<input id="TruckNumber" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Số xe" type="text">
											<span class="input-group-addon" id="QRSCAN">
	                                           	<i class="fa fa-qrcode"></i>
	                                        </span>
										</div>	
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">TL max</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="remainCargoWeight" readonly style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="TL hàng tối đa (kg)" type="text">
											
										</div>	
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">TL hàng</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="CargoWeight" readonly style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="TL hàng (kg)" type="text">
										</div>	
	                        		</div>	                        		          		
	                        	</div>
	                        	<div class="col-6">           
	                        		<div class="row">
	                        			<label class="col-md-12 col-sm-12 col-xs-12 col-form-label" style="text-align: center;">TRỌNG LƯỢNG HIỆN TẠI</label>
	                        			<div class="col-md-2 col-sm-2 col-xs-2">
	                        			</div>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
	                        				<input id="currentWeight" style="height: 35px; font-size: 20px; text-align: center; padding-left: 11px;" class="form-control" type="number" min="0">
	                        			</div>
	                        			<div class="col-md-2 col-sm-2 col-xs-2">
	                        				<label class="col-form-label" style="float: left">(kg)</label>
	                        			</div>
	                        		</div>       
	                        		<div class="row mt-2">
	                        		</div>      		
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">TL xe hàng</label>
										<div class="col-md-8 col-sm-8 col-xs-8 input-group">
	                                        <input class="form-control form-control-sm" type="text" placeholder="TL xe hàng (kg)" style="background-color: #f1f1f1" id="TruckWeightIn" readonly>
	                                        <span class="input-group-addon" id="btnTruckWeightIn">
	                                           	<i class="la la-balance-scale"></i>
	                                        </span>
	                                    </div>
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">TL xe</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8 input-group">
	                                        <input class="form-control form-control-sm" type="text" placeholder="TL xe (kg)" style="background-color: #f1f1f1" id="TruckWeightOut" readonly>
	                                        <span class="input-group-addon" id="btnTruckWeightOut">
	                                           	<i class="la la-balance-scale"></i>
	                                        </span>
	                                    </div>
	                        		</div>	 
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">TL R-M</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Trọng lượng Rơ-mooc" type="text">
										</div>	
	                        		</div>                                		
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Ghi chú</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Ghi chú" type="text">
											<input id="BillOfLading" hidden>
											<input id="BookingNo" hidden>
											<input id="StockRef" hidden>
										</div>	
	                        		</div>
	                        	</div>
	                        </div>
	                        <div class="row form-group mt-2">
	                        	<h5 style="margin-left: auto; margin-right: auto"><b>THÔNG TIN THANH TOÁN</b></h5>
	                        </div>
	                        <div class="row form-group">
	                        	<div class="col-6">
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Phiếu TC</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Số phiếu tính cước" type="text">
										</div>	
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Hóa đơn</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Hóa đơn" type="text">
										</div>	
	                        		</div>
	                        	</div>
	                        	<div class="col-6">
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Tổng tiền</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Tổng tiền" type="text">
										</div>	
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="col-md-4 col-sm-4 col-xs-4 col-form-label">Mã hàng</label>
	                        			<div class="col-md-8 col-sm-8 col-xs-8">
											<input id="CusID" style="height: 28px; font-size: 12px; padding-left: 11px" class="form-control" placeholder="Khách hàng" type="text">
										</div>
	                        		</div>
	                        		<div class="row mt-2">
	                        			<label class="mt-1 ml-3 radio radio-success">
				                            <input type="radio" name="IsLocalForeign" class="css-checkbox" value="1" />
				                            <span class="input-span"></span><span style="margin-left: 0;">Trả trước</span>
				                        </label>	
										<label class="mt-1 ml-4 radio radio-success">
				                            <input type="radio" checked name="IsLocalForeign" class="css-checkbox" value="2" />
				                                <span class="input-span"></span>Trả sau
				                      	</label>
				                      	<input hidden id="JobModeID">
				                      	<input hidden id="rowguid">
	                        		</div>
	                        	</div>
	                        </div></form>
	                    </div>
	                    <div class="col-md-6 col-sm-6 col-xs-6 table-responsive">
	                    	<table id="tblScales" class="table table-striped display nowrap" cellspacing="0" style="min-width: 99.5%">
	                            <thead>
	                                <tr style="width: 100%">
	                                    <th class="editor-cancel" col-name="STT">STT</th>
	                                    <th col-name="TruckNumber">Số xe</th>
										<th col-name="Sequence">Sequence</th>									
										<th col-name="FirstWeightScale">Trọng lượng xe hàng (tấn)</th>
										<th col-name="SecondWeightScale">Trọng lượng xe (tấn)</th>
										<th col-name="JobModeID"></th>
										<th col-name="JobModeName">Phương án</th>
										<th col-name="1">Mã phiếu cân</th>
										<th col-name="EirNo">Số lệnh</th>
										<th col-name="BillOfLadingORBookingNo">Số vận đơn/ booking</th>
										<th col-name="BillOfLading"></th>
										<th col-name="BookingNo"></th>
										<th col-name="rowguid">rowguid</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                            	<?php if(count($truckWeightList) > 0) {$i = 1; ?>
										<?php foreach($truckWeightList as $item) {  ?>
											<?php if ($item['EirNo'] && !($item['BillOfLading'])) { ?>
												<tr>
													<td style="text-align: center"><?=$i;?></td>
													<td><?=$item['TruckNumber'];?></td>							
													<td><?=$item['Sequence'];?></td>								
													<td><?=$item['FirstWeightScale'];?></td>
													<td><?=$item['SecondWeightScale'];?></td>
													<td><?=$item['JobModeID'];?></td>
													<td><?=$item['JobModeName'];?></td>
													<td></td>												
													<td><?=$item['EirNo'];?></td>
													<td></td>
													<td></td>
													<td></td>													
													<td><?=$item['rowguid'];?></td>
												</tr>
											<?php $i++; }  ?>
										<?php } ?>
									<?php } ?>
	                            </tbody>
	                        </table>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ORD Eir modal-->
<div class="modal fade" id="ord-eir-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding: auto; padding-top: 4%">
    <div class="modal-dialog" role="document" style="min-width: 1250px!important">
        <div class="modal-content" style="border-radius: 4px">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="groups-modalLabel-1">Danh mục lệnh</h5>
            </div>
            <div class="modal-body" style="padding: 0px 15px 15px 15px">
                <div class="row ibox-footer border-top-0 mt-3">
                    <div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
                        <table id="tblORDEir" class="table table-striped display nowrap" cellspacing="0" style="min-width: 99.5%">
                            <thead>
                                <tr style="width: 100%">
                                    <th class="editor-cancel" col-name="STT">STT</th>
									<th col-name="rowguid">rowguid</th>
									<th col-name="VoyageKey">VoyageKey</th>
									<th col-name="EirNo">Số lệnh</th>
									<th col-name="PinCode">Mã pin</th>
									<th col-name="ClassID">Nhập/ xuất tàu</th>	
									<th col-name="BillOfLadingORBookingNo">Số vận đơn/ Booking</th>
									<th col-name="BillOfLading">Số vận đơn</th>
									<th col-name="BookingNo">Số booking</th>
									<th col-name="VINNo">Số VIN</th>
									<th col-name="ordPos">Vị trí</th>
									<th col-name="IssueDate" class="data-type-datetime">Ngày lệnh</th>
									<th col-name="ExpDate" class="data-type-datetime">Hạn lệnh</th>
									<th col-name="CarTypeID">Loại xe</th>
									<th col-name="BrandID">Hãng xe</th>
									<th col-name="CarWeight">Trọng lượng</th>
									<th col-name="JobModeID">Phương án</th>
									<th col-name="MethodID">Phương thức</th>
									<th col-name="Remark">Ghi chú</th>		
									<th col-name="IsLocalForeign">Hàng nội/ ngoại</th>
									<th col-name="ETB">ETB</th>
									<th col-name="ETD">ETD</th>
									<th col-name="POL">POL</th>
									<th col-name="POD">POD</th>
									<th col-name="FPOD">FPOD</th>
									<th col-name="TransitID">TransitID</th>
									<th col-name="ShipperName">ShipperName</th>
									<th col-name="InboundVoyage">InboundVoyage</th>
									<th col-name="OutboundVoyage">OutboundVoyage</th>
									<th col-name="VesselName">VesselName</th>
									<th col-name="Block">Block</th>
									<th col-name="Bay">Bay</th>
									<th col-name="Row">Row</th>
									<th col-name="Tier">Tier</th>
									<th col-name="Area">Area</th>
									<th col-name="CusTypeID">Loại khách hàng</th>
									<th col-name="CusID">Khách hàng</th>
									<th col-name="PaymentTypeID">Loại hình thanh toán</th>
									<th col-name="InvNo">Số hóa đơn</th>
									<th col-name="InvDraftNo">Số phiếu thu</th>
									<th col-name="KeyNo">Mã chìa khóa</th>
									<th col-name="Sequence">Sequence</th>
									<th col-name="UnitID">Đơn vị tính</th>
									<th col-name="TruckNumber">Số xe</th>
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
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-ord-eir" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="livestream_scanner">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">Quét Mã Vạch</h4>
			</div>
			<div class="modal-body" style="position: static"><div>
			<div></div>
      		<div>
        		<video id="video" width="100%" height="auto" style="max-height: 70vh; "></video>
      		</div>
			</div>
			</div>
			<div class="modal-footer"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function () {
    	var _scalesColumns 	= ["STT", "TruckNumber", "Sequence", "FirstWeightScale", "SecondWeightScale", "JobModeID", "JobModeName", "1", "EirNo", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "rowguid"],
    		_ordEirColumn = ["STT", "rowguid", "VoyageKey", "EirNo", "PinCode", "ClassID", "BillOfLadingORBookingNo", "BillOfLading", "BookingNo", "VINNo", "ordPos", "IssueDate", "ExpDate", "CarTypeID", "BrandID", "CarWeight", "JobModeID", "MethodID", "Remark", "IsLocalForeign", "ETB", "ETD", "POL", "POD", "FPOD", "TransitID", "ShipperName", "InboundVoyage", "OutboundVoyage", "VesselName", "Block", "Bay", "Row", "Tier", "Area", "CusTypeID", "CusID", "PaymentTypeID", "InvNo", "InvDraftNo", "KeyNo", "Sequence", "UnitID", "TruckNumber"],
    		tblScales   	= $("#tblScales"),
    		tblORDEir 	= $("#tblORDEir"),
    		ordEirModal  	= $("#ord-eir-modal"),
    		equipmentList   = {},
    		parentMenuList 	= {},
    		truckWeightList = {};

    	<?php if(isset($truckWeightList) && count($truckWeightList) >= 0){?>
			truckWeightList = <?=json_encode($truckWeightList);?>;
		<?php } ?>

		<?php if(isset($equipmentList) && count($equipmentList) >= 0){?>
			equipmentList = <?=json_encode($equipmentList);?>;
		<?php } ?>

		/* Load data for Parent Menu */
		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Scales'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		/* Initial tblORDEir */
		tblScales.newDataTable({
			scrollY: '47vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _scalesColumns.getIndexs(["STT"])},		
				{ className: "text-center", targets: _scalesColumns.getIndexs(["1", "EirNo", "TruckNumber", "FirstWeightScale", "SecondWeightScale", "JobModeName", "Sequence", "BillOfLadingORBookingNo"]) },
				{ className: "hiden-input", targets: _scalesColumns.getIndexs(["JobModeID", "rowguid", "BillOfLading", "BookingNo"]) },
			],
			order: [[ _scalesColumns.indexOf('STT'), 'asc' ]],
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
            searching: true,
            paging: false,
            info: false,
            rowReorder: false,
            arrayColumns: _scalesColumns,            
		});   	

		/* Initial tblORDEir */
		tblORDEir.newDataTable({
			scrollY: '20vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _ordEirColumn.getIndexs(["STT", "Bay", "Row", "Tier"])},		
				{ className: "text-center", targets: _ordEirColumn.getIndexs(["EirNo", "PinCode", "ClassID", "IsLocalForeign", "BillOfLadingORBookingNo", "VINNo", "ordPos", "IssueDate", "ExpDate", "CarTypeID", "BrandID", "CarWeight", "Remark", "JobModeID", "MethodID", "ETB", "ETD", "POD", "FPOD", "VesselName", "Area", "CusTypeID", "CusID", "PaymentTypeID", "InvNo", "InvDraftNo", "KeyNo", "Sequence", "ShipperName", "InboundVoyage", "OutboundVoyage", "TruckNumber"]) },
				{ className: "hiden-input", targets: _ordEirColumn.getIndexs(["rowguid", "VoyageKey", "BillOfLading", "BookingNo", "Block", "Bay", "Row", "Tier", "UnitID", "POL", "POD", "FPOD"])},
			],
			order: [[ _ordEirColumn.indexOf('STT'), 'asc' ]],
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
            searching: false,
            paging: false,
            info: false,
            rowReorder: false,
            arrayColumns: _ordEirColumn,            
		});

		// Adjust column in table when show modal
		ordEirModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

    	$("#currentWeight").val("0.00");
		$("#btnScales").on('click', function(e){
			if (!($("#PINCodeOREirNo").val())){
				toastr['error']("Vui lòng chọn lệnh trước khi cân!");
				return;
			}

			scalesModal.modal('show');
		});

		$("#currentWeight").on('click', function(){
			if ($("#currentWeight").val() == '0.00'){
				$("#currentWeight").val('');
			}
		});

		$("#btnTruckWeightIn").on('click', function(){
			if (!($("#currentWeight").val())){
				toastr['error']('Vui lòng nhập Trọng lượng hiện tại!');
				return;
			}

			/* BULK IN */
			if ($("input[type=radio][name=ClassID]:checked").val() == 1){
				var TruckWeightOut = parseInt($("#TruckWeightOut").val()),
					currentWeight = parseInt($("#currentWeight").val());
				
				if (TruckWeightOut){			
					if (currentWeight < TruckWeightOut){
						toastr['error']("Trọng lượng xe hàng phải lớn hơn trọng lượng xe!");
						return;
					}

					$("#CargoWeight").val(currentWeight - TruckWeightOut);
				}

				$("#TruckWeightIn").val(currentWeight);
			}
			/* BULK OUT */
			else{ 
				if (!($("#EirNo").val()) && !($("#CusID").val())){
					toastr['error']('Vui lòng nhập lệnh!');
					return;
				}

				if ($("#TruckWeightOut").val()){			
					var temp = $("#currentWeight").val() - $("#TruckWeightOut").val();

					if (temp > $("#remainCargoWeight").val()){
						toastr['error']("Trọng lượng hàng tối đa còn lại là: " + $("#remainCargoWeight").val() + " (kg). Vui lòng nhập dữ liệu phù hợp!");
						return;
					}

					if ($("#currentWeight").val() < $("#TruckWeightOut").val()){
						toastr['error']("Trọng lượng xe hàng phải lớn hơn trọng lượng xe!");
						return;
					}

					$("#CargoWeight").val($("#currentWeight").val() - $("#TruckWeightOut").val());
				}

				$("#TruckWeightIn").val($("#currentWeight").val());
			}
		});

		$("#btnTruckWeightOut").on('click', function(){
			if (!($("#currentWeight").val())){
				toastr['error']('Vui lòng nhập Trọng lượng hiện tại!');
				return;
			}

			if ($("input[type=radio][name=ClassID]:checked").val() == 1){
				var TruckWeightOut 	= parseInt($("#currentWeight").val());

				$("#TruckWeightOut").val(TruckWeightOut);
			}
			else{
				var TruckWeightOut 	= parseInt($("#currentWeight").val());

				if ($("#TruckWeightIn").val()){
					var TruckWeightIn 	= parseInt($("#TruckWeightIn").val());
						
					if (TruckWeightIn <= TruckWeightOut){
						toastr['error']("Trọng lượng xe phải nhỏ hơn trọng lượng xe hàng!");
						return;
					}

					if (TruckWeightIn - TruckWeightOut > ($("#remainCargoWeight").val())){
						toastr['error']("Trọng lượng hàng tối đa còn lại là: " + $("#remainCargoWeight").val() + " (kg). Vui lòng nhập dữ liệu phù hợp!");
						return;
					}

					$("#CargoWeight").val(TruckWeightIn - TruckWeightOut);
				}
				$("#TruckWeightOut").val(TruckWeightOut);
				$("#TruckWeightOut").val(TruckWeightOut);
			}
		});
		
		$(document).on("click", "#tblScales tbody tr",  function(){
			var data 			 = $("#tblScales").getSelectedRows().data().toArray()[0],
				EirNo 			 = data[_scalesColumns.indexOf('EirNo')],
				rowguid			 = data[_scalesColumns.indexOf('rowguid')],
				FirstWeightScale = data[_scalesColumns.indexOf('FirstWeightScale')],
				SecondWeightScale = data[_scalesColumns.indexOf('SecondWeightScale')],
				JobModeID		 = data[_scalesColumns.indexOf('JobModeID')],
				TruckNumber 	 = data[_scalesColumns.indexOf('TruckNumber')];

			/* CLASS ID: IN */
			if ($("input[type=radio][name=ClassID]:checked").val() == 1){
				$("#JobModeID").val(JobModeID);
				$("#TruckNumber").val(TruckNumber);
				$("#TruckWeightOut").val(SecondWeightScale * 1000);
				$("#rowguid").val(rowguid);
			}
			/* CLASS ID: OUT */
			else{
				$("#EirNo").val(EirNo);
				$("#JobModeID").val(JobModeID);
				$("#TruckWeightIn").val(FirstWeightScale * 1000);
				$("#TruckNumber").val(TruckNumber);

				var formData = {
	        		'action': 'view',
	        		'child_action': 'getDataByTruckNumberForOut',
	        		'TruckNumber': $("#TruckNumber").val(),
	        	};

	        	$('.ibox.collapsible-box').blockUI();
	        	$.ajax({
	            	url: "<?=site_url(md5('Scales') . '/' . md5('scScales'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
	        			$('.ibox.collapsible-box').unblock();

						$("#remainCargoWeight").val(data.remainCargoWeight * 1000);
						if (data.secondWeightScale != -1){
							$("#TruckWeightOut").val(data.secondWeightScale * 1000);
						}

						if (data.list.length > 0){
							var data = data.list[0];
							$("#JobModeID").val(data['JobModeID']);							
						}
						else{
							toastr['warning']("Không tìm thấy dữ liệu tương ứng với số xe: " + formData.TruckNumber + "!");
							return;	
						}
					},
					error: function(err){
						$('.ibox.collapsible-box').unblock();
						console.log(err);
					}
				});		
			}
		});

		/*
		$("#EirNo").on('keydown', function(e){
          	if (e.which == 13){
        		e.preventDefault();
        		if (this.value == ''){
	        		toastr['warning']("Vui lòng nhập giá trị Số PIN/ Số lệnh cần tìm!");
        		}

        		var formData = {
        			'action': 'view',
        			'child_action': 'getDataByPinCodeOrEirNo',
        			'PINCodeOREirNo': this.value,
        		};

        		$.ajax({
                	url: "<?=site_url(md5('Scales') . '/' . md5('scScales'));?>",
					dataType: 'json',
					data: formData,
					type: 'POST',
					success: function (data) {
						if (data.bulkList.length > 0){
							var rows = [];             
console.log(data.bulkList);
							for (i = 0; i < data.bulkList.length; i++){   
								if (!(data.bulkList[i]['FinishDate'])){
									var rData = data.bulkList[i], r = [];
	                            
		                            $.each(_ordEirColumn, function(idx, colname){
		                                var val = "";
		                                switch(colname){
		                                    case "STT": 
		                                        val = i + 1; 
		                                       break;
		                                    case "BillOfLadingORBookingNo":
		                                    	if (rData['BillOfLading']){
		                                    		val = rData['BillOfLading'];
		                                    	}
		                                    	else{
		                                    		val = rData['BookingNo'];
		                                    	}
		                                    	break;	                                        
			 	  							case "IssueDate":
			 	  							case "ExpDate":
			 	  							case "ETB":
			 	  							case "ETD":
			 	  								val = getDateTime(rData[colname]);
			 	  								break;	
			 	  							case "CarWeight":
			 	  								val = rData['CargoWeight'];
			 	  								break;
			 	  							case "TruckNumber":
			 	  								val = rData['TruckNumber'];
			 	  								break;
			 	  							case "Block":
			 	  							case "Bay":
			 	  							case "Row":
			 	  							case "Tier":
			 	  							case "Area":	 	  								
			 	  							case "BrandID":	 	  								
			 	  							case "CarTypeID":	 	  								
											case "VINNo":		 	  									
		                                    case "ordPos":
		                                   	case "Remark":	
		                                   	case "KeyNo":									
		                                   	case "Sequence":									
												val = '';
												break;											
		                                    default:
		                                    	val = '';
		                                        if (rData[colname] != ''){
		                                            val = rData[colname]; 
		                                        }
		                                        break;  
		                                }
		                                r.push(val);
		                            });
		                            rows.push(r);
								}	                            	
	                        }

	                        tblORDEir.dataTable().fnClearTable();
	                        if(rows.length > 0){
	                            tblORDEir.dataTable().fnAddData(rows);
	                            ordEirModal.modal('show');
	                        }
						}
						else{
							toastr['warning']("Không tìm thấy lệnh!");
							return;	
						}
					},
					error: function(err){
						console.log(err);
					}
				});
        	}
        });
		*/

		$("#TruckNumber").on('keydown', function(e){
          	if (e.which == 13){
          		if (this.value == ''){
	        		toastr['warning']("Vui lòng nhập giá trị Số xe cần tìm!");
	        		return;
        		}

        		var TruckNumber = this.value;
        		$("#inputForm").trigger('reset');
        		$("#TruckNumber").val(TruckNumber);

				if ($("input[type=radio][name=ClassID]:checked").val() == 1){
					var formData = {
							'action': 'view',
							'child_action': 'getDataByTruckNumberForIn',
							'TruckNumber': this.value,
						};

					$.ajax({
	                	url: "<?=site_url(md5('Scales') . '/' . md5('scScales'));?>",
						dataType: 'json',
						data: formData,
						type: 'POST',
						success: function (data) {	      				
							/* IN CASE: TruckNumber not have EirNo */
	        				if (data.equipmentList.length > 0){
	        					$('#TruckWeightOut').val(data.equipmentList[0]['EquipmentWeight'] * 1000);
	        					$("#BillOfLading").val(data.equipmentList[0]['BillOfLading']);
	        					$("#BookingNo").val(data.equipmentList[0]['BookingNo']);	 
	        					$("#StockRef").val(data.equipmentList[0]['StockRef']);
	        					return;
	        				}

							/* IN CASE: TruckNumber with EirNo */
	        				if (data.truckWeightDataWithEirNo.length > 0){
	        					$("#EirNo").val(data.truckWeightDataWithEirNo[0]['EirNo']);

	        					if (data.truckWeightDataWithEirNo[0]['TruckWeight']){
	        						$("#TruckWeightOut").val(data.truckWeightDataWithEirNo[0]['TruckWeight'] * 1000);
	        					}

	        					$("#Sequence").val(data.truckWeightDataWithEirNo[0]['maxSequence']);
	        					$("#BillOfLading").val(data.truckWeightDataWithEirNo[0]['BillOfLading']);
	        					return;
	        				}


	        				toastr['info']('Không tồn tại dữ liệu liên quan đến số xe: ' + formData.TruckNumber + ' trong hệ thống. Vui lòng thêm mới trong danh mục thiết bị (hàng rời)!');
						},
						error: function(err){
							$('.ibox.collapsible-box').unblock();
							console.log(err);
						}
					});					
				}	
        		else{
        			var formData = {
		        			'action': 'view',
		        			'child_action': 'getDataByTruckNumberForOut',
		        			'TruckNumber': this.value,
		        		};

	        		$('.ibox.collapsible-box').blockUI();

	        		$.ajax({
	                	url: "<?=site_url(md5('Scales') . '/' . md5('scScales'));?>",
						dataType: 'json',
						data: formData,
						type: 'POST',
						success: function (data) {
	        				$('.ibox.collapsible-box').unblock();

							$("#remainCargoWeight").val(data.remainCargoWeight * 1000);
							if (data.secondWeightScale != -1){
								$("#TruckWeightOut").val(data.secondWeightScale * 1000);
							}
							$('.ibox.collapsible-box').unblock();

							if (data.list.length > 0){
								var data = data.list[0],
									currentTableData = tblScales.getDataByColumns(_scalesColumns);

								$("#EirNo").val(data['EirNo']);
								$("#JobModeID").val(data['JobModeID']);

								for (i = 0; i < currentTableData.length; i++){
									if ($("#TruckNumber").val() == currentTableData[i]['TruckNumber']){
										$("#TruckWeightIn").val(currentTableData[i]['FirstWeightScale'] * 1000);
										$("#JobModeID").val(currentTableData[i]['JobModeID']);
									}
								}
							}
							else{
								toastr['warning']("Không tìm thấy dữ liệu tương ứng với số xe: " + formData.TruckNumber + "!");
								$("#remainCargoWeight").val('');
								return;	
							}
						},
						error: function(err){
							$('.ibox.collapsible-box').unblock();
							console.log(err);
						}
					});
        		}
        	}
		});


		/*
        $(document).on("dblclick", "#tblORDEir tbody tr",  function(){
        	var ordEirData 		= tblORDEir.getSelectedRows().data().toArray()[0],
       			rowguid 		= ordEirData[_ordEirColumn.indexOf('rowguid')],
       			JobModeID 		= ordEirData[_ordEirColumn.indexOf('JobModeID')],
       			TruckNumber 	= ordEirData[_ordEirColumn.indexOf('TruckNumber')],
        		CusID 			= ordEirData[_ordEirColumn.indexOf('CusID')];

        	$("#CusID").val(CusID);
        	$("#JobModeID").val(JobModeID);
        	$("#TruckNumber").val(TruckNumber);

       		ordEirModal.modal('hide');
        });

        $("#apply-ord-eir").on('click', function(){
        	var ordEirData 		= tblORDEir.getSelectedRows().data().toArray()[0],
       			rowguid 		= ordEirData[_ordEirColumn.indexOf('rowguid')],
       			TruckNumber 	= ordEirData[_ordEirColumn.indexOf('TruckNumber')],
       			JobModeID 		= ordEirData[_ordEirColumn.indexOf('JobModeID')],
        		CusID 			= ordEirData[_ordEirColumn.indexOf('CusID')];

        	$("#CusID").val(CusID);
        	$("#JobModeID").val(JobModeID);
        	$("#TruckNumber").val(TruckNumber);
        });
        */

        $("#search").on('click', function(){
        	var formData = {
        			'action': 'view',
        			'child_action': 'loadTruckWeightList',
        		};

        	tblScales.waitingLoad();
        	$("#inputForm").trigger('reset');

        	$.ajax({
               	url: "<?=site_url(md5('Scales') . '/' . md5('scScales'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					tblScales.dataTable().fnClearTable();
					if (data.list.length > 0){
						var rows = [];

						if ($("input[type=radio][name=ClassID]:checked").val() == 1){
							var index = 1;							
							for (i = 0; i < data.list.length; i++){
								var r = [],
									rData = data.list[i];

								if ((rData['EirNo'] && rData['BillOfLading']) || (!rData['EirNo'])){
									$.each(_scalesColumns, function(idx, colname){
				                    	var val = "";
				                        switch(colname){
				                            case "STT": 
				                                val = index++; 
				                                break;
			                               	case "BillOfLadingORBookingNo":
			                               	case "BillOfLading":
			                               	case "BookingNo":
			                               	case "1":
			                               		val = '';
			                               		break;		
				                            default:
				                                val = '';
				                                if (rData[colname] != ''){
				                                    val = rData[colname]; 
				                                }
				                                break;  
				                        }
				                        r.push(val);
				                    });
				                    rows.push(r);  
								}     
							}
						}
						else{
							var index = 1;
							for (i = 0; i < data.list.length; i++){
								var r = [],																	
									rData = data.list[i];

								if (rData['EirNo'] && (!rData['BillOfLading'])){
									$.each(_scalesColumns, function(idx, colname){
				                    	var val = "";
				                        switch(colname){
				                            case "STT": 
				                                val = index++; 
				                                break;
			                               	case "1":
			                               		val = '';
			                               		break;	
			                               	case "BillOfLadingORBookingNo":
			                               		if (rData['BillOfLading']){
			                               			val = rData['BillOfLading'];
			                               		}		
			                               		else{
			                               			val = '';
			                               		}
			                               		break;
			                               	case "BillOfLading":
			                               	case "BookingNo":
			                               		if (rData[colname]){
			                               			val = rData[colname];
			                               		}
			                               		else{
			                               			val = '';
			                               		}
			                               		break;
				                            default:
				                                val = '';
				                                if (rData[colname] != ''){
				                                    val = rData[colname]; 
				                                }
				                                break;  
				                        }
				                        r.push(val);
				                    });
				                    rows.push(r);  
								}     
							}
						}
						
				        if(rows.length > 0){
				            tblScales.dataTable().fnAddData(rows);
				        }
					}
				},
				error: function(err){
					tblScales.dataTable().fnClearTable();
					console.log(err);
				},
        	});

        	
        });

        $("input[type=radio][name=ClassID]").on('change', function(){
        	$("#search").trigger('click');
        });

		$("#save").on('click', function(){
			if (!($("#TruckNumber").val())){
				toastr['error']('Vui lòng nhập Số xe!')
				return;
			}

			if ($("input[type=radio][name=ClassID]:checked").val() == 1){
				/* Scale cargo + truck */
				if ($("#TruckWeightIn").val() && $("#TruckWeightOut").val()){
					if (!($("#EirNo").val())){
						var data = [{
							'TruckNumber': $("#TruckNumber").val(),
							'FirstWeightScale': $("#TruckWeightIn").val() / 1000,
							'SecondWeightScale': $("#TruckWeightOut").val() / 1000,
							'TruckWeight': $("#TruckWeightOut").val() / 1000,	
							'CargoWeight': $("#CargoWeight").val() / 1000,						
							'JobModeID': 'NTAU',
						}],
						formData = {
							'action': 'edit',
							'child_action': 'addTruckWeightForIn',
							'StockRef': $("#StockRef").val(),
							'data': data,
						};
						postSave(formData);
					}
					else{
						var data = [{
							'TruckNumber': $("#TruckNumber").val(),
							'BillOfLading': $("#BillOfLading").val(),
							'FirstWeightScale': $("#TruckWeightIn").val() / 1000,
							'SecondWeightScale': $("#TruckWeightOut").val() / 1000,
							'TruckWeight': $("#TruckWeightOut").val() / 1000,	
							'CargoWeight': $("#CargoWeight").val() / 1000,
							'Sequence': $("#Sequence").val(),
							'EirNo': $("#EirNo").val(),
							'JobModeID': 'NTAU',
						}],
						formData = {
							'action': 'edit',
							'child_action': 'updateTruckWeightWithBLForIn',
							'data': data,
						};
						postSave(formData);
		        		$("#save").attr("disabled", true);
					}
				}
				/* Scale cargo */
				/*
				else{
					if ($("#TruckWeightOut").val() && !($("#TruckWeightIn").val())){ 
						var data = [{
								'SecondWeightScale': $("#TruckWeightOut").val() / 1000,
								'TruckWeight': $("#TruckWeightOut").val() / 1000,							
								'TruckNumber': $("#TruckNumber").val(),
								'JobModeID': 'NTAU',
								'Sequence': 1,
							}],
							formData = {
								'action': 'add',
								'child_action': 'addTruckWeightForIn',
								'data': data,
							};
						postSave(formData);
					}
				}
				*/

				if (!($("#TruckWeightIn")).val() && $("#TruckWeightOut").val()){
					if ($("#EirNo").val()){
						var data = [{
								'EirNo': $("#EirNo").val(),
								'TruckNumber': $("#TruckNumber").val(),
								'BillOfLading': $("#BillOfLading").val(),
								'SecondWeightScale': $("#TruckWeightOut").val() / 1000,
								'TruckWeight': $("#TruckWeightOut").val() / 1000,
								'Sequence': 1, // update later
								'JobModeID': 'NTAU',
							}],
							formData = {
								'action': 'add',
								'child_action': 'addTruckWeightWithBLForIn',
								'data': data,
							};

						postSave(formData);
		        		$("#save").attr("disabled", true);						
					}
				}
			}
			else{
				/* Scase in second time: scale truck + cargo weight */
				if ($("#TruckWeightIn").val() && $("#TruckWeightOut").val()){
					var data = [{
							'EirNo': $("#EirNo").val(),
							'TruckNumber': $("#TruckNumber").val(),			
							'FirstWeightScale': $("#TruckWeightIn").val() / 1000,
							'SecondWeightScale': $("#TruckWeightOut").val() / 1000,
							'TruckWeight': $("#TruckWeightOut").val() / 1000,
							'CargoWeight': $("#CargoWeight").val() / 1000,
							'JobModeID': $("#JobModeID").val(),
							'Sequence': 1,
						}],	
						formData = {
							'action': 'add',
							'data': data,
						};

					/* Prevent duplicate */
					$("#TruckNumber").val('');

					/* Save */
					postSave(formData);
				}
				/* Scase in second time: scale truck weight */
				else if ($("#TruckWeightIn").val() && !($("#TruckWeightOut").val())){
					/* Check exist before save */
					var currentTableData = tblScales.getDataByColumns(_scalesColumns);

					for (i = 0; i < currentTableData.length; i++){
						if ($("#TruckNumber").val() == currentTableData[i]['TruckNumber']){
							toastr['error']("Số xe: " + $("#TruckNumber").val() + " đã được cân lần 1!");
							$("#TruckWeightIn").val(currentTableData[i]['FirstWeightScale'] * 1000);
							$("#currentWeight").val('');
							return;
						}
					}

					var data = [{
							'EirNo': $("#EirNo").val(),
							'TruckNumber': $("#TruckNumber").val(),
							'FirstWeightScale': $("#TruckWeightIn").val() / 1000,
							'SecondWeightScale': '',
							'JobModeID': $("#JobModeID").val(),
							'Sequence': 1,
						}],
						formData = {
							'action': 'add',
							'data': data,
						};
						
					/* Save */
					postSave(formData);

					/* Prevent duplicate */
					$("#TruckWeightIn").val('');
				}
			}
		});

		function postSave(formData){
			$.ajax({
                url: "<?=site_url(md5('Scales') . '/' . md5('scScales'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

		       		$("#save").attr("disabled", false);						
                    if(formData.action == 'add' || formData.action == 'edit'){
                    	toastr["success"]("Lưu dữ liệu thành công!");
                    	location.reload();
                    }
                },
                error: function(err){
		       		$("#save").attr("disabled", false);						
                	toastr["error"]("error!");
                	console.log(err); 
                }
            });
		}

		// QR scan
		let selectedDeviceId;
		var hascam=0;
		const codeReader = new ZXing.BrowserMultiFormatReader();
		codeReader.getVideoInputDevices()
        .then((videoInputDevices) => {
          	const sourceSelect = document.getElementById('sourceSelect')
          	//selectedDeviceId = videoInputDevices[0].deviceId
          	hascam=videoInputDevices.length;
          	if (videoInputDevices.length >= 1) {
           		selectedDeviceId = videoInputDevices[0].deviceId
           		if (videoInputDevices.length >= 2)
           			selectedDeviceId = videoInputDevices[1].deviceId
        	}
        	else
        	{
        		hascam=0;
        	}
    	}).catch((err) => {
          	console.error(err)
        });

		$(document).on("click","#QRSCAN",function(){
			$('#livestream_scanner').modal("show");
		});

		$('#livestream_scanner').on('show.bs.modal', function(){
			if(hascam>0){
		    	codeReader.decodeFromInputVideoDeviceContinuously(selectedDeviceId, 'video', (result, err) => {
		              if (result) {
		                $('#livestream_scanner').modal('hide');
		                try{
		                var jdata=JSON.parse(result.text);
		                var e = jQuery.Event("keydown");
						e.which = 13;
		                $("#TruckNumber").val(jdata.TruckNo).trigger(e);
		                }
		                catch(ex){
		                	toastr["error"]("QR này không thuộc chương trình!");
		                }
					
		              }
		              if (err && !(err instanceof ZXing.NotFoundException)) {
		                console.error(err)
		              }
		            });
			}
			else
			{
				alert("Thiết bị không có camera !");
				setTimeout(function(){
					$('#livestream_scanner').modal("hide");
				},100);
				
			}

   		});

		$('#livestream_scanner').on('hide.bs.modal', function(){
	    	codeReader.reset();
	    });
    });
</script>