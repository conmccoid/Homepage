<?php
require_once 'lib/Parsedown.php';
$Parsedown = new Parsedown();
$markdown = file_get_contents('MSCW/README.md');
$htmlContent = $Parsedown->text($markdown);
?>

<!DOCTYPE=html>
<html lang="en">
<head>
  <link rel="stylesheet" href="custom.css">
  <link href="icons/css/all.css" rel="stylesheet">
  <link href="icons/Academicons/css/academicons.css" rel="stylesheet">
  <link rel="icon" href="img/McMaster_icon.png">
  <title>Interactive</title>
<style>
:root{
  --colour-page: var(--colour-maintheme);
}

body {
	margin: 0;
	font-family: Arial, Helvetica, sans-serif;
}

.sidebar {
  background-image: linear-gradient(to bottom, rgb(0,0,0,0),rgb(0,0,0,0),var(--colour-page)),
  url(img/McMaster_icon.png);
}

.sidebar-background {
  background-image: none;
}  

dt {
    font-weight: bold;
    padding: 5px;
}

dd {
    text-align: justify;
}
</style>
</head>

<body>
  <?php require_once "sidebar.php";?>

<div class="main">

<?php require_once "header.php";?>

<div class="main-content">
    <?=$htmlContent?>
</div>

<?php require_once "footer.php" ?>

</div>

</body>
</html>