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
	#contenttable_wrapper .dataTables_scroll #cell-context .dropdown-menu  .dropdown-item .sub-text{
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
				<div class="ibox-title">QUYỂN HÓA ĐƠN</div>
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
			<div class="row ibox-footer border-top-0">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
						<thead>
						<tr>
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="PackageID">PackageID</th>
							<th col-name="InvPrefixID">Mã quyển hóa đơn</th>
							<th col-name="PackageType">PackageType</th>
							<th col-name="FromInvNo">Số hóa đơn đầu</th>
							<th col-name="ToInvNo">Số hóa đơn cuối</th>
							<th col-name="CreateDate" class="data-type-datetime">Ngày tạo</th>
							<th col-name="ApplyDate" class="data-type-datetime">Ngày áp dụng</th>
						</tr>
						</thead>
						<tbody>
							<?php if(count($prefixList) > 0) {
								  		$i = 1; ?>
								<?php foreach($prefixList as $item){  ?>									
									<tr>
										<td col-name="STT"><?=$i;?></td>
										<td col-name="PackageID"><?=$item['PackageID'];?></td>
										<td col-name="InvPrefixID"><?=$item['InvPrefixID'];?></td>
										<td col-name="PackageType"><?=$item['PackageType'];?></td>		
										<td col-name="FromInvNo"><?=$item['FromInvNo'];?></td>		
										<td col-name="ToInvNo"><?=$item['ToInvNo'];?></td>		
										<td class="CreateDate" col-name="CreateDate"><?=$item['CreateDate'];?></td>		
										<td class="ApplyDate" col-name="ApplyDate"><?=$item['ApplyDate'];?></td>			
									</tr>
									<?php $i++; }  ?>
							<?php } ?>	
						</tbody>
					</table>
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
						<input id="rowsNumeric" name="rowsNumeric" min="1" class="col-md-6 col-sm-6 col-xs-6 form-control form-control-sm border-e" placeholder="Số dòng" type="number" value="1" >
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
		var tbl 			= $('#contenttable'),
			_columns 		= ['STT', 'PackageID', 'InvPrefixID', 'PackageType', 'FromInvNo', 'ToInvNo', 'CreateDate', 'ApplyDate'],
			prefixList		= {};

		<?php if(isset($prefixList) && count($prefixList) > 0){?>
			prefixList = <?=json_encode($prefixList);?>;
		<?php } ?>

		$('.ApplyDate').each((key, val) => {
			let text = $(val).text();
			$(val).text(getDateTime(text));
		});

		$('.CreateDate').each((key, val) => {
			let text = $(val).text();
			$(val).text(getDateTime(text));
		});


		var dataTbl = tbl.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{ className: "text-center", targets: _columns.getIndexs(['PackageID', 'InvPrefixID', 'PackageType', 'FromInvNo', 'ToInvNo', 'CreateDate', 'ApplyDate'])},
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

		tbl.editableTableWidget();

		// Add new event
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

		$(document).bind('keypress', function(e) {
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
		
       	/* Prevent press '-' */
       	$("#rowsNumeric").keydown(function(event) {
		  	if (event.which == 189) {
		    	event.preventDefault();
		   	}
		});

		// Save button event
		$('#save').on('click', function(){
            if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{
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

		function getDateTimeFormatDMY(date){
        	if (date.substring(4,5) == '-')
        		return date.substring(8,10) + '-' + date.substring(5,7) + '-' + date.substring(0,4) + date.substring(10, 19);
        	else 
        		return date;
        }

        function getSQLDateTimeFormat(date){
        	if (date.substring(2,3) == '/')
        		return date.substring(6,10) + '-' + date.substring(3,5) + '-' + date.substring(0,2) + date.substring(10, date.length);
        	else 
        		return date;
        }

		//save functions
        function saveData(){        	
			var newData = tbl.getAddNewData();

			for (i = 0; i < newData.length; i++){
				if (!newData[i]['PackageID']){
					toastr['error']("Vui lòng nhập PackageID!");
					return;
				}	

				if (!newData[i]['InvPrefixID']){
					toastr['error']("Vui lòng nhập Mã quyển hóa đơn!");
					return;
				}
				else{
					for (j = 0; j < prefixList.length; j++){
						if (newData[i]['InvPrefixID'] == prefixList[j]['InvPrefixID']){
							toastr['error']("Đã tồn tại Mã quyển hóa đơn: " + newData[i]['InvPrefixID']);
							return;
						}
					}	
				}		

				if (!newData[i]['PackageType']){
					toastr['error']("Vui lòng nhập PackageType cho Mã quyển hóa đơn: " + newData[i]['InvPrefixID'] + "!");
					return;
				}

				if (!newData[i]['FromInvNo']){
					toastr['error']("Vui lòng nhập Số hóa đơn đầu cho Mã quyển hóa đơn: " + newData[i]['InvPrefixID'] + "!");
					return;
				}

				if (!newData[i]['ToInvNo']){
					toastr['error']("Vui lòng nhập Số hóa đơn cuối cho Mã quyển hóa đơn: " + newData[i]['InvPrefixID'] + "!");
					return;
				}

				if (!newData[i]['CreateDate']){
					toastr['error']("Vui lòng nhập Ngày tạo cho Mã quyển hóa đơn: " + newData[i]['InvPrefixID'] + "!");
					return;
				}
				else{
					newData[i]['CreateDate'] = getSQLDateTimeFormat(newData[i]['CreateDate']); 
				}

				if (!newData[i]['ApplyDate']){
					toastr['error']("Vui lòng nhập Ngày áp dụng cho Mã quyển hóa đơn: " + newData[i]['InvPrefixID'] + "!");
					return;
				}
				else{
					newData[i]['ApplyDate'] = getSQLDateTimeFormat(newData[i]['ApplyDate']); 
				}
			}

			if(newData.length > 0){
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();

			for (i = 0; i < editData.length; i++){
				editData[i]['CreateDate'] = getSQLDateTimeFormat(editData[i]['CreateDate']); 
				editData[i]['ApplyDate'] = getSQLDateTimeFormat(editData[i]['ApplyDate']); 
			}

			console.log(editData);
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
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmPrefix'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                // async: false,
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
			var delPortID = data.map(p=>p[_columns.indexOf("InvPrefixID")]);

			var fdel = {
					'action': 'delete',
					'data': delPortID
				};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmPrefix'));?>",
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

		$("#rowsNumeric").on('change', function(){
			CheckRowsNumericAddNew();
		});

		function CheckRowsNumericAddNew(){
			if ($("#rowsNumeric").val() == ''){
				toastr['error']("Vui lòng nhập Số dòng!");
				return false;
			}
			if (parseInt($("#rowsNumeric").val()) <= 0){
				toastr['error']("Vui lòng nhập Số dòng hợp lệ!");
				return false;
			}
			return true;
		}
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
