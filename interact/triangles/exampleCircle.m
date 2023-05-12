%% Circle example
% To test out our new algorithm for triangle-triangle intersections, we
% take an example suggested by Frederic Hecht. We begin by constructing a
% mesh representing a circle. There is a point at the centre and a number
% of points around the perimeter, equally spaced.
% Next, we make a copy of this mesh, adjust its position slightly and
% rotate  is by a small fraction of pi.

[N,T,Np]=CircleMesh(20,0.5*eps);
PlotMesh(N,T,'b')
PlotMesh(Np,T,'r')

%%
% The two meshes appear identical, but there is a separation between them.
% This separation is so small it can cause errors when trying to intersect
% the meshes. We use the original PANG to intersect them.

M = PANG(N,T,Np,T);

%%
% We see that PANG is unable to calculate the intersection of all of the
% triangles. We try again with our new algorithm.

clf
PlotMesh(N,T,'b')
PlotMesh(Np,T,'r')
M = MeshIntersect(N,T,Np,T);