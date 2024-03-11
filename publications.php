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
  url(img/MAT_improved_expTT203bSidebar_20180819.png);
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

    <h1>Publications</h1>

  <h3>Peer-reviewed</h3>

    <p>Manuscripts found on this page are accepted preprints. They are made available under the <a href="https://creativecommons.org/licenses/by/4.0/">CC-BY 4.0 license</a>,
    unless noted otherwise. For versions of record, please see individual publishers. Where available, DOI links are provided.</p>

  <dl>
    <dt><a href="pubs/mccoid2022chaotic.pdf">Cyclic and chaotic examples in Schwarz-preconditioned Newton methods</a>,
      with Martin J. Gander, preprint, accepted to Domain Decomposition Methods in Science and Engineering XXVII (2023) <i class="ai ai-springer"></i></dt>
    <dd>Accelerating domain decomposition methods with Newton's method is known to not have guaranteed convergence.
Earlier work by the authors gave insight into why this occurs in 1D.
This current paper expands on that work by considering the problem in higher dimensions.
We provide a methodology for finding chaotic examples and highlight it with a particular counterexample.</dd>
    
    <dt><a href="pubs/mccoid2022extrapolation.pdf">Extrapolation methods as nonlinear Krylov methods</a>,
      with Martin J. Gander, <a href="https://www.sciencedirect.com/science/article/pii/S0024379523001301?casa_token=JCu_x6gV5xYAAAAA:rU47MpM6QGJJgYA9IhyrNgeI3E9CKNXMSa1rqeeTx1o5dw3BdhFD_Fn7AARw5s0Bylwp-2fc1iU">Linear Algebra and its Applications</a> (2023) <i class="ai ai-elsevier"></i> <i class="fab fa-creative-commons-by"></i><i class="fab fa-creative-commons-nc"></i><i class="fab fa-creative-commons-nd"></i></dt>
    <dd>When applied to linear vector sequences, extrapolation methods are equivalent to Krylov subspace methods.
    Both types of methods can be expressed as particular cases of the multisecant equations, the secant method 
    generalized to higher dimensions. Through these equations, there is also equivalence with a variety of 
    quasi-Newton methods. This paper presents a framework to connect these various methods.</dd>
    <dd>

    <dt><a href="pubs/mccoid2021cycles.pdf">Cycles in Newton-Raphson preconditioned by Schwarz (ASPIN and its cousins)</a>
      with Martin J. Gander, Domain Decomposition Methods in Science and Engineering XXVI (2023) <i class="ai ai-springer"></i></dt>
    <dd>Newton-Raphson preconditioned by Schwarz methods does not have sufficient convergence criteria.
