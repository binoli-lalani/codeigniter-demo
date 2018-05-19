<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 

    'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>

<head>    
    <title><?php echo $title; ?></title>
</head>
<body>
    <div id='login_form'>
        <form action='<?php echo base_url();?>main/login_validation' method='post' name='process'>
            <h2>User Login</h2>
            <br />
            <label for='username'>Username</label>
            <input type='text' name='username' id='username'  class='form-control' size='25' /><br />
            <span class="text-danger"><?php $this->load->library('form_validation'); 
                                            echo form_error('username'); ?></span>
        
            <label for='password'>Password</label>
            <input type='password' name='password' id='password' class='form-control' size='25' /><br />                            
            <span class="text-danger"><?php $this->load->library('form_validation'); echo form_error('password'); ?></span>

            <input type='Submit' value='Login' />
            <?php
              echo $this->session->flashdata('error');
            ?>
        </form>
    </div>
</body>
</html>