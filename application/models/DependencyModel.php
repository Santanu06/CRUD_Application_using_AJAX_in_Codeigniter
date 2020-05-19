<?php 
  class DependencyModel extends CI_model
  {
    public function loadcountry()
    {
      $this->db->order_by('country_name','ASC');
      $q=$this->db->get('country');
      return $q->result();
    }

    public function show_state($id)
    {
      $this->db->where('country_id',$id);
      $q=$this->db->get('state');
      $output='<option value="">Select State</option>';
      foreach($q->result() as $view){
        $output .='<option value="'.$view->state_id.'">'.$view->state_name.'</option>';
      }
      return $output;
    }
    
    public function show_city($id)
    {
      $this->db->where('state_id',$id);
      $q=$this->db->get('city');
      $output='<option value="">Select City</option>';
      foreach($q->result() as $view){
        $output.='<option value="'.$view->city_id.'">'.$view->city_name.'</option>';
      }
      return $output;
    }
  }
?>