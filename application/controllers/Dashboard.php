<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');        
        $this->load->library('datatables');
         
    }

    public function index()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != '' && $_SESSION['user_logs'] == $this->panda->validate_login())
        {   
            $dashboard_num_days_data = $this->db->query("SELECT a.dashboard_num_days_data FROM  lite_b2b.acc a WHERE a.acc_guid = '".$_SESSION['customer_guid']."'")->row('dashboard_num_days_data');
            
            $session_query_loc = $_SESSION['query_loc'];
            $customer_guid = $_SESSION['customer_guid'];
            $query_supcode = $_SESSION['query_supcode'];

            if($session_query_loc == null || $session_query_loc == '' || $session_query_loc == 'null')
            {
                $session_query_loc = "''";
            }

            // section for four cards info
            if(!in_array('IAVA',$_SESSION['module_code']))
            {
                $check_outstanding_pomain = $this->db->query("SELECT count(refno) as count_pomain FROM b2b_summary.pomain WHERE `status` = '' AND customer_guid = '$customer_guid' AND loc_group in ('$session_query_loc') AND scode IN ('$query_supcode') and podate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE()");

                $check_grn =  $this->db->query("SELECT COUNT(refno) AS count_doc FROM b2b_summary.grmain WHERE `status` = '' AND customer_guid = '$customer_guid' AND loc_group IN ('$session_query_loc') AND `code` IN ('$query_supcode') AND grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");

                $check_grda =  $this->db->query("SELECT COUNT(a.refno) AS count_doc FROM b2b_summary.grmain AS a INNER JOIN (SELECT * FROM b2b_summary.grmain_dncn WHERE customer_guid = '$customer_guid' GROUP BY refno) AS b ON a.refno = b.refno AND a.customer_guid = b.customer_guid WHERE b.status = '' AND b.`customer_guid` = '$customer_guid' AND a.loc_group IN ('$session_query_loc') and code in ('$query_supcode')  AND a.grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");

                $no_respond =  $this->db->query("SELECT count(refno) as count_pomain from b2b_summary.pomain where status = '' and customer_guid = '$customer_guid' and loc_group in ('$session_query_loc') and scode in ('$query_supcode') and podate < CURDATE() - INTERVAL $dashboard_num_days_data DAY and CURDATE() ");

            }
            else
            {
                $check_outstanding_pomain = $this->db->query("SELECT count(refno) as count_pomain from b2b_summary.pomain where status = '' and customer_guid = '$customer_guid' and loc_group in ($session_query_loc)  and podate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE()");

                $check_grn =  $this->db->query("SELECT COUNT(refno) AS count_doc FROM b2b_summary.grmain WHERE `status` = '' AND customer_guid = '$customer_guid' AND loc_group IN ($session_query_loc) AND grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");


                $check_grda =  $this->db->query("SELECT COUNT(a.refno) AS count_doc FROM b2b_summary.grmain AS a INNER JOIN (SELECT * FROM b2b_summary.grmain_dncn WHERE customer_guid = '$customer_guid' GROUP BY refno) AS b ON a.refno = b.refno AND a.customer_guid = b.customer_guid WHERE b.`customer_guid` = '$customer_guid' AND a.loc_group IN ($session_query_loc) AND a.grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");

                $no_respond =  $this->db->query("SELECT count(refno) as count_pomain from b2b_summary.pomain WHERE `status` = '' and customer_guid = '$customer_guid' and loc_group in ($session_query_loc) and podate < CURDATE() - INTERVAL $dashboard_num_days_data DAY and CURDATE() ");
            }

            // announcement data
            $check_announcement = $this->db->query("SELECT * FROM lite_b2b.announcement WHERE customer_guid = '$customer_guid' and posted= '1' AND NOW() >= publish_at AND acknowledgement = 0 ORDER BY publish_at desc, created_at desc limit 1");

            if($check_announcement->num_rows() < 1)
            {
                $announcement = $this->db->query("SELECT 'Welcome' as title, 'No New Announcement at this moment' as content, curdate() as docdate ");
            }   
            else
            {
                $announcement = $check_announcement;
            }

            $data = array(
                'pomain' => $check_outstanding_pomain->row('count_pomain'),
                'grmain' => $check_grn->row('count_doc'),
                'grda' => $check_grda->row('count_doc'),
                'no_respond' => $no_respond->row('count_pomain'),
                'announcement' => $announcement,
            );

            $this->load->view('header');
            $this->load->view('dashboard/dashboard', $data);
            $this->load->view('footer');
        }
        else
        {
            redirect('#');
        }

    }

    public function chart()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('userid') != '' && $_SESSION['user_logs'] == $this->panda->validate_login())
        {   
            $dashboard_num_days_data = $this->db->query("SELECT a.dashboard_num_days_data FROM  lite_b2b.acc a WHERE a.acc_guid = '".$_SESSION['customer_guid']."'")->row('dashboard_num_days_data');
            
            $session_query_loc = $_SESSION['query_loc'];
            $customer_guid = $_SESSION['customer_guid'];
            $query_supcode = $_SESSION['query_supcode'];

            if($session_query_loc == null || $session_query_loc == '' || $session_query_loc == 'null')
            {
                $session_query_loc = "''";
            }

            // section for four cards info
            if(!in_array('IAVA',$_SESSION['module_code']))
            {
                $check_outstanding_pomain = $this->db->query("SELECT count(refno) as count_pomain FROM b2b_summary.pomain WHERE `status` = '' AND customer_guid = '$customer_guid' AND loc_group in ('$session_query_loc') AND scode IN ('$query_supcode') and podate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE()");

                $check_grn =  $this->db->query("SELECT COUNT(refno) AS count_doc FROM b2b_summary.grmain WHERE `status` = '' AND customer_guid = '$customer_guid' AND loc_group IN ('$session_query_loc') AND `code` IN ('$query_supcode') AND grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");

                $check_grda =  $this->db->query("SELECT COUNT(a.refno) AS count_doc FROM b2b_summary.grmain AS a INNER JOIN (SELECT * FROM b2b_summary.grmain_dncn WHERE customer_guid = '$customer_guid' GROUP BY refno) AS b ON a.refno = b.refno AND a.customer_guid = b.customer_guid WHERE b.status = '' AND b.`customer_guid` = '$customer_guid' AND a.loc_group IN ('$session_query_loc') and code in ('$query_supcode')  AND a.grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");

                $no_respond =  $this->db->query("SELECT count(refno) as count_pomain from b2b_summary.pomain where status = '' and customer_guid = '$customer_guid' and loc_group in ('$session_query_loc') and scode in ('$query_supcode') and podate < CURDATE() - INTERVAL $dashboard_num_days_data DAY and CURDATE() ");

            }
            else
            {
                $check_outstanding_pomain = $this->db->query("SELECT count(refno) as count_pomain from b2b_summary.pomain where status = '' and customer_guid = '$customer_guid' and loc_group in ($session_query_loc)  and podate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE()");

                $check_grn =  $this->db->query("SELECT COUNT(refno) AS count_doc FROM b2b_summary.grmain WHERE `status` = '' AND customer_guid = '$customer_guid' AND loc_group IN ($session_query_loc) AND grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");


                $check_grda =  $this->db->query("SELECT COUNT(a.refno) AS count_doc FROM b2b_summary.grmain AS a INNER JOIN (SELECT * FROM b2b_summary.grmain_dncn WHERE customer_guid = '$customer_guid' GROUP BY refno) AS b ON a.refno = b.refno AND a.customer_guid = b.customer_guid WHERE b.`customer_guid` = '$customer_guid' AND a.loc_group IN ($session_query_loc) AND a.grdate BETWEEN CURDATE() - INTERVAL $dashboard_num_days_data DAY AND CURDATE() ");

                $no_respond =  $this->db->query("SELECT count(refno) as count_pomain from b2b_summary.pomain WHERE `status` = '' and customer_guid = '$customer_guid' and loc_group in ($session_query_loc) and podate < CURDATE() - INTERVAL $dashboard_num_days_data DAY and CURDATE() ");
            }

            // announcement data
            $check_announcement = $this->db->query("SELECT * FROM lite_b2b.announcement WHERE customer_guid = '$customer_guid' and posted= '1' AND NOW() >= publish_at AND acknowledgement = 0 ORDER BY publish_at desc, created_at desc limit 1");

            if($check_announcement->num_rows() < 1)
            {
                $announcement = $this->db->query("SELECT 'Welcome' as title, 'No New Announcement at this moment' as content, curdate() as docdate ");
            }   
            else
            {
                $announcement = $check_announcement;
            }

            $data = array(
                'pomain' => $check_outstanding_pomain->row('count_pomain'),
                'grmain' => $check_grn->row('count_doc'),
                'grda' => $check_grda->row('count_doc'),
                'no_respond' => $no_respond->row('count_pomain'),
                'announcement' => $announcement,
            );

            $this->load->view('header');
            $this->load->view('dashboard/dashboard_chart', $data);
            $this->load->view('footer');
        }
        else
        {
            redirect('#');
        }

    }

    public function create_close_notification()
    {
        $customer_guid = $this->session->userdata('customer_guid');
        $user_guid = $this->session->userdata('user_guid');
        $now = $this->db->query("SELECT NOW() as now")->row('now');

        $data = array(
            'customer_guid' => $customer_guid,
            'user_guid' => $user_guid,
            'close_status' => 1,
            'closed' => $now,
        );

        $check_exist = $this->db->query("SELECT * FROM set_supplier_user_relationship_close WHERE customer_guid = '$customer_guid' AND user_guid = '$user_guid' ");

        if ($check_exist->num_rows() <= 0) {
            $this->db->insert("set_supplier_user_relationship_close", $data);
        } else {
            $this->db->query("UPDATE set_supplier_user_relationship_close SET close_status = 1 WHERE customer_guid = '$customer_guid' AND user_guid = '$user_guid' ");
        }
    } //close create_close_notification
}
