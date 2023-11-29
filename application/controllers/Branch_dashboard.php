<?php
class Branch_dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('html');
        
        //load the department_model
        $this->load->model('Datatable_model');
        $this->jasper_ip = $this->file_config_b2b->file_path_name($this->session->userdata('customer_guid'),'web','general_doc','jasper_invoice_ip','GDJIIP');
    }

    public function index()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != '' && $_SESSION['user_logs'] == $this->panda->validate_login())
        {   
            $customer_guid = $_SESSION['customer_guid'];

            $get_loc = $this->db->query("SELECT aa.*,bb.branch_desc FROM (SELECT a.* FROM acc_branch a INNER JOIN acc_concept b ON a.concept_guid = b.concept_guid WHERE b.acc_guid = '$customer_guid' AND a.isactive = '1') aa INNER JOIN (SELECT * FROM b2b_summary.cp_set_branch WHERE customer_guid = '$customer_guid') bb ON aa.branch_code = bb.branch_code ORDER BY aa.is_hq DESC,branch_code ASC");

            $data = array(
                'location' => $get_loc,
            );

            unset($_SESSION['from_other']);

            $this->load->view('header');
            $this->load->view('Branch_dashboard/branch_view', $data);
            $this->load->view('footer');
        }
        else
        {
            $this->session->set_flashdata('message', 'Session Expired! Please relogin');
            redirect('#');
        }
    }

    public function branch_setsession()
    {
        if ($this->session->userdata('loginuser') == true) 
        {
            $customer_guid = $_SESSION['customer_guid'];
            $user_guid = $_SESSION['user_guid'];

            $query_supcode = $this->db->query("SELECT DISTINCT backend_supplier_code FROM lite_b2b.set_supplier_user_relationship AS a
            INNER JOIN lite_b2b.set_supplier_group AS b on a.supplier_group_guid = b.supplier_group_guid INNER JOIN lite_b2b.set_supplier c ON a.supplier_guid = c.supplier_guid WHERE a.user_guid = '$user_guid' and b.customer_guid = '$customer_guid' and isactive = 1");

            foreach ($query_supcode->result() as  $row) {
                $check_supcode[] = $row->backend_supplier_code;
            }

            foreach ($check_supcode as &$value) {
                $value = "'" . trim($value) . "'";
            }

            $query_supcode = implode(',', array_filter($check_supcode));

            $sessiondata = array(
                'query_supcode' => $query_supcode,
            );
            $this->session->set_userdata($sessiondata);

            redirect($_SESSION['frommodule'] . "?loc=" . $this->input->post('location') . '&first=1');
        } else {
            redirect('#');
        }
    }

} // nothing after this
