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
	.wrapper {
        display: grid;
        grid-template-columns: repeat(8, [col] 11.15% ) ;
        grid-template-rows: repeat(13, [row] 7%  );
        color: #444;
    }

    ::-webkit-scrollbar
    {
        width: 3px;   /*for vertical scrollbars*/ 
        height: 7px;  /*for horizontal scrollbars*/ 
    }

    ::-webkit-scrollbar-track
    {
        background: rgba(0, 0, 0, 0.1);

        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); 
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.4);

        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
        background-color: #818B99;
        border: 1px solid transparent;
        border-radius: 9px;
        -moz-background-clip: content-box;
        -webkit-background-clip: content-box;
        background-clip: content-box;
    }

    .datatable-header #tblOpr_filter,
    .datatable-header #tblFullPort_filter{
        margin-top: 5px;
    }
    .datatable-header #tblOpr_filter input,
    .datatable-header #tblFullPort_filter input{
        width: 8em;
        height: 1.5em;
        margin-top: 5px;
    }
    .datatable-header #tblOpr_filter span,
    .datatable-header #tblFullPort_filter span{
        font-size: 1em;
    }
    .datatable-header #tblOpr_filter>label:after,
    .datatable-header #tblFullPort_filter>label:after{
        padding-top: 2px;
    }

    th { font-size: 13px; max-width: 5px; height: 10px}
    td { font-size: 12px; }
    body{
        line-height: 1;
    }

    #vesselModel{
        animation: shimmy 60s infinite;
        /*animation-direction: alternate;*/
        animation-fill-mode: forwards;
    }

    #tblOpr td .checkbox span,
    #tblFullPort td .checkbox span{
        max-height: 13px;
        max-width: 13px;
        margin-top: 2px;
    }

    #tblOpr .checkbox-success input:checked~.input-span::after,
    #tblFullPort .checkbox-success input:checked~.input-span::after{
        width: 3px;
    }

    @keyframes shimmy {
        0% {
            transform: translate(0, 0);    
        }

        20%{
            transform: translate(54.5em, 0);
        }
        /*
        23%{
            transform: translate(54.5em, 0) rotate(360deg);
        }
        25%{
            transform: translate(54.5em, 0) rotate(360deg);
        }
        */
        40%{
            /*transform: translate(54.5em, 19em) rotate(360deg);*/
            transform: translate(54.5em, 19em);
        }         
        45%{
            transform: translate(54.5em, 19em) rotateY(180deg);
        }
        50%{
            transform: translate(54.5em, 19em) rotateY(180deg);
        }
        70%{
            transform: translate(0em, 19em) rotateY(180deg);
        }
        75%{
            transform: translate(0em, 19em);
        }

        100%{
            transform: translate(0em, 0em);
        }  
    }

    /*
    @-webkit-keyframes run {
        0% { left: 0;}
        50%{ left : 100%;}
        100%{ left: 0;}
    }*/

    .box {
        background-color: #ffffff;
        color: #000000;
        padding: 5%;
        font-size: 100%;
        margin: 0px;
    }

    .a1 {
        grid-column: col 1 / span 8;
        grid-row: row 1;
    }

    .a2{
        grid-column: col 1 / span 8;
        grid-row: row 2;
    }

    .a {
        grid-column: col 1 / span 1;
        grid-row: row 3;
    }

    .b {
        grid-column: col 2 / span 1;
        grid-row: row 3;
    }

    .b1 {
        grid-column: col 2 / span 1;
        grid-row: row 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .b2 {
        grid-column: col 3 / span 1;
        grid-row: row 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .b3 {
        grid-column: col 4 / span 1;
        grid-row: row 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .b4 {
        grid-column: col 5 / span 1;
        grid-row: row 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .b5 {
        grid-column: col 6 / span 1;
        grid-row: row 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .b6 {
        grid-column: col 7 / span 1;
        grid-row: row 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .c {
        grid-column: col 3/ span 1;
        grid-row: row 3;
    }

    .d {
        grid-column: col 4/ span 1;
        grid-row: 3;
    }

    .e {
        grid-column: col 5 / span 1;
        grid-row: 3;
    }

    .f {
        grid-column: col 6 / span 1;
        grid-row: 3;
    }

    .g {
        grid-column: col 7 / span 1;
        grid-row: 3;
    }

    .h {
        grid-column: col 8 / span 1;
        grid-row: 3
    }

    .i0{
        grid-column: col 1 / span 1;
        grid-row: 4;
    }

    .i1{
        grid-column: col 2 / span 7;
        grid-row: 4;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .i2{
        grid-column: col 1 / span 1;
        grid-row: 5;
    }

    .i3{
        grid-column: col 1 / span 1;
        grid-row: 6;
    }

    .i4{
        grid-column: col 1 / span 1;
        grid-row: 7;
    }

    .i5{
        grid-column: col 1 / span 1;
        grid-row: 8;
    }
    .i6{
        grid-column: col 1 / span 1;
        grid-row: 9;
    }
    .i7{
        grid-column: col 1 / span 1;
        grid-row: 10;
    }
    .i8{
        grid-column: col 1 / span 1;
        grid-row: 11;
    }
    .i9{
        grid-column: col 1 / span 1;
        grid-row: 12;
    }
    .i10{
        grid-column: col 1 / span 1;
        grid-row: 13;
    }

    .j{
    	grid-column: auto / span 3;
        grid-row: auto / span 7;
        display: grid;
   		grid-gap: 10px;
    }

    .k{
    	grid-column: auto / span 3;
        grid-row: auto / span 7;
        display: grid;
   		grid-gap: 10px;
    }

    .l1{
        grid-column: col 8 / span 1;
        grid-row: 4;
    }

    .l2{
        grid-column: col 8 / span 1;
        grid-row: 5;
    }

    .l3{
        grid-column: col 8 / span 1;
        grid-row: 6;
    }

    .l4{
        grid-column: col 8 / span 1;
        grid-row: 7;
    }

    .l5{
        grid-column: col 8 / span 1;
        grid-row: 8;
    }
    .l6{
        grid-column: col 8 / span 1;
        grid-row: 9;
    }
    .l7{
        grid-column: col 8 / span 1;
        grid-row: 10;
    }
    .l8{
        grid-column: col 8 / span 1;
        grid-row: 11;
    }
    .l9{
        grid-column: col 8 / span 1;
        grid-row: 12;
    }
    .l10{
        grid-column: col 8 / span 1;
        grid-row: 13;
    }

    .m {
        grid-column: col 2 / span 1;
        grid-row: row 13;
    }

    .m1 {
        grid-column: col 2 / span 1;
        grid-row: row 12;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .m2 {
        grid-column: col 3 / span 1;
        grid-row: row 12;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .m3 {
        grid-column: col 4 / span 1;
        grid-row: row 12;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .m4 {
        grid-column: col 5 / span 1;
        grid-row: row 12;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .m5 {
        grid-column: col 6 / span 1;
        grid-row: row 12;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .m6 {
        grid-column: col 7 / span 1;
        grid-row: row 12;
        padding-right: 0px!important;
        padding-left: 0px!important;
    }

    .n {
        grid-column: col 3/ span 1;
        grid-row: row 13;
    }

    .o {
        grid-column: col 4/ span 1;
        grid-row: 13;
    }

    .p {
        grid-column: col 5 / span 1;
        grid-row: 13;
    }

    .q {
        grid-column: col 6 / span 1;
        grid-row: 13;
    }

    .r {
        grid-column: col 7 / span 1;
        grid-row: 13;
    }
</style>
<div class="row">
	<div class="col-xl-12">
		<div class="ibox collapsible-box">
			<i class="la la-angle-double-up dock-right"></i>
			<div class="ibox-head">
				<div class="ibox-title">HÀNH TRÌNH TÀU</div>
				<div class="button-bar-group mr-3">
					<button id="addrow" class="btn btn-outline-success btn-sm mr-1" 
										title="Thêm hành trình mới">
						<span class="btn-icon"><i class="fa fa-plus"></i>Thêm mới</span>
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
				<div class="row ibox mb-0 border-e pb-0 pt-2">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">
									<label class="col-md-4 col-sm-6 col-xs-6 col-form-label pt-2">Mã hành trình</label>
									<div class="col-md-6 col-sm-6 col-xs-6 input-group input-group-sm">
                                        <select id="LaneIDFilter" class="selectpicker" data-width="100%" data-style="btn-default btn-sm" title="Mã hành trình">
                                            <?php if(count($laneList) > 0)?>
                                                <?php foreach($laneList as $item) {  ?>
                                                    <option value="<?=$item['LaneID']?>"><?=$item['LaneID'];?></option>
                                                <?php }?>
                                        </select>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<div class="row form-group">									
									<label class="col-md-5 col-sm-6 col-xs-6 col-form-label pt-2">Tên hành trình</label>
									<div class="col-md-6 col-sm-6 col-xs-6 input-group input-group-sm">
										<input id="LaneNameFilter" class="form-control form-control-sm" placeholder="Tên hành trình" type="text">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ibox-footer border-top-0">
				<div class="wrapper" style="margin: 0 auto">
                    <div class="box a1" style="margin: 0 auto; padding: 0px">
                        <svg width = "1024" height="35">              
                            <text x="512" y="18" fill="black" text-anchor="middle" font-weight="bold">CHI TIẾT HÀNH TRÌNH TÀU</text>                           
                        </svg>                       
                    </div>
                    <div class="box a2" style="padding: 0px">
                        <svg width = "1024" height="35"> 
                             <text x="50" y="18" fill="black">Mã hành trình</text>  
                             <text x="350" y="18" fill="black">Tên hành trình</text>  

                            <foreignObject class="node" x="150" y="0" width="150" height="30">
                                <input type="text" id="LaneID" class="form-control form-control-sm" style="padding-top: 3px;height: 2em;">
                            </foreignObject>

                            <foreignObject class="node" x="460" y="0" width="150" height="30">
                                <input type="text" id="LaneName" class="form-control form-control-sm" style="padding-top: 3px;height: 2em;">
                            </foreignObject>
                        </svg>
                    </div>
			  		<div class="box a" style="padding: 0px">
			           	<svg width = "150" height="35">	
			                <line x1="20" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

			                <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
			                <foreignObject class="node" x="20" y="9" width="72" height="18">
			               		<input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text1">
			               	</foreignObject>
			               	<text x="96" y="20" fill="black" id="port1">...</text>               

			               	<rect x="115" y="9" width="18" height="18" id="chooseColor1" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <text x="120" y="23" fill="black" id="ShortPort1"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor1">
                                <input type="text" id="ForeColor1">
                            </foreignObject>
			            </svg>
			  		</div>
			  		<div class="box b" style="padding: 0px">
			  			<svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);    "/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text2">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port2">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor2" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort2"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor2">
                                <input type="text" id="ForeColor2">
                            </foreignObject>
			            </svg>
			  		</div>
                    <!--
			  		<div class="box b1" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <text x="50" y="20" fill="black">>></text>
			            </svg>
			        </div>
			  		<div class="box b2" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
			  		<div class="box b3" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
			  		<div class="box b4" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
			  		<div class="box b5" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
			  		<div class="box b6" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="125" y1="15" x2="125" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="0" y1="15" x2="125" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
                -->
			  		<div class="box c" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);    "/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text3">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port3">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor3" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort3"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor3">
                                <input type="text" id="ForeColor3">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box d" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);    "/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text4">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port4">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor4" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort4"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor4">
                                <input type="text" id="ForeColor4">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box e"style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);    "/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text5">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port5">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor5" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort5"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor5">
                                <input type="text" id="ForeColor5">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box f" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);    "/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text6">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port6">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor6" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort6"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor6">
                                <input type="text" id="ForeColor6">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box g" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);    "/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text7">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port7">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor7" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort7"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor7">
                                <input type="text" id="ForeColor7">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box h"style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="50" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="70" y1="15" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

			                <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text8">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port8">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor8" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort8"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor8">
                                <input type="text" id="ForeColor8">
                            </foreignObject>
			            </svg>
			        </div>
                    <div class="box i0" style="padding: 0px;">
                        <svg width = "150" height="35">
                            <line x1="70" y1="20" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text34">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port34">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor34" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort34"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor34">
                                <input type="text" id="ForeColor34">
                        </svg>
                    </div>
					<div class="box i1" style="padding: 0px">
			            <svg width = "900" height="35">
                            <line x1="25" y1="15" x2="794" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
                            <line x1="25" y1="15" x2="25" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="794" y1="15" x2="794" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

                            <foreignObject class="node" x="0" y="0" width="1050" height="300">
                                <image id="vesselModel" src="<?=base_url('assets/img/vessel_images/v1.png');?>" x="400" y="200" height="30" width="60"/>
                            </foreignObject>

                            <foreignObject class="node">
                                <input type="text" id="BackColor28">
                                <input type="text" id="ForeColor28">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box i2" style="padding: 0px;">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text33">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port33">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor33" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort33"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor33">
                                <input type="text" id="ForeColor33">
			            </svg>
			        </div>
					<div class="box i3" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text32">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port32">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor32" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />

                            <text x="120" y="23" fill="black" id="ShortPort32"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor32">
                                <input type="text" id="ForeColor32">
			            </svg>
			        </div>
					<div class="box i4" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text31">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port31">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor31" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />

                            <text x="120" y="23" fill="black" id="ShortPort31"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor31">
                                <input type="text" id="ForeColor31">
			            </svg>
			        </div>
					<div class="box i5" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text30">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port30">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor30" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />

                            <text x="120" y="23" fill="black" id="ShortPort30"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor30">
                                <input type="text" id="ForeColor30">
			            </svg>
			        </div>
					<div class="box i6" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text29">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port29">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor29" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />

                            <text x="120" y="23" fill="black" id="ShortPort29"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor29">
                                <input type="text" id="ForeColor29">
			            </svg>
			        </div>
					<div class="box i7" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text28">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port28">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor28" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />

                            <text x="120" y="23" fill="black" id="ShortPort28"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor28">
                                <input type="text" id="ForeColor28">
			            </svg>
			        </div>
			        <div class="box i8" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text27">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port27">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor27" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort27"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor27">
                                <input type="text" id="ForeColor27">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box i9" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text26">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port26">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor26" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort26"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor26">
                                <input type="text" id="ForeColor26">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box i10" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="35" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="70" y1="0" x2="70" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text25">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port25">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor25" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort25"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor25">
                                <input type="text" id="ForeColor25">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box j" style="padding: 0px;">
			            <svg width = "450" height="250">
			                <line x1="25" y1="0" x2="25" y2="250" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

			                <foreignObject class="node" x="65" y="10" width="325" height="200">
			                	<div class="ibox-title" style="text-align: center;"><b>HÃNG KHAI THÁC</b></div>
			                    <table id="tblOpr" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
									<thead>
									<tr>
										<th class="editor-cancel data-type-checkbox" col-name="Tick"></th>
										<th class="editor-cancel" col-name="STT">STT</th>
										<th col-name="OprID">Mã hãng</th>
										<th col-name="OprName">Tên hãng</th>
									</tr>
									</thead>
									<tbody> 
                                    <?php if(count($oprList) > 0) {$i = 1; ?>
                                        <?php foreach($oprList as $item) {  ?>
                                            <tr>
                                                <td>
                                                    <label class="checkbox checkbox-success"><input id="<?= 'checkOpr' . $item['OprID'] ?>" type="checkbox"><span class="input-span"></span></label>
                                                </td>
                                                <td><?=$i;?></td>
                                                <td><input id="<?= 'OprID'.$i ?>" type="text" hidden value="<?=$item['OprID'];?>"><?=$item['OprID'];?></td>
                                                <td><?=$item['OprName'];?></td>    
                                            </tr>
                                            <?php $i++; }  ?>
                                    <?php } ?>        			
									</tbody>
								</table>
			                </foreignObject>
			            </svg>
					</div>
					<div class="box k" style="padding: 0px;">
			            <svg width = "450" height="250">               
			                <foreignObject class="node" x="46" y="10" width="300" height="1000">
			                	<div class="ibox-title" style="text-align: center;"><b>DANH SÁCH CẢNG ĐÍCH</b></div>
			                	<table id="tblFullPort" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
                                    <thead>
                                    <tr>
                                        <th class="editor-cancel data-type-checkbox" col-name="Tick"></th>
                                        <th col-name="LaneCode">Mã LH</th>
                                        <th col-name="PortID">Mã cảng</th>
                                        <th col-name="NationID">Quốc gia</th>
                                    </tr>
                                    </thead>
                                    <tbody>  
                                    <?php if(count($portList) > 0) {$i = 1; ?>
                                        <?php foreach($portList as $item) {  ?>
                                            <tr>
                                                <td>
                                                    <label class="checkbox checkbox-success"><input id="<?= 'checkPort'. $item['PortID'] ?>" type="checkbox"><span class="input-span"></span></label>
                                                </td>
                                                <td><input id="<?= 'LaneCode'. $item['PortID'] ?>" type="text" hidden value="<?php echo($item['NationID'].$item['PortID']); ?>"><?php echo($item['NationID'].$item['PortID']); ?></td>
                                                <td><input id="<?= 'PortID'.$i ?>" type="text" hidden value="<?=$item['PortID'];?>"><?=$item['PortID'];?></td>
                                                <td><input type="text" hidden value="<?=$item['NationID'];?>"><?=$item['NationName'];?></td>    
                                            </tr>
                                            <?php $i++; }  ?>
                                    <?php } ?>                                       
                                    </tbody>
                                </table>
			                </foreignObject>
			                <line x1="393" y1="0" x2="391" y2="250" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" /> 
			            </svg>
			        </div>    
					<div class="box l1" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />

			                <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text9">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port9">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor9" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort9"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor9">
                                <input type="text" id="ForeColor9">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l2"  style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text10">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port10">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor10" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort10"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor10">
                                <input type="text" id="ForeColor10">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l3" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text11">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port11">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor11" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort11"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor11">
                                <input type="text" id="ForeColor11">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l4" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text12">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port12">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor12" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort12"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor12">
                                <input type="text" id="ForeColor12">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l5" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text13">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port13">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor13" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort13"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor13">
                                <input type="text" id="ForeColor13">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l6" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70 " y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text14">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port14">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor14" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort14"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor14">
                                <input type="text" id="ForeColor14">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l7" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text15">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port15">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor15" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort15"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor15">
                                <input type="text" id="ForeColor15">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l8" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text16">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port16">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor16" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort16"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor16">
                                <input type="text" id="ForeColor16">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l9" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="70" y1="0" x2="70" y2="35" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text17">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port17">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor17" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort17"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor17">
                                <input type="text" id="ForeColor17">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box l10" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="50" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="70" y1="0" x2="70" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text18">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port18">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor18" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort18"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor18">
                                <input type="text" id="ForeColor18">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box m1" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="25" y1="0" x2="25" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="25" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
					<div class="box m2" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
					<div class="box m3" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
					<div class="box m4" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>
					<div class="box m5" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="15" x2="150" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>

					<div class="box m6" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="123" y1="0" x2="123" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                <line x1="0" y1="15" x2="123" y2="15" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			            </svg>
			        </div>

			        <div class="box m" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text24">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port24">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor24" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort24"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor24">
                                <input type="text" id="ForeColor24">
                            </foreignObject>
			            </svg>
			        </div>
			  		<div class="box n" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text23">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port23">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor23" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort23"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor23">
                                <input type="text" id="ForeColor23">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box o" style="padding: 0px">
			             <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text22">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port22">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor22" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort22"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor22">
                                <input type="text" id="ForeColor22">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box p" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			               
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text21">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port21">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor21" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort21"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor21">
                                <input type="text" id="ForeColor21">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box q" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text20">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port20">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor20" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort20"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor20">
                                <input type="text" id="ForeColor20">
                            </foreignObject>
			            </svg>
			        </div>
					<div class="box r" style="padding: 0px">
			            <svg width = "150" height="35">
			                <line x1="0" y1="18" x2="150" y2="18" style="stroke:rgb(0,0,0); stroke-width:0.75; padding: 0px" />
			                
                            <rect x="20" y="9" width="90" height="18"  style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0);"/>
                            <foreignObject class="node" x="20" y="9" width="72" height="18">
                                <input type="text" maxlength="5" style="padding-left: 0.8rem; padding-bottom: 0.25rem; margin-top: -0.25rem;" id="text19">
                            </foreignObject>
                            <text x="96" y="20" fill="black" id="port19">...</text>               

                            <rect x="115" y="9" width="18" height="18" id="chooseColor19" style="fill: white; stroke-width:0.75; stroke:rgb(0,0,0); " />
                            <text x="120" y="23" fill="black" id="ShortPort19"></text>  

                            <foreignObject class="node">
                                <input type="text" id="BackColor19">
                                <input type="text" id="ForeColor19">
                            </foreignObject>
			            </svg>
			        </div>
				</div>   
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="color-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%; top: 200px">
    <div class="modal-dialog" role="document" style="width: 400px!important">
        <div class="modal-content" style="border-radius: 4px">
            <div class="modal-body" style="margin: 0 auto">
                <fieldset class="col">
                    <label for="excolor1">Màu nền:   </label>
                    <input type="color" id="BackColor" name="excolor1" list="rainbow" style="margin-left: 10px;"> 
                </fieldset>
                <fieldset class="col" style="margin-top: 10px">
                    <label for="excolor1">Màu chữ:   </label>
                    <input type="color" id="ForeColor" name="excolor1" list="rainbow" style="margin-left: 10px;">
                </fieldset>
                <datalist id="rainbow">
                    <option value="#FF0000">Red</option>
                    <option value="#FFA500">Orange</option>
                    <option value="#FFFF00">Yellow</option>
                    <option value="#008000">Green</option>
                    <option value="#0000FF">Blue</option>
                    <option value="#4B0082">Indigo</option>
                    <option value="#EE82EE">Violet</option>
                </datalist>
            </div>
            <div class="modal-footer">
                <div  style="margin: 0 auto!important;">
                    <button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-color" data-dismiss="modal">
                        <span class="btn-label"><i class="ti-check"></i></span>Xác nhận</button>
                    <button class="btn btn-sm btn-rounded btn-gradient-peach btn-labeled btn-labeled-left btn-icon" data-dismiss="modal">
                        <span class="btn-label"><i class="ti-close"></i></span>Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="port-modal" tabindex="-1" role="dialog" aria-labelledby="groups-modalLabel" aria-hidden="true" data-whatever="id" style="padding-left: 14%">
	<div class="modal-dialog" role="document" style="min-width: 1024px!important">
		<div class="modal-content" style="border-radius: 4px">
			<div class="modal-header">
				<h5 class="modal-title text-primary" id="groups-modalLabel">Danh mục cảng</h5>
			</div>
			<div class="modal-body">
				<table id="tblPort" class="table table-striped display nowrap" cellspacing="0" style="width: 99.5%">
					<thead>
						<tr style="width: 100%">
							<th col-name="STT">STT</th>
                            <th col-name="LaneCode">Mã liên hiệp</th>
                            <th col-name="NationID">Mã quốc gia</th>
                            <th col-name="NationName">Tên quốc gia</th>
							<th col-name="PortID">Mã cảng</th>
                            <th col-name="PortName">Tên cảng</th>
						</tr>
					</thead>
					<tbody>
                    
					<?php if(count($portList) > 0) {$i = 1; ?>
						<?php foreach($portList as $item){ ?>
							<tr>
								<td><?=$i;?></td>
                                <td><?php echo($item['NationID'].$item['PortID']); ?></td>
                                <td><?=$item['NationID'];?></td>
                                <td><?=$item['NationName'];?></td>
								<td><?=$item['PortID'];?></td>
                                <td><?=$item['PortName'];?></td>
							</tr>
							<?php $i++; }  ?>
					<?php } ?>
                    <!---->
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div  style="margin: 0 auto!important;">
					<button class="btn btn-sm btn-rounded btn-gradient-blue btn-labeled btn-labeled-left btn-icon" id="apply-port" data-dismiss="modal">
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
		var tbl1 			= $('#tblOpr'),
			tblPort 		= $('#tblPort'),
            tblFullPort     = $("#tblFullPort"),
			_columns1		= ["Tick", "STT", "OprID", "OprName"],
			_portColumns	= ["STT", "LaneCode", "NationID", "NationName", "PortID", "PortName"],
            _fullPortColumns= ["Tick", "LaneCode", "PortID", "NationID"];
			oprList			= {},
			portList		= {},
            portModal       = $('#port-modal'),
			colorModal 		= $('#color-modal'),
            maxIndex        = 0,
            delList         = [],
            parentMenuList  = {};

		var x = tbl1.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", targets: _columns1.indexOf('STT')},		
				{ className: "text-center", targets: _columns1.getIndexs(["Tick", "OprID", "OprName"])},
			],
			order: [[ _columns1.indexOf('STT'), 'asc' ]],
			paging: false,
            keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: "single",
            	info: false,
            },
            rowReorder: false,
            buttons: [], // hide select all
            info: false, // hide rows count
            arrayColumns: _columns1
		});

		var y = tblPort.newDataTable({
			scrollY: '30vh',
			columnDefs: [
				{ type: "num", className: "text-center", width: "5px", targets: _portColumns.indexOf('STT')},		
				{ className: "text-center", width: "5px", targets: _portColumns.getIndexs(["LaneCode", "NationID", "NationName", "PortID", "PortName"])},
			],
			order: [[ _portColumns.indexOf('STT'), 'asc' ]],
			paging: false,
            keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: {
            	style: "single",
            	info: false,
            },
            rowReorder: false,
            buttons: [], // hide select all
            searching: false, // hide search box
            arrayColumns: _portColumns,
		});

        var z = tblFullPort.newDataTable({
            scrollY: '20vh',
            columnDefs: [    
                { className: "text-center", targets: _fullPortColumns.getIndexs(["Tick", "LaneCode", "PortID", "NationID"])},
            ],
            order: [[ _fullPortColumns.indexOf('NationID'), 'asc' ]],
            paging: false,
            keys: true,
            autoFill: {
                focus: 'focus'
            },
            select: {
                style: "single",
                info: false,
            },
            rowReorder: false,
            buttons: [], // hide select all
            info: false, // hide rows count
            arrayColumns: _fullPortColumns,
        });

		<?php if(isset($oprList) && count($oprList) >= 0){?>
			oprList = <?= json_encode($oprList);?>;
		<?php } ?>

		<?php if(isset($portList) && count($portList) >= 0){?>
			portList = <?= json_encode($portList);?>;
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

        $("#text1, #text2, #text3, #text4, #text5, #text6, #text7, #text8, #text9, #text10, #text11, #text12, #text13, #text14, #text15, #text16, #text17, #text18, #text19, #text20, #text21, #text22, #text23, #text24, #text25, #text26, #text27, #text28, #text29, #text30, #text31, #text32, #text33, #text34, #port1, #port2, #port3, #port4, #port5, #port6, #port7, #port8, #port9, #port10, #port11, #port12, #port13, #port14, #port15, #port16, #port17, #port18, #port19, #port20, #port21, #port22, #port23, #port24, #port25, #port26, #port27, #port28, #port29, #port30, #port31, #port32, #port33, #port34").on('mouseover', function(){
            var rows = [];
            if(portList.length > 0) {
               var rows = [], index = 1;;
               for (i = 0; i < portList.length; i++) {
                   var id = "#checkPort" + portList[i]['PortID'];
                   if ($(id).prop('checked')){
                       var r = [];
                       $.each(_portColumns, function(idx, colname){ 
                           var val = "";
                           switch(colname){
                               case "STT": 
                                   val = index;
                                   index++; 
                                   break;
                               case "LaneCode":
                                   var LaneCode = (portList[i]['NationID'] + portList[i]['PortID']);
                                   val = LaneCode;
                                   break;
                               default:
                                   val = portList[i][colname];
                                   break;
                           }
                           r.push(val);
                       });
                       rows.push(r);                                  
                   }                                     
                } 
                tblPort.dataTable().fnClearTable();
                if(rows.length > 0){
                    tblPort.dataTable().fnAddData(rows);
                }    
            }
        });

		// Port on Click
        var index = 0;
		$("#port1, #port2, #port3, #port4, #port5, #port6, #port7, #port8, #port9, #port10, #port11, #port12, #port13, #port14, #port15, #port16, #port17, #port18, #port19, #port20, #port21, #port22, #port23, #port24, #port25, #port26, #port27, #port28, #port29, #port30, #port31, #port32, #port33, #port34").click(function(event){
		    portModal.modal("show");
            index = event.target.id.slice(4,event.target.id.length);
		});	

		//tblPort.find("tbody tr").on("dblclick", function(){ // Double Click
        $(document).on("dblclick", "#tblPort tbody tr",  function(){
            var portID      = tblPort.getSelectedRows().data().toArray()[0][_portColumns.indexOf("PortID")],
		        laneCode    = tblPort.getSelectedRows().data().toArray()[0][_portColumns.indexOf("LaneCode")],
                shortPort   = portID.slice(0,1);
            id = "#text" + index;
			$(id).val(laneCode);
            $(id).css({"border-color": "", 
                       "boxorder-width":"", 
                       "border-style":""});

            id = "#ShortPort" + index;
            $(id).text(shortPort);

            if (maxIndex < parseInt(index)){
                maxIndex = parseInt(index);
            }

			portModal.modal("hide");
		});

        $('#port-modal').on('shown.bs.modal', function(e){
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

		$("#apply-port").on("click", function(){	// Click Accept
            var portID      = tblPort.getSelectedRows().data().toArray()[0][_portColumns.indexOf("PortID")],
                laneCode    = tblPort.getSelectedRows().data().toArray()[0][_portColumns.indexOf("LaneCode")],
				shortPort   = portID.slice(0,1);

            id = "#text" + index;
            $(id).val(laneCode);
            $(id).css({"border-color": "", 
                       "boxorder-width":"", 
                       "border-style":""});

            id = "#ShortPort" + index;
            $(id).text(shortPort);

            if (maxIndex < parseInt(index)){
                maxIndex = parseInt(index);
            }
		});

        var colorIndex;
		$("#chooseColor1, #chooseColor2, #chooseColor3, #chooseColor4, #chooseColor5, #chooseColor6, #chooseColor7, #chooseColor8, #chooseColor9, #chooseColor10, #chooseColor11, #chooseColor12, #chooseColor13, #chooseColor14, #chooseColor15, #chooseColor16, #chooseColor17, #chooseColor18, #chooseColor19, #chooseColor20, #chooseColor21, #chooseColor22, #chooseColor23, #chooseColor24, #chooseColor25, #chooseColor26, #chooseColor27, #chooseColor28, #chooseColor29, #chooseColor30, #chooseColor31, #chooseColor32, #chooseColor33, #ShortPort1, #ShortPort2, #ShortPort3, #ShortPort4, #ShortPort5, #ShortPort6, #ShortPort7, #ShortPort8, #ShortPort9, #ShortPort10, #ShortPort11, #ShortPort12, #ShortPort13, #ShortPort14, #ShortPort15, #ShortPort16, #ShortPort17, #ShortPort18, #ShortPort19, #ShortPort20, #ShortPort21, #ShortPort22, #ShortPort23, #ShortPort24, #ShortPort25, #ShortPort26, #ShortPort27, #ShortPort28, #ShortPort29, #ShortPort30, #ShortPort31, #ShortPort32, #ShortPort33, #ShortPort34").on('click', function(){
			colorModal.modal("show");
            if (event.target.id.slice(0,1) == 'c')
                colorIndex = event.target.id.slice(11,event.target.id.length)
            else
                colorIndex = event.target.id.slice(9,event.target.id.length)
		});

        $("#apply-color").on("click", function(){    // Click Accept
            var BackColor = $("#BackColor").val().slice(1, this.length),
                ForeColor = $("#ForeColor").val().slice(1, this.length);

            id = "#text" + colorIndex;
            $(id).css("background-color", "#" + BackColor);
            $(id).css("color", "#" + ForeColor);

            id = "#BackColor" + colorIndex;
            $(id).val(BackColor);

            id = "#ForeColor" + colorIndex;
            $(id).val(ForeColor);
        });

        $("#text1, #text2, #text3, #text4, #text5, #text6, #text7, #text8, #text9, #text10, #text11, #text12, #text13, #text14, #text15, #text16, #text17, #text18, #text19, #text20, #text21, #text22, #text23, #text24, #text25, #text26, #text27, #text28, #text29, #text30, #text31, #text32, #text33, #text34").on('blur', function(){
            if (this.value != ''){
                textIndex = event.target.id.slice(4,event.target.id.length);
                id = "#ShortPort" + textIndex;

                text = (this.value == '' ? '' : this.value);
                check = false;

                $.each(portList, function(key, value){
                    var compareString = value['NationID'] + value['PortID'];
                    if (compareString == text){
                        $(id).text(value['PortID'].slice(0,1));
                        check = true;

                        if (maxIndex < parseInt(textIndex)){
                            maxIndex = parseInt(textIndex);
                        }

                        return false;                    
                    }
                });

                if (!check){
                    toastr['error']("Vui lòng nhập Mã tàu hợp lệ");
                    $(id).text("");
                    $(this).css({"border-color": "red", 
                                 "boxorder-width":"2px", 
                                 "border-style":"solid"});
                }
                else{
                    $(this).css({"border-color": "", 
                                 "boxorder-width":"", 
                                 "border-style":""});
                }
            }
            else{
                /*
                textIndex = event.target.id.slice(4,event.target.id.length);
                id = "#ShortPort" + textIndex;
                if ($(id).text() != ''){
                    delList.push(textIndex);

                }
                */
            }            
        });
        // Save button event
        var input_type = 'add';
        $('#save').on('click', function(){
            var LaneID      = ($("#LaneID").val() == '' ? '' : $("#LaneID").val()),
                LaneName    = ($("#LaneName").val() == '' ? '' : $("#LaneName").val());

            if (LaneID == ""){
                toastr['error']("Vui lòng nhập Mã hành trình!");
                return;
            }

            if (LaneName == ""){
                toastr['error']("Vui lòng nhập Tên cho Mã hành trình " + LaneID);
                return;
            }

           
            /* Collect lane code delete list */
            delList = [];
            for (i = 1; i <= maxIndex; i++){
                idText  = "#text" + i;
                idSP    = "#ShortPort" + i;
                if ($(idText).val() == ''  && $(idSP).text() != ''){
                    delList.push(i);
                }
            }

            // Get Opr Save List and del
            oprAddList = [];
            oprDelList = [];
            for (i = 0; i < oprList.length; i++){
                var oId = "#checkOpr" + oprList[i]['OprID'];
                if ($(oId).prop('checked'))
                    oprAddList.push(oprList[i]['OprID'])
                else
                    oprDelList.push(oprList[i]['OprID']);
            }

            if (oprAddList.length == 0){
                toastr['error']("Vui lòng chọn ít nhất một hãng khai thác!");
                return;
            }

            /* Check if user delete (a) row(s) in Lane Details (with LaneID) */
            if (delList.length > 0 || oprDelList.length > 0){
                delList.sort(function(a,b) { return b - a; });

                var fdel = {
                    'action': 'delete',
                    'data1': delList,
                    'data2': oprDelList,
                    'LaneID': LaneID,
                };

                $.ajax({
                    url: "<?=site_url(md5('Common') . '/' . md5('cmLane'));?>",
                    dataType: 'json',
                    data: fdel,
                    type: 'POST',
                    success: function (data) {
                        if(data.deny) {
                            toastr["error"](data.deny);
                            console.log(data);
                        }
                        toastr["success"]("Cập nhật thành công!");
                    },
                    error: function(err){
                        toastr["error"]("Error!");
                        console.log(err);
                    }
                });
            }

            /* ** */
            var laneList = {},
                ldIndexs = 0;

            for (i = 0; i < oprAddList.length; i++){
                laneList[ldIndexs] = {
                    'LaneID':     LaneID,
                    'LaneName':   LaneName,
                    'OprID':      oprAddList[i],
                };
                ldIndexs++; 
            }

            var laneDetailList = {};
            ldIndexs = 0;

            for (i = 1; i <= maxIndex; i++){
                id          = "#text" + i;
                PortID      = $(id).val().slice(2,5); 

                id          = "#ShortPort" + i;
                ShortPort   = $(id).text();

                id          = "#BackColor" + i;
                BackColor   = ($(id).val() == '' ? 'ffffff' : $(id).val());

                id          = "#ForeColor" + i;
                ForeColor   = ($(id).val() == '' ? '000000' : $(id).val());

                if (PortID != ''){
                    laneDetailList[ldIndexs] = {
                        'LaneID':       LaneID,
                        'PortID':       PortID,
                        'ShortPort':    ShortPort,
                        'PortSeq':      ldIndexs + 1,
                        'BackColor':    BackColor,
                        'ForeColor':    ForeColor,                        
                    };
                   ldIndexs++;
                }
            }

            saveLane(laneList);
            saveLaneDetail(laneDetailList);
        }); 

        function saveLane(formData){
            var fData = {
                    'action': input_type,
                    'child_action': 'add_lane',
                    'data': formData,
                };
            postSave(fData);
        }

        function saveLaneDetail(formData){
            var fData = {
                    'action': input_type,
                    'child_action': 'add_lane_detail',
                    'data': formData,
                };
            postSave(fData);
        }   
        
        function postSave(formData){            
            $.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmLane'));?>",
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
                        $('#search').trigger('click');
                        return;
                    }

                    if(formData.action == 'add'){
                        toastr["success"]("Thêm mới thành công!");
                        $('#search').trigger('click');
                        return;                     
                    }
                },
                error: function(err){
                    toastr["error"]("Error!");
                    console.log(err);
                }
            });
        }

        $("#LaneIDFilter").on('change', function(){
            input_type = 'edit';

            var formData = {
                'action': 'view',
                'child_action': 'loadLane',
                'LaneID': this.value,
            };

            $.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmLane'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.list.length > 0) {
                        $("#LaneID").val(data.list[0]['LaneID']);
                        $("#LaneName").val(data.list[0]['LaneName']);
                        for (i = 0; i < data.list.length; i++) {
                            var rData = data.list[i];

                            id = "#checkOpr" + rData['OprID'];
                            $(id).prop('checked', true);
                        }
                    }
                },
                error: function(err){
                    toastr["error"]("Error!");
                    console.log(err);
                }
            });         

            var formData = {
                'action': 'view',
                'child_action': 'loadLaneDetails',
                'LaneID': this.value,
            };

            $.ajax({
                url: "<?=site_url(md5('Common') . '/' . md5('cmLane'));?>",
                dataType: 'json',
                data: formData,
                type: 'POST',
                success: function (data) {
                    if(data.list.length > 0) {
                        $("#LaneID").val(data.list[0]['LaneID']);
                        $("#LaneName").val(data.list[0]['LaneName']);
                        maxIndex = data.list.length;

                        for (i = 1; i <= data.list.length; i++) {
                            var rData = data.list[i - 1],
                                index = rData['PortSeq'];

                            id = "#text" + index;
                            $(id).val(rData['NationID'] + rData['PortID']);

                            id = "#BackColor" + index;
                            $(id).val(rData['BackColor']);

                            id = "#ForeColor" + index
                            $(id).val(rData['ForeColor']);

                            id = "#text" + index;
                            $(id).css("background-color", "#" + rData['BackColor']);
                            $(id).css("color", "#" + rData['ForeColor']);

                            id = "#ShortPort" + index;
                            $(id).text(rData['ShortPort']);

                            id = "#checkOpr" + rData['OprID'];
                            $(id).prop('checked', true);

                            id = "#checkPort" + data.list[i - 1]['PortID'];
                            $(id).prop('checked', true);
                        }
                    }
                },
                error: function(err){
                    toastr["error"]("Error!");
                    console.log(err);
                }
            });
        });

        $('.contenttable_wrapper').each(function(){
            $(this).prefectScrollbar();
        });

        $("#addrow").on('click', function(){
            $("#LaneID").val('');
            $("#LaneName").val('');
            $("#LaneIDFilter").val('');
            $( "#LaneIDFilter" ).selectpicker( "refresh" );

            for (i = 0; i < oprList.length; i++){
                id = "#checkOpr" + oprList[i]['OprID'];
                $(id).prop('checked', false);
            }

            for (i = 0; i < portList.length; i++){
                id = "#checkPort" + portList[i]['PortID'];
                $(id).prop('checked', false);
            }

            for (i = 1; i <= 34; i++) {
                id = "#BackColor" + i;
                $(id).val('');

                id = "#ForeColor" + i
                $(id).val('');

                id = "#text" + i;
                $(id).val('');
                $(id).css("background-color", "#ffffff");

                id = "#ShortPort" + i;
                $(id).text('');
            }
        });
	});
</script>

<script src="<?=base_url('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>