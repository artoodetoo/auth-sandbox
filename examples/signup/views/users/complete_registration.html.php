<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="application/public/css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<center>
<br />
<h1>Hi there, be cool and complete your registration</h1>
we need your email and a password at least
<br />
<?php if (isset($error_message)) { echo $error_message; } ?>
<br />
<br />
<form action="" method="post">
<table width="500" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top"><fieldset>
      <legend>My information</legend>
      
      <table width="500" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td><div align="right"><strong>Email</strong></div></td>
          <td><input name="email" type="text" size="55" value="<?= isset($user_data['email']) ? $this->e($user_data['email']) : '' ?>" /></td>
          </tr>
        <tr>
          <td><div align="right"><strong>Password</strong></div></td>
          <td><input type="text" name="password" size="30" value="<?= isset($user_data['password']) ? $this->e($user_data['password']) : '' ?>" /> auto genrated for you</td>
          </tr>
        <tr>
          <td nowrap="nowrap"><div align="right"><strong>First name</strong></div></td>
          <td><input name="first_name" type="text" size="30" value="<?= isset($user_data['first_name']) ? $this->e($user_data['first_name']) : '' ?>" /></td>
          </tr>
        <tr>
          <td><div align="right"><strong>Last name</strong></div></td>
          <td><input type="text" name="last_name" size="30" value="<?= isset($user_data['last_name']) ? $this->e($user_data['last_name']) : '' ?>" /></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="right"><input type="submit" value="Complete my registration" /> - <a href="?route=users/logout">Logout</a> </td>
          </tr>
        </table> 
    </fieldset></td>
    </tr>
</table>
</form> 
</center>
 
</body>
</html>