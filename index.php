<!DOCTYPE=html>
<html lang="en">
<head>
  <link rel="stylesheet" href="custom.css">
  <link href="icons/css/all.css" rel="stylesheet">
  <link href="icons/Academicons/css/academicons.css" rel="stylesheet">
  <title>Conor McCoid</title>
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
<p>Welcome to my personal website.
  My name is Conor McCoid and I am a postdoctoral researcher at the Universit&eacute; Laval.
  You will find here a collection of my published works, presentations and ongoing projects.</p>

<h3>Research Interests</h3>

<dl>
  <dt>Phase field model for fractures</dt>
  <dd>Currently, I am working with Blaise Bourdin at McMaster University to speed up
    computation time of the phase field model for fractures.</dd>

  <dt>Domain decomposition</dt>
  <dd>My PhD work at the University of Geneva with Martin Gander involved domain decomposition.
    I investigated examples of bad behaviour in Schwarz methods accelerated by the Newton-Raphson method (see <a href="publications.php" title="Publications">Presentations</a>).
  </dd>
  <dd>I also constructed algorithms for the intersection of 2D and 3D objects
    to assist in solving grid transfer problems.
    Our paper on the intersection of triangles is published in Transactions on Mathematical Software, an ACM journal.
    The intersection of tetrahedra and higher dimensional simplices are in progress.
  </dd>
  <dd>
    At the Universit&eacute; Laval I developed algorithms for adaptively optimising existing Schwarz methods with Felix Kwok.
  </dd>

  <dt>Spectral collocation</dt>
  <dd>During my masters at Simon Fraser University I worked with Manfred Trummer on pseudospectral integration matrices.
    These matrices are inverses of differentiation matrices constructed using collocation methods.
    I am currently working on extending these ideas to invert more general linear operators.
  </dd>
  <dd>I have also helped develop an algorithm for improving the accuracy for these methods
    in the context of singularly perturbed two-point boundary value problems (see <a href="publications.php" title="Publications">Publicatons</a>).
  </dd>
</dl>

</div>

<?php require_once "footer.php" ?>

</div>

</body>
</html>

<!-- Good things to know:
<a href="url, rel or abs">link</a>
<img src="img location" width="#" height="#" alt="some alt text">
<p style="color:options;">paragraph in colour 'options'</p>
<p title="mouseover text">this paragraph has mouseover text</p>
-->
