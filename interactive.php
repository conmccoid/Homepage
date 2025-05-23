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
    <h3><a href="geogebra.php">GeoGebra demo of PANG2</a></h3>
    <h3><a href="mem.php">Mozart Ex Machina</a></h3>
      <p>Machine learning prototyping project</p>

    <h2>Test suites from publications</h2>
    <ul>
      <li><a href="interact/TetIA/TestSuite.zip">Tetrahedral intersection algorithm</a></li>
      <li><a href="interact/AOSM/TestSuite.zip">Adaptive optimized Schwarz method</a></li>
    </ul>
</div>

<?php require_once "footer.php" ?>

</div>

</body>
</html>