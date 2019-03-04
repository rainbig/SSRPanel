@extends('user.layouts')
@section('css')
    <link href="/assets/pages/css/pricing.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />
    <style>
        .fancybox > img {
            width: 75px;
            height: 75px;
        }
    </style>
@endsection
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content" style="padding-top:0;">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <h4 class="">
                        <span class="font-blue">账户等级：</span>
                        <span class="font-red">{{Auth::user()->levelList->level_name}}</span>
                        <span class="font-blue">、账户余额：</span>
                        <span class="font-red">{{Auth::user()->balance}}元</span>
                        <a class="btn btn-sm red" href="#" data-toggle="modal" data-target="#charge_modal" style="color: #FFF;">{{trans('home.recharge')}}</a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet light">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#services1" data-toggle="tab"> <i class="fa fa-book"></i> 说明 </a>
                                </li>
                                <li>
                                    <a href="#services2" data-toggle="tab"> <i class="fa fa-cloud"></i> 基础套餐 </a>
                                </li>
                                <li>
                                    <a href="#services3" data-toggle="tab"> <i class="fa fa-jsfiddle"></i> 流量包 </a>
                                </li>
                            </ul>
                            <div class="tab-content" style="font-size:16px;">
                                <div class="tab-pane active" id="services1">
                                    <h4>购买流程：</h4>
                                    <ol>
                                        <li>第一步：先购买基础套餐。</li>
                                        <li>第二步：按需求，选择是否购买流量包。</li>
                                    </ol>
                                    <h4>基础套餐：</h4>
                                    <ol>
                                        <li>在套餐生效的时间内，您将获得「套餐对应的网络速度」、「套餐内相应的流量」及其它特权。</li>
                                        <li>基础套餐每月将会重置一次流量，重置日为购买日。</li>
                                        <li>如在套餐未到期的情况下购买新套餐，则会导致旧套餐的所有配置立即失效，新套餐的配置立即生效。</li>
                                    </ol>
                                    <h4>流量包：</h4>
                                    <ol>
                                        <li>当您在基础套餐重置日之前将流量耗尽，您可以选择购买流量包解燃眉之急。</li>
                                        <li>流量包只在固定时间内增加可用流量，不会更改账户的配置，并且即时生效可以多个叠加。 </li>
                                    </ol>
                                </div>
                                <div class="tab-pane" id="services2">
                                    <div class="portlet-body">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light table-checkable order-column">
                                                <thead>
                                                <tr>
                                                    <th style="width:35%;"> {{trans('home.service_name')}} </th>
                                                    <th style="text-align: center;"> {{trans('home.service_desc')}} </th>
                                                    <th style="text-align: center;"> {{trans('home.service_price')}} </th>
                                                    <th> </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($packageList->isEmpty())
                                                    <tr>
                                                        <td colspan="4" style="text-align: center;">{{trans('home.services_none')}}</td>
                                                    </tr>
                                                @else
                                                    @foreach($packageList as $key => $vo)
                                                        <tr class="odd gradeX">
                                                            <td style="width: 20%;">
                                                            <!--@if($vo->logo) <a href="{{$vo->logo}}" class="fancybox"><img src="{{$vo->logo}}"/></a> @endif -->
                                                                <span style="font-size: 1.15em; color: #000;">{{$vo->name}}</span>
                                                                <br>
                                                                <span style="color: #000;">{{trans('home.service_traffic')}}：{{$vo->traffic_label}}</span>
                                                                <br>
                                                                <span style="color: #000;">{{trans('home.service_days')}}：{{$vo->days}} {{trans('home.day')}}</span>
                                                            </td>
                                                            <td style="width: 20%; text-align: center;"> {{$vo->desc}} </td>
                                                            <td style="width: 20%; text-align: center;"> ￥{{$vo->price}} </td>
                                                            <td style="width: 20%; text-align: center;">
                                                                <a href="javascript:buy('{{$vo->id}}');" class="btn blue"> {{trans('home.service_buy_button')}} </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                                    {{ $packageList->appends(array_except(Request::query(), 'packagePage'))->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="services3">
                                    <div class="portlet-body">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light table-checkable order-column">
                                                <thead>
                                                <tr>
                                                    <th style="width:35%;"> {{trans('home.service_name')}} </th>
                                                    <th style="text-align: center;"> {{trans('home.service_desc')}} </th>
                                                    <th style="text-align: center;"> {{trans('home.service_price')}} </th>
                                                    <th> </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if($trafficList->isEmpty())
                                                    <tr>
                                                        <td colspan="4" style="text-align: center;">{{trans('home.services_none')}}</td>
                                                    </tr>
                                                @else
                                                    @foreach($trafficList as $key => $vo)
                                                        <tr class="odd gradeX">
                                                            <td style="width: 20%;">
                                                            <!--@if($vo->logo) <a href="{{$vo->logo}}" class="fancybox"><img src="{{$vo->logo}}"/></a> @endif -->
                                                                <span style="font-size: 1.15em; color: #000;">{{$vo->name}}</span>
                                                                <br>
                                                                <span style="color: #000;">{{trans('home.service_traffic')}}：{{$vo->traffic_label}}</span>
                                                                <br>
                                                                <span style="color: #000;">{{trans('home.service_days')}}：{{$vo->days}} {{trans('home.day')}}</span>
                                                            </td>
                                                            <td style="width: 20%; text-align: center;"> {{$vo->desc}} </td>
                                                            <td style="width: 20%; text-align: center;"> ￥{{$vo->price}} </td>
                                                            <td style="width: 20%; text-align: center;">
                                                                <a href="javascript:buy('{{$vo->id}}');" class="btn blue"> {{trans('home.service_buy_button')}} </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="dataTables_paginate paging_bootstrap_full_number pull-right">
                                                    {{ $trafficList->appends(array_except(Request::query(), 'trafficPage'))->links() }}
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
        </div>

        <div id="charge_modal" class="modal fade" tabindex="-1" data-focus-on="input:first" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">{{trans('home.recharge_balance')}}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" style="display: none; text-align: center;" id="charge_msg"></div>
                        <form action="#" method="post" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="charge_type" class="col-md-4 control-label">{{trans('home.payment_method')}}</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="charge_type" id="charge_type">
                                            <option value="1" selected>{{trans('home.coupon_code')}}</option>
                                            @if(!$chargeGoodsList->isEmpty())
                                                <option value="2">{{trans('home.online_pay')}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @if(!$chargeGoodsList->isEmpty())
                                    <div class="form-group" id="charge_balance" style="display: none;">
                                        <label for="online_pay" class="col-md-4 control-label">充值金额</label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="online_pay" id="online_pay">
                                                @foreach($chargeGoodsList as $key => $goods)
                                                    <option value="{{$goods->id}}">充值{{$goods->price}}元</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group" id="charge_coupon_code">
                                    <label for="charge_coupon" class="col-md-4 control-label"> {{trans('home.coupon_code')}} </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="charge_coupon" id="charge_coupon" placeholder="{{trans('home.please_input_coupon')}}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn dark btn-outline">{{trans('home.close')}}</button>
                        <button type="button" class="btn red btn-outline" onclick="return charge();">{{trans('home.recharge')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
@endsection
@section('script')
    <script src="/assets/global/plugins/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>

    <script type="text/javascript">
        function buy(goods_id) {
            window.location.href = '/buy/' + goods_id;
        }

        // 查看商品图片
        $(document).ready(function () {
            $('.fancybox').fancybox({
                openEffect: 'elastic',
                closeEffect: 'elastic'
            })
        })

        // 切换充值方式
        $("#charge_type").change(function(){
            if ($(this).val() == 2) {
                $("#charge_balance").show();
                $("#charge_coupon_code").hide();
            } else {
                $("#charge_balance").hide();
                $("#charge_coupon_code").show();
            }
        });

        // 充值
        function charge() {
            var charge_type = $("#charge_type").val();
            var charge_coupon = $("#charge_coupon").val();
            var online_pay = $("#online_pay").val();

            if (charge_type == '2') {
                $("#charge_msg").show().html("正在跳转支付界面");
                window.location.href = '/buy/' + online_pay;
                return false;
            }

            if (charge_type == '1' && (charge_coupon == '' || charge_coupon == undefined)) {
                $("#charge_msg").show().html("{{trans('home.coupon_not_empty')}}");
                $("#charge_coupon").focus();
                return false;
            }

            $.ajax({
                url:'{{url('charge')}}',
                type:"POST",
                data:{_token:'{{csrf_token()}}', coupon_sn:charge_coupon},
                beforeSend:function(){
                    $("#charge_msg").show().html("{{trans('home.recharging')}}");
                },
                success:function(ret){
                    if (ret.status == 'fail') {
                        $("#charge_msg").show().html(ret.message);
                        return false;
                    }

                    $("#charge_modal").modal("hide");
                    window.location.reload();
                },
                error:function(){
                    $("#charge_msg").show().html("{{trans('home.error_response')}}");
                },
                complete:function(){}
            });
        }
    </script>
@endsection
