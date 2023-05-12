function M=MeshIntersect(Na,Ta,Nb,Tb)
% INTERFACEMATRIX projection matrix for nonmatching triangular grids
%   M=InterfaceMatrix(Na,Ta,Nb,Tb); takes two triangular meshes Ta
%   and Tb with associated nodal coordinates in Na and Nb and
%   computes the interface projection matrix M
na=size(Ta,1); nb=size(Tb,1);       % number of triangles in each list
cand=[1;1];                         % init. candidate pair
bl=1;                               % list of triangles in Tb to treat
bd=zeros(nb+1,1); bd([1,end])=1;    % flag triangles already treated
M=sparse(size(Nb,2),size(Na,2));
while ~isempty(bl)
    bc=bl(1); bl=bl(2:end);         % pick out 1st tri. in bl
    al=cand(1,(cand(2,:)==bc));     % list of candidates intersecting bc
    al=unique(al);                  % avoid duplicates
    ad=zeros(na+1,1);
    ad(end)=1; ad(al)=1;            % flag triangles of Ta already treated
    while ~isempty(al)
        ac=al(1); al=al(2:end);
        [P,nc,Mc]=Intersect(Nb(:,Tb(bc,1:3)),Na(:,Ta(ac,1:3)));
        if ~isempty(P)
            M(Tb(bc,1:3),Ta(ac,1:3))=M(Tb(bc,1:3),Ta(ac,1:3))+Mc;
            ta=Ta(ac,4:6);          % nhbrs of ac
            al=[al ta(ad(ta)==0)];  % add those nhbrs not treated to al
            ad(ta)=1;               % flag new entries of al
            tb=[ac,ac,ac;Tb(bc,4:6)]; % nhbrs of bc (and index for ac)
            tb=tb(:,nc==1);         % nhbrs of bc which intersect ac
            bl=[bl tb(2,bd(tb(2,:))==0)]; % add those nhbrs not treated to bl
            bd(tb(2,:))=1;          % flag new entries of bl
            cand=[cand tb];         % ac is candidate for new bl entries
        end
    end
end
end

function [P,n,M]=Intersect(X,Y)
% INTERSECT intersection of two triangles and mortar contribution
%   [P,n,M]=Intersect(X,Y); computes for the two given triangles X and
%   Y (point coordinates are stored column-wise, in counter clock
%   order) the points P where they intersect, in n the indices of
%   which neighbors of X are also intersecting with Y, and the local
%   mortar matrix M of contributions of the P1 elements X on the P1
%   element Y. The numerical challenges are handled by including
%   points on the boundary and removing duplicates at the end.

[P1,Q,R,n] = TriIntersect(X,Y);
if size(P1,2)>1                      % if two or more interior points
    n=[1 1 1];                       % the triangle is candidate for all 
end                                  % neighbors
P=[P1 Q R];
P=SortAndRemoveDoubles(P);           % sort counter clock wise
M=zeros(3,3);
if size(P,2)>0
    for j=2:size(P,2)-1              % compute interface matrix
        M=M+MortarInt(P(:,[1 j j+1]),X,Y);
    end
    patch(P(1,:),P(2,:),'m')         % draw intersection for illustration
%  H=line([P(1,:) P(1,1)],[P(2,:),P(2,1)]);
%  set(H,'LineWidth',3,'Color','m');
    pause(0)
end
end

function [P,Q,R,n]=TriIntersect(U,V)
% TRIINTERSECT intersection of two triangles
%   [P,Q,R,n]=TriIntersect(U,V) gives the vertices of U inside V (P),
%   intersections between the edges of U and those of V (Q), the vertices
%   of V inside U (R), and the neighbours of U that also intersect V (n).

v1=V(:,2)-V(:,1);                            % vector between V1 and V2
v2=V(:,3)-V(:,1);                            % vector between V1 and V3
X=[v1,v2]\(U-V(:,1));                        % Step 1: change of coordinates
Q=zeros(2,9); indQ=zeros(1,9); n=zeros(1,3); indP=ones(1,3);
indR=n;                                      % 1-(0,0); 2-(1,0); 3-(0,1)
for i=1:3                                    % Step 2: select ref. line
    [Qtemp,ntemp,indRtemp,sp]=EdgeIntersect(X,i);
    ind=(1:3) + 3*(i-1);                     % indices of Q for this ref. line
    Q(:,ind)=Qtemp; indQ(ind)=ntemp;         % update Q and its non-empty index
    n=max(n,ntemp); indR=max(indR,indRtemp); % update other indices
    indP=indP.*sp;                           % Step 3: vertices of X in Y
