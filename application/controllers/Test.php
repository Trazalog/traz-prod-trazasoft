<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function save($code = false)
	{
		echo $this->input->get('code');
		echo $code;
	}
}
