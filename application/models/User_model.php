<?php
define('PATH', dirname(__FILE__));
class User_model extends CI_model{

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

public function __construct(){

    parent::__construct();
    $this->load->helper('url');
    

require_once __DIR__ . '/vendor/autoload.php';
  }

  public function register_user($user){
    $this->db->insert('user', $user);
  }

  public function login_user($email,$pass){

    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('user_email',$email);
    $this->db->where('user_password',$pass);

    if($query=$this->db->get())
    {
        return $query->row_array();
    }
    else{
      return false;
    }
  }

  public function email_check($email){

    $this->db->select('*');
    $this->db->from('user');
    $this->db->where('user_email',$email);
    $query=$this->db->get();

    if($query->num_rows()>0){
      return false;
    }else{
      return true;
    }
  }

  public function ForgotPassword($email) {
    $this->db->select('user_email');
    $this->db->from('user'); 
    $this->db->where('user_email', $email); 
    $query=$this->db->get();
    return $query->row_array();
  }

  public function sendpassword($data) {
    $email = $data['user_email'];
    $query1=$this->db->query("SELECT *  from user where user_email = '".$email."' ");
    $row=$query1->result_array();
    if ($query1->num_rows()>0) {
      $passwordplain = "";
      $passwordplain  = rand(999999999,9999999999);
      $newpass['user_password'] = md5($passwordplain);
      $this->db->where('user_email', $email);
      $this->db->update('user', $newpass); 
      $mail_message='Dear '.$row[0]['user_name'].','. "\r\n";
      $mail_message.='Thanks for contacting regarding to forgot password,<br> Your <b>Password</b> is <b>'.$passwordplain.'</b>'."\r\n";
      $mail_message.='<br>Please Update your password.';
      $mail_message.='<br>Thanks & Regards';
      $mail_message.='<br>Your company name';        
      date_default_timezone_set('Etc/UTC');
      //require FCPATH.'assets/PHPMailer/PHPMailerAutoload.php';
      //require("phpMailer/PHPMailerAutoload.php");
      $mail = new \PHPMailer;
      $mail->isSMTP();
      $mail->SMTPSecure = "tls"; 
      $mail->Debugoutput = 'html';
      $mail->Host = "smtp.gmail.com";
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->Username = "johnnyharpertesting1@gmail.com";
      $mail->Password = "addweb123";
      $mail->setFrom('admin@site', 'admin');
      $mail->IsHTML(true);
      $mail->addAddress($email);
      $mail->Subject = 'OTP from company';
      $mail->Body    = $mail_message;
      $mail->AltBody = $mail_message;
      if (!$mail->send()) {
        $this->session->set_flashdata('msg','Failed to send password, please try again!');
      }
      else {
        $this->session->set_flashdata('msg','Password sent to your email!');
      }
      redirect(base_url().'user/login_view','refresh');
    }
    else {
      $this->session->set_flashdata('msg','Email not found try again!');
      redirect(base_url().'user/login_view','refresh');
    }
  }
}


?>
