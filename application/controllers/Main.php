<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login controller class
 */
class Main extends CI_Controller{

  function login() {
      $data['title'] = 'Login Form';
      $this->load->view("login_view",$data);
  }

  function login_validation() {
    $this->load->library("form_validation");
    $this->form_validation->set_rules('username','Username', 'required');
    $this->form_validation->set_rules('password','Password', 'required');
    if ($this->form_validation->run()) {
      $username = $this->input->post('username');
      $password = $this->input->post('password');

      $this->load->model('login_model');

      if ($this->login_model->can_login($username, $password)) {
        $session_data = array (
          'username' => $username
          );
        $this->session->set_userdata($session_data);
        redirect(base_url() . 'main/enter');
      }
      else {
        $this->session->set_flashdata('error', 'Invalid Username and Password');
        redirect(base_url() . 'main/login');
      }
    }
    else {
      $this->login();
    }
  }

  function enter(){
    if($this->session->userdata('username') != ''){
      //echo '<h2>Welcome - '.$this->session->userdata('username').'</h2>';
      redirect(base_url() . 'home');
      echo '<a href="'.base_url().'main/login">Logout</a>';
    }
    else {
      redirect(base_url() . 'main/login');
    }
  }

  function logout(){
    $this->session->unset_userdata('username');
    redirect(base_url().'main/login');
  }
}
?>