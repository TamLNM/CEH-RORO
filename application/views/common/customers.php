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
	/*
	#cus-type-modal .modal-content input[type="search"]{
		width: 65%;
	}

	#cus-type-modal .modal-content label:after{
		right: 27%;
	}
	*/

	#contenttable_wrapper .dataTables_scroll #cell-context 	 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu  .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">KHÁCH HÀNG</div>
				<div class="button-bar-group mr-3">
					<a 	class="btn btn-outline-dark btn-sm mr-1"
						id="export" 
						title="Export"
						href="<?=site_url(md5('Common') . '/' . md5('createXLSForCustomerExport'));?>">
						<span class="btn-icon"><i class="ti-export"></i>Export</span>
					</a>					
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
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Loại</label>
									<div class="col-md-8 col-sm-10 col-xs-10 input-group input-group-sm">
										<select id="customer-type" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Loại khách hàng">
											<option value="" selected>Tất cả</option>
											<?php if(count($cusType) > 0){?>
												<?php foreach($cusType as $item) {  ?>
													<option value="<?=$item['CusTypeID']?>"><?=$item['CusTypeID'];?></option>
												<?php } ?>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Mã</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="cusID" class="form-control form-control-sm" placeholder="Mã khách hàng" type="text">
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">Tên</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="cusName" class="form-control form-control-sm" placeholder="Tên khách hàng" type="text">
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-2 col-sm-2 col-xs-2 col-form-label">MST</label>
									<div class="col-md-8 col-sm-10 col-xs-10">
										<input id="TaxCode" class="form-control form-control-sm" placeholder="Mã số thuế" type="number">
									</div>
								</div>
							</div>
							<hr>
						</div>
					</div>
				</div>
			</div>

			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="rowguid"></th>
							<th col-name="CusTypeID">Loại khách</th>
							<th col-name="CusID">Mã khách hàng</th>
							<th col-name="CusName">Tên khách hàng</th>
							<th col-name="TaxCode">Mã số thuế</th>
							<th col-name="PaymentTypeID">Loại hình thanh toán</th>
							<th col-name="Tel">Điện thoại</th>
							<th col-name="Fax">Fax</th>
							<th col-name="Address">Địa chỉ</th>						
							<th col-name="Email">Email</th>
							<th class="editor-cancel data-type-checkbox" col-name="IsActive">Kích hoạt</th>
						</tr>
						</thead>
						<tbody>
							<!--
							<?php if(count($cus) > 0) {
								  		$i = 1; ?>
								<?php foreach($cus as $item){  ?>
									
									<tr>
										<td colname="STT"><?=$i;?></td>
										<td colname="CusTypeID"><?=$item['CusTypeID'];?></td>
										<td colname="CusID"><?=$item['CusID'];?></td>
										<td colname="CusName"><?=$item['CusName'];?></td>
										<td colname="TaxCode"><?=$item['TaxCode'];?></td>
										<td colname="Tel"><?=$item['Tel'];?></td>					
										<td colname="Fax"><?=$item['Fax'];?></td>
										<td colname="Address"><?=$item['Address'];?></td>
										<td colname="Email"><?=$item['Email'];?></td>
										<td class="editor-cancel data-type-checkbox" colname="TaxCode">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsActive'] == 1 ? "checked" : ""?>>
											<span class="input-span"></span></label>
										</td>
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

<!-- Cus Type modal-->
<!--
<div class="modal fade" id="cus-type-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh mục loại khách hàng</h5>
			</div>
			<div class="modal-body">
				<table id="tblCusType" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT">STT</th>
							<th col-name="CusTypeID">Mã loại</th>
							<th col-name="CusTypeName">Tên loại</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($cusType) > 0) {$i = 1; ?>
						<?php foreach($cusType as $item) {  ?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$item['CusTypeID'];?></td>
								<td><?=$item['CusTypeName'];?></td>
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
-->

<!-- Add more row modal --> 
<div class="modal fade" id="add-row-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding-left: 14%; top: 200px">
	<div class="modal-dialog" role="document" style="width: 300px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="row form-group">
						<label class="col-md-4 col-sm-4 col-xs-4 col-form-label" style="text-align: right; margin-right: 5px">Số dòng</label>
						<input id="rowsNumeric" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Số dòng" type="number" value="1" min="0">
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

<div id="cell-context" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<div id="cell-context-2" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		var _columns 	= ["STT", "rowguid", "CusTypeID", "CusID", "CusName", "TaxCode", "PaymentTypeID", "Tel", "Fax",  "Address", "Email", "IsActive"],
			tbl 		= $('#contenttable'),
			cusType 	= {},
			cus 		= {},
			paymentTypeList = {},
			parentMenuList 	= {};

		<?php if(isset($cusType) && count($cusType) >= 0){?>
			cusType = <?= json_encode($cusType);?>;
		<?php } ?>

		<?php if(isset($cus) && count($cus) >= 0){?>
			cus = <?= json_encode($cus);?>;
		<?php } ?>

		<?php if(isset($paymentTypeList) && count($paymentTypeList) >= 0){?>
			paymentTypeList = <?= json_encode($paymentTypeList);?>;
		<?php } ?>

		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Common'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		var x = tbl.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT')},		
				{ className: "text-center", targets: _columns.getIndexs(["CusTypeID", "CusID", "CusName", "TaxCode", "PaymentTypeID", "Tel", "Fax",  "Address", "Email", "IsActive"])},
				{ className: "hiden-input", targets: _columns.getIndexs(["rowguid"])},
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

		tbl.setExtendDropdown({
			target: "#cell-context",
			source: cusType,
			colIndex: _columns.indexOf("CusTypeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				var cusTypeName = cusType.filter( p => p.CusTypeID == value).map( x => x.CusTypeName );
				tbl.DataTable().cell(cell).data(
					//cusTypeName
					'<input class="hiden-input" value="'+ value  +'">' + cusTypeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});	

		tbl.setExtendDropdown({
			target: "#cell-context-2",
			source: paymentTypeList,
			colIndex: _columns.indexOf("PaymentTypeID"),
			onSelected: function(cell, value){ 
				var paymentTypeName = paymentTypeList.filter( p => p.PaymentTypeID == value).map( x => x.PaymentTypeName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + paymentTypeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});	

        tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

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

		if(isMobile.any()){
			$('#customer-type').selectpicker('mobile');
		}

		$('#search').on('click', function () {
			tbl.waitingLoad();
			var btn = $(this);
			btn.button('loading');
			sumNumRows = 0;

			var formData = {
				'action': 'view',
				'cusType': $('#customer-type').val(),
				'cusID': $('#cusID').val(),
				'cusName': $('#cusName').val(),
				'TaxCode': $('#TaxCode').val(),
			};

			$.ajax({
				url: "<?=site_url(md5('Common') . '/' . md5('cmCustomers'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.list.length > 0) {
						console.log(data.list);
						for (i = 0; i < data.list.length; i++) {
							var rData = data.list[i], r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": 
										val = i+1; 
										break;
									case "CusTypeID":
										val='<input class="hiden-input" value="'+rData[colname]+'">' + rData['CusTypeName'];
										break;
									case "PaymentTypeID":
										val='<input class="hiden-input" value="'+rData[colname]+'">' + rData['PaymentTypeName'];
										break;
									case "IsActive":
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
					
					/*
					$('#contenttable').DataTable( {
						data: rows,
						paging: true,
						columnDefs: [
							{
								 className: "hiden-input"
								,targets: [_columns.indexOf("rowguid")]
							},
							{
								render: function (data, type, full, meta) {
									return "<div class='wrap-text width-"+(meta.col==_columns.indexOf("Address")?350:250)+"'>" + data + "</div>";
								},
								targets: _columns.getIndexs(["CusName", "Address"])
							},
							{ 
								 className: "text-center"
								,targets: _columns.getIndexs(["STT", "CusTypeID", "CusID", "Tel", "Fax", "Email", "IsActive"])
							}
						],
						order: [[ _columns.indexOf("STT"), 'asc' ]],
						keys:true,
			            autoFill: {
			                focus: 'focus'
			            },
			            select: true,
			            rowReorder: false,
						scroller: {
							displayBuffer: 9,
							boundaryScale: 0.95
						}
					} );

					tbl.realign();
			        tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});
				*/
					btn.button('reset');
				},
				error: function(err){
					btn.button('reset');
				}
			});
		});

		$('#save').on('click', function(){
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
            	var newData = tbl.getAddNewData();

            	for (i = 0; i <  newData.length; i++){
            		var checkCusTypeID	= newData[i]['CusTypeID'],
						checkCusID   	= newData[i]['CusID'],
						checkCusName   	= newData[i]['CusName'],
						checkTaxCode 	= newData[i]['TaxCode'],
						checkPaymentType = newData[i]['PaymentTypeID'];

					if(!checkCusTypeID){
						toastr["error"]("Vui lòng chọn Loại khách hàng!");
						return ;
					}

					if(!checkCusID){
						toastr["error"]("Vui lòng nhập Mã khách hàng!");
						return ;
					}

					if(!checkCusName){
						toastr["error"]("Vui lòng nhập Tên khách hàng!");
						return ;
					}

					if(!checkTaxCode){
						toastr["error"]("Vui lòng nhập Mã số thuế!");
						return ;
					}	

					if(!checkPaymentType){
						toastr["error"]("Vui lòng chọn Loại hình thanh toán!");
						return ;
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

        $('#delete').on('click', function(){
            if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(data){
            		postDel(data);
            	});
            }
        });

		function saveData(){
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();
			if(editData.length > 0){		
				var fedit = {
					'action': 'edit',
					'data': editData
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			//saveBtn.button('loading');
        	//$('.ibox.collapsible-box').blockUI();
        	
			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmCustomers'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (datas) {
                	
                    if(datas.deny) {
                        toastr["error"](datas.deny);
                        return;
                    }

                    if(formData.action == 'edit'){
                    	tbl.DataTable().rows( '.editing' ).nodes().to$().removeClass("editing");

                    	var data = datas.result;

		                if(data.error && data.error.length > 0){
		                	for (var i = 0; i < data.error.length; i++) {
		                		toastr["error"](data.error[i].substring(0, data.error[i].length - 36));

		                		tbl.updateSTT( _columns.indexOf( "STT" ) );
				                var	str 	= data.error[i].split(':')[1].trim(),
				                	valueID = str.substring(0, str.length - 36),
				                	compareStr = str.substring(str.length - 37, str.length),
				                	cRow 	= tbl.filterRowIndexes( _columns.indexOf( "rowguid" ), compareStr)['context'][0]['_select_lastCell'].row,
				                	cell 	= tbl.find("tbody tr:eq(" + cRow + ") td:eq("+ _columns.indexOf("DamagedTypeID") +")");			    
	                			tbl.DataTable().cell(cell).data(valueID).draw(false);	                			
		                	}
		                }

		                if(data.success && data.success.length > 0){
		                	for (var i = 0; i < data.success.length; i++) {
		                		toastr["success"]( data.success[i] );
		                	}
		                }

                    	$('#search').trigger('click');
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
                    	$('#search').trigger('click');
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		function postDel(data){
			var delCusID = data.map(p=>p[_columns.indexOf("CusID")]);

			var fdel = {
					'action': 'delete',
					'data': delCusID
				};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmCustomers'));?>",
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

		/*
		// Set extension button choose customer type name brand
		tbl.setExtendSelect( _columns.indexOf("CusTypeName"), function(rIdx, cIdx){
			$("#apply-brand").val(rIdx + "." + cIdx);
			cusTypeModal.modal("show");
		});

		tbl.editableTableWidget();
		*/

		// Adjust column in table when show modal
		/*
		$('#cus-type-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		// Select custom type id on table custom-type-table
		tblCusType.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = $("#apply-brand"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq("+_colCusType.indexOf("CusTypeName")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(cgType).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			cusTypeModal.modal("hide");
		});

		$("#apply-brand").on("click", function(){	// Click Accept
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				cusTypeName = tblCusType.getSelectedRows().data().toArray()[0][_colCusType.indexOf("CusTypeName")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(cusTypeName).draw();
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
		*/

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
                   		ProcessExcel(e.target.result);
                	};
                	reader.readAsBinaryString(input.files[0]);
	            }
	            else{
	              	reader.onload = function (e) {
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
			var rows = [], listAddEdit = {};
			if(excelRows.length > 0) {
				for (i = 0; i < excelRows.length; i++) {
					var rData = excelRows[i], r = [];
						
					if (rData['Mã loại khách (Xem ở cột L đến N)']){
						listAddEdit[i] = 0;
						$.each(_columns, function(idx, colname){
							var val = "";
							switch(colname){
								case "CusTypeID":
									val = rData['Mã loại khách (Xem ở cột L đến N)'];
									break;
								case "CusID":

								// Check invalid data to add new, edit
									for (j = 0; j < cus.length; j++){
										if (cus[j]['CusID'] ==  rData['Mã khách hàng']){
											listAddEdit[i] = 1;
											break;
										}	
									}
									val = rData['Mã khách hàng'];
									break;
								case "CusName":
									val = rData['Tên khách hàng'];
									break;
								case "TaxCode":
									val = rData['Mã số thuế'];
									break;
								case "PaymentTypeID":
									val = rData['Mã loại hình thanh toán (xem ở cột R đến T)'];
									break;
								case "Tel":
									if (rData['Điện thoại'])
										val = rData['Điện thoại']
									else 
										val = '';
									break;		
								case "Address":
									if (rData['Địa chỉ'])
										val = rData['Địa chỉ']
									else
										val = '';
									break;
								case "IsActive":
									val='<label class="checkbox checkbox-success"><input type="checkbox"' + (rData["Kích hoạt (Không: 0, Có: 1)"] == 1 ? "checked" : "") + '><span class="input-span"></span></label>';			
									break;
								default:
									if (rData[colname])
										val = rData[colname];
									else 
										val = '';
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

			for (i = 0; i < excelRows.length; i++){
				crRow = tbl.find("tbody tr:eq("+i+")");
				if (listAddEdit[i] == 0)
					tbl.DataTable().rows(crRow).nodes().to$().addClass("addnew")
				else
					tbl.DataTable().rows(crRow).nodes().to$().addClass("editing");
			}
	    }	
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>