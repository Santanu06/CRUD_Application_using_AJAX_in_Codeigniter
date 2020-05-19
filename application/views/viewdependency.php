<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dependency</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
  <h2 class="text-center mb-4">Dependency/Dependent Dropdown Using Ajax</h2>
    <div class="row">
      <div class="col-md-8 offset-md-2 shadow-lg p-5">
      <form action="" method="post">
      <div class="form-group">
        <label for="County">Country</label>
        <select name="country" id="country" class="form-control">
          <option value="">Select Country</option>
            <?php if(isset($result)){
              foreach($result as $view){  
            ?>
           <option value="<?php echo $view->country_id; ?>"><?php echo $view->country_name; ?></option>
              <?php } }?>
        </select>
      </div>
      <div class="form-group">
        <label for="state">State</label>
          <select name="state" id="state" class="form-control">
            <option value="">Select State</option>
          </select>
      </div>
      <div class="form-group">
        <label for="city">City</label>
          <select name="city" id="city" class="form-control">
            <option value="">Select City</option>
          </select>
      </div>
    </form>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <script>
      $(document).ready(function(){
      $('#country').change(function(){
        var id = $('#country').val();
        $.ajax({
          url:'<?php echo base_url(); ?>DependencyCont/showState',
          type:'ajax',
          data:{id:id},
          datatype:'html',
          method:'post',
          success: function(response){
              $('#state').html(response);
              $('#city').html('<option value="">Select city</option>');
          },
          error: function(){
              $('#state').html('<option value="">Select State</option>');
              $('#city').html('<option value="">Select city</option>');            
          }
        });
        $('#state').change(function(){
          var id = $('#state').val();
          $.ajax({
            url:'<?php echo base_url(); ?>DependencyCont/showCity',
            type:'ajax',
            data:{id:id},
            method:'post',
            datatype:'html',
            success:function(response){
              $('#city').html(response);
            }       
          });
        });
      });
    });
  </script>
</body>
</html>