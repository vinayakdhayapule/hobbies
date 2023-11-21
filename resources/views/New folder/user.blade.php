<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

</head>
<style>
  .ml-auto{
    margin-left: 2% !important;
}
</style>
<body>

<div class="container mt-2">

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2></h2>
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create User</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card-body">

        <table class="table table-bordered" id="ajax-crud-datatable">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>FirstName</th>
                 <th>LastName</th>
                 <th>Hobbies</th>
                 <th>Created at</th>
                 <th>Action</th>
              </tr>
           </thead>
        </table>

    </div>
   
</div>

  <!-- boostrap User model -->
    <div class="modal fade" id="user-modal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="UserModal"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="UserForm" name="UserForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" maxlength="50" required="">
                </div>
              </div>  

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-12">
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" maxlength="50" required="">
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-4 control-label">Hobbies:</label>
                @foreach($hobbies as $hobby)
                    <div class="ml-auto">
                        <label>
                            <input type="checkbox" name="hobbies[]" value="{{ $hobby->id }}"> {{ $hobby->name }}
                        </label>
                    </div>
                @endforeach
            </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->

</body>
<script type="text/javascript">
     
 $(document).ready( function () {
  var counter = 1;
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#ajax-crud-datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('users') }}",
           columns: [
            { data: 'id', render: function () { return counter++; } },
                    { data: 'firstname', name: 'firstname' },
                    { data: 'lastname', name: 'lastname' },
                    { data: 'hobbies', name: 'hobbies' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false},
                 ],
                 order: [[0, 'desc']],
                 createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row-' + dataIndex);
        }
       });

  });
  
  function add(){

       $('#UserForm').trigger("reset");
       $('#UserModal').html("Add User");
       $('#user-modal').modal('show');
       $('#id').val('');

  }   
  function editFunc(id){
    
    $.ajax({
        type:"POST",
        url: "{{ url('edit-user') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
          $('#UserModal').html("Edit Users");
          $('#user-modal').modal('show');
          $('#id').val(res.id);
          $('#firstname').val(res.firstname);
          $('#lastname').val(res.lastname);
       }
    });
  }  

  function deleteFunc(id){
        if (confirm("Delete Record?") == true) {
        var id = id;
         
          // ajax
          $.ajax({
              type:"POST",
              url: "{{ url('delete-user') }}",
              data: { id: id },
              dataType: 'json',
              success: function(res){

                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
             }
          });
       }
  }

  $('#UserForm').submit(function(e) {

     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{ url('store-user')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#user-modal").modal('hide');
          var oTable = $('#ajax-crud-datatable').dataTable();
          oTable.fnDraw(false);
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
        },
        error: function(data){
           console.log(data);
         }
       });
   });

</script>
</html>