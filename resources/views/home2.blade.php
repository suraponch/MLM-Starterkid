@extends('layouts.web')

@section('title', __('web.dashboard_title') . " || e-earners")

@section('breadtitle', __('web.dashboard_title'))

@section('breadli')
<li class="breadcrumb-item active">@lang('web.dashboard_title')</li>
@endsection

@section('content')
@php
$userLevel = Auth::user()->level;
$upgradeParams = [
    0 => ['key' => 'web.activate_account', 'params' => ['activation_fee' => '3,000', 'earning' => '5,000']],
    1 => ['key' => 'web.upgrade_level', 'params' => ['level' => 2, 'upgrade_fee' => '2,500', 'earning' => '10,000']],
    2 => ['key' => 'web.upgrade_level', 'params' => ['level' => 3, 'upgrade_fee' => '5,000', 'earning' => '40,000']],
    3 => ['key' => 'web.upgrade_level', 'params' => ['level' => 4, 'upgrade_fee' => '16,000', 'earning' => '256,000']],
    4 => ['key' => 'web.upgrade_level', 'params' => ['level' => 5, 'upgrade_fee' => '56,000', 'earning' => '1,792,000']],
    5 => ['key' => 'web.upgrade_level', 'params' => ['level' => 6, 'upgrade_fee' => '350,000', 'earning' => '22,400,000']],
];
@endphp

@if(isset($upgradeParams[$userLevel]))
<div class="alert alert-success"> {!! __($upgradeParams[$userLevel]['key'], $upgradeParams[$userLevel]['params']) !!} </div>
@endif

