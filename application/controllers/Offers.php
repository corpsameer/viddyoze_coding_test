<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offers extends CI_Controller {
    public function index() {
        $this->load->view('common/header');
        $this->load->view('offers');
        $this->load->view('common/footer');
    }
}
