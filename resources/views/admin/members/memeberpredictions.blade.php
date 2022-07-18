<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: admin/members/userpredictions.blade.php
# Created on: JULY 2018
# Purpose: Manage  memebr predictions at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/
?>

@extends('admin.adminlayout')

@section('page-header')
   Member Predictions <small>{{ trans('app.manage') }}</small>
@stop

@section('content')
 <div class="row">
    <div class="col-xs-12">
      <div class="box" style="border:1px solid #d2d6de;" >
        <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
            <div class="div-left">
              <strong><p>Name: {{ $arrMembers->first_name }} {{ $arrMembers->last_name }}</p>
              <p>Email: {{ $arrMembers->email }}</p></strong>
            </div>
            <div class="div-right" id="total_points"></div>
        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
          <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="7%">Sr. No</th>
                        <th>Event Name</th>
                        <th>Team Name1</th>
                        <th>Predicted Score</th>
                        <th>Actual Score</th>
                        <th>Team Name2</th>
                        <th>Predicted Score</th>
                        <th>Actual Score</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                  @php $i = 1;$intTotalPoi = 0; @endphp
                  @foreach ($arrUserPredictions as $item)
                      <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $item['event_name'] }}</a></td>
                          <td>{{ $item['name_team1'] }}</a></td>
                          <td>{{ $item['pred_score_team1'] }}</td>
                          <td>{{ ($item['score_team1']) ? $item['score_team1'] : '-' }}</a></td>
                          <td>{{ $item['name_team2'] }}</a></td>
                          <td>{{ $item['pred_score_team2'] }}</td>
                          <td>{{ ($item['score_team2']) ? $item['score_team2'] : '-' }}</a></td>
                          <td>
                            @if($item['point']!='1')
                                    {{ '- ' }}
                            @else
                                {{ $item['point'] }}
                                @php
                                  $intTotalPoi++;
                                @endphp
                            @endif
                           </td>
                      </tr>
                  @endforeach
             </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
@stop

@section('js')
  <script>
    (function($) {

      var table = $('.data-tables').DataTable({
        "columnDefs": [{
           "targets": 'no-sort',
           "orderable": false,
         }],
      });
    })(jQuery); 

    //Show total point count
    $(document).ready(function () {
      $("#total_points").append('<h2 style="float:right; margin-right:5px;">Total Points: {{$intTotalPoi}}</h2>');
    });
  </script>
@stop
