@extends('adminlte::page')

@section('title', 'Add Category')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-sm-6">
                <h1 class="m-0">Add Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Category</li>
                </ol>
            </div>
        </div>
    </div>

@endsection

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
            <form role="form" method="post" action="{{ route('category.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-light">
                            <div class="card-header">
                                <h3 class="card-title">Add New Category</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputStatus">Title</label>
                                    <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" placeholder="Title here.." value="{{ old('title') }}">
                                    @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputStatus">Description</label>
                                    <textarea class="form-control" name="description" id="" cols="30" rows="5">{{ old('description') }}</textarea>
                                    @error('excerpt')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="status">Status</label>
                                        <select required="required" name="status" id="inputStatus" class="form-control custom-select">
                                            <option disabled value="">Select Option</option>
                                            <option value="1">Published</option>
                                            <option value="0">Draft</option>
                                        </select>
                                    </div>
    
                                    <div class="form-group col-md-6">
                                        <label class="form-label for="image">Featured Image</label>
                                        <small class="text-red">Note: size: Width-1280px Height: 720px</small>
                                        <input class="form-control" name="image" accept="image/*" type="file" id="imgInp">
                                        <img style="width: 150px; margin-top:10px; border:1px solid black;" id="blah" src="{{ asset('uploads/images/no-image.jpg') }}" alt="">
                                    </div>
                                </div>


                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Publish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection


@section('css')

@endsection



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
@endsection
