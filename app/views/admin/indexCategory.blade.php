@extends('layouts.admin')

@section('title')
	@parent
	:: Categories list
@stop

@section('styles')
	{{ HTML::style('css/datatables/dataTables.bootstrap.css') }}
@stop

@section('javascripts')
    {{ HTML::script('js/datatables/jquery.dataTables.min.js') }}
    {{ HTML::script('js/datatables/dataTables.bootstrap.js') }}
	<script>
		$(document).ready(function() {
			$('#postList').dataTable({
				"bLengthChange": false,
				"iDisplayLength": 20,
				'aoColumnDefs': [{"bSortable" : false,"aTargets" : [ -1 ]}],
			    "bFilter": false,
			});
		} );
	</script>
@stop

@section('content')
	<h2>@lang('messages.category_list')</h2>
	<div class="row">
		<div class="col-md-3 col-sm-4 col-xs-12 pull-right">
			<a data-toggle="modal" data-target="#createModal" class="btn btn-primary btn-lg btn-block">@lang('messages.category_create')</a>
		</div>
	</div>
	<div class="row">
		<table id="postList" class="col-md-12 table table-striped table-bordered">
			<thead>
				<tr>
					@foreach ($languages as $abbrlang => $lang)
						<th>{{$lang}}</th>
					@endforeach
					<th class="no-sort">@lang('messages.post_actions')</th>
				</tr>
			</thead>
			<tbody>
					@foreach($categories as $category)
						<tr>
							@foreach ($languages as $abbrlang => $lang)
								<th>
									<?php 
										$nameLang = "name_".$abbrlang;
										echo $category->$nameLang;
									?>
								</th>
							@endforeach
							<td>
								<a href="{{route('deleteCategory',['id'=>$category->id])}}" class="btn btn-danger">Delete</a>
							</td>
						</tr>
					@endforeach
			</tbody>
		</table>
	</div>
	<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				{{Form::open(['url' => route('createCategory'),'class'=>'form-horizontal'])}}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel">@lang('messages.category_create')</h4>
					</div>
					<div class="modal-body">
						...
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				{{Form::close()}}
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

@stop