<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel2"><i class="la la-road2"></i> @lang('web.upgrade_modal_title', ['amount' => number_format($pay_amount)])</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="registerForm" method="post">
                <div class="modal-body">
                    <h5><i class="icon-arrow-right"></i> <b class="text-danger">@lang('web.select_upgrade_method')</b></h5>
                    <div class="input-group">
                        <ul class="list-group col-sm-12">
                            <li class="list-group-item p-3">
                                <input type="radio" class="check" id="flat-radio-1" name="payment_method" checked data-radio="iradio_flat-red" value="wallet">
                                <label for="flat-radio-1">{!! __('web.upgrade_with_wallet', ['amount' => number_format($pay_amount)]) !!}</label>
                            </li>
                            <li class="list-group-item p-3">
                                <input type="radio" class="check" id="flat-radio-2" name="payment_method" data-radio="iradio_flat-red" value="paystack">
                                <label for="flat-radio-2">@lang('web.upgrade_with_card')</label>
                                <img src="/assets/images/paystack-ii.png" alt="PAYSTACK" class="img-fluid">
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">@lang('web.close')</button>
                    <button type="submit" class="btn btn-outline-info waves-effect waves-light">@lang('web.make_payment')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-header bg-light">
                <h3 class="m-b-0 text-dark">@lang('web.user_summary')</h3>
            </div>
            <div class="card-body">
                <script src="https://js.paystack.co/v1/inline.js"></script>
                @if($userLevel < 1)
                <a onclick="payWithPaystack()" id="buttonText" href="javascript:void(0)" class="btn btn-outline-info">@lang('web.activate_your_account')</a>
                @elseif($userLevel < 6)
                <a href="javascript:void(0)" id="buttonText" data-toggle="modal" data-target="#modal" class="btn btn-outline-success">@lang('web.upgrade_to_next_level')</a>
                @else
                <div class="alert alert-success"> @lang('web.you_did_it') </div>
                @endif

                <table class="table mt-3">
                    <tbody>
                        <tr>
                            <td>@lang('web.level')</td>
                            <td class="{{ $userLevel == 0 ? 'text-danger' : '' }}">{{ $userLevel == 0 ? __('web.not_activated') : $userLevel }}</td>
                        </tr>
                        <tr>
                            <td>@lang('web.total_benefits')</td>
                            <td class="text-success">฿{{number_format($transIn)}}</td>
                        </tr>
                        <tr>
                            <td>@lang('web.total_withdrawal')</td>
                            <td class="text-danger">฿{{number_format($transOut)}}</td>
                        </tr>
                        <tr>
                            <td>@lang('web.joined')</td>
                            <td class="text-dark">{{ Auth::user()->created_at->format("d-M-Y") }}</td>
                        </tr>
                        @if($userLevel > 0)
                        <tr>
                            <td>@lang('web.referral_link')</td>
                            <td><a class="text-info" href="http://e-earners.com/register?ref={{Auth::user()->username}}">http://e-earners.com/register?ref={{Auth::user()->username}}</a></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-success">
            <div class="card-header bg-light">
                <h3 class="m-b-0 text-dark">@lang('web.sponsor_details')</h3>
            </div>
            <div class="card-body">
                <table class="table mt-3">
                    <tbody>
                        <tr>
                            <td>@lang('web.name')</td>
                            <td>{{ optional($upline)->name ?? __('web.nil') }}</td>
                        </tr>
                        <tr>
                            <td>@lang('web.username')</td>
                            <td>{{ optional($upline)->username ?? __('web.nil') }}</td>
                        </tr>
                        <tr>
                            <td>@lang('web.email')</td>
                            <td>{{ optional($upline)->email ?? __('web.nil') }}</td>
                        </tr>
                        <tr>
                            <td>@lang('web.phone')</td>
                            <td>{{ optional($upline)->phone ?? __('web.nil') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="card border-success mt-2">
            <div class="card-header bg-info">
                <h3 class="m-b-0 text-white">@lang('web.how_it_works')</h3>
            </div>
            <div class="card-body">
                <h5><b>@lang('web.strategy_title')</b></h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr><td>@lang('web.hwi_l1_title')</td></tr>
                            <tr><td>@lang('web.hwi_l1_desc')</td></tr>
                            <tr><td>@lang('web.hwi_l2_title')</td></tr>
                            <tr><td>@lang('web.hwi_l2_desc')</td></tr>
                            <tr><td>@lang('web.hwi_l3_title')</td></tr>
                            <tr><td>@lang('web.hwi_l3_desc')</td></tr>
                            <tr><td>@lang('web.hwi_l4_title')</td></tr>
                            <tr><td>@lang('web.hwi_l4_desc')</td></tr>
                            <tr><td>@lang('web.hwi_l5_title')</td></tr>
                            <tr><td>{!! __('web.hwi_l5_desc') !!}</td></tr>
                            <tr><td>@lang('web.hwi_l6_title')</td></tr>
                            <tr><td>{!! __('web.hwi_l6_desc') !!}</td></tr>
                            <tr><td>@lang('web.hwi_bonus_title')</td></tr>
                            <tr><td>@lang('web.hwi_bonus_desc')</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div id="daModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('web.damodal_title')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="post" action="/activate-user">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <p>@lang('web.damodal_warning')</p>
                    </div>
                    <input type="radio" name="upgrade" value="balance" checked> @lang('web.damodal_use_balance')
                    <br>
                    <input type="radio" name="upgrade" value="paystack"> @lang('web.damodal_use_paystack')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('web.close')</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">@lang('web.damodal_activate_user')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: '{{$paystack_key}}',
            email: '{{Auth::user()->email}}',
            amount: {{$pay_amount * 100}},
            currency: "NGN",
            ref: '' + Math.floor((Math.random() * 1000000000) + 1),
            metadata: {
                custom_fields: [{
                    display_name: "Mobile Number",
                    variable_name: "mobile_number",
                    value: "{{Auth::user()->phone}}"
                }, {
                    display_name: "Username",
                    variable_name: "username",
                    value: "{{Auth::user()->username}}"
                }]
            },
            callback: function(response) {
                document.getElementById("buttonText").innerHTML = '<h3>@lang("web.js_processing") <i class="fa fa-spinner fa-spin fa-1x fa-fw" aria-hidden="true"></i></h3>';

                $.ajax({
                    url: '/verify/' + response.reference,
                    method: 'GET'
                }).done(function(data) {
                    location.reload();
                }).fail(function(err) {
                    // Improved error message display
                    var errorMessage = "An unknown error occurred.";
                    if (err.responseJSON && err.responseJSON.message) {
                        errorMessage = err.responseJSON.message;
                    } else if (err.responseText) {
                        errorMessage = err.responseText;
                    }
                    swal("Opps!", "@lang('web.js_transaction_failed', ['error' => ''])" + errorMessage, "error");
                    document.getElementById("buttonText").innerHTML = '@lang("web.js_activate_button")'; // Restore button text
                });
            },
            onClose: function() {
                //   alert('window closed');
            }
        });
        handler.openIframe();
    }
</script>
@endsection