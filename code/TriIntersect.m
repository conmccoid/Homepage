function [P,Q,R,n]=TriIntersect(U,V)
% TRIINTERSECT intersection of two triangles
%   [P,Q,R,n]=TriIntersect(U,V) gives the vertices of U inside V (P),
%   intersections between the edges of U and those of V (Q), the vertices
%   of V inside U (R), and the neighbours of U that also intersect V (n).
v1=V(:,2)-V(:,1);               % vector between V1 and V2
v2=V(:,3)-V(:,1);               % vector between V1 and V3
X=[v1,v2]\(U-V(:,1));           % Step 1: change of coordinates
X=[X;1-X(1,:)-X(2,:)]; % values of the barycentric coordinates
sX=sign(X)>=0;                  % signs of the barycentric coordinates
n=zeros(1,3);                   % storage of nhbrs of U
if prod(sum(sX,2))==0
    P=[]; R=[]; Q=[];               % intersection is empty
else
    P=U(:,prod(sX)==1);             % vertices of U in V
    S=false(3);                     % storage of int. indicators
    indj=[1,2,3;2,3,1];             % ordering of edges (must match listing in triangulation)
    for i=1:3                       % for each ref. line
        for j=1:3                   % for each edge of X
            j1=indj(1,j); j2=indj(2,j); % identify vertices assoc. w/ edge
            if sX(i,j1)~=sX(i,j2)   % determine if they intersect
                S(i,j)=true;
            end
        end
    end
    
    sQ=false(3,3,3);            % storage for signs of intersections
    indQ=false(1,9);            % indicators for intersections in Y
    Q=zeros(2,9);               % storage for intersection coord.s
    indi=1:3;
    for j=indi                  % for each pair of X vertices
        j1=indj(1,j); j2=indj(2,j); % pairs of X vertices
        flagQ=false(3,3);       % flags for calculated intersections
        for i=indi(S(:,j))      % for each ref. line w/ an int.
            k1=mod(i,3)+1; k2=mod(i+1,3)+1;
            for k=[k1,k2]       % for each remaining coord.
                % following if/else corresponds to decision tree of Fig. 6
                if ~S(k,j)      % inherited sign (Fig. 5)
                    sQ(i,k,j)=sX(k,j1);
                elseif flagQ(k,i) % paired sign (Table 2)
                    % NB: this is a new formula for paired signs, developed
                    %  for the general dimension case but applicable here
                    sQ(i,k,j)=~xor(sQ(k,i,j),~xor(sX(i,j1),sX(k,j2)));
                else            % need to calculate sign directly
                    q=EdgeIntersect(X([i,k],j1),X([i,k],j2));
                    Q(k,j+3*(i-1))=q;
                    flagQ(i,k)=true;
                    sQ(i,k,j)=sign(q)>=0;
                end
            end
            if sQ(i,k1,j) && sQ(i,k2,j) % both coord.s positive
                if ~flagQ(i,k1) && k1~=3 % first coord. already calculated
                    Q(k1,j+3*(i-1))=EdgeIntersect(X([i,k1],j1),X([i,k1],j2));
                end
                if ~flagQ(i,k2) && k2~=3 % second coord. already calculated
                    Q(k2,j+3*(i-1))=EdgeIntersect(X([i,k2],j1),X([i,k2],j2));
                end
                indQ(j+3*(i-1))=true; % intersection lies in V
                n(j)=1;         % nhbrs of U that also intersect V
            end
        end
    end
    Q=V(:,1) + [v1,v2]*Q([1,2],indQ);% Step 4: reverse change of coordinates

    indR=false(1,3);            % storage for indices of vertices of V
    for i=indi                  % for each ref. line
        j=indi(S(i,:));         % identify which intersections exist
        if ~isempty(j)          % if there is one
            j1=j(1); j2=j(2);   % then there are two
            % for ref. line i=1, k=2, which share vertex 1
            % i=2, k=3, which share vertex 2
            % i=3, k=1, which share vertex 3
            k=mod(i,3)+1;       % pick only one vertex for each ref. line
            if sQ(i,k,j1)~=sQ(i,k,j2) % if intersections on opposite sides of vertex
                indR(i)=true;   % then vertex of V lies in U
            end
        end
    end
    R=V(:,indR);            % vertices of V in U
end
end

function q=EdgeIntersect(x,y)
% EDGEINTERSECT computes intersection between a line and an axis
%   q=EdgeIntersect(x,y) returns the intersection between the line with
%   vertices at coordinates (x(1),x(2)) and (y(1),y(2)) and the axis in the
%   first variable. The coordinates of the intersection are then (0,q).

% NB: this can be replaced with any formula that computes the root of a
% linear function in 1D
q = ( x(1)*y(2) - x(2)*y(1) )/(x(1) - y(1));
end