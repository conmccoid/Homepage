<!DOCTYPE=html>
<html lang="en">
<head>
  <link rel="stylesheet" href="custom.css">
  <link href="icons/css/all.css" rel="stylesheet">
  <link href="icons/Academicons/css/academicons.css" rel="stylesheet">
  <title>Code</title>
<style>
:root{
  --colour-page: var(--colour-unige);
}

body {
	margin: 0;
	font-family: Arial, Helvetica, sans-serif;
}

.sidebar {
  background-image: linear-gradient(to bottom, rgb(0,0,0,0),rgb(0,0,0,0),var(--colour-page)),
  url(img/MINT_provably_TriIntersectRF_20201005.svg);
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

<div class="topbox" title="Header">
  <div class="topbox-heading" alt="Conor McCoid">
    <h1>Conor McCoid</h1>
      <h3>Code</h3>
  </div>
</div>

<div class="main-content">

<dl>
  <dt><a href="code/PSIM.m">PSIM.m</a></dt>
  <dd>This algorithm is described in detail in "Preconditioning of spectral methods via Birkhoff interpolation" (see Publications).
   An example of its usage is presented <a href="interact/PSIM/html/examplePSIM.html">here</a>.
  </dd>

  <dt><a href="code/Intersect.m">Intersect.m</a></dt>
  <dd>See the preprint "A provably robust algorithm for triangle-triangle intersections in floating point arithmetic" for more information (filed under Publications).
   A working example is presented <a href="interact/triangles/html/exampleCircle.html">here</a>.
  </dd>

  <dt><a href="code/TriIntersect.m">TriIntersect.m</a></dt>
  <dd>An update (13.7.2023) to the subfunction TriIntersect, which calculates the intersection of triangles. This verison is significantly faster.</dd>
</dl>

</div>

<?php require_once "footer.php";?>

</div>

</body>
</html>
