@extends('layouts.web')
@section('title', __('web.payment') . ' || e-earners')

@section('breadtitle', __('web.withdrawal_request'))

@section('breadli')
<li class="breadcrumb-item active">{{__('web.withdrawal')}}</li>               
@endsection

@section('content')
                    <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{__('web.withdrawal_request')}}</h4>
                                <h6 class="card-subtitle">{{__('web.pay_every_24hrs')}}</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('web.name')}}</th>
                                                <th>{{__('web.amount')}}</th>
                                                <th>{{__('web.username')}}</th>
                                                <th>{{__('web.email')}}</th>
                                               
                                                <th>{{__('web.phone')}}</th>
                                                <th>{{__('web.level')}}</th>
                                                <th>{{__('web.balance')}}</th>
                                                <th>{{__('web.action')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>₦{{ !$user ? 0 : number_format($user->amount) }}</td>
                                               
                                                <td>{{$user->username}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->level}}</td>
                                                <td>₦{{ !$user ? 0 : number_format($user->balance) }}</td>
                                                <td>
                                                <button  data-toggle="modal" data-target="#daModal{{$user->id}}" class="btn btn-success btn-sm"><i class="fa fa-lg fa-eye"></i></button>
                                                </td>
                                            </tr>

                                            <!-- modal -->
                                <div id="daModal{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{__('web.activate_user_modal_title')}}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form method="post" action="/payment/{{$user->trans_id}}">
                                            <div class="modal-body">
                                                
                                                        @csrf

                                                                <h5>{{__('web.bank_name')}}:&nbsp;  {{$user->bank_name}}</h5>
                                                                <h5>{{__('web.account_name')}}: &nbsp; {{$user->account_name}}</h5>
                                                                <h5>{{__('web.account_number')}}:&nbsp; <b> {{$user->account_no}}</b></h5>
                                                                <h5>{{__('web.username')}}:&nbsp;  {{$user->username}}</h5>
                                                                <h5>{{__('web.amount')}}:&nbsp;   {{$user->amount}}</h5>
                                            
                                                    
                                                    <div class="form-group">
                                                       
                                                        <input type="text" class="form-control" name="username" value="{{$user->username}}" hidden>
                                                    </div>
                                                                                            

                                                 <span class="text-danger">{{__('web.ensure_user_paid_message')}} </span>  
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">{{__('web.close')}}</button>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light">{{__('web.confirm_payment_made')}}</button>
                                             
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                       
   
@endsection