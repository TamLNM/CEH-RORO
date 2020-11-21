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
	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu  .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu  .dropdown-item .sub-text{
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
				<div class="ibox-title">PHƯƠNG ÁN</div>
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
							<th col-name="ClassID">Hướng Nhập/Xuất</th>
							<th col-name="TransitID">Transit ID</th>
							<th col-name="InOut">Vào/Ra</th>
							<th col-name="JobModeID">Mã phương án</th>
							<th col-name="JobModeName">Tên phương án</th>
							<th col-name="IsYard">Bãi</th>
							<th col-name="IsVessel">Tàu</th>
							<th class="data-type-numeric" col-name="CustomsJobType">Mã hình thức (HQ)</th>						
							<th col-name="Remark">Ghi chú</th>							
						</tr>
						</thead>
						<tbody>
							<?php if(count($jobmodeList) > 0) {
								  		$i = 1; ?>
								<?php foreach($jobmodeList as $item){  ?>									
									<tr>
										<td style="text-align: center; width: 10%" col-name="STT"><?=$i;?></td>					
										<td col-name="ClassID">
											<input class="hiden-input" value="<?=$item['ClassID'];?>"><?=$item['ClassName'];?>		
										</td>
										<td col-name="TransitID">
											<input class="hiden-input" value="<?=$item['TransitID'];?>"><?=$item['TransitName'];?>		
										</td>
										<td col-name="ClassID">
											<?php 
												if ($item['InOut'] == "1"){?>
													<input class='hiden-input' value="1">Vào
											<?php
												}else{
											?>
													<input class='hiden-input' value="2">Ra
											<?php
												}
											?>
											</input>
										</td>
										<td col-name="JobModeID"><?=$item['JobModeID'];?></td>
										<td col-name="JobModeName"><?=$item['JobModeName'];?></td>
										<td class="editor-cancel data-type-checkbox" colname="IsYard">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsYard'] == 1 ? "checked" : ""?>>
											<span class="input-span"></span></label>
										</td>
										<td class="editor-cancel data-type-checkbox" colname="IsYard">
											<label class="checkbox checkbox-success">
												<input type="checkbox" <?= $item['IsVessel'] == 1 ? "checked" : ""?>>
											<span class="input-span"></span></label>
										</td>
										<td col-name="CustomsJobType"><?=$item['CustomsJobType'];?></td>
										<td col-name="Remark"><?=$item['Remark'];?></td>
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
		var tbl 		= $('#contenttable'),
			_columns 	= ['STT', 'ClassID', 'TransitID', 'InOut', 'JobModeID', 'JobModeName', 'IsYard', 'IsVessel', 'CustomsJobType', 'Remark'],
			ioList 		= {1: 'Vào', 2: 'Ra'}, // This is a object
			//classList	= {1: 'Nhập', 2: 'Xuất'},
			classList   = {},
			jobmodeList = {},
			transitList = {},
			parentMenuList 	= {}; 

		var dataTbl = tbl.newDataTable({
			scrollY: '55vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{ className: "text-center", targets: _columns.getIndexs(['ClassID', 'TransitID', 'InOut', 'JobModeID', 'JobModeName', 'IsYard', 'IsVessel', 'CustomsJobType', 'Remark']) }
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

		tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")});

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

        	var data = '<label class="checkbox checkbox-success"><input type="checkbox" value="0"><span class="input-span"></span></label>';

        	if (crCell[0]['_DT_CellIndex'].column == _columns.indexOf('IsYard')){
        		var row 	= crCell[0]['_DT_CellIndex'].row,
        			cell 	= tbl.find("tbody tr:eq(" + row + ") td:eq("+ _columns.indexOf("IsVessel") +")");
        		tbl.DataTable().cell(cell).data(data).draw(false);
        	}
        	else{
        		var row 	= crCell[0]['_DT_CellIndex'].row,
        			cell 	= tbl.find("tbody tr:eq(" + row + ") td:eq("+ _columns.indexOf("IsYard") +")");
        		tbl.DataTable().cell(cell).data(data).draw(false);
        	}
        });

		<?php if(isset($jobmodeList) && count($jobmodeList) >= 0){?>
			jobmodeList = <?= json_encode($jobmodeList);?>;
		<?php } ?>

		<?php if(isset($transitList) && count($transitList) >= 0){?>
			transitList = <?= json_encode($transitList);?>;
		<?php } ?>

		<?php if(isset($classList) && count($classList) >= 0){?>
			classList = <?= json_encode($classList);?>;
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

		$("#save").on('click', function(){
			if(tbl.DataTable().rows( '.addnew, .editing' ).data().toArray().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Không có dữ liệu thay đổi!");
            }else{

            	var newData = tbl.getAddNewData();

            	for (i = 0; i < newData.length; i++){
					if (!newData[i]['ClassID']){
						toastr['error']("Vui lòng chọn Loại Nhập/ Xuất!");
						return;
					}

					if (!newData[i]['InOut']){
						toastr['error']("Vui lòng chọn Loại Vào/ Ra!");
						return;
					}

					if (!newData[i]['JobModeID']){
						toastr['error']("Vui lòng chọn Mã phương án!");
						return;
					}
					else{
						for (j = 0; j < jobmodeList.length; j++){
							if (newData[i]['JobModeID'] == jobmodeList[j]['JobModeID']){
								toastr['error']("Đã tồn tại Mã phương án: " + newData[i]['JobModeID']);
								return;
							}
						}	
					}			

					if (!newData[i]['CustomsJobType']){
						toastr['error']("Vui lòng nhập Mã hình thức (HQ) cho Mã phương án: " + newData[i]['JobModeID'] + "!");
						return;
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

		function checkDataValue(data){
			var check = true;
			$.each(data, function(index, value){
				var checkCustomsType = value['CustomsJobType'],
					checkClassID     = value['ClassID'],
					checkInOut	     = value['InOut'],
					checkJobModeID   = value['JobModeID'],
					checkJobModeName = value['JobModeName'];

				if(!checkClassID){
					toastr["error"]("Vui lòng chọn Loại Nhập/Xuất!");
					check = false;
					return ;
				}

				if(!checkInOut){
					toastr["error"]("Vui lòng chọn Vào/Ra");
					check = false;
					return ;
				}

				if(!checkJobModeID){
					toastr["error"]("Vui lòng nhập Mã phương án!");
					check = false;
					return ;
				}

				if(!checkJobModeName){
					toastr["error"]("Vui lòng nhập Tên phương án!");
					check = false;
					return ;
				}

				if(!checkCustomsType){
					toastr["error"]("Vui lòng nhập Mã hình thức (HQ)!");
					check = false;
					return ;
				}

				if (checkClassID != 1 && checkClassID != 2){
					toastr["error"]("Vui lòng chọn giá trị loại Nhập/ Xuất hợp lệ!");
					check = false;
					return ;						
				}

				if (checkInOut != 1 && checkInOut != 2){
					toastr["error"]("Vui lòng chọn giá trị Vào/ Ra hợp lệ!");
					check = false;
					return ;						
				}				
				
				if( checkCustomsType < 0 || checkCustomsType > 255){
					toastr["error"]('Mã hình thức (HQ) có giá trị trong khoảng [0, 255]');
					check = false;
					return ;
				}				

				if(!parseInt(checkCustomsType) && checkCustomsType != 0){
					toastr["error"]("Mã hình thức (HQ) phải là số nguyên!");
					check = false;
					return;
				}
			});
			return check;
		}

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
        	
			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmJobModes'));?>",
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
			$('.ibox.collapsible-box').blockUI();
			var delBtn = $('#delete');
			delBtn.button('loading');

			var delPortID = data.map(p=>p[_columns.indexOf("JobModeID")]);

			var fdel = {
					'action': 'delete',
					'data': delPortID
				};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmJobModes'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                     delBtn.button('reset');
					var data = data.result;
	                if(data.error && data.error.length > 0){
	                	for (var i = 0; i < data.error.length; i++) {
	                		toastr["error"](data.error[i]);
	                	}
	                }

	                if(data.success && data.success.length > 0){
	                	for (var i = 0; i < data.success.length; i++) {
	                		var valueID = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "JobModeID" ), valueID);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( data.success[i] );
	                	}
	                }

					$('.ibox.collapsible-box').unblock();
                },
                error: function(err){
                	delBtn.button('reset');
                	$('.ibox.collapsible-box').unblock();
                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

		tbl.setExtendDropdown({
			target: "#cell-context-1",
			source: classList,
			colIndex: _columns.indexOf("ClassID"),
			onSelected: function(cell, value){
				/*
				if (value == "Nhập"){
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}
				*/
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
			target: "#cell-context-2",
			source: ioList,
			colIndex: _columns.indexOf("InOut"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				tbl.DataTable().cell(cell).data(value).draw(false);
				if (value == "Vào"){
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="1">' + value
					).draw(false);
				}
				else{
					tbl.DataTable().cell(cell).data(
						'<input class="hiden-input" value="2">' + value
					).draw(false);
				}
				
				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});

		tbl.setExtendDropdown({
			target: "#cell-context-3",
			source: transitList,
			colIndex: _columns.indexOf("TransitID"), 
			onSelected: function(cell, value){ 
				var transitName = transitList.filter( p => p.TransitID == value).map( x => x.TransitName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + transitName
				).draw(false);

				var rowIdx = tbl.DataTable().cell(cell).index()['row'];

				if(!tbl.DataTable().row( rowIdx ).nodes().to$().hasClass("addnew"))
					tbl.DataTable().row( rowIdx ).nodes().to$().addClass("editing");
			}
		});
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>