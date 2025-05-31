@extends('adminlte::page')

@section('title', 'Edit Category')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-sm-6">
                <h1 class="m-0 text-decoration-underline">Edit: {{ $category->title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </div>
        </div>
    </div>

@stop

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-dismissable alert-danger mt-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Whoops!</strong> There were some problems with your input.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class=" justify-content-between pb-5">

            <form role="form" method="post" action="{{ route('category.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-light">
                            <div class="card-header">
                                <h3 class="card-title">Edit Category</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputStatus">Title</label>
                                    <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" placeholder="Title here.." value="{{ old('title', $category->title) }}">
                                    @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputStatus">Description</label>
                                    <textarea class="form-control" name="description" id="" cols="30" rows="5">{!! $category->description !!}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select required="required" name="status" id="inputStatus" class="form-control custom-select">
                                        <option disabled value="">Select Option</option>
                                        <option value="1" {{ old('published', $category->status) == 1 ? 'selected' : '' }}>Published</option>
                                        <option value="0" {{ old('published', $category->status) == 0 ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="image">Featured Image</label>
                                    <div class="justify-content-between">
                                        <div>
                                            <input class="form-control mt-2" name="image" accept="image/*" type="file" id="imgInp">
                                        </div>
                                        <div>
                                            @if ($category->image)
                                                <img class="img-fluid" style="width: 150px; margin-top:10px; border:1px solid black;" id="blah" src="{{ asset($category->image) }}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@stop

@section('css')

@stop

@section('js')
    {{-- show image --}}
    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
@stop
