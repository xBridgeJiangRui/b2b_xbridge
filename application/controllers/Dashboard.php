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
            
            $data = array(

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
}
