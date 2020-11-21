<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=base_url('assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css');?>" rel="stylesheet" />
<link href="<?=base_url('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" />
<style>
	@media (max-width: 650px) {
		label {
			text-overflow: ellipsis;
			display: inline-block;
			overflow: hidden;
			white-space: nowrap;
			vertical-align: middle;
		}
	}
	@media (max-width: 650px) and (orientation: landscape) {
		#expired_date {
			font-size: .7rem;
		}
	}

	button[data-id="temp"] span.filter-option{
		padding-right: 15px;
	}
	.border-bottom{
		border-bottom: dotted 1px #ccc;
	}
	#temp_info div.row.form-group{
		width: 95%;
	}
	#temp_info div.col-form-label{
		font-style: italic;
	}
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">HỢP ĐỒNG (CHIẾT KHẤU/ TIỀN PHẠT)</div>
			</div>
			<div class="ibox-body pt-3 pb-2 bg-f9 border-e">
				<div class="row border-e bg-white pb-1">
					<div class="col-sm-12 mt-3">
						<div class="form-group">
							<div class="input-group">
								<label class="col-form-label pr-5">Mẫu HĐ</label>
								<select id="temp" class="selectpicker pr-3" data-style="btn-default btn-sm" data-live-search="true">
									<?php if(isset($temp) && count($temp) > 0){ foreach ($temp as $item){ ?>
										<option value="<?= $item ?>"><?= $item ?></option>
									<?php }} ?>
								</select>
								<button id="search" class="btn btn-info btn-labeled btn-labeled-right btn-icon btn-sm">
									<span class="btn-label"><i class="ti-search"></i></span>Tìm kiếm</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row pt-2 border-e bg-white" id="temp_info" style="border-top: none!important;">
					<div class="col-xl-4 col-lg-3 col-md-12 col-sm-12 col-xs-12">
						<div class="row form-group">
							<label class="col-lg-4 col-md-4 col-sm-2 col-xs-4 col-form-label">Tên hợp đồng</label>
							<div class="col-lg-8 col-md-8 col-sm-10 col-xs-8 border-bottom col-form-label" id="nick_name">Tên HĐ</div>
						</div>
						<div class="row form-group">
							<label class="col-lg-4 col-md-4 col-sm-2 col-xs-4 col-form-label">Ngày hiệu lực</label>
							<div class="col-lg-8 col-md-8 col-sm-10 col-xs-8 border-bottom col-form-label" id="apply_date">Ngày hiệu lực</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-3 col-md-7 col-sm-6 col-xs-8">
						<div class="row form-group">
							<label class="col-lg-6 col-md-4 col-sm-2 col-xs-4 col-form-label">Hãng khai thác</label>
							<div class="col-lg-6 col-md-8 col-sm-10 col-xs-8 border-bottom col-form-label" id="opr">Hãng khai thác</div>
						</div>
						<div class="row form-group">
							<label class="col-lg-6 col-md-4 col-sm-2 col-xs-4 col-form-label">Hình thức thanh toán</label>
							<div class="col-lg-6 col-md-8 col-sm-10 col-xs-8 border-bottom col-form-label" id="pm_type">Tiền mặt</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-xs-4">
						<div class="row form-group">
							<label class="col-lg-5 col-md-4 col-sm-2 col-xs-4 col-form-label">ĐT thanh toán</label>
							<div class="col-lg-7 col-md-8 col-sm-10 col-xs-8 border-bottom col-form-label" id="payer">ĐT thanh toán</div>
						</div>
						<div class="row form-group">
							<label class="col-lg-5 col-md-4 col-sm-2 col-xs-4 col-form-label">Tham chiếu</label>
							<div class="col-lg-7 col-md-8 col-sm-10 col-xs-8 border-bottom col-form-label" id="ref_mrk">Tham chiếu</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row ibox-footer">
				<div class="col-md-12 col-sm-12 col-xs-12 table-responsive">
					<div id="tablecontent">
						<table id="contenttable" class="table table-striped display table-bordered nowrap" cellspacing="0" style="width: 99.8%">
							<thead>
							<tr>
								<th>STT</th>
								<th>Mã biểu cước</th>
								<th>Diễn giải</th>
								<th>Hướng container</th>
								<th>Loại hàng</th>
								<th>Nâng/ Hạ</th>
								<th>Phương án</th>
								<th>PT giao nhận</th>
								<th>Nội/Ngoại</th>
								<th>Loại tiền</th>
								<th>Tiền 20 Full</th>
								<th>Tiền 40 Full</th>
								<th>Tiền 45 Full</th>
								<th>Tiền 20 Empty</th>
								<th>Tiền 40 Empty</th>
								<th>Tiền 45 Empty</th>
								<th>Tiền Non-Container</th>
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

