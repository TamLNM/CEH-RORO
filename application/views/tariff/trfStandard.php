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

	#contenttable_wrapper .dataTables_scroll #cell-context-0 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-4 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-5 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-6 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-7 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-9 .dropdown-menu  .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}

	.row .collapsible-box .ibox .btn-group{
		width: 328px;
	}

	.btn-group-sm>.btn, .btn-sm{
		border-radius: 5px;
	}
</style>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">BIỂU CƯỚC CHUẨN</div>
				<div class="button-bar-group">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" title="Thêm dòng mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm dòng</span>
					</button>
					<button id="save" class="btn btn-outline-primary btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Lưu dữ liệu" 
										title="Lưu dữ liệu">
						<span class="btn-icon"><i class="fa fa-save"></i>Lưu</span>
					</button>
					<button id="delete" class="btn btn-outline-danger btn-sm mr-1" 
										data-loading-text="<i class='la la-spinner spinner'></i>Xóa dữ liệu" 
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
							<select id="trfStandardFilter" name="trfStandardFilter" class="selectpicker" data-style="btn-default btn-sm" title="-- Chọn mẫu biểu cước --">
								<?php 
								if(count($trfStandardList_distinct) > 0)
								foreach($trfStandardList_distinct as $item) {  	
									$ApplyDate = substr($item['ApplyDate'], 8, 2).'/'.substr($item['ApplyDate'], 5, 2).'/'.substr($item['ApplyDate'], 0, 4);
									$ExpireDate = ( $item['ExpireDate'] != '*' ? substr($item['ExpireDate'], 8, 2).'/'.substr($item['ExpireDate'], 5, 2).'/'.substr($item['ExpireDate'], 0, 4) : '*');

								?>
									<option>
										<?= $ApplyDate.'-'.$ExpireDate.'-'.$item['Remark'] ?>
									</option>
								<?php 
								} 
								?>
							</select>
							<button id="addNewTariff" class="btn btn-outline-success btn-sm ml-3" style="max-height: 5rem;" 
										title="Thêm biểu cước chuẩn mới">
								<span class="btn-icon"><i class="fa fa-plus"></i>Thêm biểu cước chuẩn mới</span>
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-1 bg-f9 border-e">
				<form id='samplesTariffForm'>
				<div class="row ibox mb-0 border-e pb-1 pt-3">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="row ml-2">
							<label class="col-form-label">Hiệu lực từ</label>
							<input id="ApplyDate" class="form-control form-control-sm" placeholder="" type="text" style="height: 25px; width: 125px; margin-left: 10px; margin-right: 10px; margin-top: 2px;border-radius: 5px;">
							<label class="col-form-label">đến</label>
							<input id="ExpireDate" class="form-control form-control-sm" placeholder="" type="text" style="height: 25px; width: 125px; margin-left: 10px; margin-right: 10px; margin-top: 2px; border-radius: 5px;">
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="row ml-2">
							<label class="col-form-label">Tham chiếu</label>
							<input id="Remark" class="form-control form-control-sm" placeholder="Tham chiếu" type="text" style="height: 25px; width: 335px; border-radius: 5px; margin-top: 2px; margin-left: 10px;">
						</div>
					</div>
				</div>
				</form>
			</div>
			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th col-name="STT" class="editor-cancel" style="width: 20px">STT</th>	
								<th col-name="TRFCode">Mã biểu cước</th>
								<th col-name="TRFDesc">Diễn giải</th>
								<th col-name="MethodID">Phương thức vận chuyển</th>
								<th col-name="TransitID">Loại hình vận chuyển</th>
								<th col-name="JobTypeID">Loại công việc</th>
								<th col-name="JobModeID">Phương án</th>
								<th col-name="ClassID">Loại nhập/ xuất</th>
								<th col-name="CargoTypeID">Loại hàng hóa</th>
								<th col-name="Price">Giá</th>
								<th col-name="ServiceID">Dịch vụ</th>
								<th col-name="CarTypeID">Loại xe</th>
								<th col-name="RateID">Tỷ giá</th>
								<th col-name="VAT">VAT</th>
								<!--
								<th col-name="ApplyDate" class="data-type-datetime ApplyDate">Ngày áp dụng</th>
								<th col-name="ExpireDate" class="data-type-datetime ExpireDate">Ngày hết hạn</th>
								-->
								<th col-name="IncludeVAT" class="editor-cancel data-type-checkbox">Đã bao gồm thuế</th>
								<th col-name='rowguid'></th>
							</tr>
							</thead>
							<tbody>
							<!--
							<?php if(count($trfStandardList) > 0) {$i = 1; ?>
								<?php foreach($trfStandardList as $item) {  ?>
									<tr>
										<td style="text-align: center"><?=$i;?></td>
										<td><?=$item['TRFCode'];?></td>
										<td><?=$item['TRFDesc'];?></td>
										<td><input class="hiden-input" value="<?=$item['MethodID'];?>"><?=$item['MethodName'];?></td>
										<td><input class="hiden-input" value="<?=$item['TransitID'];?>"><?=$item['TransitName'];?></td>
										<td><input class="hiden-input" value="<?=$item['JobTypeID'];?>"><?=$item['JobTypeName'];?></td>
										<td><input class="hiden-input" value="<?=$item['JobModeID'];?>"><?=$item['JobModeName'];?></td>
										<td><input class="hiden-input" value="<?=$item['ClassID'];?>"><?=$item['ClassName'];?></td>
										<td><?=$item['Price'];?></td>
										<td><input class="hiden-input" value="<?=$item['ServiceID'];?>"><?=$item['ServiceName'];?></td>
										<td><input class="hiden-input" value="<?=$item['CarTypeID'];?>"><?=$item['CarTypeName'];?></td>
										<td><?=$item['RateID'];?></td>
										<td><?=$item['VAT'];?></td>
										<td class="ApplyDate"><?=$item['ApplyDate'];?></td>
										<td class="ExpireDate"><?=$item['ExpireDate'];?></td>
										<td>
											<label class="checkbox checkbox-success">
												<input type="checkbox"  <?= $item['IncludeVAT'] == 1 ? "checked" : ""?>>
											<span class="input-span"></span></label>
										</td>
										<td><?=$item['Remark'];?></td>
									</tr>
								<?php $i++; }  ?>
							<?php } ?>	
							</tbody>
						-->
						</table>
					</div>
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

