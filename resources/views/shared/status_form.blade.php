<form action="{{ route('statuses.store') }}" method="post">
	@include('shared.errors')
	{{ csrf_field() }}
	<textarea name="content" id="conten" class="form-control" rows="3" placeholder="please input">
		{{ old('content') }}
	</textarea>
	<button type="submit" class="btn btn-primary pull-right">发布</button>
</form>