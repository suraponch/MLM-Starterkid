@extends('layouts.web')

@section('title', __('web.referrals') . ' || e-earners')

@section('breadtitle', __('web.my_referrals'))

@section('breadli')
<li class="breadcrumb-item active">{{__('web.referrals')}}</li>               
@endsection

@section('content')
         
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">{{__('web.level_one_referrals')}}</h4>
                              
                                <div class="table-responsive">
                                    <table id="one" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{__('web.name')}}</th>
                                                <th>{{__('web.username')}}</th>
                                                <th>{{__('web.level')}}</th>
                                                <th>{{__('web.joined')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($ones as $one)
                                            <tr>
                                                <td>{{$one->name}}</td>
                                                <td>{{$one->username}}</td>
                                                <td>{{$one->level}}</td>
                                                <td>{{date("d-M-Y", strtotime($one->created_at))}}</td>
                                            </tr>

                          
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
  
  
  <!-- level two -->

  @if($twos->count())
         
         <div class="card">
             <div class="card-body">
                 <h4 class="card-title">{{__('web.level_two_referrals')}}</h4>
               
                 <div class="table-responsive">
                     <table id="two" class="table table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th>{{__('web.name')}}</th>
                                 <th>{{__('web.username')}}</th>
                                 <th>{{__('web.level')}}</th>
                                 <th>{{__('web.joined')}}</th>
                             </tr>
                         </thead>
                         <tbody>
                         @foreach ($twos as $two)
                             <tr>
                                 <td>{{$two->name}}</td>
                                 <td>{{$two->username}}</td>
                                 <td>{{$two->level}}</td>
                                 <td>{{date("d-M-Y", strtotime($two->created_at))}}</td>
                             </tr>

           
                         @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
@endif

<!-- level three -->

@if($threes->count())
         
         <div class="card">
             <div class="card-body">
                 <h4 class="card-title">{{__('web.level_three_referrals')}}</h4>
               
                 <div class="table-responsive">
                     <table id="three" class="table table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th>{{__('web.name')}}</th>
                                 <th>{{__('web.username')}}</th>
                                 <th>{{__('web.level')}}</th>
                                 <th>{{__('web.joined')}}</th>
                             </tr>
                         </thead>
                         <tbody>
                         @foreach ($threes as $three)
                             <tr>
                                 <td>{{$three->name}}</td>
                                 <td>{{$three->username}}</td>
                                 <td>{{$three->level}}</td>
                                 <td>{{date("d-M-Y", strtotime($three->created_at))}}</td>
                             </tr>

           
                         @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
@endif

<!-- level four -->


@if($fours->count())
         
         <div class="card">
             <div class="card-body">
                 <h4 class="card-title">{{__('web.level_four_referrals')}}</h4>
               
                 <div class="table-responsive">
                     <table id="three" class="table table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th>{{__('web.name')}}</th>
                                 <th>{{__('web.username')}}</th>
                                 <th>{{__('web.level')}}</th>
                                 <th>{{__('web.joined')}}</th>
                             </tr>
                         </thead>
                         <tbody>
                         @foreach ($fours as $four)
                             <tr>
                                 <td>{{$four->name}}</td>
                                 <td>{{$four->username}}</td>
                                 <td>{{$four->level}}</td>
                                 <td>{{date("d-M-Y", strtotime($four->created_at))}}</td>
                             </tr>

           
                         @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
@endif



@if($fives->count())
         
         <div class="card">
             <div class="card-body">
                 <h4 class="card-title">{{__('web.level_five_referrals')}}</h4>
               
                 <div class="table-responsive">
                     <table id="three" class="table table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th>{{__('web.name')}}</th>
                                 <th>{{__('web.username')}}</th>
                                 <th>{{__('web.level')}}</th>
                                 <th>{{__('web.joined')}}</th>
                             </tr>
                         </thead>
                         <tbody>
                         @foreach ($fives as $five)
                             <tr>
                                 <td>{{$five->name}}</td>
                                 <td>{{$five->username}}</td>
                                 <td>{{$five->level}}</td>
                                 <td>{{date("d-M-Y", strtotime($five->created_at))}}</td>
                             </tr>

           
                         @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
@endif



@if($sixs->count())
         
         <div class="card">
             <div class="card-body">
                 <h4 class="card-title">{{__('web.level_six_referrals')}}</h4>
               
                 <div class="table-responsive">
                     <table id="three" class="table table-bordered table-striped">
                         <thead>
                             <tr>
                                 <th>{{__('web.name')}}</th>
                                 <th>{{__('web.username')}}</th>
                                 <th>{{__('web.level')}}</th>
                                 <th>{{__('web.joined')}}</th>
                             </tr>
                         </thead>
                         <tbody>
                         @foreach ($sixs as $six)
                             <tr>
                                 <td>{{$six->name}}</td>
                                 <td>{{$six->username}}</td>
                                 <td>{{$six->level}}</td>
                                 <td>{{date("d-M-Y", strtotime($six->created_at))}}</td>
                             </tr>

           
                         @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
@endif
@endsection