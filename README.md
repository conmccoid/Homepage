# Homepage
repo for professional website

## Project parameters

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

### Technical information

- Server: IA-Hotel, 208.68.162.229
- Connection type: SFTP
- FTP Hostname: ftp.conormccoid.com
- Address of website: http://www.conormccoid.com
- Address of files: /writable/public_html

## Naming conventions and best practices
### Images

Images will follow the naming convention:
>	FORMAT_Topic_subject_v1_YYYYMMDD.svg
- FORMAT: 	3 to 4 letter indicator of how the file was created:
	- MTLB: MATLAB;
	- TIKZ: TIKZ standalone, see Tutorials below.
- Topic: 	identifies topic within research project the image relates to.
- subject: identifies purpose of image.
- v1: 		version number.
- YYYYMMDD: 	date of initial creation.
- .svg:		file format; use .eps for vector graphics when possible.

### Code

>	TYPE_Function_v1_YYYYMMDD.m
- TYPE:		3 to 4 letters denoting intended result of the script:
	- PLOT: produces a plot, MTLB_extrap_Function_v1_YYYYMMDD.eps;
	- SUB: subfunction, used in another function;
	- EXP: computational experiment/test/example problem;
	- MESH: mesh generation;
	- ALGO: implementation of algorithm.
- Function:	name to indicate related topic or result.
- v1:		version number.
- YYYYMMDD:	date of initial creation.
- .m:		file format.

### Publications

In the case where .pdfs are available, we will use the Google Scholar naming convention for articles:
>	mccoid2020provably.pdf
- mccoid: last name of first author.
- 2020: year of publication.
- provably: first significant word appearing in the title.

It is important that the posting of these publications aligns with copyright law.
Check [Sherpa Romeo](https://v2.sherpa.ac.uk/romeo/) for copyright information for each specific journal.
Most journals should indicate their copyright requirements when sending the AAM or VOR.

### Presentations

As many presentations share titles with articles, the same naming conventions cannot apply.
As such, we add the FORMAT indicator:
>	TALK_algoritmy_2020_provably.pdf
- TALK: to indicate a talk. Use POST for poster.
- algoritmy: name of conference.
- 2020: year of conference.
- provably: 1st non-article word appearing in title.
- .pdf: format of document.

In this way, presentations will be organized first by type, then by conference, then by year.

Some presentations are made using reveal.js.
These will be kept in a separate Github repo, with links to its Github Pages on the presentations page.

# Branding
Most branding decisions are made in the `custom.css` file, which also lists other options should the need arise.

### Colour scheme
The primary colour of the website is Medium Violet Red.
This is used in the header and the sidebar.
It is contrasted against a motif of Lavender Blush.

The secondary colour, used in the footer, is Dim Gray.
This had to be changed while at McMaster as the McMaster logo uses a gray too close to this shade to be distinguished.

## Tutorials
### Instructions for creating TIKZ_...svg files

1. Make a TIKZ_...tex file containing:
```
\documentclass[tikz]{standalone}
\begin{document}
  \begin{tikzpicture}
		...
  \end{tikzpicture}
\end{document}
```
2. Open the resulting TIKZ_...pdf file in Inkscape and save as a TIKZ_...svg.

### Instructions for saving MATLAB figures without whitespace

1. Set h to figure:
`h=figure(1);`
2. Export as .eps or other file type:
`exportgraphics(h,'PLOT_filename.eps')`
3. File will be found in the current MATLAB folder.
