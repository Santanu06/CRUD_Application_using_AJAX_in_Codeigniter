<?php 
  class DependencyCont extends CI_Controller
  {
    public function __construct()
    {
      parent :: __construct();
      $this->load->model('DependencyModel');
    }
    public function index()
    {
      $result=$this->DependencyModel->loadcountry();
      $this->load->view('viewdependency',compact('result'));
    }
   public function showState()
   {
     $id=$this->input->post('id');      
     echo $this->DependencyModel->show_state($id);
   }
   public function showCity()
   {
     $id=$this->input->post('id');
     echo $this->DependencyModel->show_city($id);
   }
  }
?>