<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CURD AJAX</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="#">Student Details</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
</nav>
  <div class="container mt-4">
    <div class="alert alert-success" style="display:none";>
    
    </div>
    <button id="btnAdd" class="btn btn-success mt-4">Add New</button>

    <table class="table table-striped table-responsive mt-4">
      <thead>
        <th>ID</th>
        <th>Student Name</th>
        <th>Address</th>
        <th>Created On</th>
        <th>Action</th>
      </thead>
      <tbody id="showdata">
      </tbody>
    </table>
  </div>

  <div id="myModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="myForm" class="form-horizontal">
            <input type="hidden" id="student_id" name="student_id" value="0">
          <div class="form-group">
            <label for="name" class="label-control font-weight-bold">Student Name</label>
            <input type="text" id="name" name="student_name" class="form-control"><span id="nameVal"></span>
          </div>
          <div class="form-group">
            <label for="address" class="label-control font-weight-bold">Student Address</label>
            <input type="text" id="address" name="address" class="form-control"><span id="addVal"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm Delete</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>       
      </div>
      <div class="modal-body">
        	Do you want to delete this record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnDelete" class="btn btn-danger">Delete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
  $(document).ready(function(){

    showAllStudent();
    //Add Student
    $('#btnAdd').click(function(){
      $('#myModal').modal('show');
      $('#myForm').attr('action','<?php echo base_url(); ?>Student_cont/addStudent');
    });

    $('#saveBtn').click(function(){
      var url=$('#myForm').attr('action');
      var data=$('#myForm').serialize();
      //validation
      var student_name = $('#name');
      var address = $('#address');
     
      var result = '';
      if(student_name.val() == ""){
        $('#nameVal').html('Please Fill the field').css('color','red');
      }else{
        result +='1';
      }
      if(address.val() == ""){
        $('#addVal').html('Please fill the field').css('color','red');
      }else{        
        result +='2';
      }

      if(result = '12'){
        $.ajax({
          url:url,
          data:data,
          type:'ajax',
          method:'post',
          datatype:'json',
          async: true,
          success: function(response){
            var obj = JSON.parse(response);
            if(obj.success){
              $('#myModal').modal('hide');
              $('#myForm')[0].reset();
              if(obj.type == 'add'){
                var type="added";
              } else if (obj.type == 'update'){
                var type = "Updated";
              }
              $('.alert-success').html('Student '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
              showAllStudent();
            }else{
              alert('Error');
            }
          },
          error: function(){
            alert('Could not add Data');
          }
        });
      }
    });

      //Show Student Details
      function showAllStudent(){
        $.ajax({
          url:'<?php echo base_url(); ?>Student_cont/showStudent',
          type:'ajax',
          async: true,
          datatype:'json',
          success: function(data){
            var obj = JSON.parse(data);
            var html='';
            var i;
            for(i=0; i<obj.result.length;i++){
              html +='<tr>'+'<td>'+obj.result[i].student_id+'</td>'+
                            '<td>'+obj.result[i].student_name+'</td>'+
                            '<td>'+obj.result[i].address+'</td>'+
                            '<td>'+obj.result[i].created_at+'</td>'+
                            '<td>'
                              +'<a href="javascript:;" data="'+obj.result[i].student_id+'" class="btn btn-primary btn-sm itemEdit">Edit</a>'
                              +'<a href="javascript:;" data="'+obj.result[i].student_id+'" class="btn btn-danger btn-sm mx-2 itemDelete">Delete</a>'+
                            '</td>'+
                    '</tr>'
            }
            $('#showdata').html(html);
          }
        });
      }

      //Delete Student details
      $('#showdata').on('click','.itemDelete',function(){
        var id=$(this).attr('data');
        $('#deleteModal').modal('show');
        $('#btnDelete').unbind().click(function(){
          $.ajax({
              type:'ajax',
              method:'get',
              async:true,
              url:'<?php echo base_url(); ?>Student_cont/deleteStudent',
              data:{id:id},
              datatype:'json',
              success: function(response){
                var obj = JSON.parse(response);
                if(obj.success){
                  $('#deleteModal').modal('hide');
                  $('.alert-success').html('Student Deleted Successfully').fadeIn().delay(4000).fadeOut('slow');
                  showAllStudent();
                }else{
                  alert('Error');
                }
              },
              error: function(){
                alert('Failed to Delete');
              }
          });

        });
      });
      
      //Edit
      $('#showdata').on('click','.itemEdit',function(){
        var id=$(this).attr('data');
        $('#myModal').modal('show');
        $('#myModal').find('.modal-title').text('Edit Student');
        $('#myForm').attr('action','<?php echo base_url(); ?>Student_cont/updateStudent');
        $.ajax({
          type:'ajax',
          url:'<?php echo base_url(); ?>Student_cont/editStudent',
          data:{id:id},
          method:'get',
          datatype:'json',
          success: function(response){
            var obj = JSON.parse(response);
            //alert(obj.data.student_name);
            //exit;
            $('#name').val(obj.data.student_name);
            $('#address').val(obj.data.address);
            $('#student_id').val(obj.data.student_id)
          },
          error:function(){
            alert('Could not Edit Student');
          }
        });
      });

  });
</script>

</body>
</html>