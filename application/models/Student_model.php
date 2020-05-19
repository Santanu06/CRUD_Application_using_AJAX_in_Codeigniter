<?php 
  class Student_model extends CI_model
  {
    public function add_student()
    {
      $field=array(
                'student_name'=>$this->input->post('student_name'),
                'address'=>$this->input->post('address'),
                'created_at'=>date('Y-m-d H:i:s')
      );
      $this->db->insert('student_details',$field);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
    }

    public function show_student()
    {
      $this->db->order_by('student_name','ASC');
      $q=$this->db->get('student_details');
      if($q->num_rows() > 0){
        return $q->result();
      }else{
        return false;
      }
    }

    public function delete_student()
    {
      $id=$this->input->get('id');
      $this->db->where('student_id',$id);
      $this->db->delete('student_details');
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
    }

    public function edit_student()
    {
      $id=$this->input->get('id');
      $this->db->where('student_id',$id);
      $q=$this->db->get('student_details');
      if($q->num_rows() > 0){
        return $q->row();
      }else{
        return false;
      }
    }

    public function update_student()
    {
      $id=$this->input->post('student_id');
      $field=array(
                'student_name'=>$this->input->post('student_name'),
                'address'=>$this->input->post('address'),
                'updated_at'=>date('Y-m-d H:i:s')
      );
      $this->db->where('student_id',$id);
      $this->db->update('student_details',$field);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
    }
  }
?>