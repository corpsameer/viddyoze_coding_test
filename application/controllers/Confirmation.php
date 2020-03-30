<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Confirmation extends CI_Controller {
    public function index() {
        $this->load->view('common/header');
        $this->load->view('confirmation');
        $this->load->view('common/footer');
    }
}
