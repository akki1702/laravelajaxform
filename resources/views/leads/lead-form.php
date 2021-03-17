<html lang="en">
<head>
    <title>Lead Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>

<div class="container panel panel-default ">
        <h2 class="panel-heading">Lead Form</h2>
    <form id="lead-form">

        <div class="form-group">
            <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" id="name">
            <span class="text-danger" id="name-error"></span>
        </div>

        <div class="form-group">
            <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" id="name">
            <span class="text-danger" id="name-error"></span>
        </div>

        <div class="form-group">
            <input type="text" name="mobile" class="form-control" placeholder="Enter Mobile Number" id="mobile">
            <span class="text-danger" id="mobile-error"></span>
        </div>

        <div class="form-group">
            <input type="text" name="email" class="form-control" placeholder="Enter Email" id="email">
            <span class="text-danger" id="email-error"></span>
        </div>

        

        <div class="form-group">
            <input type="text" name="status" class="form-control" placeholder="Select Status" id="status">
            <span class="text-danger" id="status-error"></span>
        </div>

        <div class="form-group">
          <textarea class="form-control" name="source" placeholder="source" id="source"></textarea>
          <span class="text-danger" id="source-error"></span>
        </div>

        <div class="form-group">
            <button class="btn btn-success" id="submit">Submit</button>
        </div>
        <div class="form-group">
            <b><span class="text-success" id="success-message"> </span><b>
        </div>
    </form>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

   <script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#lead-form').on('submit', function(event){
        event.preventDefault();
        $('#first-name-error').text('');
        $('#last-name-error').text('');
        $('#email-error').text('');
        $('#mobile-error').text('');
        $('#status-error').text('');
        $('#source-error').text('');

        first_name = $('#first_name').val();
        last_name = $('#last_name').val();
        mobile = $('#mobile').val();        
        email = $('#email').val();
        status = $('#status').val();
        source = $('#source').val();

        $.ajax({
          url: "/lead-form",
          type: "POST",
          data:{
              first_name:first_name,
              last_name:last_name,
              mobile:mobile,
              email:email,              
              status:status,
              source:source,
          },
          success:function(response){
            console.log(response);
            if (response) {
              $('#success-message').text(response.success);
              $("#lead-form")[0].reset();
            }
          },

          // error: function(response) {
          //     $('#first-name-error').text(response.responseJSON.errors.name);
          //     $('#first-name-error').text(response.responseJSON.errors.name);
          //     $('#email-error').text(response.responseJSON.errors.email);
          //     $('#mobile-number-error').text(response.responseJSON.errors.mobile_number);
          //     $('#subject-error').text(response.responseJSON.errors.subject);
          //     $('#message-error').text(response.responseJSON.errors.message);
          // }

         });
        });
      </script>
 </body>
</html>