<script type="text/javascript">
	$(document).ready(function () {
		$('#contenttable').DataTable();
		$('#search-ship').DataTable({
			paging: false,
			searching: false,
			infor: false
		});

		var data = $('#temp').val().split(':');
		if(data.length > 0){
//				NICK_NAME, OPR, LANE, PAYER_TYPE, PAYER, APPLY_DATE
			$('#nick_name').text(data[0]);
			$('#opr').text(data[1]);
			$('#payer').text(data[4]);
			$('#apply_date').text(data[5]);
			$('#pm_type').text(data[6] == "CAS" ? "Tiền mặt" : "Trả sau");
			$('#ref_mrk').text(data[7]);
		}

		$('#temp').on('change', function () {
			var data = $(this).val().split(':');
			if(data.length > 0){
//				NICK_NAME, OPR, LANE, PAYER_TYPE, PAYER, APPLY_DATE
				$('#nick_name').text(data[0]);
				$('#opr').text(data[1]);
				$('#payer').text(data[4]);
				$('#apply_date').text(data[5]);
				$('#pm_type').text(data[6] == "CAS" ? "Tiền mặt" : "Trả sau");
				$('#ref_mrk').text(data[7]);
			}
		});

		$('#search').on('click', function () {
			$("#contenttable").waitingLoad();

			var formData = {
				'action': 'view',
				'temp': $('#temp').val()
			};

			$.ajax({
				url: "<?=site_url(md5('Contract_Tariff') . '/' . md5('ctContract'));?>",
				dataType: 'json',
				data: formData,
				type: 'POST',
				success: function (data) {
					var rows = [];
					if(data.lists.length > 0) {
						for (i = 0; i < data.lists.length; i++) {
							rows.push([
								(i+1)
								, data.lists[i].TRF_CODE
								, data.lists[i].TRF_STD_DESC
								, data.lists[i].IX_CD
								, data.lists[i].CARGO_TYPE
								, data.lists[i].Jobkind
								, data.lists[i].CntrJobType
								, data.lists[i].DMethod_CD
								, data.lists[i].IsLocal
								, data.lists[i].CURRENCYID
								, data.lists[i].AMT_F20
								, data.lists[i].AMT_F40
								, data.lists[i].AMT_F45
								, data.lists[i].AMT_E20
								, data.lists[i].AMT_E40
								, data.lists[i].AMT_E45
								, data.lists[i].AMT_NCNTR
							]);
						}
					}
					$('#contenttable').DataTable( {
						data: rows,
						columnDefs: [
							{ width: "30px", targets: 0 },
							{ className: "text-center", targets: 0 },
							{ className: "text-right", render: $.fn.dataTable.render.number( ',', '.', 2), targets: [10, 11, 12, 13, 14, 15, 16] }
						],
						order: [[ 0, 'asc' ]],
						scroller: {
							displayBuffer: 9,
							boundaryScale: 0.95
						}
					} );
				},
				error: function(err){console.log(err);}
			});
		});
	});
</script>

<script>
	function search_ship(){
		$("#search-ship").waitingLoad();
		var formdata = {
			'actions': 'searh_ship',
			'arrStatus': $('input[name="shipArrStatus"]:checked').val(),
			'shipyear': $('#cb-search-ship').val(),
			'shipname': $('#search-ship-name').val()
		};
		$.ajax({
			url: "<?=site_url(md5('Common') . '/' . md5('cmEir'));?>",
			dataType: 'json',
			data: formdata,
			type: 'POST',
			success: function (data) {
				$('#search-ship').dataTable().fnDestroy();
				var rows = [];
				if(data.vsls.length > 0) {
					for (i = 0; i < data.vsls.length; i++) {
						rows.push([
							data.vsls[i].ShipKey
							, (i+1)
							, data.vsls[i].ShipID
							, data.vsls[i].ImVoy
							, data.vsls[i].ExVoy
							, getDateTime(data.vsls[i].ETB)
							, getDateTime(data.vsls[i].ETD)
						]);
					}
					$('#search-ship').DataTable( {
						scrollY: '35vh',
						paging: false,
						order: [[ 1, 'asc' ]],
						columnDefs: [
							{ className: "input-hidden", targets: [0] },
							{ className: "text-center", targets: [0] }
						],
						info: false,
						searching: false,
						data: rows
					} );
				}
			},
			error: function(err){console.log(err);}
		});
	}
</script>
<script src="<?=base_url('assets/vendors/moment/min/moment.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>