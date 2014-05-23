<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="application/public/css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<center>
<br />
<h1>Create a new account</h1>
<?php if (isset($error_message)) { echo $error_message; } ?>
<br /> 
<br />
<form action="" method="post">
<table width="00%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top"><fieldset>
        <legend>Sign-up form</legend>

        <table width="300" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td><div align="right"><strong>Email</strong></div></td>
            <td><input name="email" type="text" size="55" value="<?= isset($email) ? $this->e($email) : '' ?>" /></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Password</strong></div></td>
            <td><input type="text" name="password" size="30" value="<?= isset($password) ? $this->e($password) : '' ?>" /></td>
          </tr>
          <tr>
            <td nowrap="nowrap"><div align="right"><strong>First name</strong></div></td>
            <td><input name="first_name" type="text" size="30"  value="<?= isset($first_name) ? $this->e($first_name) : '' ?>" /></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Last name</strong></div></td>
            <td><input type="text" name="last_name" size="30"  value="<?= isset($last_name) ? $this->e($last_name) : '' ?>" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="Create new account" /> </td>
          </tr>
        </table> 
      </fieldset></td>
    <td valign="top"> 
		<fieldset>
			<legend>Already have an account?</legend>
			&nbsp;&nbsp;<a href="?route=users/login">Sign-in</a><br />  
		</fieldset>  
	  </td>
  </tr>
</table>
</form> 
</center>
</body>
</html>