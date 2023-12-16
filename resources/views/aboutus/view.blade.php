@extends('layouts.dashboard')

@section('title') View About Us  @endsection
@section('page_pre_title')  @endsection
@section('page_title') View About Us  @endsection

@section('content')
<div class="col-md-8">
	<div class="card">
		<div class="card-body">
			{!! Form::open(['url' => route('cms.aboutus.view', ['slug' => $about->_id]), 'files' => true]) !!}
			   
			  <div class="form-group">
                    {!! Form::label('category', 'Category', ['class' => 'form-label']) !!}
                    <div> 
                        <select class="form-select form-control" name="category" id="category" disabled>
                        <option value="0" selected='selected' disabled="disabled">Select the Module</option>
                        @foreach($category_name as $item)
                        <option value="{{$item['category']}}" @if( $about->category == $item['category']) {{'selected'}} @endif>{{$item['category']}}</option>
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
						{!! Form::text('slug', $about->slug, ['class' => 'form-control', 'readonly' => true]) !!}
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
						{!! Form::textarea('page_content', $about->page_content, ['class' => 'form-control mce-content-body', 'id' => 'tiny-mce-editor', 'data-id' => 'tinymce-mytextarea', 'contenteditable' => 'true', 'readonly' => true]) !!}
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
						{!! Form::text('title', $about->title, ['class' => 'form-control', 'readonly' => true]) !!}
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
						{!! Form::textarea('sub_contents', $about->sub_contents, ['class' => 'form-control mce-content-body', 'id' => 'tiny-mce-editor', 'data-id' => 'tinymce-mytextarea', 'contenteditable' => 'true', 'readonly' => true]) !!}
					</div>
					@if ($errors->has('sub_contents'))
                        <div class="text-danger">
                            <p>{{ $errors->first('sub_contents') }}</p>
                        </div>
                    @endif
				</div>

			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection