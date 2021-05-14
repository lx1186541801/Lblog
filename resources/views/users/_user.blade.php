<div class="list-group-item">
	<img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="mr-3" width="32" />
	<a href="{{ route('users.show', $user) }}">{{ $user->name }}</a>
	@can('destroy', $user)
		<form action="{{ route('users.destroy', $user) }}" method="POST" class="float-right">
			@csrf
			@method('DELETE')
			<button class="btn btn-sm btn-danger delete-btn" type="submit">删除</button>
		</form>
	@endcan
</div>