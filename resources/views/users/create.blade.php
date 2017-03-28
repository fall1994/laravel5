@extends('layouts.default')
@section('title', '注册')

@section('content')
	<div class="col-md-offset-2 col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>注册</h5>
			</div>
			<div class="panel-body">
				 @include('shared.errors')
				<form action="{{ route('users.store') }}" method="post">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="name">名称：</label>
						<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<label for="email">邮箱：</label>
						<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
					</div>
					<div class="form-group">
						<label for="password">密码：</label>
						<input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
					</div>
					<div class="form-group">
						<label for="password_confirmation">密码：</label>
						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
					</div>

					<button type="submit" class="btn btn-primary">注册</button>
				</form>
			</div>
		</div>
	</div>
@stop