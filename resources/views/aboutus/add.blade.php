@extends('layouts.dashboard')

@section('title') About Us Add @endsection
@section('page_pre_title')  @endsection
@section('page_title') About Us Add @endsection

@section('content')
<div class="col-md-8">
	<div class="card">
		<div class="card-body">

			{!! Form::open(['url' => route('cms.aboutus.add'), 'files' => true]) !!}

			   <div class="form-group">
                    {!! Form::label('category', 'Category', ['class' => 'form-label']) !!}
                    <div> 
                         <select class="form-select form-control" name="category" id="category">
                        <option value="0" selected='selected' disabled="disabled">Select the Module</option>
                        @foreach($category_name as $item)
                        <option value="{{$item['category']}}">{{$item['category']}}</option>
                        @endforeach
                       </select>
                    </div>
                    @if ($errors->has('category'))
                        <div class="text-danger">
                            <p>{{ $errors->first('category') }}</p>
                        </div>
                    @endif
                </div>

				<div class="form-group ">
					{!! Form::label('slug', 'Slug', ['class' => 'form-label']) !!}
					<div> 
						{!! Form::text('slug', null, ['class' => 'form-control']) !!}
					</div>
					@if ($errors->has('slug'))
                        <div class="text-danger">
                            <p>{{ $errors->first('slug') }}</p>
                        </div>
                    @endif
				</div>

				<div class="form-group mt-2">
					{!! Form::label('page_content', 'Page Contents', ['class' => 'form-label']) !!}
					<div>
						{!! Form::textarea('page_content', null, ['class' => 'form-control mce-content-body', 'id' => 'tiny-mce-editor', 'data-id' => 'tinymce-mytextarea', 'contenteditable' => 'true']) !!}
					</div>
					@if ($errors->has('page_content'))
                        <div class="text-danger">
                            <p>{{ $errors->first('page_content') }}</p>
                        </div>
                    @endif
				</div>

				<div class="form-group ">
					{!! Form::label('title', 'Title', ['class' => 'form-label']) !!}
					<div> 
						{!! Form::text('title', null, ['class' => 'form-control']) !!}
					</div>
					@if ($errors->has('title'))
                        <div class="text-danger">
                            <p>{{ $errors->first('title') }}</p>
                        </div>
                    @endif
				</div>

				<div class="form-group mt-2">
					{!! Form::label('sub_contents', 'Sub Contents', ['class' => 'form-label']) !!}
					<div>
						{!! Form::textarea('sub_contents', null, ['class' => 'form-control mce-content-body', 'id' => 'tiny-mce-editor', 'data-id' => 'tinymce-mytextarea', 'contenteditable' => 'true']) !!}
					</div>
					@if ($errors->has('sub_contents'))
                        <div class="text-danger">
                            <p>{{ $errors->first('sub_contents') }}</p>
                        </div>
                    @endif
				</div>

				<div class="form-group mt-2">
					{!! Form::label('is_active', 'IsActive', ['class' => 'form-label']) !!}
					<div>
						<input type="checkbox" name="is_active" class="form-check-input" value="1" />
					</div>
					@if ($errors->has('is_active'))
                        <div class="text-danger">
                            <p>{{ $errors->first('is_active') }}</p>
                        </div>
                    @endif
				</div>

				<div class="form-footer">
					<a class="btn btn-light" href="{{ route('cms.aboutus.list') }}">Cancel</a> 
					{!! Form::submit('Save', ['class' => 'btn btn-warning']) !!}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('scripts')
    @include('components.tiny-mce.tinymce-config')
	<script>
		$(document).ready(function() {
			$("#category").on('change', function(e) {
			e.preventDefault();
			if ($("#category").length > 0) {
				var value = $(this).val().toLowerCase();
				value = value.replace(/\s+/g, '-');
				$('#slug').val(value);
			}
		});
    });
	</script>
@endsection