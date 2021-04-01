<?php include("../common-new.php"); PageBegin("Releases"); ?>
<div class="ContentBox">
<h2 class="ContentBoxHead">Notes and Errata:</h2>
<div class="ContentBoxBody">
<p>
<font color="yellow">Before upgrading from 0.9.x to 1.x, please read the <a href="https://forum.fobby.net/index.php?t=msg&th=1652">1.21.0-UNSTABLE release announcement</a>.</font>
</p>

<p>
When using ALSA sound output under Linux, the <a href="/documentation/mednafen.html#sound.device">"sound.device"</a> setting "default" is Mednafen's default, AKA "hw:0", not
ALSA's "default".  If you want to use ALSA's "default", use "sexyal-literal-default".
</p>
</div>
</div>

<div class="ContentBox">
<h2 class="ContentBoxHead">Downloads:</h2>
<div class="ContentBoxBody">
<a href="/documentation/ChangeLog.txt">ChangeLog</a>

<p>
For the Windows builds, Windows XP or newer required.
Windows 8 and newer will work, but their use is discouraged unless Mednafen is running in fullscreen mode(for video lag and quality reasons).  Using the 64-bit build is recommended, for better performance and functionality.
</p>
<?php
 function ReleaseFile($base, $version, $suffix, $purpose, $first)
 {
  $frfn = strtolower($base) . '-' . $version . $suffix;
  $frfp = 'files/' . $frfn;
  if(file_exists($frfp))
  {
   if($first)
   {
    $lfp = 'files/' . strtolower($base) . '-' . 'latest' . $suffix;
    if(file_exists($lfp))
     unlink($lfp);
    symlink($frfn, $lfp);
    $first = FALSE;
   }

   echo '<li><a href="/releases/' . htmlspecialchars($frfp) . '">' . htmlspecialchars($purpose) . '</a>';
   return TRUE;
  }
  return FALSE;
 }

 function Release($version, $reldate, $base, $first)
 {
  echo '<li><b>' . htmlspecialchars($base) . ' ' . htmlspecialchars($version) . '</b> <i>(' . htmlspecialchars($reldate) . ')</i>';
  echo '<ul>';

  if(!ReleaseFile($base, $version, ".tar.xz", "Source code", $first))
  {
   ReleaseFile($base, $version, ".tar.gz", "Source code", FALSE);
   ReleaseFile($base, $version, ".tar.bz2", "Source code", FALSE);
  }
  ReleaseFile($base, $version, "-win32.zip", "32-bit Windows", $first);
  ReleaseFile($base, $version, "-win64.zip", "64-bit Windows (Recommended)", $first);

  echo '</ul>';
 }

 function PrintReleases($listpath, $base)
 {
  echo '<ul class="ReleaseList">';
  $fp = fopen($listpath, "rb");

  $counter = 0;
  $first = TRUE;
  $release_version = $release_date = "";
  while(FALSE !== ($line = fgets($fp)))
  {
   $line = trim($line);

   if(!strlen($line) || $line[0] == '#' || $line[0] == ';')
    continue;

   if(sscanf($line, "%[^!]!%[^\n]", $release_version, $release_date) == 2)
   {
    Release($release_version, $release_date, $base, $first);
    $first = FALSE;
   }
   else
   {
    fprintf(STDERR, "Malformed release line: %s\n", $line);
    exit(1);
   }
   $counter++;
   if($counter == 3)
    break;
  }

  fclose($fp);

  echo '</ul>';
 }
?>

<?php PrintReleases("RELEASES", "Mednafen"); ?>
</ul>
<hr>
<a name="mednafen-server" href="/releases/ChangeLog.server.txt">Mednafen-Server Changelog</a>
<?php PrintReleases("RELEASES-SERVER", "Mednafen-Server"); ?>
</div>
</div>

<div class="ContentBox">
<h2 class="ContentBoxHead">Compiling from Sources:</h2>
<div class="ContentBoxBody">
<table border>
<tr><td colspan="4">Library dependencies for Mednafen >= 1.21.0-UNSTABLE, plus the development package names for various distributions that need to be installed.</td></tr>
<tr><th>&nbsp;</th><th>Debian Stretch</th></tr>
<tr><td>(General)</td><td>build-essential<br>pkg-config</td></tr>
<tr><td>ALSA</td><td>libasound2-dev</td></tr>
<tr><td><a href="http://libsdl.org/">SDL 2.0.5+</a></td><td>libsdl2-dev</td></tr>
<tr><td><a href="https://xiph.org/flac/">libFLAC</a></td><td>libflac-dev</td></tr>
<tr><td><a href="http://www.mega-nerd.com/libsndfile/">libsndfile</a></td><td>libsndfile1-dev</td></tr>
<tr><td><a href="http://www.zlib.org/">zlib</a></td><td>zlib1g-dev</td></tr>
</table>
<p />
<hr>
Mednafen has been successfully compiled on:
<ul>
<li>FreeBSD
<li>Linux
<li>NetBSD
<li>OpenBSD
<li>Windows
</ul>
</div>
</div>

</div>
</div>
<?php PageEnd(); ?>
