@extends('layouts.web')

@section('title', __('web.transactions') . ' || e-earners')

@section('breadtitle', __('web.transactions'))

@section('breadli')
<li class="breadcrumb-item active">{{__('web.transactions')}}</li>               
@endsection

@section('content')
                <!-- ============================================================== -->
                <!-- Info box -->
                <!-- ============================================================== -->
                <div class="card mt-5">
                    <div class="card-body">
                        <h4 class="card-title">{{__('web.transactions')}}</h4>
                        <h6 class="card-subtitle">{{__('web.incoming_and_outgoing')}}</h6>
                        <div class="table-responsive ">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{__('web.username')}}</th>
                                        <th>{{__('web.type')}}</th>
                                        <th>{{__('web.amount')}}</th>
                                        <th>{{__('web.status')}}</th>
                                        <th>{{__('web.date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trans as $tran)
                                    <tr>
                                    <td>{{$tran->username}}</td>
                                        <td>{{$tran->type}}</td>
                                        <td>฿{{$tran->amount}}</td>
                                        <td>{{$tran->status}}</td>
                                        <td>{{$tran->created_at}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
@endsection