<script type="text/javascript">
	$(document).ready(function () {
		var _columns 		= ["STT", "TRFCode", "TRFDesc", "MethodID", "TransitID", "JobTypeID", "JobModeID", "ClassID", "CargoTypeID", "Price", "ServiceID", "CarTypeID", "RateID", "VAT", "IncludeVAT", "rowguid"],
			tbl 			= $('#contenttable'),
			trfCodesList 	= {},
			trfStandardList = {},
			methodList	 	= {},
			transitList		= {},
			jobTypeList 	= {},
			jobModeList 	= {},
			classList 		= {},
			serviceList		= {},
			carTypeList		= {},
			parentMenuList 	= {},
			cargoTypeList 	= {},
			invRataList		= {};

		<?php if(isset($trfStandardList) && count($trfStandardList) >= 0){?>
			trfStandardList = <?= json_encode($trfStandardList);?>;
		<?php } ?>
		
		<?php if(isset($trfCodesList) && count($trfCodesList) >= 0){?>
			trfCodesList = <?= json_encode($trfCodesList);?>;
		<?php } ?>

		<?php if(isset($methodList) && count($methodList) >= 0){?>
			methodList = <?= json_encode($methodList);?>;
		<?php } ?>

		<?php if(isset($transitList) && count($transitList) >= 0){?>
			transitList = <?= json_encode($transitList);?>;
		<?php } ?>

		<?php if(isset($jobTypeList) && count($jobTypeList) >= 0){?>
			jobTypeList = <?= json_encode($jobTypeList);?>;
		<?php } ?>

		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		<?php if(isset($classList) && count($classList) >= 0){?>
			classList = <?= json_encode($classList);?>;
		<?php } ?>

		<?php if(isset($serviceList) && count($serviceList) >= 0){?>
			serviceList = <?= json_encode($serviceList);?>;
		<?php } ?>

		<?php if(isset($carTypeList) && count($carTypeList) >= 0){?>
			carTypeList = <?= json_encode($carTypeList);?>;
		<?php } ?>

		<?php if(isset($invRataList) && count($invRataList) >= 0){?>
			invRataList = <?= json_encode($invRataList);?>;
		<?php } ?>

		<?php if(isset($cargoTypeList) && count($cargoTypeList) >= 0){?>
			cargoTypeList = <?= json_encode($cargoTypeList);?>;
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

		$('.ApplyDate').each((key, val) => {
			let text = $(val).text();
			$(val).text(getDateTime(text));
		});

		$('.ExpireDate').each((key, val) => {
			let text = $(val).text();
			$(val).text(getDateTime(text));
		});

		function getSQLDateTimeFormat(date){
			if (date.length <= 10)
				date += ' 00:00:00';

        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else
        		return date;
        }

		var dataTbl = tbl.newDataTable({
			scrollY: '35vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.getIndexs(["STT", "Price"]) },
				{ className: "text-center", targets: _columns.getIndexs(["TRFCode", "TRFDesc", "MethodID", "TransitID", "JobTypeID", "JobModeID", "ClassID", "CargoTypeID", "ServiceID", "CarTypeID", "RateID", "VAT", "IncludeVAT", "Remark"])},
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

		tbl.editableTableWidget();

		dataTbl.on('preAutoFill', function(evt, datatable, cells){
			cells = cells.map(x => x[0]);
			for (i = 0 ; i < cells.length; i++){
				var cell = tbl.find('tbody tr').eq(cells[i].index.row).find('td').eq(cells[i].index.column);
				/* Set value for colunm 'TRFDesc' */
				var rowIdx 		= cells[i].index.row,
					colIdx 		= _columns.indexOf("TRFDesc"),
					trfDesc 	= trfCodesList.filter( p => p.TRFCode == cells[i].set).map( x => x.TRFCodeName ),
					trfDescCell = tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();


				tbl.DataTable().cell(trfDescCell).data(trfDesc).draw();
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

		var xCol = 1 + parseInt(_columns.getIndexs("TRFCode"));
        tbl.on('change', "tbody tr td:nth-child(" + xCol + ")", function(e){
           	var inp = $(e.target);

        	var crRow 		= inp.closest('tr'),
        		crCol 		= _columns.indexOf('TRFDesc'),
        		crCol2 		= _columns.indexOf('TRFCode'),
        		trfCodeCell = tbl.find("tbody tr:eq(" + ( crRow[0].rowIndex - 1 )+ ") td:eq(" + crCol2 + ")").first(),
        		trfCode		= trfCodeCell.html(),
        		crCell	 	= tbl.find("tbody tr:eq(" + ( crRow[0].rowIndex - 1 )+ ") td:eq(" + crCol + ")").first(),
        		trfDesc 	= trfCodesList.filter( p => p.TRFCode == trfCode).map( x => x.TRFCodeName );
        	tbl.DataTable().cell(crCell).data(trfDesc).draw(false);

        	if(!crRow.hasClass("getAddNewData")){	
	        	tbl.DataTable().row(crRow).nodes().to$().addClass("editing");
        	}
        });

        tbl.bind("paste", function(e){
			var inp = $(e.target);

        	if (inp.closest('td')[0].colSpan == _columns.indexOf("TRFCode")){
        		var trfCode 	= e.originalEvent.clipboardData.getData('Text'),
	        		trfDesc 	= trfCodesList.filter( p => p.TRFCode == trfCode).map( x => x.TRFCodeName ),
	        		crRow 		= inp.closest('tr')[0].rowIndex - 1,
	        		crCol 		= _columns.indexOf('TRFDesc'),
	        		crCell	 	= tbl.find("tbody tr:eq(" + crRow + ") td:eq(" + crCol + ")").first()

	        	tbl.DataTable().cell(crCell).data(trfDesc).draw(false);
        	}
        });

		/* ApplyDate, ExpireDate */
		$('#ApplyDate, #ExpireDate').datepicker({
			controlType: 'select',
			oneLine: true,
			dateFormat: 'dd/mm/yy',	
		});

		$('#ExpireDate').on('focus', function(){
			$(window).keyup(function (e) {
				if (e.which == 56){
					$('#ExpireDate').val('*');
				}
			});
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

       	/* Save event */
       	$('#save').on('click', function(){
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
           		if (!($("#ApplyDate").val())){
           			toastr['error']('Vui lòng nhập thời gian bắt đầu hiệu lực!');
           			return;
           		}   

           		if (!($("#ExpireDate").val())){
           			toastr['error']('Vui lòng nhập thời gian kết thúc hiệu lực!');
           			return;
           		}   

            	var newData = tbl.getAddNewData();

            	if (newData.length > 0){
					for (i = 0; i < newData.length; i++){
						if (newData[i]['TRFCode'] == ''){
							toastr['error']("Vui lòng chọn Mã biểu cước!");
							return;
						}
						
						if (newData[i]['TRFDesc'] == ''){
							toastr['error']("Vui lòng nhập Tên biểu cước cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}
						else{
							for (j = 0; j < trfStandardList.length; j++){
								if (newData[i]['TRFCode'] == trfStandardList[j]['TRFCode']){
									if (newData[i]['TRFDesc'] == trfStandardList[j]['TRFDesc']){
										toastr['error']("Đã tồn tại tên '" + newData[i]['TRFDesc'] + "'' tương ứng với Mã biểu cước: " + newData[i]['TRFCode']);
										return;
									}
								}
							}
						}												

						if (newData[i]['MethodID'] == ''){
							toastr['error']("Vui lòng chọn Phương thức vận chuyển cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}

						if (newData[i]['TransitName'] == ''){
							toastr['error']("Vui lòng chọn Loại hình vận chuyển cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}


						if (newData[i]['JobTypeID'] == ''){
							toastr['error']("Vui lòng chọn Loại công việc cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}

						if (newData[i]['JobModeID'] == ''){
							toastr['error']("Vui lòng chọn Phương án cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}

						if (newData[i]['ClassID'] == ''){
							toastr['error']("Vui lòng chọn Loại nhập xuất cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}

						if (newData[i]['Price'] == ''){
							toastr['error']("Vui lòng nhập Giá cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}
						else{
							if (!($.isNumeric(newData[i]['Price']))){
								toastr['error']("Vui lòng nhập Giá hợp lệ cho Mã biểu cước: " + newData[i]['TRFCode']);
								return;
							}
						}

						if (newData[i]['ServiceID'] == ''){
							toastr['error']("Vui lòng chọn Dịch vụ cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}

						if (newData[i]['CarTypeID'] == ''){
							toastr['error']("Vui lòng chọn Loại xe cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}


						if (newData[i]['RateID'] == ''){
							toastr['error']("Vui lòng chọn Tỷ giá cho Mã biểu cước: " + newData[i]['TRFCode']);
							return;
						}

						if (newData[i]['VAT'] == ''){
							toastr['error']("Vui lòng nhập VAT cho Mã biểu cước: " + newData[i]['TRFCode']);
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


        //save functions
        function saveData(){        	
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				var ApplyDate	= getSQLDateTimeFormat($("#ApplyDate").val()),
					ExpireDate 	= ($("#ExpireDate").val() == '*' ? '*' : getSQLDateTimeFormat($("#ExpireDate").val())),
					Remark 		= $("#Remark").val();

				var fnew = {
					'action': 'add',
					'data': newData,
					'ApplyDate': ApplyDate,
					'ExpireDate': ExpireDate,
					'Remark': Remark,
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				var ApplyDate	= getSQLDateTimeFormat($("#ApplyDate").val()),
					ExpireDate 	= ($("#ExpireDate").val() == '*' ? '*' : getSQLDateTimeFormat($("#ExpireDate").val())),
					Remark 		= $("#Remark").val();

				var fedit = {
					'action': 'edit',
					'data': editData,
					'ApplyDate': ApplyDate,
					'ExpireDate': ExpireDate,
					'Remark': Remark,
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Tariff') . '/' . md5('trfStandard'));?>",
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
                    	location.reload();
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
                    	tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
                    	tbl.updateSTT(_columns.indexOf("STT"));
                    	location.reload();
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
		 
		function postDel(rows){
			$('.ibox.collapsible-box').blockUI();
			
			var delTRFStandard = rows.map(p=>p[_columns.indexOf("rowguid")]);
			var delBtn = $('#delete');
			delBtn.button('loading');

			for (i = 0; i < delTRFStandard.length; i++){
				for (j = 0; j < trfStandardList.length; j++){
					if (delTRFStandard[i] == trfStandardList[j]['rowguid']){
						trfStandardList.splice(j,1);
					}
				}
			}	

			var formdata = {
				'action': 'delete',
				'data': delTRFStandard,
			};

			$.ajax({
				url: "<?=site_url(md5('Tariff') . '/' . md5('trfStandard'));?>",
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
	                		var deletedTRFStandard = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "rowguid" ), deletedTRFStandard);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( "Xóa thành công!" );
	                		location.reload();
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

		/* Set drop down list */
		tbl.setExtendDropdown({
			target: "#cell-context-0",
			source: trfCodesList,
			colIndex: _columns.indexOf("TRFCode"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				tbl.DataTable().cell(cell).data(value).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];
				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");

				/* Set value for colunm 'TRFDesc' */
				/*
				var colIdx 	= _columns.indexOf("TRFDesc"),
					trfDesc = trfCodesList.filter( p => p.TRFCode == value).map( x => x.TRFCodeName ),
					trfDescCell = tbl.find("tbody tr:eq(" + rowIdx + ") td:eq(" + colIdx + ")").first();

				tbl.DataTable().cell(trfDescCell).data(trfDesc).draw();
				*/
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-1",
			source: methodList,
			colIndex: _columns.indexOf("MethodID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var methodName = methodList.filter( p => p.MethodID == value).map( x => x.MethodName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + methodName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-2",
			source: transitList,
			colIndex: _columns.indexOf("TransitID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var transitName = transitList.filter( p => p.TransitID == value).map( x => x.TransitName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + transitName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-3",
			source: jobTypeList,
			colIndex: _columns.indexOf("JobTypeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var jobTypeName = jobTypeList.filter( p => p.JobTypeID == value).map( x => x.JobTypeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + jobTypeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-4",
			source: jobModeList,
			colIndex: _columns.indexOf("JobModeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var jobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + jobModeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-5",
			source: classList,
			colIndex: _columns.indexOf("ClassID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var className = classList.filter( p => p.ClassID == value).map( x => x.ClassName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + className
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-6",
			source: serviceList,
			colIndex: _columns.indexOf("ServiceID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var serviceName = serviceList.filter( p => p.ServiceID == value).map( x => x.ServiceName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + serviceName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-7",
			source: carTypeList,
			colIndex: _columns.indexOf("CarTypeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var carTypeName = carTypeList.filter( p => p.CarTypeID == value).map( x => x.CarTypeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + carTypeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-8",
			source: invRataList,
			colIndex: _columns.indexOf("RateID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				tbl.DataTable().cell(cell).data(value).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-9",
			source: cargoTypeList,
			colIndex: _columns.indexOf("CargoTypeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var CargoTypeName = cargoTypeList.filter( p => p.CargoTypeID == value).map( x => x.CargoTypeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + CargoTypeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		$('#FromDay, #ToDay').on('change', function(){
			var FromDay = $('#FromDay').val(),
				ToDay 	= $('#ToDay').val();

			if ((FromDay != '' && ToDay != '') || (FromDay == '' && ToDay == '')){			
				var formData = {
					'action': 'view',
					'FromDay': (FromDay == '' ? '' : getSQLDateTimeFormat(FromDay)),
					'ToDay': (ToDay == '' ? '' : getSQLDateTimeFormat(ToDay)),
				};

				$.ajax({
					url: "<?=site_url(md5('Tariff') . '/' . md5('trfStandard'));?>",
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
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'];
											break;
										case "TransitID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['TransitName'];
											break;
										case "JobTypeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobTypeName'];
											break;
										case "JobModeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'];
											break;
										case "ClassID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['ClassName'];
											break;
										case "ServiceID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['ServiceName'];
											break;
										case "CarTypeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CarTypeName'];
											break;	
										case "CargoTypeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CargoTypeName'];
											break;	
										case "IncludeVAT":
											val='<label class="checkbox checkbox-success"><input type="checkbox"' + (rData[colname] == 1 ? "checked" : "") + '><span class="input-span"></span></label>';
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
			}
		});

		/* Filter */
		$('#trfStandardFilter').on('change', function(){
			var val 		= $('select[name=trfStandardFilter]').val();				

			if (val.substring(11, 12) != '*'){
				FromDay 	= val.substring(6,10) + '-' + val.substring(3,5) + '-' + val.substring(0,2),
				ToDay 		= val.substring(17,21) + '-' + val.substring(14,16) + '-' + val.substring(11,13);
				Remark 		= val.substring(22,val.length);
			}
			else{
				FromDay 	= val.substring(6,10) + '-' + val.substring(3,5) + '-' + val.substring(0,2),
				ToDay 		= '*';
				Remark 		= val.substring(13,val.length);
			}

			$('#ApplyDate').val(getDate(FromDay));
			$("#ExpireDate").val(getDate(ToDay));
			$('#Remark').val(Remark);

			var formData = {
					'action': 'view',
					'FromDay': (FromDay == '' ? '' : getSQLDateTimeFormat(FromDay)),
					'ToDay': (ToDay == '*' ? '*' : getSQLDateTimeFormat(ToDay)),
					'Remark': Remark,
				};
				$.ajax({
					url: "<?=site_url(md5('Tariff') . '/' . md5('trfStandard'));?>",
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
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['MethodName'];
											break;
										case "TransitID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['TransitName'];
											break;
										case "JobTypeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobTypeName'];
											break;
										case "JobModeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['JobModeName'];
											break;
										case "ClassID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['ClassName'];
											break;
										case "ServiceID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['ServiceName'];
											break;
										case "CarTypeID":
											val='<input class="hiden-input" value="' + rData[colname] + '">' + rData['CarTypeName'];
											break;	
										case "IncludeVAT":
											val='<label class="checkbox checkbox-success"><input type="checkbox"' + (rData[colname] == 1 ? "checked" : "") + '><span class="input-span"></span></label>';
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

		$("#addNewTariff").on('click', function(){
			$("#samplesTariffForm").trigger('reset');
			$("#trfStandardFilter").val('');
			$("#trfStandardFilter").selectpicker('refresh');
			tbl.dataTable().fnClearTable();
		});
	});
</script>

<div id="cell-context-0" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

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

<div id="cell-context-6" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-7" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-8" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-9" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-10" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>