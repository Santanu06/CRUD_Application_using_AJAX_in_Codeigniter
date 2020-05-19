<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Details</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Employee Details</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor01">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url(); ?>DependencyCont">Dependency/Dependent Dropdown </a>
      </li>
    </ul>
  </div>
</nav>
  <div class="container mt-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="alert alert-success" style="display:none;" >
        </div>
      </div>
    </div>
    <button class="btn btn-primary " id="addEmployee">Add Employee</button>
    <div class="row mt-4">
      <div class="col-lg-8">
        <table class="table table-striped table-responsive">
          <thead>
            <th>Employee Id</th>
            <th>Emoloyee Name</th>
            <th>Address</th>
            <th>Created On</th>
            <th>Action</th>
          </thead>
          <tbody id="myTable">
           
          </tbody>
        </table>
      </div>
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
            <form action="" method="post" id="myForm">
              <input type="hidden" id="empId" name="emp_id" value="0">
            <div class="form-group">
              <label for="empname" class="label-control font-weight-bold">Employee Name</label>
              <input type="text" id="empName" name="emp_name" class="form-control"><span id="nameVal"></span>
            </div>
            <div class="form-group">
              <label for="empaddress" class="label-control font-weight-bold">Employee Address</label>
              <input type="text" id="empAddress" name="emp_address" class="form-control"><span id="addressVal"></span>
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
  </div>

  <div id="deleteModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Do you Want to Delete</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="deleteBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
    <script>
      $(document).ready(function(){

        showEmployee();

        $('#addEmployee').click(function(){
          $('#myModal').modal('show');
          $('#myModal').find('.modal-title').text('Add Employee');
          $('#myForm').attr('action','<?php echo base_url(); ?>EmployeeCont/addEmployee')
        });

        //Add Employee
        $('#saveBtn').click(function(){
          var url=$('#myForm').attr('action');
          var data=$('#myForm').serialize();
          //validation
          var empName = $('#empName').val();
          var empAddress = $('#empAddress').val();
          
          var result = '';
          if(empName == ''){
            $('#nameVal').html('Please Fill the Field').css('color','red');
          }else{
            result +='1';
          }
          if(empAddress == ''){
            $('#addressVal').html('Please Fill the Field').css('color','red');
          }else{
            result +='2';
          }
          if(result == '12'){
            $.ajax({
              url:url,
              data:data,
              method:'post',
              type:'ajax',
              datatype:'json',
              success: function(response){
                  var obj =JSON.parse(response);
                  if(obj.success){
                    $('#myModal').modal('hide');
                    $('#myForm')[0].reset();
                    if(obj.type == 'add'){
                      var type = 'Added';
                    } else if(obj.type == 'update') {
                      var type = 'Updated';
                    }
                    $('.alert-success').html('Employee '+type+' Successfully').fadeIn().delay(4000).fadeOut('slow');
                    showEmployee();
                  }else{
                    alert('Error');
                  }
              },
              error: function(){
                alert('Failed to Add Employee');
              }
            });
          }
        });

        //Show Employee Details
        function showEmployee(){
          $.ajax({
            url:'<?php echo base_url(); ?>EmployeeCont/showEmployee',
            type:'ajax',
            datatype:'json',
            success: function(response){
              var obj = JSON.parse(response);
              var html = "";
              var i;
              for(i=0;i<obj.data.length;i++){
                html +='<tr>'+'<td>'+obj.data[i].emp_id+'</td>'
                             +'<td>'+obj.data[i].emp_name+'</td>'
                             +'<td>'+obj.data[i].emp_address+'</td>'
                             +'<td>'+obj.data[i].created_on+'</td>'
                             +'<td>'
                                +'<a href="javascript:;" class="btn btn-warning btn-sm editItem" data="'+obj.data[i].emp_id+'">Edit</a>'
                                +'<a href="javascript:;" class="btn btn-danger btn-sm deleteItem mx-2" data="'+obj.data[i].emp_id+'">Delete</a>'
                             +'</td>'
                       +'</tr>'
              }
              $('#myTable').html(html);
            }
          });
        }

        //Edit Empployee
        $('#myTable').on('click','.editItem',function(){
          var id=$(this).attr('data');
          $('#myModal').modal('show');
          $('#myForm').find('.modal-title').html('Edit Employee');
          $('#myForm').attr('action','<?php echo base_url(); ?>EmployeeCont/updateEmployee');
          $.ajax({
            url:'<?php echo base_url(); ?>EmployeeCont/editEmployee',
            type:'ajax',
            method:'post',
            data:{id:id},
            datatype:'json',
            success: function(response){
              var obj = JSON.parse(response);
              $('#empName').val(obj.data.emp_name);
              $('#empAddress').val(obj.data.emp_address);
              $('#empId').val(obj.data.emp_id);
            },
            error: function(){
              alert('Could Not Edit Employee');
            }
          });
        });

        //Delete Employee
        $('#myTable').on('click','.deleteItem',function(){
          var id=$(this).attr('data');
          $('#deleteModal').modal('show');
          $('#deleteModal').find('.modal-title').html('Delete Employee');
          $('#deleteBtn').unbind().click(function(){
            $.ajax({
              url:'<?php echo base_url(); ?>EmployeeCont/deleteEmployee',
              type:'ajax',
              method:'post',
              data:{id:id},
              datatype:'json',
              success: function(response){
                var obj = JSON.parse(response);
                if(obj.success){
                  $('#deleteModal').modal('hide');
                  $('.alert-success').html('Employee Deleted Successfully').fadeIn().delay(4000).fadeOut('slow');
                  showEmployee();
                }
              },
              error:function(){
                alert('Failed to Delete Employee');
              }
            });
          });

        });

      });
    </script>

</body>
</html>