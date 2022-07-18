<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: admin/members/index.blade.php
# Created on: JULY 2018
# Purpose: Manage functionality for memebers at admin panel
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/
?>

@extends('admin.adminlayout')

@section('page-header')
   Members <small>{{ trans('app.manage') }}</small>
@stop

@section('content')
	<div class="row">
	  <div class="col-xs-12">
      <div class="box" style="border:1px solid #d2d6de;" >
	      <div class="box-header" style="background-color:#f5f5f5;border-bottom:1px solid #d2d6de;">
	      </div>

	      <!-- /.box-header -->
	      <div class="box-body table-responsive no-padding">
	        <table id="tbl" class="table data-tables table-striped table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th width="7%">Sr. No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registration Date</th>
                        <th class='bool text-center'>Status</th>
                        <th class='text-center'>View Predictions</th>
                        <th class="no-sort">Action</th>
                    </tr>
                </thead>

                <tbody>
                  <?php $i = 1; ?>
        					@foreach ($arrMembers as $item)
          						<tr>
                          <td>{{ $i++ }}</td>
                          <td><a href="{{ route(ADMIN . '.members.edit', $item->id) }}">{{ ucwords($item->first_name.' '.$item->last_name) }}</a></td>
                          <td>{{ $item->email }}</td>
                          <td>{{ date('d-F-Y', strtotime($item->created_at)) }}</td>
                          <td>{{ getStatus($item->isActive) }}</td>
                          <td class="text-center">
                            <a target="_blank" class="btn btn-success" title="{{ trans('app.view_title') }}" href="{{route(ADMIN.'.showpredictions', ['memebrId' => base64_encode($item->id)])}}">View</a>
                          </td>
                          <td class="actions">
                              <ul class="list-inline" style="margin-bottom:0px;">
                                  <!-- Edit -->
                                  <li><a href="{{ route(ADMIN . '.members.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a></li>
                                  <!-- View -->
                                  <li><a href="{{ route(ADMIN . '.members.show', $item->id) }}" title="{{ trans('app.view_title') }}" class="btn btn-info btn-xs"><i class="fa fa-globe"></i></a></li>
                                  <!-- Delete -->
                                  <li>
                                      {!! Form::open([
                                          'class'=>'delete',
                                          'url'  => route(ADMIN . '.members.destroy', $item->id),
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

      //replace bool column to checkbox
      //renderBoolColumn('#tbl','bool');
    })(jQuery); 

  </script>
@stop
