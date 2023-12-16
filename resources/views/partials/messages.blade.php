@if ($message = Session::get('success'))
		<div class="alert alert-success alert-dismissible" role="alert">
			<div class="d-flex">
				<div>
					<i class="ti ti-check alert-icon icon"></i>
				</div>
				<div>
					<div class="alert-title">
						@if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
						@else {{ $message }} @endif
					</div>
				</div>
			</div>
			<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
		</div>
@endif 
@if ($message = Session::get('error'))
		<div class="alert alert-danger alert-dismissible" role="alert">
			<div class="d-flex">
				<div>
					<i class="ti ti-alert-circle alert-icon icon"></i>
				</div>
				<div>
					<div class="alert-title">
						@if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
						@else {{ $message }} @endif
					</div>
				</div>
			</div>
			<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
		</div>
@endif
@if ($message = Session::get('warning'))
		<div class="alert alert-warning alert-dismissible" role="alert">
			<div class="d-flex">
				<div>
					<i class="ti ti-alert-triangle alert-icon icon"></i>
				</div>
				<div>
					<div class="alert-title">
						@if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
						@else {{ $message }} @endif
					</div>
				</div>
			</div>
			<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
		</div>
@endif
@if ($message = Session::get('info'))
		<div class="alert alert-info alert-dismissible" role="alert">
			<div class="d-flex">
				<div>
					<i class="ti ti-info-circle alert-icon icon"></i>
				</div>
				<div>
					<div class="alert-title">
						@if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
						@else {{ $message }} @endif
					</div>
				</div>
			</div>
			<a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
		</div>
@endif