end
P=U(:,indP==1);                              % vertices of U in V
Q=V(:,1) + [v1,v2]*Q(:,indQ==1);             % Step 4: reverse change of coordinates
R=V(:,indR==1);                              % vertices of V in U
end

function [Q,ind,indR,sp]=EdgeIntersect(X,edge)
% EDGEINTERSECT intersection of edges of X with reference line of Y
%   [Q,ind,indR,sp]=EdgeIntersect(X,edge) calculates the intersections
%   between all edges of X and the reference line of Y indicated by edge
%   and stores the values in Q. It also calculates Boolean indicators for
%   neighbours of X intersecting Y (ind), vertices of Y inside X (indR),
%   and vertices of X inside Y (sp).

if edge==1                                      % v1
    p=X(2,:); q=X(1,:);                         % parametrization of edge
    a=[1;0]; b=[0;0];                           % inversion of parametrization
    R1=1; R2=2;                                 % vertices of V on edge
elseif edge==2                                  % v2
    p=X(1,:); q=X(2,:); a=[0;1]; b=[0;0]; R1=1; R2=3;
elseif edge==3                                  % line connecting v1 and v2
    p=1-X(1,:)-X(2,:); q=0.5*(1-X(1,:)+X(2,:)); a=[-1;1]; b=[1;0]; R1=2; R2=3;
end
Q=zeros(2,3); ind=zeros(1,3); indR=ind; sp=sign(p)>=0; qold=NaN;
for i=1:3
    j=mod(i,3)+1;
    if sp(i)~=sp(j)                             % vertices on opposite sides of edge?
        q0=(q(i)*p(j)-q(j)*p(i))/(p(j)-p(i));   % calculate intersection
        if q0>=0 && q0<=1                       % intersection lies on edge of Y?
            Q(:,i)=q0*a+b;
            ind(i)=1;
        end
        if isnan(qold)                          % 1st intersection already calculated?
            qold=q0;
        else
            indR(R1)=indR(R1)|sign(qold)~=sign(q0);
            indR(R2)=indR(R2)|sign(qold-1)~=sign(q0-1);
        end
    end
end
end

function P=SortAndRemoveDoubles(P)
% SORTANDREMOVEDOUBLES sort points and remove duplicates
%   P=SortAndRemoveDoubles(P); orders polygon corners in P counter
%   clock wise and removes duplicates

ep=10*eps;                           % tolerance for identical nodes
m=size(P,2); 
if m>0                              
    c=sum(P,2)/m;                      % order polygon corners counter 
    ao=zeros(1,m);
    for i=1:m                          % clockwise
        d=P(:,i)-c; ao(i)=angle(d(1)+1i*d(2));
    end
    [~,id]=sort(ao); 
    P=P(:,id);
    i=1;j=2;                           % remove duplicates
    while j<=m
        if norm(P(:,i)-P(:,j))>ep
            i=i+1;P(:,i)=P(:,j);j=j+1;
        else
            j=j+1;
        end
    end
    P=P(:,1:i);
end
end

function M=MortarInt(T,X,Y)
% MORTARINT computes mortar contributions 
%   M=MortarInt(T,X,Y); computes for triangles X and Y with nodal coordinates 
%   stored columnwise the integrals of all P1 element shape function combinations 
%   between triangles X and Y on triangle T.
%   The result is stored in the 3 by 3 matrix M 


Jd=-T(1,1)*T(2,3)-T(1,2)*T(2,1)+T(1,2)*T(2,3)+T(1,1)*T(2,2)+...
   T(1,3)*T(2,1)-T(1,3)*T(2,2);

a=T(1,1); 
d=T(2,1);
e=-T(2,1)+T(2,2);
b=-T(1,1)+T(1,2);
c=-T(1,1)+T(1,3);
f=-T(2,1)+T(2,3);

T1=1/2*(X(1,1)*(X(2,2)-X(2,3))-X(1,2)*(X(2,1)-X(2,3))+X(1,3)*(X(2,1)-X(2,2)));
T2=1/2*(Y(1,1)*(Y(2,2)-Y(2,3))-Y(1,2)*(Y(2,1)-Y(2,3))+Y(1,3)*(Y(2,1)-Y(2,2)));

