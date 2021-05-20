<a href="#">
	<strong class="stat" id="following">
		{{ count($user->followings) }}
	</strong>
	 关注
</a>

<a href="#">
	<strong class="stat" id="followers">
		{{ count($user->followers) }}
	</strong>
	粉丝
</a>

<a href="{{ route('users.show', $user) }}">
	<strong class="stat" id="statuses">
		{{ $user->statuses()->count() }}
	</strong>
	动态
</a>
