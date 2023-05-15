%--Introduction

This project is intended as a personal website to help promote and distribute my scientific works.
The website is intended to have a homepage with a picture of me, explaining the site and my research interests.
Links off of this page will lead to a list of my publications, presentations and software.

The layout, as planned, will have a sidebar featuring images related to my research, such as those found in my
publications.
While mousing over this sidebar, links will expand to direct persons towards the other pages.
These links will initially be presented as icons, unfolding to proper links on mouse over.

The header will change based on the current page.
On the homepage it will have my name.
On other pages, it will give a title to the things presented there.

The footer will contain contact information, including academic social media accounts such as ORCID, Scopus,
Research Gate and others.
Email addresses will also be included, using current institutional.
Office address should appear as well, but not phone number (office phone as a possible exception).

%--Images

All images will be kept in a separate 'img' folder.
They will be labelled using the following convention:
	FORMAT_origin_SpecificTopic_YYYYMMDD.svg
FORMAT: 3 or 4 letter indicator of how the file was created, ie. TIKZ for tikzpicture, INK for inkscape, etc.
origin: lowercase word indicating what topic the image relates to, ex. if it comes from the publication entitled
	'A provably robust algorithm for triangle-triangle intersections in floating point arithmetic' then
	origin is set to 'provably', the first non-article word in the title (see convention for publications).
SpecificTopic: further classification based on topic, meant to describe the image in one or two words.
YYYYMMDD: date of initial creation of the image. This is done largely for archival purposes and is not expected
	to be useful for identification, hence it appears last in the name.
.svg: it is expected that this will be the most used file format for images, though .png and .jpeg are also options.

%====Instructions for creating TIKZ_...svg files

	1. Make a TIKZ_...tex file containing:
		\documentclass[tikz]{standalone}
		\begin{document}
		\begin{tikzpicture}
			...
		\end{tikzpicture}
		\end{document}
	2. Open the resulting TIKZ_...pdf file in Inkscape and save as a TIKZ_...svg.

%====Instructions for saving MATLAB figures without whitespace

	1. Set h to figure:
		h=figure(1);
	2. Export as .eps or other file type:
		exportgraphics(h,'PLOT_filename.eps')
	3. File will be found in the current MATLAB folder.

%--Publications

Publications will probably be shared via links sent by publishers.
In the case where .pdfs are available, I will use the Google Scholar naming convention for articles:
	mccoid2020provably.pdf
mccoid: my last name (or last name of 1st author, if applicable).
2020: year of publication.
provably: first non-article word appearing in the title.

It is important that the posting of these publications aligns with copyright law.
Check Sherpa Romeo (https://v2.sherpa.ac.uk/romeo/) for copyright information for each specific journal.
Most journals should indicate their copyright requirements when sending the AAM or VOR.

%--Presentations

As many presentations share titles with articles, the same naming conventions cannot apply.
As such, we add the FORMAT indicator:
	TALK_algoritmy_2020_provably.pdf
TALK: to indicate a talk. Use POST for poster.
algoritmy: name of conference.
2020: year of conference.
provably: 1st non-article word appearing in title.
.pdf: format of document.

In this way, presentations will be organized first by type, then by conference, then by year.

%--Code

Only completed, published code will be included.
For example, PSIM.m and Intersect.m from published or submitted articles.
Additionally, examples explaining how to use them will be added, such as the one from my masters thesis and the Hecht example.
These examples will follow a more rigorous naming convention than the code.

%--Technical information

Server: IA-Hotel, 208.68.162.229
Username: conormcc (password stored with Google)
Connection type: SFTP
FTP Hostname: ftp.conormccoid.com
Address of website: http://www.conormccoid.com
Address of files: /writable/public_html

To access from Ubuntu, go to Other Locations then enter sftp://mccoid@luniwebeol1.unige.ch

SSH keys should be available under the .ssh folder
