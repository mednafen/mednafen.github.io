<?php
//
// XML parsing skeleton and setup code(for the news feed) is largely from an example in the PHP documentation.
//

 include("common-new.php");

 PageBegin("", TRUE);
?>
<div class="ContentBox">
 <h2 class="ContentBoxHead">Introduction to Mednafen</h2>
 <div class="ContentBoxBody">
 <p>
 Mednafen is a portable, utilizing OpenGL and SDL, argument(command-line)-driven multi-system emulator.
 Mednafen has the ability to remap hotkey functions and virtual system inputs to a keyboard, a joystick, or both simultaneously.  Save states are supported, as is real-time game rewinding.
 Screen snapshots may be taken, in the <a href="http://libpng.org/">PNG</a> file format, at the press of a button.  Mednafen can record
 audiovisual movies in the QuickTime file format, with <a href="/documentation/09x/mednafen.html#qtrecord.vcodec">several different lossless codecs</a> supported.
 </p>
 <p>
 The following systems are supported(refer to the emulation module documentation for more details):
 <ul>
  <li>Atari Lynx</li>
  <li>Neo Geo Pocket (Color)</li>
  <li>WonderSwan</li>
  <li>GameBoy (Color)</li>
  <li>GameBoy Advance</li>
  <li>Nintendo Entertainment System</li>
  <li>Super Nintendo Entertainment System/Super Famicom</li>
  <li>Virtual Boy</li>
  <li>PC Engine/TurboGrafx 16 (CD)</li>
  <li>SuperGrafx</li>
  <li>PC-FX</li>
  <li>Sega Game Gear</li>
  <li>Sega Genesis/Megadrive</li>
  <li>Sega Master System</li>
  <li>Sega Saturn <i>(experimental, x86_64 only)</i></li>
  <li>Sony PlayStation</li>
 </ul>
 </p>
 <p>
 Mednafen is distributed under the terms of the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU GPLv2</a>.
 </p>
 <p>
 Due to the threaded model of emulation used in Mednafen, and limitations of SDL, a joystick is preferred over a keyboard to play games,
 as the joystick will have slightly less latency, although the latency differences may not be perceptible to most people.
 </p>
 </div>
</div>
<div class="ContentBox">
 <h2 class="ContentBoxHead">News</h2>
 <div class="ContentBoxBody">
<?php


$file = "http://forum.fobby.net/rdf.php?mode=m&borg=1&l=1&basic=1&frm=19&n=10";
$depth = 0;
$names = array();
$valid = 0;

function startElement($parser, $name, $attrs)
{
   global $depth;
   global $names;
   global $flimflam;
   global $valid;

   $valid = strtolower($name);
   if($name == "ITEM")
   {
    $flimflam = array();
    $flimflam['url'] = $attrs['RDF:ABOUT'];
   }
   $names[$depth] = $name;
   $depth++;
}

function characterData($parser, $data)
{
   global $flimflam;
   global $valid;
   global $depth;

   if($depth == 3)
   {
    if(!isset($flimflam[$valid]))
     $flimflam[$valid] = '';

    $flimflam[$valid] .= $data;
   }
}

function endElement($parser, $name)
{
   global $depth;
   global $names;
   global $valid;
   global $flimflam;
   $depth--;

   //echo($depth[$parser] . $name . $filmflam['title'] . "<br>");
   if($name == "ITEM")
   {
    sscanf($flimflam['dc:date'], "%u-%u-%uT%u:%u:%u-%u:%u", $dt_year, $dt_month, $dt_day, $dt_hour, $dt_minute, $dt_second, $dt_to_hour, $dt_to_minute);
    $unixytime = mktime($dt_hour, $dt_minute, $dt_second, $dt_month, $dt_day, $dt_year);
//    $prettytime = $flimflam['dc:date'];
//    $prettytime = strftime("%B %e, %Y - %H:%M UTC", $unixytime);
    $prettytime = strftime("%B %e, %Y - %H:%M %Z", $unixytime);

    echo('<div class="ContentBoxSub">');
    echo('<h3><a href="' . htmlspecialchars($flimflam['url']) . '">'. htmlspecialchars($flimflam['title']) . '</a><span style="float: right;">' . htmlspecialchars($prettytime) . '</span>' . '</h3>');
    echo('<div class="ContentBoxBodySub">');
    echo($flimflam['description']);
    echo('</div>');
    echo('</div>');
    echo('<br>');
   }
}

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");

if (!($fp = fopen($file, "r"))) {
   die("could not open XML input");
}

while ($data = fread($fp, 4096)) {
   if (!xml_parse($xml_parser, $data, feof($fp))) {
       die(sprintf("XML error: %s at line %d",
                   xml_error_string(xml_get_error_code($xml_parser)),
                   xml_get_current_line_number($xml_parser)));
   }
}
xml_parser_free($xml_parser);

?>
 </div>
</div>
<br />
<?php PageEnd(); ?>
