@extends('adminlte::page')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-dismissable alert-danger mt-3">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>Whoops!</strong> There were some problems with your input.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-md-12">
                <h5>
                    <a href="{{ route('category.create') }}" class="btn btn-primary mb-1"><i class="fas fa-fw fa-plus"></i> Add New</a>
                </h5>
                <div class="card p-2">
                    <div id="" class="card-body p-0">
                        <table id="myTable" class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th style="width: 20%">Name</th>
                                    <th style="width: 50%">Description</th>
                                    <th style="width: 7%">Status</th>
                                    <th style="width: 25%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a>{{ $category->title }}</a></td>
                                        <td><a>{{ $category->description }}</a></td>
                                        <td>
                                            @if ($category->status)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">In active</span>
                                            @endif
                                        </td>
                                        <td class="project-actions text-right d-flex">
                                            <div>
                                                <a class="btn btn-info btn-sm ml-2" href="{{ route('category.edit', $category->id) }}">
                                                    <i class="fas fa-pencil-alt"></i> Edit
                                                </a>
                                            </div>
                                            <div>
                                                <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Category cannot be deleted - Post attached');" class="btn btn-danger btn-sm ml-2">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>
@endsection