@extends('layouts.default')
@section('title', $user->name)

@section('content')

<div class="row">
	<div class="col-md-10">
		<div class="col-md-12">
			<div class="offset-md-2 col-md-10">
				<section class="user_info">
					@include('shares._user_info', ['user' => $user])
				</section>
				<section class="stats mt-2">
					@include('shares._stats')
				</section>

				<section class="status">
					@if(count($statuses) > 0)
						<ul class="list-unstyled">
							@foreach ($statuses as $status)
								@include('shares._status')
							@endforeach
						</ul>

						<div class="mt-5">
							{!! $statuses->render() !!}
						</div>
					@else
						<p>没有数据！</p>
					@endif
				</section>
			</div>
		</div>
	</div>
</div>
@stop