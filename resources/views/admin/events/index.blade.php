<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: admin/events/index.blade.php
# Created on: JULY 2018
# Purpose: Manage functionality for memebers at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/
?>

@extends('admin.adminlayout')

@section('page-header')
   Events <small>{{ trans('app.manage') }}</small>
@stop

@section('content')
	<div class="row">
	  <div class="col-xs-12">
      <div class="box" style="border:1px solid #d2d6de;" >
	      <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
          <a class="btn btn-info" href="{{ route(ADMIN . '.events.create') }}" title="Add Event">
            <i class="fa fa-plus" style="vertical-align:middle" ></i> Add Event
          </a>
	      </div>

	      <!-- /.box-header -->
	      <div class="box-body table-responsive no-padding">
	        <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="7%">Sr. No</th>
                        <th>Event Name</th>
                        <th>Month</th>
                        <th width="18%">Number of Subevents</th>
                        <th class='bool text-center'>Status</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>

                <tbody>
                  <?php $i = 1; ?>
        					@foreach ($arrEvents as $item)
          						<tr>
                          <td>{{ $i++ }}</td>
                          <td><a href="{{ route(ADMIN . '.events.edit', $item->id) }}">{{ ucwords($item->event_name) }}</a></td>
                          <td>{{ getMonth($item->month) }}</td>
                          <td>
                            <?php
                              $intSubevents = getSubevents($item->id);
                              if($intSubevents != 0) {
                                ?>
                                <a target="_blank" class="btn btn-success" title="{{ trans('app.view_title') }}" href="{{route(ADMIN.'.showevents', ['eventId' => base64_encode($item->id)])}}">{{ $intSubevents }}</a>
                                <?php
                              }
                              else {
                                echo '0';  
                              }
                            ?>
                          </td>
                          <td>{{ getStatus($item->isActive) }}</td>
                          <td class="actions">
                              <ul class="list-inline" style="margin-bottom:0px;">
                                  <!-- Edit -->
                                  <li><a href="{{ route(ADMIN . '.events.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a></li>
                                  <!-- Delete -->
                                  <li>
                                      {!! Form::open([
                                          'class'=>'delete',
                                          'url'  => route(ADMIN . '.events.destroy', $item->id),
                                          'method' => 'DELETE',
                                          ])
                                      !!}
                                      <button class="btn btn-danger btn-xs" title="{{ trans('app.delete_title') }}"><i class="fa fa-trash"></i></button>
                                      {!! Form::close() !!}
                                  </li>
                              </ul>
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
  </script>
@stop
