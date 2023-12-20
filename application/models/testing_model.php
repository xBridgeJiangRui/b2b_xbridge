<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class testing_model extends CI_Model
{
    public function insert_data($data)
    {
        // Check if user_id already exists
        $this->db->where('einv_guid', $data['einv_guid']);
        $existing_record = $this->db->get('b2b_summary.einv_main')->num_rows();

        if ($existing_record > 0) {
            return false;
        } else {
            // User does not exist, proceed with the insert
            $result = $this->db->insert('b2b_summary.einv_main', $data);
            return $result; // Return the ID of the inserted record or false if the insert fails
        }
 
    }
}
