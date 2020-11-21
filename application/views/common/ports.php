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

	#nation-modal .modal-content input[type="search"]{
		width: 65%;
	}

	#nation-modal .modal-content label:after{
		right: 27%;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">CẢNG</div>
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
							<th style="width: 10%" class="editor-cancel" col-name="STT">STT</th>
							<th col-name="NationID">Quốc gia</th>
							<th col-name="PortID">Mã cảng</th>
							<th col-name="PortName">Tên cảng</th>
						</tr>
						</thead>
						<tbody>		
							<?php if(count($portList) > 0) {
								  		$i = 1; ?>
								<?php foreach($portList as $item){  ?>									
									<tr>
										<td style="text-align: center; width: 10%" col-name="STT"><?=$i;?></td>
										<td  style="text-align: center" col-name="NationID">
											<input class='hiden-input' value="<?=$item['NationID'];?>"> 
												<?=$item['NationName'];?>
											</input>
										</td>
										<td style="text-align: center" col-name="PortID"><?=$item['PortID'];?></td>
										<td style="text-align: center" col-name="PortName"><?=$item['PortName'];?></td>
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

<!-- Cus Type modal-->
<div class="modal fade" id="nation-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh mục quốc gia</h5>
			</div>
			<div class="modal-body">
				<table id="tblNation" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT">STT</th>
							<th col-name="NationID">Mã loại</th>
							<th col-name="NationName">Tên loại</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($nationList) > 0) {$i = 1; ?>
						<?php foreach($nationList as $item) {  ?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$item['NationID'];?></td>
								<td><?=$item['NationName'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-nation" data-dismiss="modal">
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
			tblNation	= $("#tblNation")
			nationModal = $("#nation-modal")
			_columns 	= ['STT', 'NationID', 'PortID', 'PortName', 'ShortPort'],
			_colNation 	= ['STT', 'NationID', 'NationName'],
			nationList	= {},
			portList    = {},
			parentMenuList 	= {};

		<?php if(isset($nationList) && count($nationList) >= 0){?>
			nationList = <?=json_encode($nationList);?>;
		<?php } ?>

		<?php if(isset($portList) && count($portList) >= 0){?>
			portList = <?=json_encode($portList);?>;
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
				{ className: "text-center", targets: _columns.getIndexs(['NationID', 'PortID', 'PortName']) }
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

		var dataTblNation = tblNation.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _colNation.indexOf("STT") },
				{ className: "text-center", targets: _colNation.getIndexs(["NationID", "NationName"]) },
			],
			order: [[ _colNation.indexOf("STT"), 'asc' ]],
			paging: false,
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false
		});


		tbl.editableTableWidget({editor: $("#status, #httt, #editor-input")}); // This line: for editing the table content

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
				var checkNationID		= value['NationID'],
					checkPortID		   	= value['PortID'],
					checkPortName		= value['PortName'];					

				if(!checkNationID){
					toastr["error"]("Vui lòng nhập Quốc gia!");
					check = false;
					return ;
				}

				if(!checkPortID){
					toastr["error"]("Vui lòng nhập Mã cảng!");
					check = false;
					return ;
				}

				if(!checkPortName){
					toastr["error"]("Vui lòng nhập Tên cảng!");
					check = false;
					return ;
				}
			});
			return check;
		}

		function saveData(){
			var newData = tbl.getAddNewData();

			if(newData.length > 0){
				if (!checkDataValue(newData)){
					return;
				}
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
                url: "<?=site_url(md5('Common') . '/' . md5('cmPorts'));?>",
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
			
			var delPortID = data.map(p=>p[_columns.indexOf("PortID")]);

			var fdel = {
					'action': 'delete',
					'data': delPortID
				};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmPorts'));?>",
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
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "PortID" ), valueID);
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

		
		/*
		// Initial nation drop-down button
		tbl.setExtendDropdown({
			target: "#cell-context",
			source: nationList,
			colIndex: _columns.indexOf("NationID"), // ô cần show drop-down box
			onSelected: function(cell, value){ // Thao tác sau khi người dùng lựa chọn
				//tbl.DataTable().cell(cell).data(value).draw(false);

				var nationName = nationList.filter( p => p.NationID == value).map( x => x.NationName );
				tbl.DataTable().cell(cell).data(
					'<input class="hiden-input" value="'+ value  +'">' + nationName
				).draw(false);
			}
		});
		*/

		// Set extension button choose nation name 
		tbl.setExtendSelect( _columns.indexOf("NationID"), function(rIdx, cIdx){
			$("#nation-modal").val(rIdx + "." + cIdx);
			nationModal.modal("show");
		});

		tbl.editableTableWidget();

		// Adjust column in table when show modal
		$('#nation-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		// Select custom type id on table custom-type-table
		tblNation.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = $("#nation-modal"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				nationID = $(this).find("td:eq("+_colNation.indexOf("NationID")+")").text(),
				nationName  = $(this).find("td:eq("+_colNation.indexOf("NationName")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ nationID  +'">' + nationName
			).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
			nationModal.modal("hide");
		});

		$("#apply-nation").on("click", function(){	// Click Accept
			var rIdx = $('#nation-modal').val().split(".")[0],
				cIdx = $('#nation-modal').val().split(".")[1],
				nationID = tblNation.getSelectedRows().data().toArray()[0][_colNation.indexOf("NationID")],
				nationName = tblNation.getSelectedRows().data().toArray()[0][_colNation.indexOf("NationName")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

				dtTbl.cell(cell).data(
					'<input class="hiden-input" value="'+ nationID  +'">' + nationName
				).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");

			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>