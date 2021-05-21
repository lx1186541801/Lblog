@can('follow', $user)

    <div class="text-center mt-2 mb-4">
    	@if (Auth::user()->isFollowing($user))
    		<form action="{{ route('followers.destroy', $user) }}" method="POST">
    			@csrf
    			@method('DELETE')
    			<button class="btn btn-sm btn-outline-primary" type="submit">取消关注</button>
    		</form>
    	@else
    		<form action="{{ route('followers.store', $user) }}" method="POST">
    			@csrf
    			@method('POST')

    			<button class="btn btn-sm btn-primary" type="submit">关注</button>
    		</form>

    	@endif
    </div>
@endcan