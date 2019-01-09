<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Volunteer_model extends CI_Model {
  public function all()
  {
    $query = $this->db
      ->select('id, first_name, last_name, address, gender')
      ->get('volunteers');
    if ($query->num_rows() >= 1) {
      return $query->result();
    }
    return false;
  }

  public function get($id)
  {
    $user = $this->db
      ->select('user_id, first_name, last_name, location_id, description')
      ->get_where('volunteers', ['id' => $id])
      ->row();
    if ($user) {
      return $user;
    } 
    return false;
  }

  public function addVolunteerField($post)
  {
    foreach ($post as $key => $value) {
      if ($key != 'volunteer_id') {
        $data = [
          'volunteer_id' => $post['volunteer_id'],
          'field_id' => $value
        ];
        $test[$key] = $value;
        $this->db->insert('volunteer_fields', $data);
      }
    }
  }

  public function create($post)
  {
    $data = [
      'user_id' => $post['user_id'],
      'first_name' => $post['first_name'],
      'last_name' => $post['last_name'],
      'location_id' => $post['location_id'],
      'birthdate' => $post['birthdate'],
      'address' => $post['address'],
      'gender' => $post['gender'],
      'profession' => $post['profession'],
    ];
    if (isset($post['id']) && $post['id'] != null) {
      $this->db->where(['id' => $post['id']]);
      $this->db->update('volunteers', $data);
      return $post['id'];
    }
    if($this->db->insert('volunteers', $data)) {
      return $this->db->insert_id();
    }
    return $data;
  }

  public function delete($id)
  {
    if($this->db->delete('volunteers', ['id' => $id])) {
      return true;
    }
    return false;
  }

}