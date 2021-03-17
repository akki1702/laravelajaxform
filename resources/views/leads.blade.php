<!DOCTYPE html>
<html>
<head>
    <title>Veefin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script> <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
</head>
<body>
    
<div class="container">
    <!-- <h1>Veefin</h1><br/><br/> -->
    <br/><br/>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewLead"> Create New Lead</a><br/><br/>
    
    <table class="table table-bordered data-table">

  <!--  -->

        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Profile Pic</th>
                <th>Status</th>
                <th>Source</th>
                <th width="300px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="leadForm" name="leadForm" class="form-horizontal">
                   <input type="hidden" name="user_id" id="user_id">

                    <div class="form-group">
                        <label for="first_name" class="col-sm-3 control-label">First Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="col-sm-3 control-label">Last Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="mobile" class="col-sm-3 control-label">Mobile Number</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profile_pic" class="col-sm-3 control-label">Profile Picture</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control" id="profile_pic" name="profile_pic" placeholder="Enter Profile" value="" required="">
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-12">

                          <select class="form-control" name="status">
                              <option>Select Status</option>
                              
                                  <option id="status" value="Active" selected="selected"> Active </option>
                                  <option id="status" value="Inactive" selected="selected"> Inactive </option>
                              
                          </select>

                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Source</label>
                        <div class="col-sm-12">

                            <select class="form-control" name="source">
                              <option>Select Source</option>
                              
                                  <option id="source" value="Active" selected="selected"> Active </option>
                                  <option id="source" value="Inactive" selected="selected"> Inactive </option>
                              
                          </select>
                            
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
<script type="text/javascript">
  $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('leads.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'last_name', name: 'last_name'},
            {data: 'mobile', name: 'mobile'},
            {data: 'email', name: 'email'},
            {data: 'profile_pic', name: 'profile_pic'},
            {data: 'status', name: 'status'},
            {data: 'source', name: 'source'},
            

            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#createNewLead').click(function () {
        $('#saveBtn').val("create-lead");
        $('#user_id').val('');
        $('#leadForm').trigger("reset");
        $('#modelHeading').html("Create New Lead");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editLead', function () {
      var user_id = $(this).data('id');
      $.get("{{ route('leads.index') }}" +'/' + user_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Lead");
          $('#saveBtn').val("edit-lead");
          $('#ajaxModel').modal('show');

          $('#user_id').val(data.id);
          $('#first_name').val(data.first_name);
          $('#last_name').val(data.last_name);
          $('#mobile').val(data.mobile);
          $('#email').val(data.email);
          $('#profile_pic').val(data.profile_pic);
          $('#status').val(data.status);
          
          $('#source').val(data.source);
          
      })
   });

    $('#saveBtn').click(function (e) {
          
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#leadForm').serialize(),
          url: "{{ route('leads.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#leadForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
        
    });
    
    $('body').on('click', '.deleteLead', function () {
     
        var user_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('leads.store') }}"+'/'+user_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>
</body>
</html>