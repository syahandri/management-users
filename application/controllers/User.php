<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        // library request to dummyapi.io use curl
        $this->load->library('requestapi');

        // If session timeout, redirect to login
        if ($this->session->userdata('login') != TRUE) {
            return redirect(base_url('auth/login'));
        }
    }

    // View list user
    public function index()
    {
        $page = $this->input->get('page') ? $this->input->get('page') : 0;
        $url = 'https://dummyapi.io/data/v1/user?limit=20&page=' . $page . '';
        $response = $this->requestapi->request($url, 'GET', '');
        $users = json_decode($response, true);
        $totalDataPerPage = $users['limit'];
        $totalPage = $users['total'] / $totalDataPerPage;
        $firstData = ($totalDataPerPage * ($page + 1)) - $totalDataPerPage;

        $this->load->view('dashboard/layouts/header', ['title' => 'List users']);
        $this->load->view('dashboard/user/index', [
            'users' => $users,
            'page_numb' => $firstData,
            'totalPage' => $totalPage,
            'page' => $page
        ]);
        $this->load->view('dashboard/layouts/footer');
    }

    // View add user
    public function create()
    {
        // Validation form input
        $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_email_check');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('dashboard/layouts/header', ['title' => 'Add user']);
            $this->load->view('dashboard/user/create');
            $this->load->view('dashboard/layouts/footer');
        } else {

            // save data to dummyapi.io
            $this->_store();
        }
    }

    // Save user to dummyapi.io
    private function _store()
    {
        $firstName = strtolower(htmlspecialchars($this->input->post('firstName', true)));
        $lastName = strtolower(htmlspecialchars($this->input->post('lastName', true)));
        $email = strtolower(htmlspecialchars($this->input->post('email', true)));

        // create user to dummyapi.io
        $url = 'https://dummyapi.io/data/v1/user/create';
        $body = 'firstName=' . $firstName . '&lastName=' . $lastName . '&email=' . $email . '';
        $response = $this->requestapi->request($url, 'POST', $body);
        $data = json_decode($response, true);

        // if response request error
        if (array_key_exists('error', $data)) {
            $this->session->set_flashdata('error', 'Failed to add user, please try again');
            return redirect(base_url('user/create'));
        }

        // if store success
        $this->session->set_flashdata('success', 'User added successfully');
        return redirect(base_url('user'));
    }

    // View edit user
    public function edit($id)
    {
        // get user by id dummyapi.io
        $url = 'https://dummyapi.io/data/v1/user/' . $id . '';
        $response = $this->requestapi->request($url, 'GET', '');
        $user = json_decode($response, true);

        // Validation form input
        $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('dashboard/layouts/header', ['title' => 'Edit user']);
            $this->load->view('dashboard/user/edit', [
                'user' => $user
            ]);
        } else {

            // Update user to dummyapi.io
            $this->_update($id);
        }
    }

    // Update data user
    private function _update($id)
    {
        $firstName = strtolower(htmlspecialchars($this->input->post('firstName', true)));
        $lastName = strtolower(htmlspecialchars($this->input->post('lastName', true)));

        // create user to dummyapi.io
        $url = 'https://dummyapi.io/data/v1/user/'.$id.'';
        $body = 'firstName=' . $firstName . '&lastName=' . $lastName . '';
        $response = $this->requestapi->request($url, 'PUT', $body);
        $data = json_decode($response, true);

        // if response request error
        if (array_key_exists('error', $data)) {
            $this->session->set_flashdata('error', 'Failed to update user, please try again');
            return redirect(base_url('user'));
        }

        // if update success
        $this->session->set_flashdata('success', 'User updated successfully');
        return redirect(base_url('user'));
    }

    // Delete user
    public function delete($id)
    {
        // delete user in dummyapi.io
        $url = 'https://dummyapi.io/data/v1/user/' . $id . '';
        $response = $this->requestapi->request($url, 'DELETE', '');
        $data = json_decode($response, true);

        // if response request error
        if (array_key_exists('error', $data)) {
            $this->session->set_flashdata('error', 'Failed to delete user');
            return redirect(base_url('user'));
        }

        // if delete success
        $this->session->set_flashdata('success', 'User deleted successfully');
        return redirect(base_url('user'));
    }

    public function email_check($str)
    {
        if ($str) {
            // Check domain email is @rumahweb.co.id
            if (!stristr($str, '@rumahweb.co.id')) {
                $this->form_validation->set_message('email_check', 'The {field} field must be from @rumahweb.co.id.');
                return FALSE;
            }

            // check if email already in file users
            $readFile = fopen('assets/data/users.txt', 'r');
            while (!feof($readFile)) {
                $getTextLine = fgets($readFile);
                $explodeLine = explode("|", $getTextLine);
                if ($explodeLine[0]) {
                    list($id, $firstName, $lastName, $email, $registerDate, $updatedDate, $password) = $explodeLine;

                    if ($email == $str) {
                        $this->form_validation->set_message('email_check', 'The {field} already used.');
                        return FALSE;
                    }
                }
            }
            fclose($readFile);

            return TRUE;
        }
    }
}
