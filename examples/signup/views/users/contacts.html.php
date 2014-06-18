<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="application/public/css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body> 
<h1>User contacts</h1>
<br />
<ul>
<?php foreach ($user_contacts as $uc): ?>
    <li><?php echo $uc->displayName.' '.$uc->email ?></li>
<?php endforeach; ?>
</ul>
</body>
</html>