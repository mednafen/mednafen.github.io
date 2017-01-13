<?php include("../common-new.php"); PageBegin("Releases"); ?>
<div class="ContentBox">
<h2 class="ContentBoxHead">Notes and Errata:</h2>
<div class="ContentBoxBody">
<p>
Save states from 0.8.x and earlier are not compatible with 0.9.x, as the save state format(and file extension) have changed.  Additionally,
save states from older 0.9.x releases may or may not work entirely correctly with newer 0.9.x releases(if there's a particularly big breakage, however,
it will be noted in the release announcement).
</p>

<p>
Mednafen's configuration file name has changed to "mednafen-09x.cfg" for 0.9.x releases, due to a large number of backwards-incompatible
setting-related changes.
</p>

<p>
When using ALSA sound output under linux, the <a href="/documentation/mednafen.html#sound.device">"sound.device"</a> setting "default" is Mednafen's default, AKA "hw:0", not
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
 function ReleaseFile($base, $version, $suffix, $purpose)
 {
  $frfp = 'files/' . strtolower($base) . '-' . $version . $suffix;
  if(file_exists($frfp))
  {
   echo '<li><a href="/releases/' . htmlspecialchars($frfp) . '">' . htmlspecialchars($purpose) . '</a>';
  }
 }

 function Release($version, $reldate, $base)
 {
  echo '<li><b>' . htmlspecialchars($base) . ' ' . htmlspecialchars($version) . '</b> <i>(' . htmlspecialchars($reldate) . ')</i>';
  echo '<ul>';

  ReleaseFile($base, $version, ".tar.xz", "Source code");
  ReleaseFile($base, $version, ".tar.bz2", "Source code");
  ReleaseFile($base, $version, ".tar.gz", "Source code");
  ReleaseFile($base, $version, "-win32.zip", "32-bit Windows");
  ReleaseFile($base, $version, "-win64.zip", "64-bit Windows (Recommended)");

  echo '</ul>';
 }

 function PrintReleases($listpath, $base)
 {
  echo '<ul class="ReleaseList">';
  $fp = fopen($listpath, "rb");

  //$first = TRUE;
  $release_version = $release_date = "";
  while(fscanf($fp, "%[^!]!%[^\n]", $release_version, $release_date) == 2)
  {
   //if($first)
   //{
   // @unlink("files/mednafen-latest.tar.bz2");
   // symlink("mednafen-" . $release_version . ".tar.bz2", "files/mednafen-latest.tar.bz2");
   // $first = FALSE;
   //}

   Release($release_version, $release_date, $base);
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
<tr><td colspan="4">Library dependencies for Mednafen >= 0.9.38, plus the development package names for various distributions that need to be installed.</td></tr>
<tr><th>&nbsp;</th><th>Debian Squeeze</th><th>Fedora Core 4</th></tr>
<tr><td>(General)</td><td>build-essential<br>pkg-config</td><td>&nbsp;</td></tr>
<tr><td>ALSA</td><td>libasound2-dev</td><td>&nbsp;</td></tr>
<tr><td><a href="http://libsdl.org/">libSDL</a></td><td>libsdl1.2-dev</td><td>SDL-devel</td></tr>
<tr><td><a href="http://www.mega-nerd.com/libsndfile/">libsndfile</a></td><td>libsndfile1-dev</td><td>libsndfile-devel(extras)</td></tr>
<tr><td><a href="http://www.zlib.org/">zlib</a></td><td>zlib1g-dev</td><td>zlib-devel</td></tr>
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
