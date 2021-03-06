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
	#contenttable_wrapper #contenttable .dataTables_scrollBody .input-span{
		float: center;
	}
	*/
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
				<div class="ibox-title">DỊCH VỤ</div>
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
							<th col-name="ServiceID">Mã dịch vụ</th>
							<th col-name="ServiceName">Tên dịch vụ</th>
							<th col-name="JobModeID">Phương án</th>
							<th col-name="IsQuayJob" class="editor-cancel data-type-checkbox">Cẩu tàu</th>
							<th col-name="IsYardJob" class="editor-cancel data-type-checkbox">Bãi</th>					
							<th col-name="IsGateJob" class="editor-cancel data-type-checkbox">Cổng</th>			
						</tr>
						</thead>
						<tbody>
							<?php if(count($servicesList) > 0) {
								  		$i = 1; ?>
								<?php foreach($servicesList as $item){  ?>									
									<tr>
										<td style="text-align: center; width: 10%" col-name="STT"><?=$i;?></td>		
										<td style="text-align: center" col-name="ServiceID"><?=$item['ServiceID'];?></td>
										<td style="text-align: center" col-name="ServiceName"><?=$item['ServiceName'];?></td>
										<td style="text-align: center" col-name="JobModeID">
											<input class='hiden-input' value="<?=$item['JobModeID'];?>"> 
												<?=$item['JobModeName'];?></input>
										</td>
										<td style="text-align: center" class="editor-cancel data-type-checkbox" colname="IsQuayJob">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsQuayJob'] == 1 ? "checked" : ""?>>
												<span class="input-span"></span>
											</label>
										</td>
										<td style="text-align: center" class="editor-cancel data-type-checkbox" colname="IsYardJob">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsYardJob'] == 1 ? "checked" : ""?>>
												<span class="input-span"></span>
											</label>
										</td>
										<td style="text-align: center" class="editor-cancel data-type-checkbox" colname="IsGateJob">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsGateJob'] == 1 ? "checked" : ""?>>
												<span class="input-span"></span>
											</label>
										</td>
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

<div id="cell-context" class="btn-group">
	<button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
	<div class="dropdown-menu dropdown-menu-right"></div>
</div>

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
<script type="text/javascript">
	$(document).ready(function () {
		var tbl 			= $('#contenttable'),
			_columns 		= ['STT', 'ServiceID', 'ServiceName', 'JobModeID', 'IsQuayJob', 'IsYardJob', 'IsGateJob'],
			jobModeList 	= {},
			servicesList 	= {},
			parentMenuList 	= {};

		<?php if(isset($jobModeList) && count($jobModeList) >= 0){?>
			jobModeList = <?= json_encode($jobModeList);?>;
		<?php } ?>

		<?php if(isset($servicesList) && count($servicesList) >= 0){?>
			servicesList = <?= json_encode($servicesList);?>;
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

		var dataTbl = tbl.newDataTable({
			scrollY: '55vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{ className: "text-center", targets: _columns.getIndexs(['ServiceID', 'ServiceName', 'JobModeID', 'IsGateJob', 'IsYardJob', 'IsQuayJob'])},
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

		tbl.editableTableWidget({editor: $("#editor-input")});

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

		tbl.on('change', 'tbody tr td input[type="checkbox"]', function(e){ // Set checkbox when tick
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

		$("#save").on('click', function(){
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

		function saveData(){
			var newData = tbl.getAddNewData();

			for (i = 0; i < newData.length; i++){
				if (!newData[i]['ServiceID']){
					toastr['error']("Vui lòng chọn Mã dịch vụ!");
					return;
				}
				else{
					for (j = 0; j < servicesList.length; j++){
						if (newData[i]['ServiceID'] == servicesList[j]['ServiceID']){
							toastr['error']("Đã tồn tại Mã dịch vụ: " + newData[i]['ServiceID']);
							return;
						}
					}	
				}			

				if (!newData[i]['ServiceName']){
					toastr['error']("Vui lòng nhập Tên dịch vụ cho Mã dịch vụ: " + newData[i]['ServiceID'] + "!");
					return;
				}

				if (!newData[i]['JobModeID']){
					toastr['error']("Vui lòng chọn Phương án cho Mã dịch vụ: " + newData[i]['ServiceID'] + "!");
					return;
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


			if(editData.length > 0){
				if (!checkDataValue(editData)){
					return;
				}				
				var fedit = {
					'action': 'edit',
					'data': editData
				};
				postSave(fedit);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
        	
			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmServices'));?>",
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
                    	location.reload();
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
			var delPortID = data.map(p=>p[_columns.indexOf("ServiceID")]);

			var fdel = {
					'action': 'delete',
					'data': delPortID
				};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmServices'));?>",
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

		tbl.setExtendDropdown({
			target: "#cell-context",
			source: jobModeList,
			colIndex: _columns.indexOf("JobModeID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//value
				var jobModeName = jobModeList.filter( p => p.JobModeID == value).map( x => x.JobModeName );
				tbl.DataTable().cell(cell).data(
					//cusTypeName
					'<input class="hiden-input" value="'+ value  +'">' + jobModeName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>