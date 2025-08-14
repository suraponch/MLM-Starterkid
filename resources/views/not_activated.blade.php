@extends('layouts.web')

@section('title', __('web.referrals_not_activated') . ' || e-earners')

@section('breadtitle', __('web.pending_activation'))

@section('breadli')
<li class="breadcrumb-item active">{{__('web.not_activated')}}</li>               
@endsection

@section('content')
<div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{__('web.your_referrals_yet_to_activate')}}</h4>
                              
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('web.name')}}</th>
                                                <th>{{__('web.username')}}</th>
                                             
                                                <th>{{__('web.joined')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->username}}</td>
                                              
                                                <td>{{date("m/d/y g:i A", strtotime($user->created_at))}}</td>
                                            </tr>

                          
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
@endsection