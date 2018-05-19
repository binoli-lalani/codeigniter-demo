<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login controller class
 */
class Adminlogin extends CI_Controller{

	public function index()
    {
        $this->isLoggedIn();
    }

    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('/admin');
        }
    }

  // function login() {
  //     $data['title'] = 'Login Form';
  //     $this->load->view("login",$data);
  // }

  function login_validation() {
    $this->load->library("form_validation");
    $this->form_validation->set_rules('username','Username', 'required');
    $this->form_validation->set_rules('password','Password', 'required');
    if ($this->form_validation->run()) {
      $username = $this->input->post('username');
      $password = $this->input->post('password');

      $this->load->model('admin/admin_login_model');

      if ($this->admin_login_model->can_login($username, $password)) {
        $session_data = array (
          'username' => $username
          );
        $this->session->set_userdata($session_data);
        redirect(base_url() . 'admin/home');
      }
      else {
        $this->session->set_flashdata('error', 'Invalid Username and Password');
        redirect(base_url() . 'admin/login');
      }
    }
    else {
      $this->isLoggedIn();
    }
  }

  function enter(){
    if($this->session->userdata('username') != ''){
      echo '<h2>Welcome - '.$this->session->userdata('username').'</h2>';
      echo '<a href="'.base_url().'admin/login">Logout</a>';
    }
    else {
      redirect(base_url() . 'admin/login');
    }
  }

  function logout(){
    $this->session->unset_userdata('username');
    redirect(base_url().'admin/login');
  }
}
?>