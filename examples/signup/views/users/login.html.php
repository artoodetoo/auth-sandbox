<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="application/public/css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<center>
<br />
<h1>Simple login web page</h1>
<br />
<?php if (isset($error_message)) { echo $error_message; } ?>
<br />
<br />
<table width="00%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top"><fieldset>
        <legend>Sign-in form</legend>
        <form action="" method="post">
		<table width="300" border="0" cellpadding="2" cellspacing="2">
          <tr>
            <td><div align="right"><strong>Email</strong></div></td>
            <td><input type="text" name="email" /></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Password</strong></div></td>
            <td><input type="text" name="password" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="right"><input type="submit" value="Sign-in" /> </td>
          </tr>
        </table>
		</form>
      </fieldset></td>
    <td valign="top" align="left"> 
		<fieldset>
			<legend>Don't have an account yet?</legend>
			&nbsp;&nbsp;<a href="?route=users/register">New Account Signup</a><br />
		</fieldset> 

		<fieldset>
			<legend>Or use anohter service</legend>
<?php foreach ($providers as $provider): ?>
            &nbsp;&nbsp;<a href="?route=authentications/authenticate_with/<?= strtolower($provider) ?>">Sign-in with <?= $provider ?></a><br /> 
<?php endforeach; ?>
		</fieldset>
	  </td>
  </tr>
</table> 
</center>
 
</body>
</html>