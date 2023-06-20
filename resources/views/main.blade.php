<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Fetch All</title>

  <!-- Select2 -->
  <link rel="stylesheet"
    href="{{ asset('plugins/select2/css/select2.min.css') }}">

  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

@yield('content')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'>
</script>
<script
  src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'>
</script>
<script type="text/javascript"
  src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>


<script>
  $(document).ready(function() {
    $('.select2').select2();
  });
</script>

<script>
  $(function() {

    /** add new todo ajax request */
    $("#add_todo_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_todo_btn").text('Adding...');
      $.ajax({
        url: '{{ route('store') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Added!',
              'ToDo Added Successfully!',
              'success'
            )

          }
          $("#add_todo_btn").text('Add ToDo');
          $("#add_todo_form")[0].reset();
          $("#addTodoModal").modal('hide');
          $("#addTodoModal").on("hidden.bs.modal", function() {
            location.reload();
          });
        }
      });
    });

    /** add new tags ajax request */
    $("#add_tags_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_tags_btn").text('Adding...');
      $.ajax({
        url: '{{ route('storeTags') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Added!',
              'Tags Added Successfully!',
              'success'
            )
            // fetchAllTodos();
          }
          $("#add_tags_btn").text('Add Tags');
          $("#add_tags_form")[0].reset();
          $("#addTagsModal").modal('hide');
          $("#addTagsModal").on("hidden.bs.modal", function() {
            location.reload();
          });
        }
      });
    });

    /** edit todo ajax request */
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: '{{ route('edit') }}',
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#task").val(response.task);
          $("#todos_id").val(response.id);
          $("#todo_image").val(response.image);
        }
      });
    });

    /** update todo ajax request */
    $("#edit_todo_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_todo_btn").text('Updating...');
      $.ajax({
        url: '{{ route('update') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Updated!',
              'ToDo Updated Successfully!',
              'success'
            )
            // fetchAllTodos();
          }
          $("#edit_todo_btn").text('Update ToDo');
          $("#edit_todo_form")[0].reset();
          $("#editTodoModal").modal('hide');
          $("#editTodoModal").on("hidden.bs.modal", function() {
            location.reload();
          });
        }
      });
    });

    /** delete todo ajax request */
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ route('delete') }}',
            method: 'post',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              $('#table_fetchall').click(function() {
                location.reload();
              });
            },
          });
        }
      })
    });


    /** edit image ajax request */
    $(document).on('click', '.editImageIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: '{{ route('editImage') }}',
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#todo_id").val(response.id);
          $("#todo_image").val(response.image);
        }
      });
    });

    /** update image ajax request */
    $("#edit_image_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_image_btn").text('Updating...');
      $.ajax({
        url: '{{ route('updateImage') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Updated!',
              'ToDo Updated Successfully!',
              'success'
            )
            // fetchAllTodos();
          }
          $("#edit_image_btn").text('Update Image');
          $("#edit_image_form")[0].reset();
          $("#editImageModal").modal('hide');
          $("#editImageModal").on("hidden.bs.modal", function() {
            location.reload();
          });
        }
      });
    });

    /** delete todo ajax request */
    $(document).on('click', '.deleteImageIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ route('deleteImage') }}',
            method: 'post',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              $('#preview_image').click(function() {
                location.reload();
              });
            },
          });
        }
      })
    });

  })
</script>

</html>

