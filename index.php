<?php

include('libWordSearch.php');

$tmp = file("words");
$default_words = array();
foreach ($tmp as $line) {
  $default_words[] = trim($line);
}

$words_to_use = (isset($_REQUEST['words']) && is_array($_REQUEST['words'])) ? $_REQUEST['words'] : $default_words;

$crap = New WordSearch ($words_to_use);

//print_r($crap->arrayOfColorsForWord);

?>
<html>
  <head>
    <title>word search</title>
    <script src="prototype.js" type="text/javascript"></script>
    <script>
      function show_solution () {
        $A($$('.letter')).each(function (td) {
            word = td.classNames().grep("word")
            word = word.toString().replace("word_", "");
            td.toggleClassName('color_' + word);
        });
      }
    </script>
    <style>
<?php
  foreach ($crap->arrayOfColorsForWord as $word => $color) {
    echo '.color_'.$word.' { background-color: #'.strtolower($color).'; } '."\n";
  }
?>
      .hint {
        background-color: #e0e0e0;
      }

      ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
      }

      li {
        margin: 0;
        padding: 0;
      }

      td {
        padding: 0.5em;
      }
    </style>
  </head>
  <body>
  <form action="?" method="post">
  <table border="1">
    <tr>
      <td>
        <table border=0 cellspacing=0 cellpadding=2>
<?php
for ($x=0; $x<=$crap->width; $x++) {
   echo '<tr>';
   for ($y=0; $y<=$crap->length; $y++) {
      $chr = $crap->puzzle[$x][$y];
      if (!strlen($chr)) {
         $chr = '<td>'.$crap->rndchar().'</td>';
      }
      echo $chr;
   }
   echo '</tr>';
}
?>
        </table>
      </td>
      <td valign="top">
        <h1>Words</h1>
        <ul>
<?php
  for($i=0; $i<10; $i++) {
    $word = (isset($_REQUEST['words'][$i]) ? $_REQUEST['words'][$i] : $default_words[$i]);
    echo '<li>'
    . '<input type="text" name="words[]" value="'.$word.'" class="color_'.$word.'"/>'
    . '</li>';
  }
?>
        </ul>
        <br/>
        <input id="solve" type="checkbox" onclick="show_solution()"/>
        <label for="solve">Show Solution?</label>
        <br/>
        <br/>
        <input type="submit" value="Generate"/>
      </td>
    </table>
    </form>
  </body>
</html>
