<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="application/public/css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body> 
<h1>Welcome back</h1>
<br />
&nbsp;<a href="?route=users/logout">Logout</a>
<br /><br />
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top">
		<fieldset>
        <legend>Your Profile information in our database</legend>
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
		<tbody>
		  <tr>
			<td width="10%"><b>User ID</b></td>
			<td width="83%">&nbsp; <?= $user_data["id"] ?></td>
		  </tr> 
		  <tr>
			<td width="10%"><b>Email</b></td>
			<td width="83%">&nbsp; <?= $user_data["email"] ?></td>
		  </tr> 
		  <tr>
			<td width="10%"><b>First name</b></td>
			<td width="83%">&nbsp; <?= $user_data["first_name"] ?></td>
		  </tr> 
		  <tr>
			<td width="10%"><b>Last name</b></td>
			<td width="83%">&nbsp; <?= $user_data["last_name"] ?></td>
		  </tr> 
		  <tr>
			<td width="10%"><b>Password</b> generated?</td>
			<td width="83%">&nbsp; <b style="color:green"><?= $user_data["password"] ?></b></td>
		  </tr> 
		</tbody>
		</table>
      </fieldset>
	</td>
  </tr>
</table>

<?php if($user_authentication): ?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
	<td valign="top">
		<fieldset>
		<legend>Associated authentications</legend> 
			<table width="100%" cellspacing="0" cellpadding="3" border="0">
			<tbody>
			  <tr>
				<td width="15%"><b>Provider</b></td>
				<td width="85%">&nbsp; <?= $user_authentication["provider"] ?></td>
			  </tr> 
			  <tr>
				<td><b>Provider UID</b></td>
				<td>&nbsp; <?= $user_authentication["provider_uid"] ?></td>
			  </tr>
			  <tr>
				<td><b>Display name</b></td>
				<td>&nbsp; <?= $user_authentication["display_name"] ?></td>
			  </tr>  
			  <tr>
				<td><b>User profile URL</b></td>
				<td>&nbsp; <?= $user_authentication["profile_url"] ?></td>
			  </tr>  
			</tbody>
			</table> 
	  </fieldset>
	</td>
  </tr>
</table>
<br />
&nbsp; <b style="color:red">Note</b>: You can login now on either with your <b>Email</b> and <b>Password</b> or using your <b><?= $user_authentication["provider"] ?> account</b>.
<?php else: ?> 
&nbsp; <b style="color:red">Note</b>: This user do not have any provider associated to him.
<?php endif; ?>
</body>
</html>