@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
               &nbsp;
            </div>
            <div class="pull-right">
               &nbsp;
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
	<table width="98%" class="table table-bordered" border="1">
        <tr>
           <td width="50%"><b>Active Events</b></td>
		   <td width="10px">&nbsp;</td>
		   <td><b>Top Predictors</b></td>
        </tr>
		<tr>
           <td>
		   		<!-- For Events -->				
				@foreach($events as $event)	
					<form method="post" action="">
					<table width="98%" >
					<tr><td style='background-color:#E7C1C0' colspan="3">{{ $event->event_name }}</td></tr>	
					@foreach($subevents as $subevent)
						@if($subevent->eventid == $event->id)
							<tr style='background-color:#E0E6E6'>
								<td width="40%" align="center">LOGO</td>
								<td align="center" rowspan="3">VS</td>
								<td width="40%" align="center">LOGO</td>
							</tr>	
							<tr style='background-color:#E0E6E6'>
								<td align="center">{{ $subevent->name_team1 }}</td>
								<td align="center">{{ $subevent->name_team2 }}</td>
							</tr>
							<tr style='background-color:#E0E6E6'>
								<td align="center"><input name="score_team1[]" type="text" size="10" value="{{$subevent->id}}"></td>
								<td align="center"><input name="score_team2[]" type="text" size="10" value="{{$subevent->id}}"></td>
							</tr>	
							<tr><td style='background-color:#E0E6E6' colspan="3">&nbsp;</td></tr>
							{{ Form::hidden('subeventid[]', $subevent->id) }}
						@else 	
						@endif
					@endforeach
					{{ Form::hidden('event', $event->id) }}
					<tr><td style='background-color:#E0E6E6' colspan="3" align="center"><button  type="button" class="btn btn-primary" id="ajaxScoreSubmit">Submit</button></td></tr>	
					</table>
					</form>
				@endforeach				
				<!-- End Events -->
		   </td>
		   <td>&nbsp;</td>
		   <td>
				<!-- For Predictors -->
				<!-- End Predictors -->
		   </td>
        </tr>	
	</table>	
@endsection	