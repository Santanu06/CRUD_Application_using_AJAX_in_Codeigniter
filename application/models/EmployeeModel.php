<?php 
  class EmployeeModel extends CI_model
  {
    public function add_employee()
    {
      $field=array(
                'emp_name'=>$this->input->post('emp_name'),
                'emp_address'=>$this->input->post('emp_address'),
                'created_on'=>date('Y-m-d H:i:m'),
      );
      $this->db->insert('employee_details',$field);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
    }

    public function show_employee()
    {
      $this->db->order_by('emp_name','ASC');
      $q=$this->db->get('employee_details');
      if($q->num_rows() > 0){
        return $q->result();
      }else{
        return false;
      }
    }

    public function edit_employee()
    {
      $id=$this->input->post('id');
      $this->db->where('emp_id',$id);
      $q=$this->db->get('employee_details');
      if($q->num_rows() > 0){
        return $q->row();
      }else{
        return false;
      }
    }

    public function update_employee()
    {
      $id=$this->input->post('emp_id');
      $field=array(
                'emp_name'=>$this->input->post('emp_name'),
                'emp_address'=>$this->input->post('emp_address'),
                'updated_on'=>date('Y-m-d H:i:s')
      );
      $this->db->where('emp_id',$id);
      $this->db->update('employee_details',$field);
      if($this->db->affected_rows() > 0 ){
        return true;
      }else{
        return false;
      }
    }

    public function delete_employee()
    {
      $id=$this->input->post('id');
      $this->db->where('emp_id',$id);
      $this->db->delete('employee_details');
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
    }
  }
?>