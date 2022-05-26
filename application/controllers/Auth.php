<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        // library request to dummyapi.io use curl
        $this->load->library('requestapi');

        // if already login, redirect to dashboard
        if ($this->session->userdata('login') == TRUE) {
            return redirect(base_url('dashboard'));
        }
    }

    // View login
    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/layouts/header', ['title' => 'Login']);
            $this->load->view('auth/login');
            $this->load->view('auth/layouts/footer');
        } else {
            $this->_attemptLogin();
        }
    }

    private function _attemptLogin()
    {
        $inputEmail = $this->input->post('email');
        $inputPassword = $this->input->post('password');

        // check if email and password exist in file users
        $readFile = fopen('assets/data/users.txt', 'r');
        while (!feof($readFile)) {
            $getTextLine = fgets($readFile);
            $explodeLine = explode("|", $getTextLine);
            if ($explodeLine[0]) {
                list($id, $firstName, $lastName, $email, $registerDate, $updatedDate, $password) = $explodeLine;

                if ($inputEmail == $email && hash('sha256', $inputPassword) == trim($password)) {
                    $url = 'https://dummyapi.io/data/v1/user/' . $id . '';
                    $response = $this->requestapi->request($url, 'GET', '');
                    $data = json_decode($response, true);

                    // if response request error
                    if (array_key_exists('error', $data)) {
                        $this->session->set_flashdata('error', 'Failed to login, check your credentials!');
                        return redirect(base_url('auth/login'));
                    }

                    // if response request success
                    $this->session->set_userdata('login', TRUE);
                    $this->session->set_userdata('firstName', $data['firstName']);
                    $this->session->set_userdata('lastName', $data['lastName']);
                    return redirect(base_url('dashboard'));
                }
            }
        }
        fclose($readFile);

        // if fail login
        $this->session->set_flashdata('error', 'Failed to login, check your credentials!');
        return redirect(base_url('auth/login'));
    }

    // View register
    public function register()
    {
        // Validation form register
        $this->form_validation->set_rules('firstName', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[12]|callback_password_check');
        $this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|trim|matches[password]');

        // If not valid, send error to view
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/layouts/header', ['title' => 'Register']);
            $this->load->view('auth/register');
            $this->load->view('auth/layouts/footer');
        } else {
            // if valid, attempt register
            $this->_attemptRegister();
        }
    }

    private function _attemptRegister()
    {
        $firstName = strtolower(htmlspecialchars($this->input->post('firstName', true)));
        $lastName = strtolower(htmlspecialchars($this->input->post('lastName', true)));
        $email = strtolower(htmlspecialchars($this->input->post('email', true)));
        $password = hash('sha256', $this->input->post('password'));

        // create user to dummyapi.io
        $url = 'https://dummyapi.io/data/v1/user/create';
        $body = 'firstName=' . $firstName . '&lastName=' . $lastName . '&email=' . $email . '';
        $response = $this->requestapi->request($url, 'POST', $body);
        $data = json_decode($response, true);
        // if response request error
        if (array_key_exists('error', $data)) {
            $this->session->set_flashdata('error', 'Register is failed, try again!');
            return redirect(base_url('auth/register'));
        }

        // if response request success
        $data['password'] = $password;

        // save data register to file users.txt
        $writeFile = fopen('assets/data/users.txt', 'a+');
        fputcsv($writeFile, $data, '|');
        fclose($writeFile);

        $this->session->set_flashdata('success', 'Registration is successful, please login with your account');
        return redirect(base_url('auth/login'));
    }

    public function logout()
    {
        $this->session->sess_destroy();
        return redirect(base_url());
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

    public function password_check($str)
    {
        if ($str) {
            // Check password is contain numeric, lowercase, uppercase and at least 2 non-alpha character
            $number =  preg_match('@[0-9]@', $str);
            $lowercase =  preg_match('@[a-z]@', $str);
            $upercase =  preg_match('@[A-Z]@', $str);
            $non_alpha = preg_match_all('@[^a-zA-Z0-9]@', $str);

            if (!$number) {
                $this->form_validation->set_message('password_check', 'The {field} field must be contains number.');
                return FALSE;
            }

            if (!$lowercase) {
                $this->form_validation->set_message('password_check', 'The {field} field must be contains lowercase.');
                return FALSE;
            }

            if (!$upercase) {
                $this->form_validation->set_message('password_check', 'The {field} field must be contains upercase.');
                return FALSE;
            }

            if (!$non_alpha || $non_alpha < 2) {
                $this->form_validation->set_message('password_check', 'The {field} field must contain at least 2 non-alphabet characters.');
                return FALSE;
            }

            return TRUE;
        }
    }
}
