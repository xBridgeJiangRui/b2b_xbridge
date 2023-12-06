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
            $this_month = date('F-Y');
            $this_year = date('Y');
            $start_date = $this->db->query("SELECT DATE_FORMAT(CURDATE(),'%Y-%m-01 00:00:00') AS `start_date`")->row('start_date');
            $end_date = $this->db->query("SELECT DATE_FORMAT(LAST_DAY(CURDATE()),'%Y-%m-%d 23:59:59') AS `end_date`")->row('end_date');

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
                $get_einvoice_query = $this->db->query("SELECT 
                    COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a
                        INNER JOIN b2b_summary.einv_main b
                        ON a.refno = b.refno 
                        AND a.customer_guid = b.customer_guid
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc) 
                        AND a.`code` IN ('$query_supcode')
                        -- AND a.postdatetime BETWEEN '$start_date' AND '$end_date'
                ");

                $get_ecn_query = $this->db->query("SELECT 
                    COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a
                        INNER JOIN b2b_summary.grmain_dncn b
                        ON a.refno = b.refno
                        AND a.customer_guid = b.customer_guid
                        INNER JOIN b2b_summary.einv_main c
                        ON a.refno = c.refno 
                        AND a.customer_guid = c.customer_guid
                        INNER JOIN b2b_summary.ecn_main d
                        ON a.refno = d.refno
                        AND a.customer_guid = d.customer_guid
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc) 
                        AND a.`code` IN ('$query_supcode')
                        -- AND a.postdatetime BETWEEN '$start_date' AND '$end_date'
                ");

                $get_einvoice_year_query = $this->db->query("SELECT
                    aa.*,
                    IFNULL(bb.count_doc, 0) AS count_doc
                    FROM
                    (
                    SELECT
                        DATE_FORMAT(DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH), '%Y-%m') AS period_code
                    FROM
                        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                        UNION SELECT 10 UNION SELECT 11) AS numbers
                    WHERE
                        DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH) <= DATE_FORMAT(CURDATE(), '%Y-12-01')
                    )aa
                    LEFT JOIN 
                    (SELECT 
                        LEFT(a.postdatetime,7) AS period_code,
                        COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a 
                        INNER JOIN b2b_summary_hub.einv_main b ON a.refno = b.refno 
                        AND a.customer_guid = b.customer_guid 
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc)
                        AND a.`code` IN ('$query_supcode')
                        AND a.postdatetime BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01 00:00:00') AND DATE_FORMAT(CURDATE(), '%Y-12-31 23:59:59')
                        GROUP BY LEFT(a.postdatetime,7),a.customer_guid
                        ORDER BY a.postdatetime ASC
                    )bb
                    ON aa.period_code = bb.period_code
                    GROUP BY aa.period_code
                    ORDER BY aa.period_code ASC 
                ")->result_array();

                $get_einvoice_year = json_encode(array_filter(array_column($get_einvoice_year_query, 'count_doc'), function($value) {
                    // Include non-empty values and 0 in the filtered array
                    return $value !== null || $value === 0;
                }),true);

                // print_r($get_einvoice_year); die;

                $get_ecn_year_query = $this->db->query("SELECT
                    aa.*,
                    IFNULL(bb.count_doc,0) AS count_doc
                    FROM
                    (
                    SELECT
                        DATE_FORMAT(DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH), '%Y-%m') AS period_code
                    FROM
                        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                        UNION SELECT 10 UNION SELECT 11) AS numbers
                    WHERE
                        DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH) <= DATE_FORMAT(CURDATE(), '%Y-12-01')
                    )aa
                    LEFT JOIN 
                    (SELECT 
                    LEFT(a.postdatetime,7) AS period_code,
                    COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a
                        INNER JOIN b2b_summary.grmain_dncn b
                        ON a.refno = b.refno
                        AND a.customer_guid = b.customer_guid
                        INNER JOIN b2b_summary_hub.einv_main c
                        ON a.refno = c.refno 
                        AND a.customer_guid = c.customer_guid
                        INNER JOIN b2b_summary_hub.ecn_main d
                        ON a.refno = d.refno
                        AND a.customer_guid = d.customer_guid
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc)
                        AND a.`code` IN ('$query_supcode')
                        AND a.postdatetime BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01 00:00:00') AND DATE_FORMAT(CURDATE(), '%Y-12-31 23:59:59')
                        GROUP BY LEFT(a.postdatetime,7),a.customer_guid
                        ORDER BY a.postdatetime ASC
                    )bb
                    ON aa.period_code = bb.period_code
                    GROUP BY aa.period_code
                    ORDER BY aa.period_code ASC
                ")->result_array();

                // echo $this->db->last_query(); die;
                
                $get_ecn_year = json_encode(array_filter(array_column($get_ecn_year_query, 'count_doc'), function($value) {
                    // Include non-empty values and 0 in the filtered array
                    return $value !== null || $value === 0;
                }),true);

            }
            else
            {
                $get_einvoice_query = $this->db->query("SELECT 
                    COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a
                        INNER JOIN b2b_summary.einv_main b
                        ON a.refno = b.refno 
                        AND a.customer_guid = b.customer_guid
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc) 
                        -- AND a.postdatetime BETWEEN '$start_date' AND '$end_date'
                ");

                $get_ecn_query = $this->db->query("SELECT 
                    COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a
                        INNER JOIN b2b_summary.grmain_dncn b
                        ON a.refno = b.refno
                        AND a.customer_guid = b.customer_guid
                        INNER JOIN b2b_summary.einv_main c
                        ON a.refno = c.refno 
                        AND a.customer_guid = c.customer_guid
                        INNER JOIN b2b_summary.ecn_main d
                        ON a.refno = d.refno
                        AND a.customer_guid = d.customer_guid
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc) 
                        -- AND a.postdatetime BETWEEN '$start_date' AND '$end_date'
                ");

                $get_einvoice_year_query = $this->db->query("SELECT
                    aa.*,
                    IFNULL(bb.count_doc, 0) AS count_doc
                    FROM
                    (
                    SELECT
                        DATE_FORMAT(DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH), '%Y-%m') AS period_code,
                        DATE_FORMAT(DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH), '%M') AS month_code
                    FROM
                        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                        UNION SELECT 10 UNION SELECT 11) AS numbers
                    WHERE
                        DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH) <= DATE_FORMAT(CURDATE(), '%Y-12-01')
                    )aa
                    LEFT JOIN 
                    (SELECT 
                        LEFT(a.postdatetime,7) AS period_code,
                        COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a 
                        INNER JOIN b2b_summary_hub.einv_main b ON a.refno = b.refno 
                        AND a.customer_guid = b.customer_guid 
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc)
                        AND a.postdatetime BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01 00:00:00') AND DATE_FORMAT(CURDATE(), '%Y-12-31 23:59:59')
                        GROUP BY LEFT(a.postdatetime,7),a.customer_guid
                        ORDER BY a.postdatetime ASC
                    )bb
                    ON aa.period_code = bb.period_code
                    GROUP BY aa.period_code
                    ORDER BY aa.period_code ASC 
                ")->result_array();

                $get_einvoice_year = json_encode(array_filter(array_column($get_einvoice_year_query, 'count_doc'), function($value) {
                    // Include non-empty values and 0 in the filtered array
                    return $value !== null || $value === 0;
                }),true);

                // print_r($get_einvoice_year); die;

                $get_ecn_year_query = $this->db->query("SELECT
                    aa.*,
                    IFNULL(bb.count_doc,0) AS count_doc
                    FROM
                    (
                    SELECT
                        DATE_FORMAT(DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH), '%Y-%m') AS period_code,
                        DATE_FORMAT(DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH), '%M') AS month_code
                    FROM
                        (SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4
                        UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9
                        UNION SELECT 10 UNION SELECT 11) AS numbers
                    WHERE
                        DATE_ADD(DATE_FORMAT(CURDATE(), '%Y-01-01'), INTERVAL n MONTH) <= DATE_FORMAT(CURDATE(), '%Y-12-01')
                    )aa
                    LEFT JOIN 
                    (SELECT 
                    LEFT(a.postdatetime,7) AS period_code,
                    COUNT(a.refno) AS count_doc 
                    FROM 
                        b2b_summary.grmain a
                        INNER JOIN b2b_summary.grmain_dncn b
                        ON a.refno = b.refno
                        AND a.customer_guid = b.customer_guid
                        INNER JOIN b2b_summary_hub.einv_main c
                        ON a.refno = c.refno 
                        AND a.customer_guid = c.customer_guid
                        INNER JOIN b2b_summary_hub.ecn_main d
                        ON a.refno = d.refno
                        AND a.customer_guid = d.customer_guid
                    WHERE 
                        a.customer_guid = '$customer_guid' 
                        AND a.loc_group IN ($session_query_loc)
                        AND a.postdatetime BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01 00:00:00') AND DATE_FORMAT(CURDATE(), '%Y-12-31 23:59:59')
                        GROUP BY LEFT(a.postdatetime,7),a.customer_guid
                        ORDER BY a.postdatetime ASC
                    )bb
                    ON aa.period_code = bb.period_code
                    GROUP BY aa.period_code
                    ORDER BY aa.period_code ASC
                ")->result_array();

                // echo $this->db->last_query(); die;
                
                $get_ecn_year = json_encode(array_filter(array_column($get_ecn_year_query, 'count_doc'), function($value) {
                    // Include non-empty values and 0 in the filtered array
                    return $value !== null || $value === 0;
                }),true);

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
                'this_month' => $this_month,
                'this_year' => $this_year,
                'get_einvoice_query' => $get_einvoice_query->row('count_doc'),
                'get_ecn_query' => $get_ecn_query->row('count_doc'),
                'get_einvoice_year_query' => $get_einvoice_year_query,
                'get_ecn_year_query' => $get_ecn_year_query,
                'get_einvoice_year' => $get_einvoice_year,
                'get_ecn_year' => $get_ecn_year,
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
