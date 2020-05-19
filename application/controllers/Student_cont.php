<?php 
  class Student_cont extends CI_Controller
  {
    public function __construct()
    {
      parent :: __construct();
      $this->load->model('Student_model');
    }
    public function index()
    {
      $this->load->view('student/studentlist');
    }
    public function addStudent()
    {
      $result=$this->Student_model->add_student();
      $msg['success']=false;
      $msg['type']='add';
      if($result){
        $msg['success']=true;
      }
      echo json_encode($msg);
    }

    public function showStudent()
    {
      $data['result']=$this->Student_model->show_student();
      echo json_encode($data);
    }

    public function deleteStudent()
    {
      $result=$this->Student_model->delete_student();
      $msg['success']=false;
      if($result){
        $msg['success']=true;
      }
      echo json_encode($msg);
    }
    public function editStudent()
    {
      $result['data']=$this->Student_model->edit_student();
      echo json_encode($result);
    }

    public function updateStudent()
    {
      $result=$this->Student_model->update_student();
      $msg['success']=false;
      $msg['type']='update';
      if($result){
         $msg['success']=true;
      }
      echo json_encode($msg);
    }
  }
?>