<?php 
  class EmployeeCont extends CI_Controller
  {
    public function __construct()
    {
      parent :: __construct();
      $this->load->model('EmployeeModel');
    }
    public function index()
    {
      $this->load->view('employee/employeelist');
    }
    public function addEmployee()
    {
      $result=$this->EmployeeModel->add_employee();
      
      $msg['success']=false;
      $msg['type']='add';
      if($result){
        $msg['success']=true;
      }
      echo json_encode($msg);
    }

    public function showEmployee()
    {
      $result['data']=$this->EmployeeModel->show_employee();
      echo json_encode($result);
    }

    public function editEmployee()
    {
      $result['data']=$this->EmployeeModel->edit_employee();
      echo json_encode($result);
    }

    public function updateEmployee()
    {
      $result=$this->EmployeeModel->update_employee();
      $msg['success']=false;
      $msg['type']='update';
      if($result){
        $msg['success']=true;
      }
      echo json_encode($msg);
    }

    public function deleteEmployee()
    {
      $result=$this->EmployeeModel->delete_employee();
      $msg['success']=false;
      if($result){
        $msg['success']=true;
      }
      echo json_encode($msg);
    }
  }
?>