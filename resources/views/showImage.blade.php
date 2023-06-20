@extends('main')

@section('content')

  <body>

    <!-- Content Header (Page header) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid d-flex justify-content-end m-3">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('fetchall') }}">Manage
                ToDo List</a></li>
            <li class="breadcrumb-item active">Preview Image</li>
          </ol>
        </nav>

      </div>
    </nav>
    <!-- /.content-header -->

    {{-- edit image modal start --}}
    <div class="modal fade" id="editImageModal" tabindex="-1"
      aria-labelledby="exampleModalLabel" data-bs-backdrop="static"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <form action="#" method="POST" id="edit_image_form"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="todo_id" id="todo_id">
            <input type="hidden" name="todo_image" id="todo_image">
            <div class="modal-body p-4 bg-light">
              <div class="my-2">
                <label for="image">Select Image</label>
                <input type="file" name="image" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Close</button>
              <button type="submit" id="edit_image_btn"
                class="btn btn-success">Update Image</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- edit image modal end --}}

  </body>

  <body class="bg-light" id="preview_image">

    <div class="container">
      <div class="row my-5">
        <div class="col-lg-12">
          <div class="card shadow">
            <div
              class="card-header bg-dark d-flex justify-content-between align-items-center">
              <h1 class="text-light mx-auto">Preview Image</h1>
            </div>
            <div class="card-body mx-auto">
              <div class="form-group align-items-center">
                <div class="mb-3">
                  @if ($todo->images?->image)
                    <img
                      src="{{ asset('storage/images/' . $todo->images?->image) }}"
                      class="img-thumbnail">
                  @endif
                </div>
                <div class="input-group">
                  <a href="#" id="{{ $todo->id }}"
                    class="text-success mx-1 editImageIcon" data-bs-toggle="modal"
                    data-bs-target="#editImageModal"><i
                      class="bi-pencil-square h3"></i> Edit Image</a>

                  <a href="#" id="{{ $todo->id }}"
                    class="text-danger mx-1 deleteImageIcon"><i
                      class="bi-trash h3"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  </body>
@endsection
