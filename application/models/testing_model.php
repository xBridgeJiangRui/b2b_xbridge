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
            if($result=true)
            {
                $insertData = array(
                    'refno' => $data['refno'],
                    'customer_guid' => $data['customer_guid']
                );
                
                // Perform the insert operation with the modified data
                $result2 = $this->db->insert('b2b_summary.grmain', $insertData);
            }
            
            return $result2; // Return the ID of the inserted record or false if the insert fails
        }
 
    }
    public function fetch_row_data($refno)
    {
        $query = $this->db->get_where('b2b_summary.einv_main', array('refno' => $refno));
        
        return $query->row(); // Return a single row
    }

    public function update_data($refno, $editedData)
    {
        $this->db->where('refno', $refno);
        $status = $this->db->update('b2b_summary.einv_main', $editedData);
        
        return $status;
    }

    public function delete_row($refno)
    {
        // Perform the deletion (replace 'your_table' with your actual database table name)
        $this->db->where('refno', $refno);
        $result = $this->db->delete('b2b_summary.einv_main');
        if($result=true)
        {
            $this->db->where('refno', $refno);
            $result2 = $this->db->delete('b2b_summary.grmain');
        }

        return $result2;
    }
}
