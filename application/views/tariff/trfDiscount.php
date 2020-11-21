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

	#contenttable_wrapper .dataTables_scroll #cell-context .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}

	.row .collapsible-box .ibox .btn-group{
		width: 300px;
	}
	.btn-group-sm>.btn, .btn-sm{
		border-radius: 5px;
	}
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">HỢP ĐỒNG (THEO KHÁCH HÀNG)</div>
				<div class="button-bar-group mr-3">
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
						<div class="row ml-2">
							<label class="mr-3">Mẫu</label>
							<select id="trfDiscountFilter" name="trfDiscountFilter" class="selectpicker" data-style="btn-default btn-sm" title="--- Chọn mẫu hợp đồng ---">
								<?php 
								if(count($trfDiscountList_distinct) > 0)
								foreach($trfDiscountList_distinct as $item) {  	
									$ApplyDate = substr($item['ApplyDate'], 8, 2).'/'.substr($item['ApplyDate'], 5, 2).'/'.substr($item['ApplyDate'], 0, 4);
									$ExpireDate = ( $item['ExpireDate'] != '*' ? substr($item['ExpireDate'], 8, 2).'/'.substr($item['ExpireDate'], 5, 2).'/'.substr($item['ExpireDate'], 0, 4) : '*');

								?>
									<option>
										<?= $item['DiscountID'].'-'.$item['CusID'].'-'.$item['CusTypeID'].'-'.$ApplyDate.'-'.$ExpireDate?>
									</option>
								<?php 
								} 
								?>
							</select>
							<button id="addNewContract" class="btn btn-outline-success btn-sm ml-3" style="max-height: 5rem;" 
										title="Thêm hợp đồng mới">
								<span class="btn-icon"><i class="fa fa-plus"></i>Thêm hợp đồng mới</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e">
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<form id='contractForm'>
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<div style="width: 95px;">
										<label class="col-form-label" style="margin-left: 20px;">Số h.đồng</label>
									</div>
									<input id="DiscountID" class="form-control form-control-sm" placeholder="Mã hợp đồng" type="text" style="height: 25px; width: 175px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;">
								</div>
								<div class="row form-group">
									<div style="width: 95px;">
										<label class="col-form-label" style="margin-left: 20px;">Tên</label>
									</div>
									<input id="DiscountName" class="form-control form-control-sm" placeholder="Tên hợp đồng" type="text" style="height: 25px; width: 175px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;">
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<div style="width: 95px;">
										<label class="col-form-label" style="margin-left: 20px;">Khách hàng</label>
									</div>
									<input id="CusName" class="form-control form-control-sm" placeholder="Khách hàng" type="text" style="height: 25px; width: 175px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;">
									<input id="CusID" hidden>
							</select>
								</div>
								<div class="row form-group">
									<div style="width: 95px;">
										<label class="col-form-label" style="margin-left: 20px;">Loại khách</label>
									</div>
									<input id="CusTypeName" class="form-control form-control-sm" placeholder="Loại khách hàng" type="text" style="height: 25px; width: 175px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;" readonly>
									<input id="CusTypeID" hidden>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<div style="width: 110px;">
										<label class="col-form-label" style="margin-left: 20px;">Ngày ký</label>
									</div>
									<input id="ApplyDate" class="form-control form-control-sm" placeholder="" type="text" style="height: 25px; width: 175px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;">
								</div>
								<div class="row form-group">
									<div style="width: 110px;">
										<label class="col-form-label" style="margin-left: 20px;">Ngày hết hạn</label>
									</div>
									<input id="ExpireDate" class="form-control form-control-sm" placeholder="" type="text" style="height: 25px; width: 175px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;">
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th col-name="STT" class="editor-cancel" style="width: 20px">STT</th>
							<th col-name="rowguid"></th>
							<th col-name="TRFCode">Mã biểu cước</th>
							<th col-name="TRFDesc">Diễn giải</th>
							<th col-name="MethodID">Phương thức vận chuyển</th>
							<th col-name="TransitID">Loại hình vận chuyển</th>
							<th col-name="JobTypeID">Loại công việc</th>
							<th col-name="JobModeID">Phương án</th>
							<th col-name="ClassID">Loại nhập/ xuất</th>
							<th col-name="Price">Giá</th>
							<th col-name="ServiceID">Dịch vụ</th>
							<th col-name="BrandID">Hãng xe</th>
							<th col-name="CarTypeID">Loại xe</th>
							<th col-name="RateID">Tỷ giá</th>
							<th col-name="VAT">VAT</th>
							<th col-name="PaymentTypeID">Loại hình thanh toán</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		var _columns 			= ["STT", "rowguid", "TRFCode", "TRFDesc", "MethodID", "TransitID", "JobTypeID", "JobModeID", "ClassID", "Price", "ServiceID", "BrandID", "CarTypeID", "RateID", "VAT", "PaymentTypeID"],
			_customerColumns 	= ["STT", "CusID", "CusName", "CusTypeID", "CusTypeName"],
			_trfStandardColumns = ["STT",  "TRFCode", "TRFCodeName", "TRFDesc", "MethodID", "MethodName", "TransitID", "TransitName", "JobTypeID", "JobTypeName", "JobModeID", "JobModeName", "ClassID", "ClassName", "Price", "ServiceID", "ServiceName", "CarTypeID", "CarTypeName", "RateID", "VAT", "IncludeVAT", "Tick"],
			_brandColumns 		= ["STT", "BrandID", "BrandName"],
			tbl 				= $('#contenttable'),
			tblCustomer			= $("#tblCustomer"),
			tblTRFStandard		= $("#tblTRFStandard"),
			tblBrand			= $("#tblBrand"),
			customerModal   	= $('#customer-modal'),
			trfStandardModal 	= $('#trf-standard-modal'),
			brandModal		 	= $('#brand-modal'),
			paymentTypeList		= {},
			customerList 		= {},
			cusTypeList			= {},
			trfCodesList			= {},
			trfDiscountList 	= {},
			trfStandardList 	= {},
			parentMenuList 	= {},
			trfDiscountList_distinct = {};

		<?php if(isset($paymentTypeList) && count($paymentTypeList) >= 0){?>
			paymentTypeList = <?= json_encode($paymentTypeList);?>;
		<?php } ?>

		<?php if(isset($trfCodesList) && count($trfCodesList) >= 0){?>
			trfCodesList = <?= json_encode($trfCodesList);?>;
		<?php } ?>	

		<?php if(isset($customerList) && count($customerList) >= 0){?>
			customerList = <?= json_encode($customerList);?>;
		<?php } ?>	

		<?php if(isset($cusTypeList) && count($cusTypeList) >= 0){?>
			cusTypeList = <?= json_encode($cusTypeList);?>;
		<?php } ?>	

		<?php if(isset($trfDiscountList_distinct) && count($trfDiscountList_distinct) >= 0){?>
			trfDiscountList_distinct = <?= json_encode($trfDiscountList_distinct);?>;
		<?php } ?>	

		<?php if(isset($trfDiscountList) && count($trfDiscountList) >= 0){?>
			trfDiscountList = <?= json_encode($trfDiscountList);?>;
		<?php } ?>	

		<?php if(isset($trfStandardList) && count($trfStandardList) >= 0){?>
			trfStandardList = <?= json_encode($trfStandardList);?>;
		<?php } ?>	

		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Tariff'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		var dataTbl = tbl.newDataTable({
			scrollY: '35vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.getIndexs(["STT", "Price"]) },
				{ className: "text-center", targets: _columns.getIndexs(["TRFCode", "TRFDesc", "MethodID", "TransitID", "JobTypeID", "JobModeID", "ClassID", "ServiceID", "BrandID", "CarTypeID", "RateID", "VAT", "PaymentTypeID"])},
				{ className: "hiden-input", targets: _columns.indexOf("rowguid")},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: true,
            select: true,
            rowReorder: false,
            arrayColumns: _columns,
		});

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

		/* Initial customer table */
		var dataTbl2 = tblCustomer.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _customerColumns.indexOf('STT')},		
				{ className: "text-center", targets: _customerColumns.getIndexs(["CusID", "CusName", "CusTypeID"])},
				{ className: "hiden-input", targets: _customerColumns.indexOf("CusTypeName")},
			],
			order: [[ _customerColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _customerColumns,
		});

		customerModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		/* Initial TRF Standard table */
		var dataTbl3 = tblTRFStandard.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _trfStandardColumns.indexOf('STT')},		
				{ className: "text-center", targets: _trfStandardColumns.getIndexs([ "TRFCode", "TRFDesc", "Price", , "RateID", "VAT", "MethodName", "TransitName", "JobTypeName", "JobModeName", "ClassName", "ServiceName", "CarTypeName", "IncludeVAT"])},
				{ className: "hiden-input", targets: _trfStandardColumns.getIndexs(["MethodID", "TransitID", "JobTypeID", "JobModeID", "ClassID", "ServiceID", "CarTypeID", "Tick"])},
			],
			order: [[ _trfStandardColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _trfStandardColumns,
		});

		/* Initial Brand table */
		var dataTbl4 = tblBrand.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _brandColumns.indexOf('STT')},		
				{ className: "text-center", targets: _brandColumns.getIndexs([ "BrandID", "BrandName" ])},
			],
			order: [[ _brandColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false,
            arrayColumns: _brandColumns,
		});
		brandModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});		

		tblTRFStandard.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

		var numCount = 0;
		/* Add new row event */
		$('#addrow').on('click', function(){
			$('#add-row-modal').modal("show");
        });

		var sumNumRows = 0;
        $("#apply-add-row").on("click", function(){
        	numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
        	sumNumRows += numRows;
        	if (numRows == 1){
        		tbl.newRow();
        		rowsExist = $("#contenttable").DataTable().rows().nodes().length;
				for (i = 0; i < rowsExist; i++){
					cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
					tbl.DataTable().cell(cell).data(i+1).draw(false);
				}
			}
			else{
				numRowsExist = $("#contenttable").DataTable().rows().nodes().length;
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
			}
       	});

        $("#add-row-modal").bind('keypress', function(e) {
       		if(e.which == 13){
	       		numRows = parseInt($('#rowsNumeric').val()); // Numeric of new rows user added
	        	sumNumRows += numRows;
	        	if (numRows == 1){
	        		tbl.newRow();
	        		rowsExist = $("#contenttable").DataTable().rows().nodes().length;
					for (i = 0; i < rowsExist; i++){
						cell = tbl.find("tbody tr:eq(" + i + ") td:eq("+ _columns.indexOf("STT") +")");
						tbl.DataTable().cell(cell).data(i+1).draw(false);
					}
				}
				else{
					numRowsExist = $("#contenttable").DataTable().rows().nodes().length;
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
				}
				$("#add-row-modal").modal("hide");
			}
			else{
			}
       	});

       	/* Prevent press '-' */
       	$("#rowsNumeric").keydown(function(event) {
		  	if (event.which == 189) {
		    	event.preventDefault();
		   	}
		});

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){
        	var inp = $(e.target);
        	if(inp.is(":checked")){
        		inp.attr("checked", "");
        		inp.val("1");
        	}else{
        		inp.removeAttr("checked");
        		inp.val("0");
        	}

        	var crCell = inp.closest('td');
        	var crRow = inp.closest('tr');
        	var eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html()).draw(false);
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

		$('#ApplyDate, #ExpireDate').datetimepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',			
		});

		$('#ApplyDate, #ExpireDate').on('change', function(){
			this.value = this.value.substr(0,10);
		});

		$('#ExpireDate').on('focus', function(){
			$(window).keyup(function (e) {
				if (e.which == 56){
					$('#ExpireDate').val('*');
				}
			});
		});

		/* Choose customer */
		$('#CusName').on('click', function(){
			customerModal.modal('show');
		});

		$("#apply-customer").on("click", function(){
			var customerData 	= tblCustomer.getSelectedRows().data().toArray()[0],
				cusID 			= customerData[_customerColumns.indexOf('CusID')],
				cusName			= customerData[_customerColumns.indexOf('CusName')],
				cusTypeID		= customerData[_customerColumns.indexOf('CusTypeID')],
				cusTypeName		= customerData[_customerColumns.indexOf('CusTypeName')];
			
			$("#CusID").val(cusID);
			$("#CusName").val(cusName);
			$("#CusTypeID").val(cusTypeID);
			$("#CusTypeName").val(cusTypeName);
		});

		tblCustomer.find("tbody tr").on("dblclick", function(){ // Double Click
			var	cusID 		 = $(this).find("td:eq("+_customerColumns.indexOf("CusID")+")").text(),
				cusName 	 = $(this).find("td:eq("+_customerColumns.indexOf("CusName")+")").text(),
				cusTypeID 	 = $(this).find("td:eq("+_customerColumns.indexOf("CusTypeID")+")").text(),
				cusTypeName	 = $(this).find("td:eq("+_customerColumns.indexOf("CusTypeName")+")").text();

			$("#CusID").val(cusID);
			$("#CusName").val(cusName);
			$("#CusTypeID").val(cusTypeID);
			$("#CusTypeName").val(cusTypeName);	
			
			customerModal.modal("hide");
		});

		/* TRF Standard Modal */
				//tbl.setExtendSelect( _columns.indexOf("TRFCode"), function(rIdx, cIdx){
		//	$("#apply-trf-standard").val(rIdx + "." + cIdx);
		//	trfStandardModal.modal("show");
		//});
		//
		//tblTRFStandard.find("tbody tr").on("dblclick", function(){ // Double Click
		//	var applyBtn = $("#apply-trf-standard"),
		//		rIdx = applyBtn.val().split(".")[0],
		//		cIdx = applyBtn.val().split(".")[1],				
		//		dtTbl = tbl.DataTable();
		//
		//	var cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),	
		//		val  = $(this).find("td:eq("+_trfStandardColumns.indexOf("TRFCode")+")").text(),
		//		currentIndex = tbl.getDataByColumns(_columns).length,
		//		rows = [];
		//	//dtTbl.cell(cell).data(val).draw(false);
		//
		//
		//	for (i = 0; i < trfStandardList.length; i++){
		//		var r = [];
		//
		//		if (trfStandardList[i]['TRFCode'] == val){
		//			r.push(currentIndex++);
		//			r.push('');
		//			r.push(trfStandardList[i]['TRFDesc']);
		//			r.push(trfStandardList[i]['TRFDesc']);
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['MethodID']  +'">' + trfStandardList[i]['MethodName']);
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['TransitID']  +'">' + trfStandardList[i]['TransitName']);
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['JobTypeID']  +'">' + trfStandardList[i]['JobTypeName']);
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['JobModeID']  +'">' + trfStandardList[i]['JobModeName']);
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['ClassID']  +'">' + trfStandardList[i]['ClassName']);
		//			r.push(trfStandardList[i]['Price']);
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['ServiceID']  +'">' + trfStandardList[i]['ServiceName']);
		//			r.push('');
		//			r.push('<input class="hiden-input" value="'+ trfStandardList[i]['CarTypeID']  +'">' + trfStandardList[i]['CarTypeName']);
		//			r.push(trfStandardList[i]['RateID']);
		//			r.push(trfStandardList[i]['VAT']);
		//			r.push('');
		//			rows.push(r);
		//		}
		//	}
		//
		//	if(rows.length > 0){
		//		tbl.dataTable().fnAddData(rows);
		//    }
		//
		//    /* Delete empty rows */
		//    var indexes = tbl.filterRowIndexes( _columns.indexOf( "TRFDesc" ), '');
	    //    tbl.DataTable().rows( indexes ).remove().draw( false );
		//
		//	/*
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("TRFDesc") + ")").first(),	
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("TRFDesc")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("Price") + ")").first(),	
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("Price")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("RateID") + ")").first(),	
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("RateID")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("VAT") + ")").first(),	
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("VAT")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("MethodID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("MethodID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("MethodName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("TransitID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("TransitID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("TransitName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("JobTypeID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("JobTypeID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("JobTypeName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("JobModeID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("JobModeID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("JobModeName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("ClassID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("ClassID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("ClassName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("ServiceID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("ServiceID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("ServiceName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("CarTypeID") + ")").first(),	
		//	id 		= $(this).find("td:eq("+_trfStandardColumns.indexOf("CarTypeID")+")").text();			
		//	val 	= $(this).find("td:eq("+_trfStandardColumns.indexOf("CarTypeName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//	*/
		//
		//	/* Add class for editting row */
		//	var crRow = tbl.find("tbody tr:eq("+rIdx+")");
		//
		//	if(!crRow.hasClass("addnew")){
	    //    	dtTbl.row(crRow).nodes().to$().addClass("editing");
        //	}
		//
        //	/* Hide modal */
		//	trfStandardModal.modal("hide");
		//});
		//
		//$("#apply-trf-standard").on('click', function(){
		//	var rIdx = $(this).val().split(".")[0],
		//		cIdx = $(this).val().split(".")[1],				
		//		dtTbl = tbl.DataTable();
		//
		//	var cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),	
		//		val  = tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("TRFCode")+")").text();			
		//		dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("TRFDesc") + ")").first(),	
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("TRFDesc")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("Price") + ")").first(),	
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("Price")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("RateID") + ")").first(),	
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("RateID")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("VAT") + ")").first(),	
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("VAT")+")").text();			
		//	dtTbl.cell(cell).data(val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("MethodID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("MethodID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("MethodName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("TransitID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("TransitID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("TransitName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("JobTypeID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("JobTypeID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("JobTypeName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("JobModeID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("JobModeID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("JobModeName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("ClassID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("ClassID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("ClassName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("ServiceID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("ServiceID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("ServiceName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+ _columns.getIndexs("CarTypeID") + ")").first(),	
		//	id 		= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("CarTypeID")+")").text();			
		//	val 	= tblTRFStandard.find("td:eq("+_trfStandardColumns.indexOf("CarTypeName")+")").text();			
		//	dtTbl.cell(cell).data('<input class="hiden-input" value="'+ id  +'">' + val).draw(false);
		//
		//	/* Add class for editting row */
		//	var crRow = tbl.find("tbody tr:eq("+rIdx+")");
		//
		//	if(!crRow.hasClass("addnew")){
	    //    	dtTbl.row(crRow).nodes().to$().addClass("editing");
        //	}
		//});

		/* Brand Standard Modal */
		tbl.setExtendSelect( _columns.indexOf("BrandID"), function(rIdx, cIdx){
			$('#apply-brand').val(rIdx + "." + cIdx);
			brandModal.modal("show");
		});
		
		tblBrand.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = $("#apply-brand"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				brandID = $(this).find("td:eq("+_brandColumns.indexOf("BrandID")+")").text(),
				brandName  = $(this).find("td:eq("+_brandColumns.indexOf("BrandName")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ brandID  +'">' + brandName
			).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			brandModal.modal("hide");
		});

		$("#apply-brand").on('click', function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = 	$(this).val().split(".")[1],
				brandID 	= tblBrand.getSelectedRows().data().toArray()[0][_brandColumns.indexOf("BrandID")],
				brandName 	= tblBrand.getSelectedRows().data().toArray()[0][_brandColumns.indexOf("BrandName")],
				cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl 	= tbl.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ brandID  +'">' + brandName
				).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});


		/* Get SQL Date Time Format */
		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		/* Save event */
		$('#save').on('click', function(){
			if ($('#DiscountID').val() == ''){
            	toastr['error']("Vui lòng nhập Mã hợp đồng!");
            	return;
            }

            if ($('#DiscountName').val() == ''){
            	toastr['error']("Vui lòng nhập Tên hợp đồng!");
            	return;
            }

            if ($('#CusID').val() == ''){
            	toastr['error']("Vui lòng chọn Khách hàng!");
            	return;
            }

            if ($('#ApplyDate').val() == ''){
            	toastr['error']("Vui lòng nhập Ngày ký!");
            	return;
            }

           	if ($('#ExpireDate').val() == ''){
           		toastr['error']("Vui lòng nhập Ngày hết hạn!");
           		return;
           	}

           	/*
           	checkDiscountIDExist = false;
           	checkDiscountNameChange = false;
           	for (i = 0; i < trfDiscountList.length; i++){
            	if (trfDiscountList[i]['DiscountID'] == $('#DiscountID').val()){
            		checkDiscountIDExist = true;
            		if (trfDiscountList[i]['DiscountName'] != $('#DiscountName').val() ){
            			checkDiscountNameChange = true;
            		}
            		i = trfDiscountList.length;
            	}
            } 
            */      

            if(/*(checkDiscountIDExist == true) && (checkDiscountNameChange == false) && */(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0)){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{            	

            	var newData = tbl.getAddNewData();

            	if (newData.length > 0){
            		for (i = 0; i < newData.length; i++){
            			if (newData[i]['TRFCode'] == ''){
							toastr['error']("Vui lòng chọn Mã biểu cước!");
							return;
						}

						if (newData[i]['BrandID'] == ''){
							toastr['error']("Vui lòng chọn Hãng xe!");
							return;
						}

						if (newData[i]['PaymentTypeID'] == ''){
							toastr['error']("Vui lòng chọn Loại hình thanh toán!");
							return;
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
		                        saveData(/*checkDiscountIDExist, checkDiscountNameChange*/);
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

        function saveData(/*checkDiscountIDExist, checkDiscountNameChange*/){        	
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				var ApplyDate	= getSQLDateTimeFormat($("#ApplyDate").val()),
					ExpireDate 	= ($("#ExpireDate").val() == '*' ? '*' : getSQLDateTimeFormat($("#ExpireDate").val())),
					DiscountID	= ($("#DiscountID").val()),
					DiscountName = ($("#DiscountName").val()),
					CusID 		= ($("#CusID").val()),
					CusTypeID 	= ($("#CusTypeID").val());

				var fnew = {
					'action': 'add',
					'data': newData,
					'ApplyDate': getSQLDateTimeFormat($("#ApplyDate").val()),
					'ExpireDate': ($("#ExpireDate").val() != '*') ? getSQLDateTimeFormat($("#ExpireDate").val()) : '*',
					'DiscountID': $("#DiscountID").val(),
					'DiscountName': $("#DiscountName").val(),
					'CusID': $("#CusID").val(),
					'CusTypeID': $("#CusTypeID").val(),
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				var ApplyDate	= getSQLDateTimeFormat($("#ApplyDate").val()),
					ExpireDate 	= ($("#ExpireDate").val() == '*' ? '*' : getSQLDateTimeFormat($("#ExpireDate").val())),
					DiscountID	= ($("#DiscountID").val()),
					DiscountName = ($("#DiscountName").val()),
					CusID 		= ($("#CusID").val()),
					CusTypeID 	= ($("#CusTypeID").val());

				var fedit = {
					'action': 'edit',
					'data': editData,
					'ApplyDate': ApplyDate,
					'ExpireDate': ExpireDate,
					'DiscountID': DiscountID,
					'DiscountName': DiscountName,
					'CusID': CusID,
					'CusTypeID': CusTypeID,
				};
				postSave(fedit);
			}

			/*
			if (!checkDiscountIDExist){
				var newData = tbl.getDataByColumns(_columns);

				for (i = 0 ; i < newData.length; i++){
					delete newData[i].STT;
				}
				
				var ApplyDate	= getSQLDateTimeFormat($("#ApplyDate").val()),
					ExpireDate 	= ($("#ExpireDate").val() == '*' ? '*' : getSQLDateTimeFormat($("#ExpireDate").val())),
					DiscountID	= ($("#DiscountID").val()),
					DiscountName = ($("#DiscountName").val()),
					CusID 		= ($("#CusID").val()),
					CusTypeID 	= ($("#CusTypeID").val());

				var fnew = {
					'action': 'add',
					'data': newData,
					'ApplyDate': ApplyDate,
					'ExpireDate': ExpireDate,
					'DiscountID': DiscountID,
					'DiscountName': DiscountName,
					'CusID': CusID,
					'CusTypeID': CusTypeID,
				};
				postSave(fnew);
			}
			else{
				if (checkDiscountNameChange){
					var editData = tbl.getDataByColumns(_columns);

					for (i = 0 ; i < editData.length; i++){
						delete editData[i].STT;
					}
					var ApplyDate	= getSQLDateTimeFormat($("#ApplyDate").val()),
						ExpireDate 	= ($("#ExpireDate").val() == '*' ? '*' : getSQLDateTimeFormat($("#ExpireDate").val())),
						DiscountID	= ($("#DiscountID").val()),
						DiscountName = ($("#DiscountName").val()),
						CusID 		= ($("#CusID").val()),
						CusTypeID 	= ($("#CusTypeID").val());

					var fedit = {
						'action': 'edit',
						'data': editData,
						'ApplyDate': ApplyDate,
						'ExpireDate': ExpireDate,
						'DiscountID': DiscountID,
						'DiscountName': DiscountName,
						'CusID': CusID,
						'CusTypeID': CusTypeID,
					};
					postSave(fedit);
				}
			}
			*/
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Tariff') . '/' . md5('trfDiscount'));?>",
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
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
                    	tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
                    	tbl.updateSTT(_columns.indexOf("STT"));
                    }

                    saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
                	$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

		/* Set dropdown for Car Brand */
		tbl.setExtendDropdown({
			target: "#cell-context",
			source: paymentTypeList,
			colIndex: _columns.indexOf("PaymentTypeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var paymentTypeName = paymentTypeList.filter(p => p.PaymentTypeID == value).map(x => x.PaymentTypeName);
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + paymentTypeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-2",
			source: trfCodesList,
			colIndex: _columns.indexOf("TRFCode"),
			onSelected: function(cell, value){
				var val = value,
					currentData = tbl.getDataByColumns(_columns),
					currentIndex = currentData.length,
					rows = [];

			    /* Delete empty rows */
			    var indexes = tbl.filterRowIndexes( _columns.indexOf( "TRFDesc" ), '');
		        tbl.DataTable().rows( indexes ).remove().draw( false );

				for (i = 0; i < trfStandardList.length; i++){
					var r = [],
						checkDuplicateData = false;

					for (j = 0; j < currentData.length; j++){
						if (currentData[j]['TRFCode'] != '' && currentData[j]['TRFDesc'] != ''){
							if (currentData[j]['TRFCode'] == trfStandardList[i]['TRFCode'] && currentData[j]['TRFDesc'] == trfStandardList[i]['TRFDesc']){
								checkDuplicateData = true;
								j = currentData.length;
							}
						}
					}

					if (!checkDuplicateData && trfStandardList[i]['TRFCode'] == val){
						r.push(currentIndex++);
						r.push('');
						r.push(trfStandardList[i]['TRFCode']);
						r.push(trfStandardList[i]['TRFDesc']);
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['MethodID']  +'">' + trfStandardList[i]['MethodName']);
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['TransitID']  +'">' + trfStandardList[i]['TransitName']);
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['JobTypeID']  +'">' + trfStandardList[i]['JobTypeName']);
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['JobModeID']  +'">' + trfStandardList[i]['JobModeName']);
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['ClassID']  +'">' + trfStandardList[i]['ClassName']);
						r.push(trfStandardList[i]['Price']);
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['ServiceID']  +'">' + trfStandardList[i]['ServiceName']);
						r.push('');
						r.push('<input class="hiden-input" value="'+ trfStandardList[i]['CarTypeID']  +'">' + trfStandardList[i]['CarTypeName']);
						r.push(trfStandardList[i]['RateID']);
						r.push(trfStandardList[i]['VAT']);
						r.push('');
						rows.push(r);
					}
				}

				/* Delete data being inserted */
				/*
				for (i = trfStandardList.length - 1; i >= 0; i--){
					if (trfStandardList[i]['TRFCode'] == val){
						trfStandardList.splice(i,1);
					}
				}
				*/

				if(rows.length > 0){
					tbl.dataTable().fnAddData(rows);
			    }
			    tbl.updateSTT( _columns.indexOf( "STT" ) );


				currentTableData = tbl.getDataByColumns(_columns);
				for (i = 0; i < currentTableData.length; i++){
					if (currentTableData[i]['TRFCode'] == val){
						tbl.DataTable().row(i).nodes().to$().addClass("addnew");
					}	
				}
			}
		});

		/* Choose TRF Discount list */
		$("#trfDiscountFilter").on('change', function(){
			var val = $('select[name=trfDiscountFilter]').val();
			DiscountID = val.substr(0, val.indexOf('-'));
			$("#DiscountID").val(DiscountID);
			DiscountName = trfDiscountList_distinct.filter(p => p.DiscountID == DiscountID).map(x => x.DiscountName);
			$("#DiscountName").val(DiscountName);

			val = val.slice(val.indexOf('-') + 1, val.length);
			CusID = val.substr(0, val.indexOf('-'));
			$("#CusID").val(CusID);
			CusName = customerList.filter(p => p.CusID == CusID).map(x => x.CusName);
			$("#CusName").val(CusName);

			val = val.slice(val.indexOf('-') + 1, val.length);
			CusTypeID = val.substr(0, val.indexOf('-'));
			$("#CusTypeID").val(CusTypeID);
			CusName = $.unique(customerList.filter(p => p.CusTypeID == CusTypeID).map(x => x.CusTypeName));
			$("#CusTypeName").val(CusName);

			val = val.slice(val.indexOf('-') + 1, val.length);
			ApplyDate = val.substr(0, val.indexOf('-'))
			$("#ApplyDate").val(ApplyDate);

			val = val.slice(val.indexOf('-') + 1, val.length);
			ExpireDate = val.substr(0, val.length);
			$("#ExpireDate").val(ExpireDate);

			var formData = {
					'action': 'view',
					'DiscountID': DiscountID,
					'CusID': CusID,
					'CusTypeID': CusTypeID,
					'ApplyDate': (ApplyDate == '' ? '' : getSQLDateTimeFormat(ApplyDate)),
					'ExpireDate': (ExpireDate == '*' ? '*' : getSQLDateTimeFormat(ExpireDate)),
				};

				$.ajax({
					url: "<?=site_url(md5('Tariff') . '/' . md5('trfDiscount'));?>",
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
										case "MethodID":
											val = rData['MethodName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'] : '';
											break;
										case "TransitID":
											val = rData['TransitName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['TransitName'] : '';
											break;
										case "JobTypeID":
											val = rData['JobTypeName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobTypeName'] : '';
											break;
										case "JobModeID":
											val = rData['JobModeName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'] : '';
											break;
										case "ClassID":
											val = rData['ClassName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['ClassName'] : '';
											break;
										case "ServiceID":
											val = rData['ServiceName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['ServiceName'] : '';
											break;
										case "CarTypeID":
											val = rData['CarTypeName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['CarTypeName'] : '';
											break;	
										case "BrandID":
											val = rData['BrandName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['BrandName'] : '';
											break;
										case "PaymentTypeID":
											val = rData['PaymentTypeName'] ? '<input class="hiden-input" value="' + rData[colname] + '">' + rData['PaymentTypeName'] : '';
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
			        	}
					},
					error: function(err){
						console.log(err);
					}
				});
		});

		/* Delete event */
		$('#delete').on('click', function () {
        	if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(selectedData){
            		postDel(selectedData);
            	});
            }
        });

		function postDel(data){
			/* Get data need delete */
			var delTRFDiscount = data.map(p=>p[_columns.indexOf("rowguid")]),
				delBtn = $('#delete');
			
			delBtn.button('loading');

			/*
			var delTRFDiscount = data.map(function(item){
				var objDel = {
					"DiscountID": 	$("#DiscountID").val(),
					"CusID": 		$("#CusID").val(),
					"ApplyDate": 	$("#ApplyDate").val(),
					"ExpireDate": 	$("#ExpireDate").val(),
					"TRFCode" : 	item[ _columns.indexOf( "TRFCode" ) ],
					"MethodID": 	item[ _columns.indexOf( "MethodID" ) ],
					"TransitID": 	item[ _columns.indexOf( "TransitID" ) ],
					"JobTypeID": 	item[ _columns.indexOf( "JobTypeID" ) ],
					"JobModeID": 	item[ _columns.indexOf( "JobModeID" ) ],
					"ClassID": 		item[ _columns.indexOf( "ClassID" ) ],
					"ServiceID": 	item[ _columns.indexOf( "ServiceID" ) ],
					"BrandID": 		item[ _columns.indexOf( "BrandID" ) ],
					"CarTypeID": 	item[ _columns.indexOf( "CarTypeID" ) ],
					"RateID": 		item[ _columns.indexOf( "RateID" ) ],
					"VAT": 			item[ _columns.indexOf( "VAT" ) ],
					"PaymentTypeID":item[ _columns.indexOf( "PaymentTypeID" ) ]
				};
				return objDel;
			});

			$('.ibox.collapsible-box').blockUI();
			var delBtn = $('#delete');
			delBtn.button('loading');

			for (i = 0; i < delTRFDiscount.length; i++){
				for (j = 0; j < trfDiscountList.length; j++){
					if (delTRFDiscount[i]['DiscountID'] == trfDiscountList[j]['DiscountID'] &&
						delTRFDiscount[i]['CusID'] 		== trfDiscountList[j]['CusID'] 		&&
						delTRFDiscount[i]['ApplyDate'] 	== trfDiscountList[j]['ApplyDate'] 	&&
						delTRFDiscount[i]['ExpireDate'] == trfDiscountList[j]['ExpireDate'] &&
						delTRFDiscount[i]['TRFCode'] 	== trfDiscountList[j]['TRFCode'] 	&&
						delTRFDiscount[i]['MethodID'] 	== trfDiscountList[j]['MethodID'] 	&&
						delTRFDiscount[i]['TransitID'] 	== trfDiscountList[j]['TransitID'] 	&&
						delTRFDiscount[i]['JobTypeID'] 	== trfDiscountList[j]['JobTypeID'] 	&&
						delTRFDiscount[i]['JobModeID'] 	== trfDiscountList[j]['JobModeID'] 	&&
						delTRFDiscount[i]['ClassID'] 	== trfDiscountList[j]['ClassID'] 	&&
						delTRFDiscount[i]['ServiceID'] 	== trfDiscountList[j]['ServiceID'] 	&&
						delTRFDiscount[i]['BrandID'] 	== trfDiscountList[j]['BrandID'] 	&&
						delTRFDiscount[i]['CarTypeID'] 	== trfDiscountList[j]['CarTypeID'] 	&&
						delTRFDiscount[i]['RateID'] 	== trfDiscountList[j]['RateID'] 	&&
						delTRFDiscount[i]['VAT'] 		== trfDiscountList[j]['VAT'] 		&&
						delTRFDiscount[i]['PaymentTypeID'] == trfDiscountList[j]['PaymentTypeID'])
					{
						trfDiscountList.splice(j,1);
					}
				}
			}	
			*/

			var formdata = {
				'action': 'delete',
				'data': delTRFDiscount,
			};

			$.ajax({
				url: "<?=site_url(md5('Tariff') . '/' . md5('trfDiscount'));?>",
				dataType: 'json',
				data: formdata,
				type: 'POST',
				success: function (output) {
					delBtn.button('reset');
					var data = output.result;
	                if(data.error && data.error.length > 0){
	                	for (var i = 0; i < data.error.length; i++) {
	                		toastr["error"](data.error[i]);
	                	}
	                }

	                if(data.success && data.success.length > 0){
	                	for (var i = 0; i < data.success.length; i++) {
	                		var deletedTRFDiscount = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "rowguid" ), deletedTRFDiscount);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]('Xóa thành công!');
	                	}
	                }
					$('.ibox.collapsible-box').unblock();
				},
				error: function(err){
					delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();
					console.log(err);
				}
			});
		}

		$("#addNewContract").on('click', function(){
			$("#contractForm").trigger('reset');
			$("#trfDiscountFilter").val('');
			$("#trfDiscountFilter").selectpicker('refresh');
			tbl.dataTable().fnClearTable();
		});

		/* Auto fill */
		/*
		dataTbl.on('preAutoFill', function(evt, datatable, cells){
			cells = cells.map(x => x[0]);
			for (i = 0 ; i < cells.length; i++){
				var cell = tbl.find('tbody tr').eq(cells[i].index.row).find('td').eq(cells[i].index.column);

				var dataArr = trfStandardList.filter( p => p.TRFCode == cells[i].set)

				var rowIdx 		= cells[i].index.row,
					colIdx 		= _columns.indexOf("TRFDesc"),
					trfDesc 	= $.unique(dataArr.map( x => x.TRFDesc )),
					cell 		= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(trfDesc).draw(false);

				colIdx 	= _columns.indexOf("MethodID");
				id 		= $.unique(dataArr.map( x => x.MethodID ));
				name 	= $.unique(dataArr.map( x => x.MethodName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);

				colIdx 	= _columns.indexOf("TransitID");
				id 		= $.unique(dataArr.map( x => x.TransitID ));
				name 	= $.unique(dataArr.map( x => x.TransitName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);

				colIdx 	= _columns.indexOf("JobTypeID");
				id 		= $.unique(dataArr.map( x => x.JobTypeID ));
				name 	= $.unique(dataArr.map( x => x.JobTypeName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);

				colIdx 	= _columns.indexOf("JobModeID");
				id 		= $.unique(dataArr.map( x => x.JobModeID ));
				name 	= $.unique(dataArr.map( x => x.JobModeName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);

				colIdx 	= _columns.indexOf("ClassID");
				id 		= $.unique(dataArr.map( x => x.ClassID ));
				name 	= $.unique(dataArr.map( x => x.ClassName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);

				colIdx 	= _columns.indexOf("ServiceID");
				id 		= $.unique(dataArr.map( x => x.ServiceID ));
				name 	= $.unique(dataArr.map( x => x.ServiceName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);

				colIdx 	= _columns.indexOf("Price");
				val 	= $.unique(dataArr.map( x => x.Price ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(val).draw(false);

				colIdx 	= _columns.indexOf("BrandID");
				id 		= $.unique(dataArr.map( x => x.BrandID ));
				name 	= $.unique(dataArr.map( x => x.BrandName ));
				cell 	= tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ id  +'">' + name
				).draw(false);
			}		
		});*/
	});
