<!DOCTYPE=html>
<html lang="en">
<head>
  <link rel="stylesheet" href="custom.css">
  <link href="icons/css/all.css" rel="stylesheet">
  <link href="icons/Academicons/css/academicons.css" rel="stylesheet">
  <link rel="icon" href="img/McMaster_icon.png">
  <title>Ongoing projects</title>
<style>
:root{
  --colour-page: var(--colour-maintheme);
}
  
body {
	margin: 0;
	font-family: Arial, Helvetica, sans-serif;
}

.sidebar {
  background-image: url(img/TIKZ_tetra_Configurations_20201005.svg);
  background-position: center 20px;
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
    <h1>Ongoing Research</h1>
    <dl>
      <dt><a href="ongoing/mccoid2020tetrahedra.pdf">Tetrahedral intersections</a></dt>
      	<dd>This is the follow-up to my paper "A provably robust algorithm for 2D triangle-triangle intersections in floating-point arithmetic" (see Publications).
	It discusses in detail the 3D version of the algorithm found there as well as how to extend the algorithm to arbitrary dimensions.</dd>
      <dt><a href="ongoing/IOM.pdf">IOMcc</a></dt>
        <dd>The continuation of my masters thesis.
	This looks at extending the results of my paper "Preconditioning of spectral methods via Birkhoff interpolation" to general linear operators, with a focus on constant coefficient linear operators.</dd>
      <dt><a href="ongoing/ASPN.pdf">RASPEN period doubling</a></dt>
      	<dd>Accelerating Schwarz methods with Newton-Raphson has been thought to be stable, safe and fast.
	This research examines some counterexamples where chaos can occur.</dd>
      <dt><a href="ongoing/StochasticNetworks.pdf">Stochastic network model of an epidemic</a></dt>
      	<dd>As part of an ongoing <a href="https://www.unige.ch/math/covid19">COVID project</a>, this research looks to use stochastic networks to model the spread of a virus through a population.
	Many difficulties arise, including computational time and the unidirectional flow of infections.</dd>
    </dl>
</div>

<?php require_once "footer.php";?>

</div>

</body>
</html>
