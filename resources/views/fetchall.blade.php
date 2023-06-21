@extends('main')

@section('content')
  <header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid d-flex justify-content-end m-3">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">Manage
              ToDo List</li>
          </ol>
        </nav>

      </div>
    </nav>

  </header>

  <body>

    {{-- add new todo modal start --}}
    <div class="modal fade" id="addTodoModal" aria-labelledby="exampleModalLabel"
      data-bs-backdrop="static" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Todo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <form action="#" method="POST" id="add_todo_form" tabindex="-1"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-4 bg-light">
              <div class="row">
                <div class="form-group w-50">
                  <label>Tags</label>
                  <select class="select2" name="tag_ids[]" multiple="multiple"
                    data-placeholder="Select Tags" style="width: 100%;">
                    @foreach ($tags as $tag)
                      <option
                        {{ is_array(old('tag_ids')) && in_array($tag->id, old('tag_ids')) ? ' selected' : '' }}
                        value="{{ $tag->id }}">{{ $tag->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="my-2">
                <label for="task">Task</label>
                <input type="text" name="task" class="form-control"
                  placeholder="Task" required>
              </div>
              <div class="my-2">
                <label for="image">Select Image</label>
                <input type="file" name="image" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Close</button>
              <button type="submit" id="add_todo_btn" class="btn btn-primary">Add
                ToDo</button>
            </div>
        </div>
        </form>
      </div>
    </div>
    </div>
    {{-- add new todo modal end --}}

    {{-- add new tags modal start --}}
    <div class="modal fade" id="addTagsModal" tabindex="-1"
      aria-labelledby="exampleModalLabel" data-bs-backdrop="static"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Tags</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <form action="#" method="POST" id="add_tags_form"
            enctype="multipart/form-data">
            @csrf
            <div class="modal-body p-4 bg-light">
              <div class="row">
                <div class="col-lg">
                  <label for="title">Tag</label>
                  <input type="text" name="title" class="form-control"
                    placeholder="Tag" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Close</button>
              <button type="submit" id="add_tags_btn" class="btn btn-primary">Add
                Tags</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- add new tags modal end --}}

    {{-- edit todo modal start --}}
    <div class="modal fade" id="editTodoModal" tabindex="-1"
      aria-labelledby="exampleModalLabel" data-bs-backdrop="static"
      aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit ToDo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"
              aria-label="Close"></button>
          </div>
          <form action="#" method="POST" id="edit_todo_form"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="todos_id" id="todos_id">
            <input type="hidden" name="todo_image" id="todo_image">
            <div class="modal-body p-4 bg-light">
              <div class="my-2">
                <label for="task">Task</label>
                <input type="text" name="task" id="task"
                  class="form-control" placeholder="Task">
              </div>
              <div class="my-2">
                <label for="image">Select Image</label>
                <input type="file" name="image" class="form-control">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">Close</button>
              <button type="submit" id="edit_todo_btn"
                class="btn btn-success">Update ToDo</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- edit todo modal end --}}

    <body class="bg-light" id="table_fetchall">
      <div class="container">
        <div class="row my-5">
          <div class="col-lg-12">
            <div class="card shadow">
              <div
                class="card-header bg-dark d-flex justify-content-between align-items-center">

                <form action="{{ route('fetchall') }}" method="GET">
                  <div class="inline-block">
                    <div class="filter-content collapse show" id="collapse_1"
                      style="">
                      <div class="card-body">
                        <div class="input-group">
                          <input type="text" class="form-control"
                            placeholder="Search" name="title">
                        </div>
                      </div>
                    </div>

                    <div class="filter-content collapse show">
                      <div class="card-body">
                        <select class="select2" name="tag_ids[]"
                          multiple="multiple" data-placeholder="Select Tags"
                          style="width: 100%;">
                          @foreach ($tags as $tag)
                            <option
                              {{ is_array(old('tag_ids')) && in_array($tag->id, old('tag_ids')) ? ' selected' : '' }}
                              value="{{ $tag->id }}">{{ $tag->title }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="container-fluid d-flex">
                      <form action="{{ route('fetchall') }}" method="GET">
                        <div class="card-body">
                          <button class="btn btn-block btn-light">Apply</button>
                        </div>
                      </form>

                      <form action="{{ route('fetchall') }}">
                        <div class="card-body">
                          <button class="btn btn-block btn-light">Reset</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <h1 class="text-light">Manage ToDo List</h1>

                  <div>
                    <button class="btn btn-light" data-bs-toggle="modal"
                      data-bs-target="#addTodoModal"><i
                        class="bi-plus-circle me-2"></i>Add ToDo</button>
                    <button class="btn btn-light" data-bs-toggle="modal"
                      data-bs-target="#addTagsModal"><i
                        class="bi-plus-circle me-2"></i>Add Tags</button>
                  </div>
              </div>
              <div class="card-body">
                <table
                  class="table table-striped table-sm text-center align-middle">
                  <thead>
                    <tr>
                      <th>Tag</th>
                      <th>Task</th>
                      <th>Image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($todos as $todo)
                      <td>
                        @foreach ($tags as $tag)
                          <div value="{{ $tag->id }}">
                            {{ is_array($todo->tags->pluck('id')->toArray()) && in_array($tag->id, $todo->tags->pluck('id')->toArray()) ? $tag->title : '' }}
                          </div>
                        @endforeach
                      </td>
                      <td>{{ $todo->task }}</td>
                      <td>
                        @if ($todo->images?->image)
                          {{-- @can('todo', $todo) --}}
                            <a href="{{ route('showImage', $todo->id) }}"
                              id="{{ $todo->id }}"
                              class="text-success mx-1 showIcon">
                            {{-- @endcan --}}
                            <img
                              src="storage/images/{{ $todo->images?->id ? $todo->images->image : '' }}"
                              style="width: 150px; height: 150px; object-fit: cover;"
                              class="img-thumbnail">
                          </a>
                        @endif
                      </td>
                      <td>
                        @can('todo', $todo)
                          <a href="#" id="{{ $todo->id }}"
                            class="text-success mx-1 editIcon"
                            data-bs-toggle="modal"
                            data-bs-target="#editTodoModal"><i
                              class="bi-pencil-square h4"></i></a>

                          <a href="#" id="{{ $todo->id }}"
                            class="text-danger mx-1 deleteIcon"><i
                              class="bi-trash h4"></i></a>
                        @endcan
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

    </body>
  @endsection
