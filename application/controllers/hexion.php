<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hexion extends CI_Controller {

    //Eerste funtie die aangeroepen wordt wanneer deze controller aangeroepen wordt.
    public function index() {
        $this->home();
    }

    public function home() {
        //pass values to view
        //eerst array aanmaken
        $data['title'] = "Welcome!";
        $this->load->view("view_header", $data);
        $this->load->view("view_home", $data);
        $this->load->view("view_footer", $data);
    }

    public function signUp() {
        $data['title'] = "Sign Up";
        $this->load->view("view_header", $data);
        $this->load->view("view_signUp", $data);
        $this->load->view('view_footer', $data);
    }

    public function loggedIn() {
        $data['title'] = "Sign Up";
        $this->load->view("view_header", $data);
        $this->load->view("view_loggedIn", $data);
        $this->load->view('view_footer', $data);
    }

    public function about() {
        $data['title'] = "About";
        $this->load->view("view_header", $data);
        $this->load->view('view_about', $data);
        $this->load->view("view_footer", $data);
    }

    public function register() {
        $data['title'] = "Register";
        $this->load->view("view_header", $data);
        $this->load->view('view_register', $data);
        $this->load->view("view_footer", $data);
    }

    function checkLogin() {
        //value, humanredable value, options
        $this->form_validation->set_rules('email', 'Username', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_verifyUser|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->signUp();
        } else {
            $this->loggedIn();
        }
    }

    function verifyUser() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->model('model_user');
        if ($this->model_user->login($email, $password)) {
            return true;
        } else {
            $this->form_validation->set_message('verifyUser', 'Incorrect Email or Password. Please try again');
            return false;
        }
    }

    function checkRegister() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[usertable.email]|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[retypePassword]|xss_clean');
        $this->form_validation->set_rules('retypePassword', 'Retyped Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            //user heeft verkeerde waarde ingegeven en mag opnieuw proberen.
            $this->register();
        } else {
            //Registratie is inorden, we tonen registratie pagina
            //we plaatsen alle gegevens in de database
            $this->load->model('model_user');

            //geef de gegevens van de gebruiker weer.
            $result = $this->model_user->insertUser();

            if ($result) {
                $data['title'] = "Sign Up";
                $data['email'] = $result;
                $this->load->view("view_header", $data);
                $this->load->view("view_loggedIn", $data);
                $this->load->view('view_footer', $data);
            } else {
                $data['title'] = "Probleempje";
                $this->load->view("view_header", $data);
                $this->load->view("view_registratie", $data);
                $this->load->view('view_footer', $data);
            }
        }
    }

}
