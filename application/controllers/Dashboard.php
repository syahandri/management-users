<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // If session timeout, redirect to login
        if ($this->session->userdata('login') != TRUE) {
            return redirect(base_url('auth/login'));
        }
    }

    public function index()
    {
        $firstName = $this->session->userdata('firstName');
        $lastName = $this->session->userdata('lastName');
        $this->load->view('dashboard/layouts/header', ['title' => 'Dashboard']);
        $this->load->view('dashboard/index', [
            'user' => $firstName . ' ' . $lastName
        ]);
        $this->load->view('dashboard/layouts/footer');
    }

}