<?php
class Testing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('html');
        
        //load the department_model
        $this->load->model('Datatable_model');
        $this->load->model('testing_model');
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
    public function testing_site()
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


            $this->load->view('header');
            $this->load->view('testing/testing1', $data);
            $this->load->view('footer');
        }
        else
        {
            $this->session->set_flashdata('message', 'Session Expired! Please relogin');
            redirect('#');
        }
    }

    public function einvoice_list_tb()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != ''   && $_SESSION['user_logs'] == $this->panda->validate_login()) {
            //die;
            $doc = 'einvoice_table';
            $ref_no = $this->input->post('ref_no');
            $einvno = $this->input->post('einvno');
            $invno = $this->input->post('invno');
            $einv_generated_date = $this->input->post('einv_generated_date');
            $generate_daterange_data = $this->input->post('generate_daterange_data');
            /*$status = $this->input->post('status');
            $datefrom = $this->input->post('datefrom');
            $dateto = $this->input->post('dateto');
            $exp_datefrom = $this->input->post('exp_datefrom');
            $exp_dateto = $this->input->post('exp_dateto');
            $period_code = $this->input->post('period_code');*/
            $type = $this->input->post('type');
            $customer_guid = $_SESSION['customer_guid'];
            $query_loc = $_SESSION['query_loc'];

            // print_r($doc); die;

            $hq_branch_code = $this->db->query("SELECT branch_code FROM acc_branch WHERE is_hq = '1'")->result();
            $hq_branch_code_array = array();
            foreach ($hq_branch_code as $key) {
                array_push($hq_branch_code_array, $key->branch_code);
            }

            if (in_array('IAVA', $_SESSION['module_code'])) {
                $module_code_in = '';
            } else {
                $module_code_in = "AND a.code IN (" . $_SESSION['query_supcode'] . ") ";
            }

            if ($ref_no == '') {
                $ref_no_in = '';
            } else {
                $ref_no_in = " AND a.RefNo LIKE '%" . $ref_no . "%' ";
            }

            /*if ($status == '') {
                $status_in = " AND a.status = '' ";
            } elseif ($status == 'READ') {
                $status_in = " AND a.status IN ('printed', 'viewed') ";
            } elseif ($status == 'ALL') {
                $get_stat = $this->db->query("SELECT code from set_setting where module_name = 'PO_FILTER_STATUS'");

                foreach ($get_stat->result() as  $row) {
                    $check_stat[] = $row->code;
                }

                foreach ($check_stat as &$value) {
                    $value = "'" . trim($value) . "'";
                }
                $check_status = implode(',', array_filter($check_stat));
                $status_in = " AND a.status IN ($check_status) ";
            } else {
                $status_in = " AND a.status = '$status' ";
            }

            if ($datefrom == '' || $dateto == '') {
                $doc_daterange_in = '';
            } else {
                $doc_daterange_in = " AND a.podate BETWEEN '$datefrom' AND '$dateto' ";
            }

            if ($exp_datefrom == '' || $exp_dateto == '') {
                $exp_daterange_in = '';
            } else {
                $exp_daterange_in = " AND a.expiry_date BETWEEN '$exp_datefrom' AND '$exp_dateto' ";
            }

            if ($period_code == '') {
                $period_code_in = '';
            } else {
                $period_code_in = " AND LEFT(a.podate, 7) = '$period_code'";
            }*/

            if (!in_array('VGR', $_SESSION['module_code'])) {
                $module = 'gr_download_child';
            } else {
                $module = 'gr_child';
            }

            $query_count = "SELECT * FROM ( SELECT a.* FROM b2b_summary.einv_main a
            INNER JOIN b2b_summary.grmain b
            ON a.refno = b.refno
            AND a.customer_guid = b.customer_guid
            WHERE a.customer_guid = '$customer_guid'
            ) zzz
            ";

            $query = "SELECT a.*, c.acc_name FROM b2b_summary.einv_main a
            INNER JOIN b2b_summary.grmain b
            ON a.refno = b.refno
            AND a.customer_guid = b.customer_guid
            INNER JOIN lite_b2b.acc c 
            ON a.customer_guid = c.acc_guid
            WHERE a.customer_guid = '$customer_guid'
            ";
            //AND a.loc_group IN ($loc) -- up to production need change this

            // Add conditions for individual filters only if they are provided
            if (!empty($ref_no)) {
                $query .= " AND a.RefNo LIKE '%$ref_no%'";
            }
            if (!empty($einvno)) {
                $query .= " AND a.einvno LIKE '%$einvno%'";
            }
            if (!empty($invno)) {
                $query .= " AND a.invno LIKE '%$invno%'";
            }
            if (!empty($einv_generated_date)) {
                $query .= " AND a.einv_generated_date = '$einv_generated_date'";
            }
            if (!empty($generate_daterange_data)) {
                // Assuming $generate_daterange_data is in the format 'YYYY-MM-DD to YYYY-MM-DD'
                list($start_date, $end_date) = explode(" - ", $generate_daterange_data);
                $query .= " AND a.einv_generated_date BETWEEN '$start_date' AND '$end_date'";
            }

            $sql = "SELECT * FROM (
                $query
            ) zzz ";
            
            $query_po = $this->Datatable_model->datatable_main($sql, $type, $doc);
            //print_r($query); die;
            $fetch_data = $query_po->result();
            //print_r($fetch_data); die;
            //echo $this->db->last_query(); die;

            $data = array();
            if (count($fetch_data) > 0) {
                
                foreach ($fetch_data as $row) {
                    $tab = array();
                    
                    $tab["refno"] = $row->refno;
                    $tab["einvno"] = $row->einvno;
                    $tab["invno"] = $row->invno;
                    $tab["acc_name"] = $row->acc_name;
                    $tab["einv_generated_date"] = $row->einv_generated_date;

                    $data[] = $tab;
                }
            } else {
                $data = '';
            }
            
            $output = array(
                "draw"                =>     intval($_POST["draw"]),
                "recordsTotal"        =>     $this->Datatable_model->general_get_all_data($query_count, $doc),
                "recordsFiltered"     =>     $this->Datatable_model->general_get_filtered_data($query_count, $doc),
                "data"                =>     $data
            );
            
            echo json_encode($output);
            
        } else {
            $this->session->set_flashdata('message', 'Session Expired! Please relogin');
            redirect('#');
        }
    }

    public function testCreate()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != ''   && $_SESSION['user_logs'] == $this->panda->validate_login()) {
            $ref_no = $this->input->post('ref_no');
            $einv_guid = $this->input->post('ref_no');
            $einvno = $this->input->post('einvno');
            $invno = $this->input->post('invno');
            $customer_guid = $_SESSION['customer_guid'];
            $einv_generated_date = date('Y-m-d');
            //$type = $this->input->post('type');
            //$customer_guid = $_SESSION['customer_guid'];
            die;
            $data = array($ref_no,$einv_guid,$einvno,$invno,$customer_guid,$einv_generated_date);
            
            // Insert new user
            $result = $this->testing_model->insert_data($data);

            if ($result!=false) {
                $response = array('status' => 'success', 'message' => 'Data Added');
            } 
            else {
                $response = array('status' => 'error', 'message' => 'Failed to add data.');
            }

            echo json_encode($response);
            
        } else {
            $this->session->set_flashdata('message', 'Session Expired! Please relogin');
            redirect('#');
        }
    }

} // nothing after this
