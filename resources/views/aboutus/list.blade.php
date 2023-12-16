@extends('layouts.dashboard')

@section('title') About Us List @endsection
@section('page_pre_title') Overview @endsection
@section('page_title')  About Us List @endsection

@section('header_actions')
<div class="col-12 col-md-auto ms-auto d-print-none">
	<div class="btn-list">
		{!! Form::open(['url' => route('cms.aboutus.search')]) !!}
			<div class="row"> 
				<div class="col input-group input-icon product-search-fields">
		            {!! Form::text('q', app('request')->input('q'), ['class' => 'form-control', 'placeholder' => 'Enter name to search...']) !!}
		            <button class="btn" type="submit"><i class="ti ti-search icon"></i></button>
		        </div>
		    </div>
	    {!! Form::close() !!}
	    @php $rolePermission = getPermissions(); @endphp
        @if(in_array('cms.aboutus.add',$rolePermission))
			<a href="{{ route('cms.aboutus.add') }}" class="btn btn-warning d-none d-sm-inline-block">
				<i class="ti ti-plus icon"></i> Create New About Us
			</a>
			<a href="{{ route('cms.aboutus.add') }}" class="btn btn-warning d-sm-none btn-icon"  aria-label="Create new product">
				<i class="ti ti-plus icon"></i>
		    </a>
		@endif
	</div>
</div>
@endsection

@section('content')
<div class="col-12">
	@if($list->count() > 0)
		<div class="card">
			<div class="table-responsive">
				<table class="table table-vcenter card-table table-striped">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Category</th>
							<th>title</th>
							<th>Status</th>
							<th>Created On</th>
							<th>Updated On</th>
							<th class="w-1"></th>
						</tr>
					</thead>
					<tbody>	
						@php $i = 1; @endphp					
						@foreach($list as $product)
							<tr>
								<td>{{ $i }}</td>
								<td>{{ $product->category }}</td>
								<td>{{ $product->title }}</td>
								<td class="text-muted">
									@if($product->is_active)
										<span class="badge bg-teal">Active</span>
									@else
										<span class="badge bg-red">In-active</span>
									@endif
								</td>
								<td>{{ $product->created_date }}</td>
								<td>{{ $product->updated_date }}</td>
								<td> 
									<div class="btn-list flex-nowrap">
										<div class="dropdown">
											<button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown"> 
												<i class="ti ti-settings icon"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-end">
												@if(in_array('cms.aboutus.view',$rolePermission))
												<a class="dropdown-item" href="{{ route('cms.aboutus.view', ['slug' => $product->_id]) }}">
													<i class="ti ti-notes icon"></i> View
												</a>
												@endif
												
												@if(in_array('cms.aboutus.edit',$rolePermission))
												<a class="dropdown-item" href="{{ route('cms.aboutus.edit', ['slug' => $product->_id]) }}">
													<i class="ti ti-edit icon"></i> Edit
												</a>
												@endif

												@if(in_array('cms.aboutus.status',$rolePermission))
												@if($product->is_active)
													<a href="{{ route('cms.aboutus.status', ['slug' => $product->_id, 'type' => 'inactive']) }}" class="dropdown-item confirmation-link">
														<i class="ti ti-x icon"></i> In-Active
													</a>
												@else
													<a href="{{ route('cms.aboutus.status', ['slug' => $product->_id, 'type' => 'active']) }}" class="dropdown-item confirmation-link">
														<i class="ti ti-check icon"></i> Active
													</a>
												@endif
												@endif
									        </div>
										</div>
									</div>
								</td>
							</tr>
							@php $i++; @endphp
						@endforeach						
					</tbody>
				</table>
			</div>	
			<div class="card-footer">				
				{!! $list->links() !!}	
			</div>
		</div>
	@else
		<div class="card">		
			<div class="card-body">				
				<div class="alert alert-warning alert-dismissible" role="alert">
					<div class="d-flex">
						<div>
							<i class="ti ti-alert-triangle icon alert-icon"></i>
						</div>
						<div>
							<h4 class="alert-title">You haven't added product slug yet.</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
</div>
@endsection