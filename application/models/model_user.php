<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_user extends CI_Model {

    function login($email, $password) {
        $this->db->select('email,password');
        $this->db->from('usertable');
        $this->db->where('email', $email);
        $this->db->where('password', $password);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function insertUser() {
        $email = $this->input->post('email');
        $password = sha1($this->config->item('salt') . $this->input->post('password'));

        $sql = "INSERT INTO usertable (email, password)
                VALUES (  
                          '" . $email . "',
                          '" . $password . "')";
                          // " . $this->db->escape('firstname') . ", Om ' een \ bij te zetten \'
        $result = $this->db->query($sql);

        if ($this->db->affected_rows() === 1) {
            //sessie starten
            $this->set_session($email);
            
            //als alles inorden is een welcom woordje email.
            return $email;
        } else {
            //admin een mailtje sturen om te zeggen dat het niet werkt
            $this->load->library('email');
            $this->email->from('hexion@pxl.be', 'Freigt Forum Admin');
            $this->email->to('Adem.Gungormus@student.pxl.be');
            $this->email->subject('Probleem met registratie User, Hexion');

            if (isset($email)) {
                $this->email->message('probleem met ' . $email);
            } else {
                $this->email->message('probleem met registratie');
            }

            $this->email->send();
            return false;
            
        }
    }
    
    function set_session($email){
        /*$sql = "SELECT d FROM usertable WHERE email = '".$email."' LIMIT 1";
        $result = $this->db->query($sql);
        $row = $result->row();
        
        $sess_data = array(
            'id' => $row->id,
            'email' => $email,
            'loggedIn' => 0 //not logged in dus 0
        ); */
        
        $this->session->set_userdata($email);
    }

}
