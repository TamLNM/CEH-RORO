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
	.ibox .ibox-footer {
	    padding: 10px 25px 5px 25px;
	}
	.modal_input{
		border-bottom: dotted 1px; 
		width: 70%;
	}
	.cash_input{
		border-bottom: dotted 1px; 
		width: 60%;
	}
	label{
		padding-right: 0px!important;
	}

	#contenttable_wrapper .dataTables_scroll #cell-context-1 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-2 .dropdown-menu .dropdown-item .sub-text,
	#contenttable_wrapper .dataTables_scroll #cell-context-3 .dropdown-menu .dropdown-item .sub-text{
		margin-left: 7px;
		font-size: 12px;
		font-style: italic;
	}
	#contenttable tbody tr.total_r{
		background: #fff0db !important;
	}
	#contenttable tr td{
		text-align: center;
	}
	.dataPanel .row.header{
		position: relative;
		z-index: 0;
	}
	.Mod0 > div{background: #08c;color: #fff !important;}
	.Mod1 > div{background: red;color: #fff !important;}
	.Mod2 > div{background: red;color: #fff !important;}
	.Mod3 > div{background: red;color: #fff !important;}
	.Mod4 > div{background: red;color: #fff !important;}
	.Mod5 > div{background: red;color: #fff !important;}
	.Mod6 > div{background: #b6b6b6;color: #fff !important;}
</style>

<div class="row">
	<div class="col-xl-12" style="font-size: 12px;">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">Giám sát kế hoạch tàu</div>
				<div class="button-bar-group mr-3">

					<button id="search" class="btn btn-outline-warning btn-sm btn-loading mr-1" data-loading-text="<i class='la la-spinner spinner'></i>Nạp dữ liệu" title="Nạp dữ liệu">
						<span class="btn-icon"><i class="ti-search"></i>Nạp dữ liệu</span>
					</button>
				</div>
			</div>
			<div class="ibox-body pt-0 pb-0 bg-f9 border-e py-2">
				<div class="row ibox mb-0 border-e pb-1 pt-1">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
						<div class="row" id="row-transfer-left">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
								
								<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
											<label class="col-sm-5 col-form-label text-left">Thời gian bắt đầu</label>
											<div class="col-lg-7 col-sm-7 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="TIMEIN" type="text" autocomplete="off" placeholder="Thời gian bắt đầu" value="<?=date('Y-m-d',strtotime('-7 days'));?>">
												</div>
											</div>
										</div>
								
							</div>								
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
									<div class="row form-group">
											<label class="col-sm-5 col-form-label text-right">Thời gian kết thúc</label>
											<div class="col-lg-7 col-sm-7 input-group input-group-sm">
												<div class="input-group">
													<input class="form-control form-control-sm input-required" id="TIMEOUT" autocomplete="off" type="text" placeholder="Thời gian kết thúc" value="<?=date('Y-m-d',strtotime('+7 days'));?>">
												</div>
											</div>
										</div>
							</div>
						</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="col-12 table-responsive">
					<div class="gantt"></div>
				</div>
			</div>
		</div>		
	</div>
</div>

<div class="modal fade" id="v_info" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel-1" aria-hidden="true" data-whatever="id" style="padding: auto; padding-top: 4%">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" style="border-radius: 4px">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="groups-modalLabel-1">Chi tiết tàu</h5>
            </div>
            <div class="modal-body" style="padding: 0px 15px 15px 15px">
                <div class="row ibox-footer border-top-0 mt-3" id="v_info_ctn">
                    
                </div>
            </div>
            <div class="modal-footer">
                <div  style="margin: 0 auto!important;">
                    <button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" id="FinishBulkJob">
                        <span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Drop down list -->


<script type="text/javascript">


	$(document).ready(function () {
		var parentMenuList={};
<?php if(isset($parentMenuList) && count($parentMenuList) >= 0){?>
			parentMenuList = <?=json_encode($parentMenuList);?>;
		<?php } ?>

		for (i = 0; i < parentMenuList.length; i++){
			if (parentMenuList[i]['MenuAct'] == 'Vessel'){
				$('#' + parentMenuList[i]['MenuAct']).addClass('active');
			}
			else{
				$('#' + parentMenuList[i]['MenuAct']).removeClass();
			}
		}

function reload_ch(){
	var from=$('#TIMEIN').val();
	var to=$('#TIMEOUT').val();
	$.ajax({
				url: "<?=site_url(('api') . '/' . md5('GetLichTauData'));?>",
				dataType: 'json',
				data: {"FROMTIME":from,"TOTIME":to},
				type: 'POST',
				success: function (data) {
					if(data.deny){
						toastr["error"](data.deny);
					}
					$(".gantt").gantt({
			            source: data.DATA,
			            navigate: "scroll",
			            scale: "hours",

			            maxScale: "weeks",
			            minScale: "hours",
			            itemsPerPage: 10,
			            scrollToToday: true,
			            useCookie: true,
			            maxDate:data.maxDate,
			            minDate:data.minDate,
			            dow: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
			            onItemClick: function(data) {
			                
			            },
			        });
				},
				error: function(err){
				}
			});
}

reload_ch();


$(document).on("mouseenter touchend",".dataPanel .bar",function(){
var jdata=($(this).data("dataObj"));
var loai="";
if(jdata.vdata.VesselType+""=="1")
	loai="Hàng Ròi";
if(jdata.vdata.VesselType+""=="3")
	loai="Hàng Xá";
$(this).attr("data-container","body").attr("data-toggle","popover").attr("data-trigger","hover").attr("data-placement","top").attr("data-content","Vivamus sagittis lacus vel augue laoreet rutrum faucibus.").attr("data-original-title","").attr("title",""+jdata.name+" "+(jdata.vdata.InboundVoyage||"")+(jdata.vdata.OutboundVoyage?"/":"")+(jdata.vdata.OutboundVoyage||"")+"\n"+loai+""+"\nNhập : "+jdata.vdata.sumnhap+" "+(jdata.vdata.UnitID||"")+"\nXuất : "+jdata.vdata.sumxuat+" "+(jdata.vdata.UnitID||""));



});
$(document).on("mouseup",".dataPanel .bar",function(){
var jdata=($(this).data("dataObj"));
var loai="";
if(jdata.vdata.VesselType+""=="1")
	loai="Hàng Ròi";
if(jdata.vdata.VesselType+""=="3")
	loai="Hàng Xá";
var html="";
html+="<center style='display:block;width:100%;font-size:18px;font-weight:bold;'>"+jdata.name+"</center>";
html+="<div class=col-md-12><center style='display:block;width:100%;font-size:16px;font-weight:bold;'>"+(jdata.vdata.InboundVoyage||"")+(jdata.vdata.OutboundVoyage?"/":"")+(jdata.vdata.OutboundVoyage||"")+"</center><div class=col-md-12>Vào : "+jdata.vdata.ETA+"<br>Ra : "+jdata.vdata.ETD+"</div><div class=col-md-12>Nhập : "+jdata.vdata.sumnhap+" "+(jdata.vdata.UnitID||"")+" - Xuất : "+jdata.vdata.sumxuat+" "+(jdata.vdata.UnitID||"")+"</div></div>";
$("#v_info_ctn").html(html);
$("#v_info").modal("show");


});
$(document).on("click","#search",function(){
reload_ch();
});
$(document).on("click","#FinishBulkJob",function(){
	$("#v_info").modal("hide");
});

$('#TIMEIN,#TIMEOUT').datepicker({     dateFormat: 'yy-mm-dd',      timeFormat: 'hh:mm:ss'});


	});
</script>
<link href="<?=base_url('assets/lichtau/lichtau.css');?>" rel="stylesheet">
<script src="<?=base_url('assets/lichtau/lichtau.js');?>"></script>
<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>

