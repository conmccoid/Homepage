<!DOCTYPE=html>
<html lang="en">
<head>
  <link rel="stylesheet" href="custom.css">
  <link href="icons/css/all.css" rel="stylesheet">
  <link href="icons/Academicons/css/academicons.css" rel="stylesheet">
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
  url(img/PHO_portrait_VancouverSidebar_20190815.jpg);
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
    <h3>GeoGebra demo of PANG2</h3>
    <iframe src="https://www.geogebra.org/calculator/gn2p9mxu?embed" width="800" height="600" allowfullscreen style="border: 1px solid #e4e4e4;border-radius: 4px;" frameborder="0"></iframe>
</div>

<?php require_once "footer.php" ?>

</div>

</body>
</html>