</script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>

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

<!-- Customer modal-->
<div class="modal fade" id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-2" aria-hidden="true" data-whatever="id" style="padding-left: 14%; margin-top: 5em;">
	<div class="modal-dialog" role="document" style="min-width: 800px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-2">DANH MỤC KHÁCH HÀNG</h5>
			</div>
			<div class="modal-body">
				<table id="tblCustomer" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT">STT</th>
							<th col-name="CusID">Mã khách hàng</th>
							<th col-name="CusName">Tên khách hàng</th>
							<th col-name="CusTypeID">Loại khách</th>
							<th col-name="CusTypeName"></th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($customerList) > 0) {$i = 1; ?>
						<?php foreach($customerList as $item) {  ?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$item['CusID'];?></td>
								<td><?=$item['CusName'];?></td>							
								<td><?=$item['CusTypeID']?></td>				
								<td><?=$item['CusTypeName']?></td>				
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-customer" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- TRF Standard modal-->
<!--
<div class="modal fade" id="trf-standard-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-3" aria-hidden="true" data-whatever="id" style="padding-left: 2%; margin-top: 5em;">
	<div class="modal-dialog" role="document" style="min-width: 1250px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-3s">DANH MỤC BIỂU CƯỚC MẪU</h5>
			</div>
			<div class="modal-body">
				<table id="tblTRFStandard" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT" class="editor-cancel" style="width: 20px">STT</th>
								<th col-name="TRFCode" class="editor-cancel">Mã biểu cước</th>
								<th col-name="TRFCodeName" class="editor-cancel">Tên biểu cước</th>
								<th col-name="TRFDesc" class="editor-cancel">Diễn giải</th>
								<th col-name="MethodID" class="editor-cancel"></th>
								<th col-name="MethodName" class="editor-cancel">Phương thức vận chuyển</th>
								<th col-name="TransitID" class="editor-cancel"></th>
								<th col-name="TransitName" class="editor-cancel">Loại hình vận chuyển</th>
								<th col-name="JobTypeID" class="editor-cancel"></th>
								<th col-name="JobTypeName" class="editor-cancel">Loại công việc</th>
								<th col-name="JobModeID" class="editor-cancel"></th>
								<th col-name="JobModeName" class="editor-cancel">Phương án</th>
								<th col-name="ClassID" class="editor-cancel"></th>
								<th col-name="ClassName" class="editor-cancel">Loại nhập/ xuất</th>
								<th col-name="Price" class="editor-cancel">Giá</th>
								<th col-name="ServiceID" class="editor-cancel"></th>
								<th col-name="ServiceName" class="editor-cancel">Dịch vụ</th>
								<th col-name="CarTypeID" class="editor-cancel">Loại xe</th>
								<th col-name="CarTypeName" class="editor-cancel"></th>
								<th col-name="RateID" class="editor-cancel">Tỷ giá</th>
								<th col-name="VAT" class="editor-cancel">VAT</th>
								<th col-name="IncludeVAT" class="editor-cancel data-type-checkbox">Đã bao gồm thuế</th>
								<th col-name="Tick">VAT</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($trfStandardList) > 0) {$i = 1; ?>
						<?php foreach($trfStandardList as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['TRFCode'];?></td>
								<td><?=$item['TRFCodeName'];?></td>
								<td><?=$item['TRFDesc'];?></td>
								<td><?=$item['MethodID'];?></td>
								<td><?=$item['MethodName'];?></td>
								<td><?=$item['TransitID'];?></td>
								<td><?=$item['TransitName'];?></td>
								<td><?=$item['JobTypeID'];?></td>
								<td><?=$item['JobTypeName'];?></td>
								<td><?=$item['JobModeID'];?></td>
								<td><?=$item['JobModeName'];?></td>
								<td><?=$item['ClassID'];?></td>
								<td><?=$item['ClassName'];?></td>
								<td><?=$item['Price'];?></td>
								<td><?=$item['ServiceID'];?></td>
								<td><?=$item['ServiceName'];?></td>
								<td><?=$item['CarTypeID'];?></td>
								<td><?=$item['CarTypeName'];?></td>
								<td><?=$item['RateID'];?></td>
								<td><?=$item['VAT'];?></td>
								<td>
									<label class="checkbox checkbox-success">
										<input type="checkbox"  <?= $item['IncludeVAT'] == 1 ? "checked" : ""?>>
									<span class="input-span"></span></label>
								</td>
								<td><?=$item['IncludeVAT'];?></td>
							</tr>
						<?php $i++; }  ?>
					<?php } ?>	
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-trf-standard" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>
-->

<!-- Brand modal-->
<div class="modal fade" id="brand-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-4" aria-hidden="true" data-whatever="id" style="padding-left: 2%; margin-top: 5em;">
	<div class="modal-dialog" role="document" style="min-width: 512px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel-4">DANH MỤC BIỂU CƯỚC MẪU</h5>
			</div>
			<div class="modal-body">
				<table id="tblBrand" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT" class="editor-cancel" style="width: 20px">STT</th>
							<th col-name="BrandID">Mã hãng</th>
							<th col-name="BrandName">Tên hãng</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($brandList) > 0) {$i = 1; ?>
						<?php foreach($brandList as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['BrandID'];?></td>
								<td><?=$item['BrandName'];?></td>
							</tr>
						<?php $i++; }  ?>
					<?php } ?>	
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-brand" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Drop down list -->
<div id="cell-context" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-2" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>