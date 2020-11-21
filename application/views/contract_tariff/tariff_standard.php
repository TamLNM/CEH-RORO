<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/select2/dist/css/select2.min.css');?>" rel="stylesheet" />
<style>
	.hidden-filter{
		display: none;
	}
	.wrap-text{
		white-space: normal!important;
	}

	button[data-id="temp"] span.filter-option{
		padding-right: 15px;
	}

	#unitcodes-modal .dataTables_filter,
	#cargotype-modal .dataTables_filter
	{
		width: 200px;
	}
	#unitcodes-modal .dataTables_filter input[type="search"],
	#cargotype-modal .dataTables_filter input[type="search"]
	{
		width: 65%;
	}

	#unitcodes-modal .dataTables_filter > label::after,
	#cargotype-modal .dataTables_filter > label::after
	{
		right: 45px!important;
	}

	.readonly-temp input{
		border-top: none!important;
		border-left: none!important;
		border-right: none!important;
		border-bottom: 1px dotted #ccc !important;
		cursor: default!important;
	}

	span.sub-text{
		font-size: 75%;
	    color: #bbb;
	    font-style: italic;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">BIỂU CƯỚC CHUẨN</div>
				<div class="button-bar-group mr-3">
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
			<div class="ibox-body pt-3 pb-3 bg-f9 border-e">
				<div class="row border-e bg-white pb-1">
					<div class="col-sm-12 col-xs-12 mt-3">
						<div class="row form-group">
							<label class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-form-label">Mẫu</label>
							<select id="temp" class="selectpicker col-xl-2 col-lg-3 col-md-3 col-sm-3" data-style="btn-default btn-sm" data-live-search="true">
								<option value="">-- Chọn mẫu biểu cước --</option>
								<?php if(isset($temp) && count($temp) > 0){ foreach ($temp as $item){ ?>
									<option value="<?= $item ?>"><?= $item ?></option>
								<?php }} ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row border-e bg-white readonly-temp" id="temp_info" style="border-top: none!important;">
					<div class="col-sm-12 mt-3">
						<div class="row form-group">
							<label class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-form-label">Hiệu lực từ</label>
							<div class="col-xl-2 col-lg-3 col-md-3 col-sm-3">
								<input class="form-control form-control-sm input-required" id="fromDate" type="text" placeholder="Hiệu lực từ" readonly>
							</div>
							<label class="col-sm-1 col-form-label">đến</label>
							<div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 input-group">
								<input class="form-control form-control-sm input-required" id="toDate" type="text"  placeholder="Hiệu lực đến" readonly>
								<span class="input-group-addon bg-white btn text-success" title="Không xác định" style="padding: 0 .4rem">ALL</span>
							</div>
							<label class="col-xl-1 col-lg-2 col-md-2 col-sm-2 col-form-label">Tham chiếu</label>
							<div class="col-xl-2 col-lg-4 col-md-3 col-sm-3">
								<input class="form-control form-control-sm" id="ref_mrk" type="text" placeholder="Tham chiếu" readonly>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="padding: 16px 12px; margin-top: -4px">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display nowrap" cellspacing="0">
							<thead>
							<tr>
								<th col-name="rowguid" class="hiden-input">rowguid</th>
								<th col-name="STT" class="editor-cancel">STT</th>
								<th col-name="TRF_CODE" class="autocomplete">Mã biểu cước</th>
								<th col-name="TRF_STD_DESC">Diễn giải</th>
								<th col-name="IX_CD">Hướng cont</th>
								<th col-name="CARGO_TYPE" class="autocomplete">Loại hàng</th>
								<th col-name="JOB_KIND">Loại CV</th>
								<th col-name="CNTR_JOB_TYPE">Phương án</th>
								<th col-name="DMETHOD_CD">PTGN</th>
								<th col-name="TRANSIT_CD">Loại hình</th>
								<th col-name="IsLocal">Nội/Ngoại</th>
								<th col-name="CURRENCYID">Loại tiền</th>
								<th col-name="AMT_F20" class="data-type-numeric">Tiền 20 Full</th>
								<th col-name="AMT_F40" class="data-type-numeric">Tiền 40 Full</th>
								<th col-name="AMT_F45" class="data-type-numeric">Tiền 45 Full</th>
								<th col-name="AMT_E20" class="data-type-numeric">Tiền 20 Empty</th>
								<th col-name="AMT_E40" class="data-type-numeric">Tiền 40 Empty</th>
								<th col-name="AMT_E45" class="data-type-numeric">Tiền 45 Empty</th>
								<th col-name="AMT_NCNTR" class="data-type-numeric">Tiền Non-Cont</th>
								<th col-name="INCLUDE_VAT" class="editor-cancel data-type-checkbox">Bao gồm thuế</th>
								<th col-name="VAT">VAT (%)</th>
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
</div>

<!--unicodes modal-->
<div class="modal fade" id="trfcodes-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 600px; max-width: 600px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách mã biểu cước</h5>
			</div>
			<div class="modal-body">
				<table id="tblTRFCode" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="TRF_CODE">Mã</th>
							<th col-name="TRF_STD">Diễn Giải</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($trfCodes) > 0) {$i = 1; ?>
						<?php foreach($trfCodes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['TRF_CODE'];?></td>
								<td><?=$item['TRF_DESC'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-trfcode" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--unicodes modal-->
<div class="modal fade" id="unitcodes-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách đơn vị tính</h5>
			</div>
			<div class="modal-body">
				<table id="tblUnitCode" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="UNIT_CODE">Mã</th>
							<th col-name="UNIT_NM">Diễn Giải</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($unitCodes) > 0) {$i = 1; ?>
						<?php foreach($unitCodes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['UNIT_CODE'];?></td>
								<td><?=$item['UNIT_NM'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-unitcode" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--cargo type modal-->
<div class="modal fade" id="cargotype-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="width: 400px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh sách loại hàng</h5>
			</div>
			<div class="modal-body">
				<table id="tblCargoType" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr>
							<th col-name="STT">STT</th>
							<th col-name="Code">Mã</th>
							<th col-name="Description">Tên</th>
						</tr>
					</thead>
					<tbody>
					<?php if(count($cargoTypes) > 0) {$i = 1; ?>
						<?php foreach($cargoTypes as $item) {  ?>
							<tr>
								<td style="text-align: center"><?=$i;?></td>
								<td><?=$item['Code'];?></td>
								<td><?=$item['Description'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-cargotype" data-dismiss="modal">
						<span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
					<button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
						<span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="cell-context" class="btn-group">
  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-toggle-split show-table" data-toggle="dropdown" 
  						aria-haspopup="true" aria-expanded="false">
  </button>
  <div class="dropdown-menu dropdown-menu-right">
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		// ------------binding shortcut key press------------
        var ctrlKey = 17,
	        cmdKey = 91,
	        rKey = 82,
	        ctrlDown = false;

	    $(document).keydown(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
	    }).keyup(function(e) {
	        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
	    });

	    $(document).keydown(function(e) {
	        if (ctrlDown && e.keyCode == rKey){
	        	alert('reload filter');
	        	return false;
	        } 
	    });

		var _columns = ["rowguid", "STT", "TRF_CODE", "TRF_STD_DESC", "IX_CD", "CARGO_TYPE", "JOB_KIND", "CNTR_JOB_TYPE", "DMETHOD_CD", "TRANSIT_CD", "IsLocal"
					, "CURRENCYID", "AMT_F20", "AMT_F40", "AMT_F45", "AMT_E20", "AMT_E40", "AMT_E45", "AMT_NCNTR", "INCLUDE_VAT", "VAT"],
			_colTRF = ["STT", "TRF_CODE", "TRF_DESC"],
			_colUnit = ["STT", "UNIT_CODE", "UNIT_NM"],
			_colCargoType = ["STT", "Code", "Description"],
			tbl = $('#contenttable'),
			tblUnitCode = $('#tblUnitCode'),
			tblTRFCode = $('#tblTRFCode'),
			tblCargoType = $('#tblCargoType'),
			unicodeModal = $('#unitcodes-modal'),
			trfCodeModal = $('#trfcodes-modal'),
			cargoTypeModal = $('#cargotype-modal'),
			unitSource = {},
			cntrClassSource = {},
			cargoTypeSource = {},
			trfSource = {};

		var dataTbl = tbl.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns.indexOf("STT") },
				{ className: "text-center", targets: _columns.indexOf("INCLUDE_VAT") },
				{ 
					className: "text-right",
					render: $.fn.dataTable.render.number( ',', '.', 2),
					targets: _columns.getIndexs(["AMT_F20", "AMT_F40", "AMT_F45", "AMT_E20", "AMT_E40", "AMT_E45", "VAT"])
				},
				{ 
					className: "text-right",
					render: $.fn.dataTable.render.number( ',', '.', 5),
					targets: _columns.indexOf("AMT_NCNTR")
				},
				{ className: "hiden-input", targets: _columns.indexOf("rowguid") },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _columns.indexOf("TRF_STD_DESC")
				}
			],
			order: [],
            keys:true,
            autoFill: {
                focus: 'focus'
            },
        	paging: true,
			scroller: {
				displayBuffer: 12,
				boundaryScale: 0.5
			},
            select: true,
            rowReorder: false
		});

		var dataTblTRFCode = tblTRFCode.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ className: "text-center", targets: _colTRF.indexOf("STT") },
				{
					render: function (data, type, full, meta) {
						return "<div class='wrap-text width-350'>" + data + "</div>";
					},
					targets: _colTRF.indexOf("TRF_DESC")
				}
			],
			order: [[ _colTRF.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false
		});

		var dataTblUnitCode = tblUnitCode.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ className: "text-center", targets: _colUnit.indexOf("STT") }
			],
			order: [[ _colUnit.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false
		});

		var dataTblCargoTYpe = tblCargoType.DataTable({
			scrollY: '40vh',
			columnDefs: [
				{ className: "text-center", targets: _colCargoType.indexOf("STT") }
			],
			order: [[ _colCargoType.indexOf("STT"), 'asc' ]],
			paging: false,
            keys:true,
            autoFill: {
                focus: 'focus'
            },
            select: {
	            style: 'single',
	            info: false
	        },
	        buttons: [],
            rowReorder: false
		});

		<?php if(isset($unitCodes) && count($unitCodes) > 0){ ?>
			unitSource = <?= json_encode(array_column($unitCodes, "UNIT_CODE"));?>;
		<?php } ?>

		<?php if(isset($trfCodes) && count($trfCodes) > 0){ ?>
			trfSource = <?= json_encode(array_column($trfCodes, "TRF_CODE"));?>;
		<?php } ?>

		<?php if(isset($cargoTypes) && count($cargoTypes) > 0){ ?>
			cargoTypeSource = <?= json_encode(array_column($cargoTypes, "Code"));?>;
		<?php } ?>

		<?php if(isset($cntrClass) && count($cntrClass) > 0){ ?>
			cntrClassSource = <?= json_encode($cntrClass);?>;
		<?php } ?>

		// tbl.find("th:eq("+_columns.indexOf('INV_UNIT')+")").setSelectSource(unitSource);
		var tblHeader = $('#contenttable').parent().prev().find('table');
		tblHeader.find(' th:eq(' + _columns.indexOf( 'TRF_CODE' ) + ') ').setSelectSource(trfSource);
		// tblHeader.find(' th:eq(' + _columns.indexOf( 'INV_UNIT' ) + ') ').setSelectSource(unitSource);
		tblHeader.find(' th:eq(' + _columns.indexOf( 'CARGO_TYPE' ) + ') ').setSelectSource(cargoTypeSource);

		tblHeader.find(' th:eq(' + _columns.indexOf( 'IX_CD' ) + ') ').setSelectSource(cntrClassSource.map(p=>p.CLASS_Code));

		tbl.setExtendSelect(_columns.indexOf( "TRF_CODE" ), function(rIdx, cIdx){
			$("#apply-trfcode").val(rIdx + "." + cIdx);
			trfCodeModal.modal("show");
		});

		tbl.setExtendDropdown({
			target: "#cell-context",
			source: cntrClassSource,
			colIndex: _columns.indexOf( "IX_CD" ),
			onSelected: function(cell, value){
				tbl.DataTable().cell(cell).data(value).draw(false);
			}
		});

		tbl.setExtendSelect(_columns.indexOf("CARGO_TYPE"), function(rIdx, cIdx){
			$("#apply-cargotype").val(rIdx + "." + cIdx);
			cargoTypeModal.modal("show");
		});

		tbl.editableTableWidget();

		$('#toDate + span').hide();
		$('#toDate + span').on('click', function(){
			$('#toDate').val("*");
		});

        $('#addrow').on('click', function(){
	        $('#toDate + span').show();
	        $('#temp_info').removeClass("readonly-temp");
	        $('#temp_info').find("input").attr("readonly", false);
	        	//---------datepicker modified---------
		    $('#fromDate, #toDate').datepicker({
				format: "dd/mm/yyyy",
					// startDate: moment().format('DD/MM/YYYY'),
					todayHighlight: true,
					autoclose: true
			});

            tbl.newRow();
        });

        $('#unitcodes-modal, #trfcodes-modal, #cargotype-modal').on('shown.bs.modal', function(e){
			$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
		});

		tblTRFCode.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-trfcode"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				trfcode = $(this).find("td:eq("+_colTRF.indexOf("TRF_CODE")+")").text(),
				trfdesc = $(this).find("td:eq("+_colTRF.indexOf( "TRF_DESC" ) +")").text(),
				cellcode = tbl.find( "tbody tr:eq( "+rIdx+" ) td:eq( " + cIdx + " )" ).first(),
				celldesc = tbl.find("tbody tr:eq("+rIdx+") td:eq( " + _columns.indexOf( "TRF_STD_DESC" ) + ") ").first();

			tbl.DataTable().cell(cellcode).data(trfcode);
			tbl.DataTable().cell(celldesc).data(trfdesc).draw();
			trfCodeModal.modal("hide");
		});

		$("#apply-unitcode").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				unit = tblUnitCode.getSelectedRows().data().toArray()[0][_colUnit.indexOf("UNIT_CODE")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			dataTbl.cell(cell).data(unit).draw();
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dataTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});

		tblUnitCode.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-unitcode"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				unit = $(this).find("td:eq("+_colUnit.indexOf("UNIT_CODE")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			tbl.DataTable().cell(cell).data(unit).draw();
			unicodeModal.modal("hide");
		});

		$("#apply-unitcode").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				unit = tblUnitCode.getSelectedRows().data().toArray()[0][_colUnit.indexOf("UNIT_CODE")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first();

			dataTbl.cell(cell).data(unit).draw();
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dataTbl.row(crRow).nodes().to$().addClass("editing");
        	}
		});

		tblCargoType.find("tbody tr").on("dblclick", function(){
			var applyBtn = $("#apply-cargotype"),
				rIdx = applyBtn.val().split(".")[0],
				cIdx = applyBtn.val().split(".")[1],
				cgType = $(this).find("td:eq("+_colCargoType.indexOf("Code")+")").text(),
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(cgType).draw();

			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
        	}

			cargoTypeModal.modal("hide");
		});

		$("#apply-cargotype").on("click", function(){
			var rIdx = $(this).val().split(".")[0],
				cIdx = $(this).val().split(".")[1],
				cgType = tblCargoType.getSelectedRows().data().toArray()[0][_colCargoType.indexOf("Code")],
				cell = tbl.find("tbody tr:eq("+rIdx+") td:eq("+cIdx+")").first(),
				dtTbl = tbl.DataTable();

			dtTbl.cell(cell).data(cgType).draw();
			var crRow = tbl.find("tbody tr:eq("+rIdx+")");
			if(!crRow.hasClass("addnew")){
	        	dtTbl.row(crRow).nodes().to$().addClass("editing");
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

        	var crCell = inp.closest('td'),
        		crRow = inp.closest('tr'),
        		eTable = tbl.DataTable();

        	eTable.cell(crCell).data(crCell.html());
        	if(!crRow.hasClass("addnew")){
	        	eTable.row(crRow).nodes().to$().addClass("editing");
        	}
        });

        tbl.DataTable().on( 'autoFill', function ( e, datatable, cells ) {
        	var startRowIndex = cells[0][0].index.row,
        		endRowIndex = cells[cells.length - 1][0].index.row,
        		dtTbl = tbl.DataTable();

        	var rows = [];
        	$.each(cells, function(idx, item){
        		rows.push(item[0].index.row);
        	});

        	$.each(rows, function(){
        		var crRow = tbl.find("tbody tr:eq("+this+")");
				if(!crRow.hasClass("addnew")){
		        	dtTbl.row(crRow).nodes().to$().addClass("editing");
	        	}
        	})
		} );

		$('#temp').on('change', function () {
			if(!$(this).val()){
				tbl.dataTable().fnClearTable();
				return;
			}

			if(tbl.getAddNewData().length > 0 || tbl.getEditData().length > 0){
				$.confirm({
		            title: 'Thông báo!',
		            type: 'orange',
		            icon: 'fa fa-warning',
		            content: 'Các thay đổi sẽ KHÔNG được lưu lại!\nTiếp tục thao tác?',
		            buttons: {
		                ok: {
		                    text: 'Xác nhận lưu',
		                    btnClass: 'btn-warning',
		                    keys: ['Enter'],
		                    action: function(){
		                        templateChanged();
		                    }
		                },
		                cancel: {
		                    text: 'Hủy bỏ',
		                    btnClass: 'btn-default',
		                    keys: ['ESC']
		                }
		            }
		        });
			}else{
				templateChanged();
			}
		});

		$("#fromDate, #toDate").on("change", function(){
			$(this).clear_error();
		});

		$('#save').on('click', function(){
			if($('.input-required').has_required()){
				$('.toast').remove();
            	toastr["warning"]("Các trường bắt buộc không được để trống!");
            	return;
			}
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

        $('#delete').on('click', function(){
            if(tbl.getSelectedRows().length == 0){
            	$('.toast').remove();
            	toastr["info"]("Vui lòng chọn các dòng dữ liệu để xóa!");
            }else{
            	tbl.confirmDelete(function(data){
            		if(!data || data.length == 0){ return; }
            		postDel(data);
            	});
            }
        });

		//FUNCTION
		function saveData(){
			var newData = tbl.getAddNewData();

			var fData = {
					'applyDate': $('#fromDate').val(),
					'expireDate': $('#toDate').val(),
					'ref_mrk': $('#ref_mrk').val()
				};

			if(newData.length > 0){
				fData["action"] = "add";
				fData["data"] = newData;
				postSave(fData);
			}

			var editData = tbl.getEditData();

			if(editData.length > 0){
				fData["action"] = "edit";
				fData["data"] = editData;
				postSave(fData);
			}
		}

		function postSave(formData){
			var saveBtn = $('#save');
			saveBtn.button('loading');
        	$('.ibox.collapsible-box').blockUI();

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Standard'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }

                    toastr["success"]("Lưu dữ liệu thành công!");
               		location.reload();
                },
                error: function(err){
                	toastr["error"]("Error!");
                	saveBtn.button('reset');
        			$('.ibox.collapsible-box').unblock();
                	console.log(err);
                }
            });
		}

		function postDel(data){
			var delRowguid = data.map(p=>p[_columns.indexOf("rowguid")]);

			var delBtn = $('#delete');
			delBtn.button('loading');

			var fdel = {
					'action': 'delete',
					'data': delRowguid
				};

			$.ajax({
                url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Standard'));?>",
                dataType: 'json',
                data: fdel,
                type: 'POST',
                success: function (data) {
                    if(data.deny) {
                        toastr["error"](data.deny);
                        return;
                    }
               		toastr["success"]("Xóa dữ liệu thành công!");
               		location.reload();
                },
                error: function(err){
                	delBtn.button('reset');
					$('.ibox.collapsible-box').unblock();

                	toastr["error"]("Error!");
                	console.log(err);
                }
            });
		}

        function templateChanged(){
        	$('#fromDate, #toDate').datepicker("destroy");
        	$('#toDate + span').hide();
        	$('#temp_info').addClass("readonly-temp");
        	$('#temp_info').find("input").attr("readonly", true);

        	var data = $('#temp').val().split('-');
			if(data.length > 2){
				$('#fromDate').val(data[0]);
				$('#toDate').val(data[1]);
				$('#ref_mrk').val(data[2]);
			}else{
				$('#fromDate, #toDate, #ref_mrk').val("");
			}

			if($('#temp').val()){
				loadTariff();
			}else{
				tbl.DataTable().rows().clear();
			}
        }

		function loadTariff(){
			$("#contenttable").waitingLoad();
			var block = $('#tablecontent');
			block.blockUI();

			var formData = {
				'action': 'view',
				'temp':$('#temp').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctTariff_Standard'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (response) {
					var rows = [];

		        	if(response.list && response.list.length > 0){
						var data = response.list;

		        		var i = 0;
			        	$.each(data, function(index, rData){
			        		var r = [];
							$.each(_columns, function(idx, colname){
								var val = "";
								switch(colname){
									case "STT": val = i+1; break;
									case "IX_CD":
										var cntrclass = '';
										switch(rData[colname]){
											case "2":
												cntrclass = "Nội địa";
												break;
											case "3":
												cntrclass = "Xuất khẩu";
												break;
											case "4":
												cntrclass = "Nhập chuyển cảng";
												break;
											case "5":
												cntrclass = "Xuất chuyển cảng";
												break;
											default:
												cntrclass = rData[colname];
										}
										val='<input class="hiden-input" value="'+rData[colname]+'">' + cntrclass;
										break;
									case "INCLUDE_VAT":
										val= '<label class="checkbox checkbox-primary">'
												+'<input type="checkbox" value="'+ rData[colname] +'" '+ (rData[colname]==1?"checked":"") +'>'
												+'<span class="input-span"></span>'
											+'</label>';
										break;
									default:
										val = rData[colname] ? rData[colname] : "";
										break;
								}
								r.push(val);
							});
							i++;
							rows.push(r);
			        	});
		        	}

		        	tbl.dataTable().fnClearTable();
		        	if(rows.length > 0){
						tbl.dataTable().fnAddData(rows);
		        	}

					// tbl.DataTable( {
					// 	data: rows,
					// 	columnDefs: [
					// 		{ className: "hiden-input", targets: _columns.indexOf("rowguid") },
					// 		{ className: "text-center", targets: _columns.getIndexs(["STT", "TRF_CODE", "INV_UNIT", "INCLUDE_VAT"]) },
					// 		{
					// 			className: "text-right",
					// 			type: "num",
					// 			targets: _columns.getIndexs(["AMT_F20", "AMT_F40", "AMT_F45", "AMT_E20", "AMT_E40", "AMT_E45", "AMT_NCNTR", "VAT"]),
					// 			render: $.fn.dataTable.render.number( ',', '.', 2)
					// 		},
					// 		{
					// 			render: function (data, type, full, meta) {
					// 				return "<div class='wrap-text width-300'>" + data + "</div>";
					// 			},
					// 			targets: _columns.indexOf("TRF_STD_DESC")
					// 		}
					// 	],
					// 	order: [],
					// 	paging: true,
					// 	scroller: {
					// 		displayBuffer: 12,
					// 		boundaryScale: 0.5
					// 	},
					// 	keys:true,
			  //           autoFill: {
			  //               focus: 'focus'
			  //           },
			  //           select: true,
			  //           rowReorder: false
					// } );

					block.unblock();
				},
				error: function(err){console.log(err); block.unblock();}
			});
		}
	});
</script>

<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/select2/dist/js/select2.full.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>