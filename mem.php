<!DOCTYPE=html>
<html lang="en">
<head>
  <link rel="stylesheet" href="custom.css">
  <link href="icons/css/all.css" rel="stylesheet">
  <link href="icons/Academicons/css/academicons.css" rel="stylesheet">
  <title>Mozart Ex Machina</title>
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
      the music itself. For that, I'm using <a href="https://www.music21.org/music21docs/">music21</a>, an open-source Python toolkit from MIT. This manipulates
      MIDI files, letting me dissect the pieces into their features.
    </p>
    <p>To get the essential components of a MIDI file, one can run the following code snippet.</p>
    <pre><code class="language-python">
      import music21
      midi_data=music21.converter.parse('mz_311_1.mid')
    </code></pre>
    <p>This extracts information from the MIDI file and puts it into the format for music21. From there, we can pick
      out specific measures: <code>midi_data.measure(144).show('text')</code>. This returns all information found in
      measure 144 of this piece, including instruments played, clef, key, tempo, meter, and list of notes.
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

    <p>To extract notes from `midi_data`, we can recurse into each part and measure.</p>
    <pre><code class="language-python">
      data=midi_data.recurse().notes
    </code></pre>
    <p>
      We now have the master list of notes for the entire song.
      The length of this list is the number of notes: `N=len(data)`.
      Each entry is one note or chord, complete with several relevant pieces of information.
      We are interested in three in particular: offset, pitch, and duration.
    </p>
    <p>
      Before we extract these data points, we need to separate chords into individual notes.
      Suppose `data[i]` is a chord, then it is stored as a list of notes.
      We can go through each note in the chord individually.
    </p>
    <pre><code class="language-python">
    def read_chord(chord,group_offset):
      output=[]
      if type(chord)==music21.note.Note:
          output.append(chord.pitch.ps)
          output.append(chord.duration.quarterLength)
          output.append(chord.offset - group_offset)
      elif type(chord)==music21.chord.Chord:
          for k in range(len(chord.notes)):
              noteChord=chord.notes[k]
              output.append(noteChord.pitch.ps)
              output.append(noteChord.duration.quarterLength)
              output.append(noteChord.offset - group_offset)
      return output
    </code></pre>

    <h3>Feature space</h3>
    <p>To feed data into an ANN, we need to divide each datum into features. For this project, each datum is a
      selection of music. Since the music is stored as a sequence of chords, each with a set of notes, an offset,
      a length of time played, etc., the feature space should be precisely these descriptors. That is, for each
      chord in the selection, there is a feature for the set of notes, the offset, and the length of the chord,
      as well as the instrument played and other important details.
    </p>
    <p>The size of each datum can be as small as a single chord or as long as the entire song. However, it must
      be constant.
    </p>
    <p>Notes and their durations and offsets are easily described by numbers.
      Chords, however, are not easily reduced to an ordinal format.
      The complexity of representing chords is rich enough for its own project.
      To sidestep this, we divide each chord into its constituent notes and take as datum sets of n notes.
    </p>
    <p>
      Thus, we are using 3*n features: for each note in the datum, there is its pitch space, its quarter length, and its offset relative to the first note in the sequence.
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
    <p>
      To preprocess the dataset for this portion of the project, we'll need to split up each song, classify each portion, then feed it into one of scikit-learn's classifiers.
      The following function parses an input song and splits up its collection of notes into sequences of n notes using the `read_chord()` function from earlier.
    </p>
    <pre><code class="language-python">
    def read_noteGroups(file,n):
      midi_data=music21.converter.parse(file)
      data=midi_data.recurse().notes
      N=len(data)
      output=[]
      for i in range(N-n):
          group_offset=data[i].offset
          group=[]
          for j in range(n):
              chord_out=read_chord(data[i+j],group_offset)
              for note_out in chord_out:
                  group.append(note_out)
          output.append(group[0:3*n])
      return output
    </code></pre>
    <p>The data is read into Python using the following code.</p>
    <pre><code>
      import music21
      X=[]; y=[]; i=0;
      for ind in ['311','330','331','332','333','545','570']:
          for j in ['_1','_2','_3']:
              i+=1
              pitches_output=read_noteGroups('mozart/mz_'+ind+j+'.mid',20)
              num_output=len(pitches_output)
              for pitch_out in pitches_output:
                  X.append(pitch_out)
                  y.append(i)
    </code></pre>

    <p>
      We'll use scikit-learn's RandomForestClassifier, a random forest model for classifying samples into qualitative groups.
      A random forest model uses a collection of decision trees, with each node on the tree a binary split based on a single variable extracted from the feature space.
      (That is to say, this variable could be a function of many features.)
      As the name suggests, each tree is random, in the sense that the variable chosen at each node is selected randomly.
      The binary split is then chosen based on the data for this variable.
    </p>
    <p>
      For example, consider a computer vision classifier for gender.
      A decision node on a tree in the random forest may use hair length as its variable.
      If hair length correlates strongly with female, then this decision node will split those with long hair into the female category and those with short hair into the male category.
      The tree may continue to grow, adding more decision nodes to further refine its categorization.
    </p>
    <p>There are four main parameters to tweak for this model:</p>
    <ul>
      <li><code>n-estimators</code>: number of trees to make (default 100);</li>
      <li><code>max_features</code>: number of features to consider at each split;</li>
      <li><code>max_depth</code>: maximum number of nodes in each tree;</li>
      <li><code>min_samples_split</code> number of samples split off by each node.</li>
    </ul>
    <p>
      Setting <code>max_depth</code> to <code>None</code> and <code>min_samples_split</code> to 2 results in fully developed trees (all samples split, trees as large as it takes).
      Standard practice is to set max_features to <code>'sqrt'</code> for classification problems like ours.
    </p>
    <p>
      To use RandomForestClassifier, start by initializing the classifier, then feeding it data.
      The list of datum is stored in <code>X</code>, an array with two dimensions.
      Each row (first dimension) of <code>X</code> is a datum, and each element in this row (second dimension) is a feature of the datum.
      The list of classifications of each datum is stored in <code>y</code>, a 1D array, so that the i-th element in <code>y</code> classifies the i-th row of <code>X</code>.
    </p>
    <p>Data is first split into training and testing sets.</p>
    <pre><code>
      from sklearn.model_selection import train_test_split
      X_train, X_test, y_train, y_test = train_test_split(X,y,random_state=0)
    </code></pre>
    <p>We now have datasets to plug into our `RandomForestClassifier()`, which we now need to construct.</p>
    <pre><code>
    from sklearn.ensemble import RandomForestClassifier
    clf = RandomForestClassifier(n_estimators=100, max_features='sqrt', max_depth=None, min_samples_split=2)
    clf.fit(X_train,y_train)
    </code></pre>
    <p>
      With the classifier trained, all that remains is to test it against the test dataset.
      This will give a percentage of the remaining data that the trained classifier gets right.
      A number closer to 1 indicates the classifier is good at classifying these note sequences, while a number closer to 0 indicates it cannot correctly associate note sequences with particular songs.
      With random guesses, a random classifier has a score of 1/m, where m is the number of possible classifications.
      Therefore, a classifier must be better than this to be considered useful.
      In our case, that number is 1/21, or 4.8%.
    </p>
    <pre><code>
    from sklearn.metrics import accuracy_score
    print(accuracy_score(clf.predict(X_test),y_test))
    </code></pre>
    <p>
      I chose to take sequences of 20 notes, resulting in several thousand sequences.
      These had 60 features.
      The resulting score was 87.3%.
      I found that the choice of <code>max_features</code> was particularly critical to the accuracy.
      Even taking longer note sequences, if the classifier could not collect more features, then it was as if these sequences were signficantly shorter.
    </p>
  
  <h3>Mistakes I've made along the way</h3>
    <p>
      One of the biggest blunders I made was my first attempt to annotate the data and encode the feature space.
      I originally tried to split each song into measures, keeping chords whole.
      The problem with this was the number of notes and chords in each measure differs.
      What, then, is the relevant feature space?
      I looked only at the collection of notes for a given measure, ignoring duration and relative offset, then assigned a bit to each note.
      If the note was present in the measure, then the relevant bit was set to 1, and 0 otherwise.
      The size of the feature space would then be the number of unique notes in the collection of songs.
      This ended up being too large, so I also threw out octaves, leaving me with 12 features per measure.
      This was not effective, as it reduced or trivialized much of the information.
    </p>
    <p>
      It also took me a while to realize the importance of the <code>max_features</code> parameter when initializing the classifier.
      I originally thought that I only needed to increase the size of the note sequences, n, to get enough unique information about them.
      But without a corresponding increase in <code>max_features</code>, the classifier couldn't recognize the increase in this size.
      It was only when I switched to using a <code>max_features</code> proportional to n did I see marked improvement in the classifier's accuracy.
    </p>
</div>

<?php require_once "footer.php" ?>

</div>

</body>
</html>