A11=1/(2*abs(T1))*((X(2,2)-X(2,3))*b-(X(1,2)-X(1,3))*e);
B11=1/(2*abs(T1))*((X(2,2)-X(2,3))*c-(X(1,2)-X(1,3))*f);
C11=1/(2*abs(T1))*((X(2,2)-X(2,3))*a-(X(1,2)-X(1,3))*d+(X(1,2)*X(2,3)-X(2,2)*X(1,3)));
A12=1/(2*abs(T1))*((X(2,3)-X(2,1))*b+(X(1,1)-X(1,3))*e);
B12=1/(2*abs(T1))*((X(2,3)-X(2,1))*c+(X(1,1)-X(1,3))*f);
C12=1/(2*abs(T1))*((X(2,3)-X(2,1))*a+(X(1,1)-X(1,3))*d-(X(1,1)*X(2,3)-X(2,1)*X(1,3)));
A13=1/(2*abs(T1))*((X(2,1)-X(2,2))*b-(X(1,1)-X(1,2))*e);
B13=1/(2*abs(T1))*((X(2,1)-X(2,2))*c-(X(1,1)-X(1,2))*f);
C13=1/(2*abs(T1))*((X(2,1)-X(2,2))*a-(X(1,1)-X(1,2))*d+(X(1,1)*X(2,2)-X(2,1)*X(1,2)));
A21=1/(2*abs(T2))*((Y(2,2)-Y(2,3))*b-(Y(1,2)-Y(1,3))*e);
B21=1/(2*abs(T2))*((Y(2,2)-Y(2,3))*c-(Y(1,2)-Y(1,3))*f);
C21=1/(2*abs(T2))*((Y(2,2)-Y(2,3))*a-(Y(1,2)-Y(1,3))*d+(Y(1,2)*Y(2,3)-Y(2,2)*Y(1,3)));
A22=1/(2*abs(T2))*((Y(2,3)-Y(2,1))*b+(Y(1,1)-Y(1,3))*e);
B22=1/(2*abs(T2))*((Y(2,3)-Y(2,1))*c+(Y(1,1)-Y(1,3))*f);
C22=1/(2*abs(T2))*((Y(2,3)-Y(2,1))*a+(Y(1,1)-Y(1,3))*d-(Y(1,1)*Y(2,3)-Y(2,1)*Y(1,3)));
A23=1/(2*abs(T2))*((Y(2,1)-Y(2,2))*b-(Y(1,1)-Y(1,2))*e);
B23=1/(2*abs(T2))*((Y(2,1)-Y(2,2))*c-(Y(1,1)-Y(1,2))*f);
C23=1/(2*abs(T2))*((Y(2,1)-Y(2,2))*a-(Y(1,1)-Y(1,2))*d+(Y(1,1)*Y(2,2)-Y(2,1)*Y(1,2)));


M(1,1)=1/24*Jd*(2*A11*A21+B11*A21+A11*B21+2*B11*B21+4*C11*A21+4*A11*C21+4*C11*B21+4*B11*C21+12*C11*C21);
M(1,2)=1/24*Jd*(2*A11*A22+B11*A22+A11*B22+2*B11*B22+4*C11*A22+4*A11*C22+4*C11*B22+4*B11*C22+12*C11*C22);
M(1,3)=1/24*Jd*(2*A11*A23+B11*A23+A11*B23+2*B11*B23+4*C11*A23+4*A11*C23+4*C11*B23+4*B11*C23+12*C11*C23);
M(2,1)=1/24*Jd*(2*A12*A21+B12*A21+A12*B21+2*B12*B21+4*C12*A21+4*A12*C21+4*C12*B21+4*B12*C21+12*C12*C21);
M(2,2)=1/24*Jd*(2*A12*A22+B12*A22+A12*B22+2*B12*B22+4*C12*A22+4*A12*C22+4*C12*B22+4*B12*C22+12*C12*C22);
M(2,3)=1/24*Jd*(2*A12*A23+B12*A23+A12*B23+2*B12*B23+4*C12*A23+4*A12*C23+4*C12*B23+4*B12*C23+12*C12*C23);
M(3,1)=1/24*Jd*(2*A13*A21+B13*A21+A13*B21+2*B13*B21+4*C13*A21+4*A13*C21+4*C13*B21+4*B13*C21+12*C13*C21);
M(3,2)=1/24*Jd*(2*A13*A22+B13*A22+A13*B22+2*B13*B22+4*C13*A22+4*A13*C22+4*C13*B22+4*B13*C22+12*C13*C22);
M(3,3)=1/24*Jd*(2*A13*A23+B13*A23+A13*B23+2*B13*B23+4*C13*A23+4*A13*C23+4*C13*B23+4*B13*C23+12*C13*C23);
end