<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
<link rel="stylesheet" href="application/public/css.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php
    // if we got an error then we display it here
    if ($error) {
        echo '<p><h3 style="color:red">Authentication error!</h3>' . $error . '</p>';
        echo "<pre>Session:<br />" . print_r( $_SESSION, true ) . "</pre><hr />";
    }
?> 
</body>
</html>