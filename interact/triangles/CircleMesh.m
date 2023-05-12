function [N,T,Np] = CircleMesh(n,epsilon,theta)
% CIRCLEMESH constructs a circular mesh
%   [N,T] = CircleMesh(n) constructs a grid of n+1 points N,
%   containing the origin and n points evenly distributed on the unit
%   circle, and a triangulation of these points T such that the unit circle
%   is divided into n equal triangles.
%
%   [N,T,Np] = CircleMesh(n,error) additionally constructs a second grid of
%   points Np with the central point shifted randomly by O(error) and the 
%   points along the unit circle rotated by a random O(error) number of
%   radians. Np uses the same triangulation, T, as N.

ind = 0:(n-1);
N = [cos(ind*2*pi/n), 0; sin(ind*2*pi/n), 0];       % grid points
T = [(n+1)*ones(n,1), mod(ind'+1,n), mod(ind'+2,n),... % triangle vertices
       mod(ind',n), (n+1)*ones(n,1), mod(ind'+2,n)];   % triangle neighbours
   % neighbours are listed in the order of the vertices they share:
   % T(i,4) shares vertices T(i,1) and T(i,2); T(i,5)--T(i,2) and T(i,3);
   % T(i,6)--T(i,3) and T(i,1).
T(T==0)=n;  % periodicity: the last grid point/triangle neighbours the first
if nargin>=2 && nargout==3
    if nargin<3
        theta=epsilon;
    end
    r = theta*rand(1)*2*pi/n;       % radians rotated
    Np= [cos(ind*2*pi/n + r), epsilon*rand(1)-0.5*epsilon;... % x-shifts
         sin(ind*2*pi/n + r), epsilon*rand(1)-0.5*epsilon];   % y-shifts
end