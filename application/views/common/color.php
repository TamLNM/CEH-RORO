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
				<div class="ibox-title">MÀU</div>
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
							<th col-name="VesselID">Tàu</th>
							<th col-name="BrandID">Hãng xe</th>
							<th col-name="CarTypeID">Loại xe</th>
							<th col-name="EngineType">Loại động cơ</th>
							<th col-name="POL">Cảng đích</th>
							<th col-name="POD">Cảng dở</th>
							<th col-name="FPOD">Cảng đích</th>
							<th col-name="BackColor" class="data-type-color">Màu nền</th>
							<th col-name="ForeColor" class="data-type-color">Màu chữ</th>							
							<th col-name="Remark">Ghi chú</th>
						</tr>
						</thead>
						<tbody>
							<?php if(count($colorList) > 0) {
								  		$i = 1; ?>
								<?php foreach($colorList as $item){  ?>									
									<tr>
										<td col-name="STT"><?=$i;?></td>
										<td col-name="VesselID"><input class="hiden-input" value="<?=$item['VesselID'];?>"><?=$item['VesselName'];?></td>
										<td col-name="BrandID"><input class="hiden-input" value="<?=$item['BrandID'];?>"><?=$item['BrandName'];?></td>		
										<td col-name="CarTypeID"><input class="hiden-input" value="<?=$item['CarTypeID'];?>"><?=$item['CarTypeName'];?></td>		
										<td col-name="EngineType"><?=$item['EngineType'];?></td>		
										<td col-name="POL"><input class="hiden-input" value="<?=$item['POL'];?>"><?=$item['POLName'];?></td>		
										<td col-name="POD"><input class="hiden-input" value="<?=$item['POD'];?>"><?=$item['PODName'];?></td>		
										<td col-name="FPOD"><input class="hiden-input" value="<?=$item['FPOD'];?>"><?=$item['FPODName'];?></td>		
										<td col-name="BackColor"><?=$item['BackColor'];?></td>		
										<td col-name="ForeColor"><?=$item['ForeColor'];?></td>		
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

<!-- Manifest modal-->
<div class="modal fade" id="manifest-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 5%">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">DANH MỤC HÀNG NHẬP MANIFEST</h5>
			</div>
			<div class="modal-body">
				<table id="tblManifest" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th class="editor-cancel" col-name="STT">STT</th>
							<th col-name="VesselID">Mã tàu</th>
							<th col-name="VesselName">Tên tàu</th>
							<th col-name="BrandID"></th>
							<th col-name="BrandName">Hãng xe</th>
							<th col-name="CarTypeID"></th>
							<th col-name="CarTypeName">Loại xe</th>
							<th col-name="EngineType">Loại động cơ</th>
							<th col-name="POL"></th>
							<th col-name="POLName">Cảng đích</th>
							<th col-name="POD"></th>
							<th col-name="PODName">Cảng dở</th>
							<th col-name="FPOD"></th>
							<th col-name="FPODName">Cảng đích</th>
							<th col-name="Remark">Ghi chú</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($manifestList) > 0) {$i = 1; ?>
						<?php foreach($manifestList as $item) {  ?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$item['VesselID'];?></td>
								<td><?=$item['VesselName'];?></td>
								<td><?=$item['BrandID'];?></td>			
								<td><?=$item['BrandName'];?></td>			
								<td><?=$item['CarTypeID'];?></td>							
								<td><?=$item['CarTypeName'];?></td>							
								<td><?=$item['EngineType'];?></td>							
								<td><?=$item['POL'];?></td>					
								<td><?=$item['POLName'];?></td>					
								<td><?=$item['POD'];?></td>					
								<td><?=$item['PODName'];?></td>					
								<td><?=$item['FPOD'];?></td>
								<td><?=$item['FPODName'];?></td>
								<td><?=$item['Remark'];?></td>							
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-manifest" data-dismiss="modal">
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
		var tbl 				= $('#contenttable'),
			tblManifest			= $('#tblManifest'),
			_columns 			= ['STT', 'VesselID', 'BrandID', 'CarTypeID', 'EngineType', 'POL', 'POD', 'FPOD', 'BackColor', 'ForeColor', 'Remark'],
			_manifestColumns 	= ['STT', 'VesselID', 'VesselName',  'BrandID', 'BrandName', 'CarTypeID', 'CarTypeName', 'EngineType', 'POL', 'POLName', 'POD', 'PODName', 'FPOD', 'FPODName', 'Remark'], 
			vesselList			= {},
			manifestList		= {},
			manifestModal 	 	= $("#manifest-modal"),
			parentMenuList 		= {};

		<?php if(isset($vesselList) && count($vesselList) >= 0){?>
			vesselList = <?=json_encode($vesselList);?>;
		<?php } ?>

		<?php if(isset($manifestList) && count($manifestList) >= 0){?>
			manifestList = <?=json_encode($manifestList);?>;
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
			scrollY: '65vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf('STT') },
				{ className: "text-center", targets: _columns.getIndexs(['VesselID', 'BrandID', 'CarTypeID', 'EngineType', 'POL', 'POD', 'FPOD', 'Remark'])},
				{ type: "color", className: "text-center", targets: _columns.getIndexs(['BackColor', 'ForeColor'])},
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

		tbl.editableTableWidget();

		var dataTbl2 = tblManifest.newDataTable({
			scrollY: '45vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _manifestColumns.indexOf('STT') },
				{ className: "text-center", targets: _manifestColumns.getIndexs(['VesselID',  'VesselName', 'BrandName', 'CarTypeName', 'EngineType', 'POLName', 'PODName', 'FPODName', 'Remark'])},
				{ className: "hiden-input", targets: _columns.getIndexs(['BrandID', 'CarTypeID', 'POL', 'POD', 'FPOD'])},
			],
			order: [[ _columns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: 'single',
            	info: false,
            },
            rowReorder: false,
            arrayColumns: _manifestColumns,
		});

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

		/* Child table when choose VesselID cell*/
        // Set extension button choose Custom 
		tbl.setExtendSelect( _columns.indexOf("VesselID"), function(rIdx, cIdx){
			manifestModal.val(rIdx + "." + cIdx);
			manifestModal.modal("show");
			console.log(rIdx, cIdx);
		});
		tbl.editableTableWidget();

		// Adjust column in table when show modal
		manifestModal.on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		tblManifest.find("tbody tr").on("dblclick", function(){ // Double Click
			var applyBtn = manifestModal,
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				dtTbl = tbl.DataTable(),

				VesselID 	= $(this).find("td:eq("+_manifestColumns.indexOf("VesselID")+")").text(),
				VesselName 	= $(this).find("td:eq("+_manifestColumns.indexOf("VesselName")+")").text(),
				BrandID 	= $(this).find("td:eq("+_manifestColumns.indexOf("BrandID")+")").text(),
				BrandName   = $(this).find("td:eq("+_manifestColumns.indexOf("BrandName")+")").text(),
				CarTypeID	= $(this).find("td:eq("+_manifestColumns.indexOf("CarTypeID")+")").text(),
				CarTypeName = $(this).find("td:eq("+_manifestColumns.indexOf("CarTypeName")+")").text(),
				EngineType  = $(this).find("td:eq("+_manifestColumns.indexOf("EngineType")+")").text(),
				POL			= $(this).find("td:eq("+_manifestColumns.indexOf("POL")+")").text(),
				POLName		= $(this).find("td:eq("+_manifestColumns.indexOf("POLName")+")").text(),
				POD 		= $(this).find("td:eq("+_manifestColumns.indexOf("POD")+")").text(),
				PODName		= $(this).find("td:eq("+_manifestColumns.indexOf("PODName")+")").text(),
				FPOD 		= $(this).find("td:eq("+_manifestColumns.indexOf("FPOD")+")").text(),
				FPODName	= $(this).find("td:eq("+_manifestColumns.indexOf("FPODName")+")").text(),
				Remark		= $(this).find("td:eq("+_manifestColumns.indexOf("Remark")+")").text(),
				
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ VesselID  +'">' + VesselName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('BrandID')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ BrandID  +'">' + BrandName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('CarTypeID')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ CarTypeID  +'">' + CarTypeName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('EngineType')+")").first(); 
			dtTbl.cell(cell).data(EngineType).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('POL')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ POL  +'">' + POLName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('POD')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ POD  +'">' + PODName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('FPOD')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ FPOD  +'">' + FPODName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('Remark')+")").first(); 
			dtTbl.cell(cell).data(Remark).draw();

			// Add class
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

        	// Hide modal
			manifestModal.modal("hide");
		});

		$("#apply-manifest").on("click", function(){	// Click Accept
			var rIdx = manifestModal.val().split(".")[0],
				cIdx = manifestModal.val().split(".")[1],
				dtTbl = tbl.DataTable(),

				VesselID 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("VesselID")],
				VesselName 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("VesselName")],
				BrandID 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("BrandID")],
				BrandName 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("BrandName")],
				CarTypeID 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("CarTypeID")],
				CarTypeName = tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("CarTypeName")],
				EngineType 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("EngineType")],
				POL 		= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("POL")],
				POLName 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("POLName")],
				POD 		= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("POD")],
				PODName 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("PODName")],
				FPOD 		= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("FPOD")],
				FPODName 	= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("FPODName")],
				Remark 		= tblManifest.getSelectedRows().data().toArray()[0][_manifestColumns.indexOf("Remark")],

				cell 	= tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ VesselID  +'">' + VesselName
			).draw();

			console.log(dtTbl.cell(cell));

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('BrandID')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ BrandID  +'">' + BrandName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('CarTypeID')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ CarTypeID  +'">' + CarTypeName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('EngineType')+")").first(); 
			dtTbl.cell(cell).data(EngineType).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('POL')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ POL  +'">' + POLName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('POD')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ POD  +'">' + PODName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('FPOD')+")").first(); 
			dtTbl.cell(cell).data(
				'<input class="hiden-input" value="'+ FPOD  +'">' + FPODName
			).draw();

			cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+_columns.indexOf('Remark')+")").first(); 
			dtTbl.cell(cell).data(Remark).draw();

			// Add class
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
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


        //save functions
        function saveData(){        	
			var newData = tbl.getAddNewData();

			for (i = 0; i < newData.length; i++){
				
			}

			if(newData.length > 0){
				var fnew = {
					'action': 'add',
					'data': newData
				};
				postSave(fnew);
			}

			var editData = tbl.getEditData();
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
                url: "<?=site_url(md5('Common') . '/' . md5('cmColor'));?>",
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

		// Delete event
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
			var delData = data.map( function( item ){

				var VesselID  = item[ _columns.indexOf( "VesselID" ) ],
					BrandID   = item[ _columns.indexOf( "BrandID" ) ],
					CarTypeID = item[ _columns.indexOf( "CarTypeID" ) ];

				VesselID	  = VesselID.substring(VesselID.lastIndexOf("value=") + 7, VesselID.lastIndexOf(">") - 1);
				BrandID		  = BrandID.substring(BrandID.lastIndexOf("value=") + 7, BrandID.lastIndexOf(">") - 1);
				CarTypeID     = CarTypeID.substring(CarTypeID.lastIndexOf("value=") + 7, CarTypeID.lastIndexOf(">") - 1);

				var objDel = {
					"VesselID" 		: VesselID,
					"BrandID" 		: BrandID,
					"CarTypeID" 	: CarTypeID,
				};
				return objDel;
			});

			var fdel = {
					'action': 'delete',
					'data': delData
				};

			$.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmColor'));?>",
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
	});
</script>