We explore an alternating Schwarz method accelerated by Newton-Raphson to find an example where the underlying Schwarz method converges but the Newton-Raphson acceleration fails.
Alternating Schwarz is posed as a fixed point iteration to make use of theory for generic root-finding methods.
An algorithm is proposed combining several aspects of this theory and others to guarantee convergence.</dd>

    <!--triangles paper, update pdf, check rights-->
    <dt><a href="pubs/PRE_mccoid2021provably.pdf">A provably robust algorithm for triangle-triangle intersections in floating point arithmetic</a>,
      with Martin J. Gander, <a href="https://doi.acm.org?doi=3513264">Trans. on Mathematical Software</a>, 48(2) (2022) <i class="ai ai-acm"></i> <i class="fab fa-creative-commons-by"></i><i class="fab fa-creative-commons-nc"></i></dt>
    <dd>Motivated by the unexpected failure of the triangle intersection component of the Projection Algorithm for
    Nonmatching Grids (PANG), this article provides a robust version with proof of backward stability. The new
    triangle intersection algorithm ensures consistency and parsimony across three types of calculations. The set
    of intersections produced by the algorithm, called representations, is shown to match the set of geometric
    intersections, called models. The article concludes with a comparison between the old and new intersection
    algorithms for PANG using an example found to reliably generate failures in the former.</dd>
    <dd>See the <a href="https://www.growkudos.com/publications/10.1145%25252F3513264/reader">Kudos</a> page for a lay explanation of the algorithm.</dd>
    <dd>Since publication, I have written a new, more efficient version of the algorithm which performs
      the smallest number of calculations. It can be found <a href="code/TriIntersect.m">here</a> and is also available on the <a href="code.php">Code page</a>.
    </dd>

    <dt><a href="pubs/mccoid2019improved.pdf">Improved Resolution of Boundary Layers for Spectral Collocation</a>,
      with Manfred Trummer, SIAM J. Sci. Comput. 41-5 (2019)</dt>
    <dd>We propose a new algorithm to improve the accuracy of spectral methods for singularly 
      perturbed two-point boundary value problems. Driscoll and Hale [J. Numer. Anal., 36 (2016), 
      pp. 108--132] suggest resampling as an alternative to row replacement when including boundary 
      conditions. Testing this with an iterated sine-transformation 
      [T. Tang and M. R. Trummer [SIAM J. Sci. Comput., 17 (1996), pp. 430--438] designed for 
      boundary layers reveals artificial boundary conditions imposed by the transformation. 
      The transformation is regularized to prevent this. The new regularized sine-transformation 
      is employed to solve boundary value problems with and without resampling. It shows superior 
      accuracy provided the regularization parameter is chosen from an optimal range.</dd>

    <dt><a href="http://rdcu.be/BfA4">Preconditioning of spectral methods via Birkhoff interpolation</a>, 
      with Manfred Trummer, Numerical Algorithms, 79(2), 555-573 (2018) <i class="ai ai-springer"></i></dt>
    <dd>High-order differentiation matrices as calculated in spectral collocation methods 
      usually include a large round-off error and have a large condition number 
      (Baltensperger and Berrut Computers and Mathematics with Applications 37(1), 41– 48 1999; 
      Baltensperger and Trummer SIAM J. Sci. Comput. 24(5), 1465–1487 2003; Costa and Don Appl. 
      Numer. Math. 33(1), 151–159 2000). Wang et al. (Wang et al. SIAM J. Sci. Comput. 36(3), 
      A907–A929 2014) present a method to precondition these matrices using Birkhoff interpolation. 
      We generalize this method for all orders and boundary conditions and allowing arbitrary 
      rows of the system matrix to be replaced by the boundary conditions. 
      The preconditioner is an exact inverse of the highest-order differentiation matrix 
      in the equation; thus, its product with that matrix can be replaced by the identity matrix. 
      We show the benefits of the method for high-order differential equations. 
      These include improved condition number and, more importantly, higher accuracy of solutions 
      compared to other methods.</dd>
  </dl>
  
  <!--
  <h3>Submitted for review</h3>

  <dl>    
  </dl>
-->

  <h3>Theses</h3>

  <dl>
    <dt><a href="https://archive-ouverte.unige.ch/unige:164515">Towards robustness in algorithms: accelerated domain decomposition, multisecant equations, and simplicial intersections</a>,
    PhD thesis, supervised by Martin J. Gander, Universit&eacute; de Gen&egrave;ve (2022)</dt>
    <dd>This thesis can be divided into three parts: cycles in domain decomposition methods; 
      the equivalence between extrapolation methods and Krylov subspace methods, and; the 
      intersection of simplices.</dd>

    <dt><a href="pubs/mccoid2018spectral.pdf">Spectral Differentiation: Integration and Inversion</a>,
    masters thesis, supervised by Manfred Trummer, Simon Fraser University (2018)</dt>
    <dd>Pseudospectral differentiation matrices suffer from large round-off error, and give
       rise to illconditioned systems used to solve differential equations numerically. This 
       thesis presents two
      types of matrices designed to precondition these systems and improve robustness towards
      this round-off error for spectral methods on Chebyshev-Gauss-Lobatto points. The first
      of these is a generalization of a pseudospectral integration matrix described by Wang et
      al. [18]. The second uses this integration matrix to construct the matrix representing the
      inverse operator of the differential equation. Comparison is made between expected and
      calculated eigenvalues. Both preconditioners are tested on several examples. In many cases,
      accuracy is improved over the standard methodology by several orders of magnitude. Using
      these matrices on general sets of points is briefly discussed.</dd>
  </dl>

  <!--phd thesis, link to archive ouverte?-->
</div>

<?php require_once "footer.php";?>

</div>

</body>
</html>
