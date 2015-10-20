<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoa extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

	public function index()	{
		$this->load->view('pessoa_cadastrar');
	}
}