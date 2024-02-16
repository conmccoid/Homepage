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
    <h1>Mozart Ex Machina</h1>
    <p>In this project, I prototype some new ideas for machine learning algorithms. Currently, artificial
        neural networks (ANNs) have serious problems of reliability, reproducability and stability, which
        collectively erode trust in their results. The hope with my new prototypes is to add transparency
        and robustness to ANNs, thereby restoring confidence in their widespread implementation.
    </p>
    <p>We start small, making sure these ideas can work on the simplest of ANNs. I've chosen to focus on
        the classification and automatic generation of the music of Mozart. I'll be saving my notes and
        observations in this blog, hopefully so others can make use of them.
    </p>

    <h3>Tools and Resources</h3>
    <h4>Dataset</h4>
    <p>The first thing I need for this project is a dataset. Since I've chosen Mozart's music as the focus,
      this means I'll need a selection of his pieces. All of these are in the public domain, and so I am
      free to re-use them however I like. I've taken the pieces from <a href="http://www.piano-midi.de/mozart.htm">http://www.piano-midi.de/mozart.htm</a>,
      where they are stored as MIDI files (more on this file format later). The copyright on this
      website is <a href="https://creativecommons.org/licenses/by-sa/3.0/de/deed.en">cc-by-sa Germany License</a>, which requires that I
      acknowledge the original copyright owner (Bernd Krueger) and make any content built on this data
      available under the same license. This does not apply to the pieces themselves, as they are in the
      public domain.
    </p>
    <p>The dataset contains 21 movements, three each for seven pieces. These pieces are numbered 311, 330, 331, 332,
      333, 545, and 570. Their files names are <code>mz_311_1.mid</code>, indicating composer, piece, and movement.
    </p>
    <h4>Machine learning package</h4>
    <p>Next, I'll need software to program my ANNs. I've gone with <a href="https://scikit-learn.org/stable/getting_started.html">scikit-learn</a>, a Python package designed
      for simple machine learning. It's open-source, which is always good in research because it makes the programs
      accessible. It also means the code won't become useless if a company goes bankrupt. The package uses NumPy,
      SciPy, and matplotlib, so I need to have those installed as well, along with a Python release.
    </p>
    <h4>Music analysis toolkit</h4>
    <p>While scikit-learn will give me the machine learning tools I need, I'm also going to need software to analyze
      the music itself. For that, I'm using <a href="https://web.mit.edu/music21/doc/">music21</a>, an open-source Python toolkit from MIT. This manipulates
      MIDI files, letting me dissect the pieces into their features.
    </p>
    <p>To get the essential components of a MIDI file, one can run the following code snippet.</p>
    <pre><code class="language-python">
      import music21 as m21
      midi_data=m21.converter.parse('mz_311_1.mid')
    </code></pre>
    <p>This extracts information from the MIDI file and puts it into the format for music21. From there, we can pick
      out specific measures: <code>midi_data.measure(144).show('text')</code>. This returns all information found in
      measure 344 of this piece, including instruments played, clef, key, tempo, meter, and list of notes.
    </p>
    <p>The format for music21 stores information as streams. These streams contain all other objects relevant to this
      project. The data extracted from the MIDI files in the dataset is stored as scores. Each of these scores is
      divided into the separate parts, usually Piano Left and Piano Right. These parts are then comprised of the
      measures that make up the piece as well as information that is true of the piece throughout, such as the clef,
      key, meter, and instrument. Note that some of this information may change for some measures. Finally, within
      each measure is a list of notes, rests, and tempos.
    </p>
    <p>While individual measures can be called using <code>midi_data.measure(#)</code>, individual parts have to be
      called as lists, <code>midi_data.parts[0]</code>. The following code snippet returns relevant information on
      the piece and follows from the previous code snippet.
    </p>
    <pre><code class="language-python">
      midi_data.parts[0].clef                                                        # returns the clef
      midi_data.parts[0].getInstrument()                                             # returns the instrument
      midi_data.parts[0].measure(1).notes.show('text') # list of chords, notes and rests, including offset from start of measure
      midi_data.parts[0].measure(1).getElementsByClass('KeySignature').show('text')  # key
      midi_data.parts[0].measure(1).getElementsByClass('TimeSignature').show('text') # meter
      midi_data.parts[0].measure(1).getElementsByClass('MetronomeMark').show('text') # tempo(s)
    </code></pre>

    <h3>Feature space</h3>
    <p>To feed data into an ANN, we need to divide each datum into features. For this project, each datum is a
      selection of music. Since the music is stored as a sequence of chords, each with a set of notes, an offset,
      a length of time played, etc., the feature space should be precisely these descriptors. That is, for each
      chord in the selection, there is a feature for the set of notes, the offset, and the length of the chord,
      as well as the instrument played and other important details.
    </p>
    <p>The size of each datum can be as small as a single chord or as long as the entire song. However, it must
      be constant. Let the number of chords found in each datum be cpd (Chords Per Datum). Each song must then
      be divided into data by taking cpd chords at a time.
    </p>
    <p>The songs as found in the dataset are divided into measures. This suggests we should use measures as the 
      length of each sample. Note, however, that the feature space will become complicated, as the contents of 
      each measure vary significantly. Can each measure be fed into an ANN as is? How can we annotate such a high 
      dimensional sample? What to do with strictly qualitative features?
    </p>

    <h3>Classifier: <b>Name That Tune</b></h3>
    <p>Let's begin with an easy task for scikit-learn to handle: classifying a measure as belonging to a specific
      song. This ANN will be called <b>Name That Tune</b>, or NTT for short.
    </p>
    <p>
      NTT takes a single datum and returns the song title. I have 21 songs composed by Mozart as a dataset. The 
      available classes should then be these 21 songs. Note that each 'song' is in fact a movement in a larger 
      piece. Ideally, this information can also be encoded into NTT.
    </p>
</div>

<?php require_once "footer.php" ?>

</div>

</body>
</html>