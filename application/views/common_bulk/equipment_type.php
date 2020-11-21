<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<div class="ibox-head">
				<div class="ibox-title">LOẠI THIẾT BỊ</div>
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
			<div class="row ibox-body">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th col-name="STT" style="width: 20px">STT</th>
								<th col-name="rowguid">rowguid</th>
								<th col-name="EquipmentTypeID">Mã loại thiết bị</th>
								<th col-name="EquipmentTypeName">Tên loại thiết bị</th>
							</tr>
							</thead>
							<tbody id='tbodyContenttable'>
							<?php if(count($equipmentTypeList) > 0) {$i = 1; ?>
								<?php foreach($equipmentTypeList as $item) {  ?>
									<tr>
										<td style="text-align: center"><?=$i;?></td>
										<td><?=$item['rowguid'];?></td>
										<td><?=$item['EquipmentTypeID'];?></td>
										<td><?=$item['EquipmentTypeName'];?></td>
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
		var _columns 		= ["STT", "rowguid", "EquipmentTypeID", "EquipmentTypeName"],
			tbl 			= $('#contenttable'),
			equipmentTypeList = {},
			parentMenuList 	= {};

		/* Load data from Equipment Type Table */
		<?php if(isset($equipmentTypeList)){?>
			equipmentTypeList = <?= json_encode($equipmentTypeList);?>;
		<?php } ?>

		<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'CommonBulk'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

		tbl.newDataTable({
			scrollY: '55vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") },
				{ className: "text-center", targets: _columns.getIndexs(["EquipmentTypeID", "EquipmentTypeName"]) },
				{ className: "hiden-input", targets: _columns.getIndexs(['rowguid'])},		
			],
			order: [[ _columns.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: true,
            rowReorder: false
		});
		tbl.editableTableWidget();

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

       	/* SAVE EVENT */
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

        function saveData(){        	
			var newData 			= tbl.getAddNewData(),
				checkExistFormData 	= {
					'action': 'view',
					'child_action': 'loadEquipmentTypeList',
				};

				$.ajax({
	                url: "<?=site_url(md5('CommonBulk') . '/' . md5('cmbEquipmentType'));?>",
	                dataType: 'json',
	                data: checkExistFormData,
	                type: 'POST',
	                success: function (datas) {
	                    if(datas.deny) {
	                        toastr["error"](datas.deny);
	                        return;
	                    }

	                    if (datas.list.length > 0 && newData.length > 0)
	                    {

	                    	for (index = 0; index < datas.list.length; index++){
	                    		for (i = 0; i < newData.length; i++){
	                    			if (newData[i]['EquipmentTypeID'] == datas.list[index]['EquipmentTypeID']){
	                    				toastr['error']("Đã tồn tại Mã loại thiết bị: " +  newData[i]['EquipmentTypeID'] + ". Vui lòng kiểm tra lại!");
	                    				return;
	                    			}
	                    		}

	                    		for (i = 0; i < newData.length; i++){
									delete newData[i].rowguid;
								}

								var fnew = {
									'action': 'add',
									'data': newData,
								};
								postSave(fnew);
	                    	}
	                    }
	                },
	                error: function(err){
	                	toastr["error"]("Error!");
	                	$('.ibox.collapsible-box').unblock();
	                	console.log(err);
	                }
	            });

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
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('CommonBulk') . '/' . md5('cmbEquipmentType'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (datas) {
                    if(datas.deny) {
                        toastr["error"](datas.deny);
                        return;
                    }

                	$('.ibox.collapsible-box').unblock();

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
				                	cell 	= tbl.find("tbody tr:eq(" + cRow + ") td:eq("+ _columns.indexOf("EquipmentTypeID") +")");			    
	                			tbl.DataTable().cell(cell).data(valueID).draw(false);	                			
		                	}
		                }

                    	if(data.success && data.success.length > 0){
		                	for (var i = 0; i < data.success.length; i++) {
		                		toastr["success"]( data.success[i] );
		                	}
		                }
                    }

                    if(formData.action == 'add'){
                    	toastr["success"]("Thêm mới thành công!");
                    	tbl.DataTable().rows( '.addnew' ).nodes().to$().removeClass("addnew");
                    	tbl.updateSTT(_columns.indexOf("STT"));
                    }
                },
                error: function(err){
                	toastr["error"]("Error!");
                	$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

		/* DELETE */
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

			var deleteData = rows.map(p=>p[_columns.indexOf("rowguid")]),
				delBtn = $('#delete');

			delBtn.button('loading');

			var formdata = {
				'action': 'delete',
				'data': deleteData,
			};

			$.ajax({
				url: "<?=site_url(md5('CommonBulk') . '/' . md5('cmbEquipmentType'));?>",
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
	                	var delList = [];

	                	for (var i = 0; i < data.success.length; i++) {
	                		var valueID = data.success[i].split(':')[1].trim();
	                		var indexes = tbl.filterRowIndexes( _columns.indexOf( "EquipmentTypeID" ), valueID);
	                		tbl.DataTable().rows( indexes ).remove().draw( false );
	                		tbl.updateSTT( _columns.indexOf( "STT" ) );
	                		toastr["success"]( data.success[i] );

	                		delList.push(valueID);
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
	});
</script>