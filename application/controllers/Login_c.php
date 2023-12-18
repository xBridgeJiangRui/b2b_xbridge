<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login_c extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->library('user_agent');
        $this->load->library('form_validation');
        $this->load->library('datatables');
        $this->load->library('session');
    }

    public function index()
    {
        /*if ($_SERVER['HTTPS'] !== "on") 
            {
            $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];   
            header("Location: $url");
            } */

        $sessiondata = array(
            'userid' => '',
            'userpass' => '',
            'module_group_guid' => '',
        );

        $this->session->set_userdata($sessiondata);
        $this->load->view('login');
        //     $this->panda->load('index', 'login');
    }

    function logout()
    {

        $this->session->sess_destroy();
        redirect('login_c');
    }

    public function check()
    {

        $this->form_validation->set_rules('userid', 'User ID', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $userid = $this->input->post('userid');
            $password = addslashes($this->input->post('password'));

            $result = $this->login_model->check_login($userid, $password);

            if($result->row('isactive') == '0')
            {
                // Add JavaScript code to show an alert and redirect back to login
                echo '<script>alert("User Account Deactive. Please contact support team.");';
                echo 'window.location.href = "' . site_url('login_c') . '";</script>';

                /*$this->session->set_flashdata('message','User Account Deactive. <br>&nbsp; Please contact support team.');
                redirect('login_c');*/
            }
            else if($result->row('isactive') == '9')
            {
                // Add JavaScript code to show an alert and redirect back to login
                echo '<script>alert("User Account Incomplete. Please contact support team.");';
                echo 'window.location.href = "' . site_url('login_c') . '";</script>';

                /*$this->session->set_flashdata('message','User Account Incomplete. <br>&nbsp; Please contact support team.');
                redirect('login_c');*/
            }
            else if($result->num_rows() == '0')
            {
                // Add JavaScript code to show an alert and redirect back to login
                echo '<script>alert("Invalid User ID / Password. Please verify and try again.");';
                echo 'window.location.href = "' . site_url('login_c') . '";</script>';
                
                /*$this->session->set_flashdata('message','Invalid User ID / Password. <br>&nbsp; Please verify and try again.');
                redirect('login_c');*/
            }
            else
            {
                if ($result->row('user_group_name') == 'SUPP_ADMIN' || $result->row('user_group_name') == 'SUPP_CLERK' || $result->row('user_group_name') == 'LIMITED_SUPP_ADMIN' || $result->row('user_group_name') == 'SUPP_ADMIN') {
                    // $user_guid = $result->row('user_guid');
    
                    $check_supplier = $this->db->query("SELECT a.*,b.* FROM set_supplier_user_relationship AS a INNER JOIN set_supplier AS b ON a.`supplier_guid` = b.supplier_guid WHERE user_guid = '" . $result->row('user_guid') . "'");
    
                    $total_supplier = $check_supplier->num_rows();
                    $i = 0;
                    foreach ($check_supplier->result() as $row) {
                        // echo $row->supplier_group_guid.'<br>'; 
                        if ($row->isactive == 0) {
                            $i++;
                        }
                    }
                    if ($total_supplier > 0) {
                        if ($i == $total_supplier) {
                            $this->session->set_flashdata('message', 'Company Inactive! Please contact Support!');
                            redirect('login_c');
                        }
                    }
                    // if($check_supplier->row('suspended') == '1')
                    // {
                    //     $this->session->set_flashdata('message', 'Company Suspended! Please contact Support!');
                    //     redirect('login_c');
                    // };
    
                };
                //  echo $this->db->last_query();die;
                if ($result->num_rows() > 0) {
                    $browser = $this->agent->browser();
                    $ip_addr = $this->input->ip_address();
                    $this->db->query("REPLACE INTO user_logs SELECT UPPER(REPLACE(UUID(), '-', '')), '" . $result->row('user_guid') . "', '$userid', now(), '$ip_addr', '$browser'");
                    $check_userlog = $this->db->query("SELECT * from user_logs where user_guid = '" . $result->row('user_guid') . "'");
    
                    //set the session variables
                    $sessiondata = array(
                        'userid' => $userid,
                        'user_logs' => $check_userlog->row('user_logs_guid'),
                        'location' => '',
                        'user_guid' => $result->row('user_guid'),
                        'user_group_name' => $result->row('user_group_name'),
                        'module_group_guid' => $result->row('module_group_guid'),
                        'isenable' => $result->row('isenable'),
                        'loginuser' => TRUE,
                        'portal_template' => 'xbridge'
                    );
                    $this->session->set_userdata($sessiondata);
                    $this->panda->get_uri();
    
                    redirect('login_c/customer');
                }
            }

        }
    }

    public function password()
    {
        if ($this->session->userdata('loginuser') == true) {
            $this->load->view('header');
            $this->load->view('changepassword');
            $this->load->view('footer');
        } else {
            redirect('#');
        }
    }

    public function submit_password()
    {
        if ($this->session->userdata('loginuser') == true) {
            $this->panda->get_uri();
            $prev_pass = $this->input->post('prev_password');
            $new_pass = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');
            $user_guid = $this->session->userdata('user_guid');

            if ($new_pass != $confirm_password) {
                $this->session->set_flashdata('warning', 'New Password and Confirm Password does not match!');
                redirect('login_c/password');
            };

            // print_r($this->session->userdata());die;
            $old_password = $this->db->query("SELECT * FROM set_user WHERE user_guid = '$user_guid' GROUP BY user_guid LIMIT 1");
            $prev_password = $this->db->query("SELECT md5('$prev_pass') as prev_pass");
            // echo $this->db->last_query();die;
            $old_passwords = $old_password->row('user_password');
            $prev_passwords = $prev_password->row('prev_pass');
            if ($prev_passwords != $old_passwords) {
                $this->session->set_flashdata('message', 'Old Password Wrong');
                redirect('login_c/password');
            }

            $check_module = $this->db->query("SELECT acc_module_group_guid FROM acc_module_group WHERE acc_module_group_name = 'Panda B2B'")->row('acc_module_group_guid');

            $this->db->query("UPDATE set_user set user_password = md5('$confirm_password'),updated_by = '" . $_SESSION['userid'] . "',updated_at = NOW() where user_guid = '$user_guid' and module_group_guid = '$check_module'");
            $new_passwords = $this->db->query("SELECT md5('$confirm_password') as new_pass")->row('new_pass');

            $this->db->query("INSERT INTO reset_pwd_self (transaction_guid,user_guid,from_value,to_value,created_by,created_at) SELECT UPPER(REPLACE(UUID(), '-', '')), '$user_guid','$old_passwords','$new_passwords','" . $_SESSION['userid'] . "',now()");

            // echo $this->db->last_query();die;

            $_SESSION['userpass'] = $confirm_password;

            $this->session->set_flashdata('message', 'Password Updated');
            redirect('login_c/password');
        } else {
            redirect('#');
        }
    }

    public function customer()
    {
        if ($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != '' && $_SESSION['user_logs'] == $this->panda->validate_login()) 
        {
            $requiredSessionVar = array('userid', 'userpass', 'location', 'user_guid', 'user_group_name', 'module_group_guid', 'isenable', 'loginuser', 'isHQ', 'query_loc', 'user_logs', 'portal_template');

            foreach ($_SESSION as $key => $value) {
                if (!in_array($key, $requiredSessionVar)) {
                    unset($_SESSION[$key]);
                }
            }

            if ($_SESSION['user_group_name'] == 'SUPER_ADMIN') {

                $get_customer = $this->db->query("SELECT *
                FROM(
                SELECT DISTINCT a.logo,a.acc_guid,a.acc_name,a.seq,'' AS register_guid,a.row_seq,a.maintenance,DATE_FORMAT(a.maintenance_date,'%d-%m-%Y') AS maintenance_date
                FROM `acc` AS a
                WHERE isactive = 1 
                ) AS aa
                GROUP BY aa.acc_guid
                ORDER BY aa.seq ASC,aa.row_seq ASC");

            } else 
            {

                $get_customer = $this->db->query("SELECT DISTINCT e.logo,d.acc_guid,e.acc_name,e.seq,e.maintenance,DATE_FORMAT(e.maintenance_date,'%d-%m-%Y') AS maintenance_date FROM `set_user` AS a 
                INNER JOIN `set_user_branch` b ON a.user_guid = b.user_guid
                INNER JOIN `acc_branch` c ON b.branch_guid = c.branch_guid 
                INNER JOIN `acc_concept` d ON c.concept_guid = d.concept_guid 
                INNER JOIN `acc` e ON d.`acc_guid` = e.`acc_guid` 
                where a.user_id = '" . $_SESSION['userid'] . "' 
                and e.isactive = '1' 
                and a.module_group_guid = '" . $_SESSION['module_group_guid'] . "' 
                order by e.seq asc,e.row_seq ASC");

            }

            $data = array(
                'customer' => $get_customer,
            );

            $this->load->view('header');
            $this->load->view('customer', $data);
            $this->load->view('footer');

        }
        else 
        {
            redirect('#');
        }
    }

    public function customer_setsession()
    {
        if ($this->session->userdata('loginuser') == true) {
            // echo '123';
            $customer_guid = $this->input->post('customer');
            // new added for reminder
            $blocked_guid = $this->input->post('blocked_guid');
            if ($blocked_guid != '') {
                $blocked_guid = explode(",", $blocked_guid);
                $blocked_guid = implode("','", $blocked_guid);
                $blocked_guid = "'" . $blocked_guid . "'";
                $query_blocked = "AND b.supplier_guid NOT IN ($blocked_guid)";
            }
            else
            {
                $query_blocked = '';
            }

            $query_set_user_group = $this->db->query("SELECT b.user_group_name 
            FROM lite_b2b.set_user a 
            INNER JOIN lite_b2b.set_user_group b 
            ON a.user_group_guid = b.user_group_guid 
            WHERE a.user_id = '" . $_SESSION['userid'] . "'
            AND a.acc_guid = '$customer_guid'")->row('user_group_name');

            // echo $query_blocked; echo '<br>'; 
            // echo $customer_guid;die;
            // $get_loc = $this->db->query("SELECT distinct branch_code, branch_name from  set_user as a inner join  acc_branch as b on a.branch_guid = b.branch_guid where user_id = '".$_SESSION['userid']."' and a.isactive = '1' and module_group_guid = '".$_SESSION['module_group_guid']."' order by branch_code asc");
            $get_loc = $this->db->query("SELECT distinct c.branch_code, c.branch_name from set_user a inner join set_user_branch b ON a.user_guid = b.user_guid inner join acc_branch c on b.branch_guid = c.branch_guid where a.user_id = '" . $_SESSION['userid'] . "' and a.isactive = '1' and a.module_group_guid = '" . $_SESSION['module_group_guid'] . "' and b.acc_guid = '$customer_guid' AND c.isactive = '1' order by branch_code asc");
            //echo $this->db->last_query();die; 

            // echo var_dump($get_loc->result()); die;
            $hq_branch_code = $this->db->query("SELECT branch_code FROM acc_branch WHERE is_hq = '1'")->result();

            $hq_branch_code_array = array();

            foreach ($hq_branch_code as $key) {

                array_push($hq_branch_code_array, $key->branch_code);
            }

            foreach ($get_loc->result() as  $row) {
                $check_HQ[] = $row->branch_code;
            }

            if (!array_diff($hq_branch_code_array, $check_HQ)) {

                $sessiondata = array(
                    'isHQ' => '1',
                );
                $this->session->set_userdata($sessiondata);
            } else {
                $sessiondata = array(
                    'isHQ' => '0',
                );
                $this->session->set_userdata($sessiondata);
            }

            $sessiondata = array(
                'customer_guid' => $this->input->post('customer'),
                /*'customer' => $this->db->query("SELECT acc where")*/
                'show_side_menu' => '1',
            );
            $this->session->set_userdata($sessiondata);


            foreach ($check_HQ as &$value) {
                $value = "'" . trim($value) . "'";
            }
            $query_loc = implode(',', array_filter($check_HQ));
            $sessiondata = array(
                'query_loc' => $query_loc,
            );
            $this->session->set_userdata($sessiondata);


            $userid = $_SESSION['userid'];
            $password = $_SESSION['userpass'];
            $result = $this->login_model->check_module($userid, $password);

            // echo $this->db->last_query();die;

            foreach ($result->result() as $row) {
                $module_code[] = $row->module_code;
            }

            $_SESSION['module_code'] = $module_code;
            // print_r($module_code);die;
            if (in_array("C1MS", $module_code)) {
                $_SESSION['system_admin'] = 1;
            } else {
                $_SESSION['system_admin'] = 0;
            }
            //@@@@@@@@@@@@@@@@@ end module_name session @@@@@@@@@@@@@@@@@@@@@@@   
            /* echo var_dump($_SESSION['module_code']);
            die;*/

            $acc_table = $this->db->query("SELECT * FROM acc WHERE acc_guid = '$customer_guid' AND isactive = 1 ");

            $session_data = array(
                'idle_time' => $acc_table->row('idle_time'),
            );

            // new add checking user group 11-08-2023
            // if (!in_array('IAVA', $_SESSION['module_code'])) 
            // {
                $sessiondata = array(
                    'user_group_name' => $query_set_user_group,
                );
                $this->session->set_userdata($sessiondata);
            // }

            if (!in_array('IAVA', $_SESSION['module_code'])) {
                $query_supcode = $this->db->query("SELECT distinct backend_supplier_code from set_supplier_user_relationship as a inner join set_supplier_group as b on a.supplier_group_guid = b.supplier_group_guid $query_blocked INNER JOIN set_supplier c ON a.supplier_guid = c.supplier_guid where a.user_guid = '" . $_SESSION['user_guid'] . "' AND b.customer_guid = '" . $_SESSION['customer_guid'] . "' AND c.isactive = 1");

                if ($query_supcode->num_rows() == 0) {
                    echo '<script>alert("Company inactive, Please contact our support!");window.location.href = "' . site_url('login_c/customer') . '";</script>;';
                    die;
                    // window.location.href = "http://www.w3schools.com";
                    // redirect(site_url('login_c/customer'));
                }
            } else {
                $query_supcode = $this->db->query("SELECT distinct backend_supplier_code from set_supplier_user_relationship as a inner join set_supplier_group as b on a.supplier_group_guid = b.supplier_group_guid $query_blocked where a.user_guid = '" . $_SESSION['user_guid'] . "' AND b.customer_guid = '" . $_SESSION['customer_guid'] . "'");
            }
            //echo $this->db->last_query(); die;
            // $query_supcode = $this->db->query("SELECT distinct backend_supplier_code from set_supplier_user_relationship as a inner join set_supplier_group as b on a.supplier_group_guid = b.supplier_group_guid where a.user_guid = '".$_SESSION['user_guid']."'");

            if (!in_array('IAVA', $_SESSION['module_code'])) {
                $query_consign_supcode = $this->db->query("SELECT distinct backend_supplier_code from set_supplier_user_relationship as a inner join set_supplier_group as b on a.supplier_group_guid = b.supplier_group_guid $query_blocked inner join b2b_summary.supcus c on b.backend_supcus_guid = c.supcus_guid INNER JOIN lite_b2b.set_supplier c ON a.supplier_guid = c.supplier_guid where a.user_guid = '" . $_SESSION['user_guid'] . "' and b.customer_guid = '" . $_SESSION['customer_guid'] . "' and c.consign = 1 and c.isactive = 1");
            } else {
                $query_consign_supcode = $this->db->query("SELECT distinct backend_supplier_code from set_supplier_user_relationship as a inner join set_supplier_group as b on a.supplier_group_guid = b.supplier_group_guid $query_blocked inner join b2b_summary.supcus c on b.backend_supcus_guid = c.supcus_guid where a.user_guid = '" . $_SESSION['user_guid'] . "' and c.consign = 1 AND b.customer_guid = '" . $_SESSION['customer_guid'] . "' ");
            }
            //echo $this->db->last_query();die;
            // print_r($query_consign_supcode->result());die;
            // $query_consign_supcode = $this->db->query("SELECT distinct backend_supplier_code from set_supplier_user_relationship as a inner join set_supplier_group as b on a.supplier_group_guid = b.supplier_group_guid inner join b2b_summary.supcus c on b.backend_supcus_guid = c.supcus_guid where a.user_guid = '".$_SESSION['user_guid']."' and c.consign = 1");

            /* $get_loc = $this->db->query("SELECT distinct branch_code, branch_name from  set_user as a inner join  acc_branch as b on a.branch_guid = b.branch_guid where user_id = '".$_SESSION['userid']."' and user_password = '".$_SESSION['userpass']."' and a.isactive = '1' and module_group_guid = '".$_SESSION['module_group_guid']."' order by branch_code asc");
            */
            // echo $this->db->last_query();
            $check_supcode = array();
            foreach ($query_supcode->result() as  $row) {
                $check_supcode[] = $row->backend_supplier_code;
            }
            // print_r($check_supcode);die;
            $check_supcode_without_quote =  $check_supcode;
            foreach ($check_supcode as &$value) {
                $value = "'" . trim($value) . "'";
            }
            $query_supcode = implode(',', array_filter($check_supcode));

            $check_consign_supcode = array();
            foreach ($query_consign_supcode->result() as  $row2) {
                $check_consign_supcode[] = $row2->backend_supplier_code;
            }
            // print_r($check_supcode);die;

            foreach ($check_consign_supcode as &$value) {
                $value = "'" . trim($value) . "'";
            }
            $query_consign_supcode = implode(',', array_filter($check_consign_supcode));

            $other_doc = $this->db->query("SELECT * FROM other_doc_setting WHERE customer_guid = '$customer_guid' AND isactive = 1 ORDER BY seq ASC");
            $check_user_group = $this->db->query("SELECT * FROM set_user WHERE acc_guid = '$customer_guid' AND user_guid = '" . $_SESSION['user_guid'] . "' LIMIT 1");
            $sessiondata = array(
                'query_supcode' => $query_supcode,
                'query_consign_supcode' => $query_consign_supcode,
                'other_doc' => $other_doc->result(),
                'check_supcode_without_quote' => $check_supcode_without_quote,
                'user_group_guid' => $check_user_group->row('user_group_guid'),
                'query_blocked' => $blocked_guid,
            );
            $this->session->set_userdata($sessiondata);

            //print_r($sessiondata); die;

            $userid = $_SESSION['userid'];
            $password = $_SESSION['userpass'];
            $result = $this->login_model->check_module($userid, $password);
            //@@@@@@@@@@@@@@@@@@@@@@ module_name session @@@@@@@@@@@@@@@@@@@@@@@@@@@@
            // echo $this->db->last_query();die;

            // $check_acc_user = $this->login_model->check_module($userid, $password);
            // if($check_acc_user->row('module_code') == 'C1MS')
            // {
            //     $_SESSION['system_admin'] = 1;
            //    // redirect("Acc_master_setup");
            // }
            // else
            // {
            //     $_SESSION['system_admin'] = 0;
            //    // redirect("Module_setup");
            // }

            foreach ($result->result() as $row) {
                $module_code[] = $row->module_code;
            }

            $_SESSION['module_code'] = $module_code;
            //print_r($module_code);die;
            if (in_array("C1MS", $module_code)) {
                $_SESSION['system_admin'] = 1;
            } else {
                $_SESSION['system_admin'] = 0;
            }
            //@@@@@@@@@@@@@@@@@ end module_name session @@@@@@@@@@@@@@@@@@@@@@@   
            /* echo var_dump($_SESSION['module_code']);
                    die;*/
            $redirect = '';
            $this->panda->get_uri();
            if (in_array('DASH', $_SESSION['module_code'])) {
                //redirect('dashboard');
                $redirect = 'dashboard';
            } else {
                //redirect('panda_home');
                $redirect = 'panda_home';
            };

            $data = array(
                //'module_code' => $module_code,
                'para' => '1',
                'redirect' => $redirect,

            );
            echo json_encode($data);
        } else {
            redirect('#');
        }
    }
}
