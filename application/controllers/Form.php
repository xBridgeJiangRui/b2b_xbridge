<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('html');
        
        //load the department_model
        //$this->load->model('Datatable_model');
        //$this->load->model('testing_model');
        $this->jasper_ip = $this->file_config_b2b->file_path_name($this->session->userdata('customer_guid'),'web','general_doc','jasper_invoice_ip','GDJIIP');
    }

    public function index()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != '' && $_SESSION['user_logs'] == $this->panda->validate_login())
        {   
            
        }
        else
        {
            $this->session->set_flashdata('message', 'Session Expired! Please relogin');
            redirect('#');
        }
    }
    public function form_site()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != '' && $_SESSION['user_logs'] == $this->panda->validate_login())
        {   
            $customer_guid = $_SESSION['customer_guid'];

            $get_location_query = $this->db->query("SELECT aa.*,bb.branch_desc FROM (SELECT a.* FROM acc_branch a INNER JOIN acc_concept b ON a.concept_guid = b.concept_guid WHERE b.acc_guid = '$customer_guid' AND a.isactive = '1') aa INNER JOIN (SELECT * FROM b2b_summary.cp_set_branch WHERE customer_guid = '$customer_guid') bb ON aa.branch_code = bb.branch_code ORDER BY aa.is_hq DESC,branch_code ASC");

            $get_supplier_query = $this->db->query("SELECT a.supplier_guid, a.supplier_name, GROUP_CONCAT(DISTINCT b.supplier_group_name) AS supplier_code FROM lite_b2b.set_supplier a INNER JOIN lite_b2b.set_supplier_group b ON a.supplier_guid = b.supplier_guid AND b.customer_guid = '$customer_guid' WHERE a.isactive = '1' GROUP BY a.supplier_guid");

            $data = array(
                'get_location_query' => $get_location_query,
                'get_supplier_query' => $get_supplier_query,
            );


            $this->load->view('header_form');
            $this->load->view('Form/form_page', $data);
            $this->load->view('footer_form');
        }
        else
        {
            $this->session->set_flashdata('message', 'Session Expired! Please relogin');
            redirect('#');
        }
    }



} // nothing after this
