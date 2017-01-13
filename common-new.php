<?php

function error_handler($errno, $errstr, $errfile, $errline)
{
 fprintf(STDERR, "File \"%s\", Line %u: %s\n", $errfile, $errline, $errstr);
 exit(1);
}

set_error_handler("error_handler");
error_reporting(E_ALL);
setlocale(LC_ALL, 'en_US.UTF8');
header("Content-type: text/html; charset=utf-8");
mb_internal_encoding("UTF-8");
mb_http_output( "UTF-8" );

function PageBegin($subtitle = "", $include_fud_js = FALSE)
{
?>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title><?php if($subtitle == "") { ?>Mednafen - Multi-system Emulator<?php } else { echo "Mednafen - " . htmlspecialchars($subtitle); } ?></title>
  <?php if($include_fud_js) { ?><script language="javascript" src="/lib.js" type="text/javascript"></script><?php } ?>
  <style type="text/css"><!--
	body
	{
	 background-color: #000000;
	 color: #e0ffe0;
	 margin-top: 0px;
	}
	a:link
	{
	 color: #90cfff;
	}
	a:visited
	{
	 color: #e0ffe0;
	}
	a:hover
	{
	 color: #FF00FF;
	}
	.ContentBox
	{
	 clear: both;
	 border: 1px solid #004000;
	 margin-bottom: 1em;
	}
	.ContentBoxBody
	{
	 border: 1px solid #004010;
	 border-top: none;
	 padding: 0.5em;
	 background-color: #000010;
	}
	.ContentBoxBody h3
	{
	 background-color: #001030;
	 padding: 0.2em;
	 font-size: 100%;
	 margin: 0px;
	}
	.ContentBoxSub
	{
	 border: 1px solid #004000;
	 margin-bottom: 1em;
	 padding: 0.2em;
	}
	.ContentBoxBodySub
	{
	 padding: 0.6em;
	}
	h2.ContentBoxHead
	{
	 margin: 0px;
	 font-size: 100%;
	 font-weight: bold;
	 border: 1px solid black;
	 border-bottom: 1px solid #00453e;
	 background-color: #000000;
	 background-image: url('/headerbg.png');
	 background-repeat: repeat-x;
	 color: #e0ffe0;
	 padding: 0.5em;
	 padding-left: 0.2em;
	}
	.CopyrightBox
	{
	 border: 1px solid #808080;
	 padding: 0.3em;
	 font-style: italic;
	 font-size: small;
	 background-color: #101010;
	}
	.NavBox
	{
	 font-size: 1.25em;
	 padding: 0.5em;
	 clear:both;
	 text-align: center;
	}
	.NavBox a
	{
	 text-decoration: none;
	 padding: 4px 12px 4px 12px;
	 border: 1px solid #002050;
	}
	.NavBox a:hover
	{
	 text-decoration: none;
	 background-color: #002020;
	}
	acronym
	{
	 text-decoration: none;
	 border: 0px;
	}
	h1
	{
	 padding: 0px;
	 border: 0px;
	 margin: 0px;
	}
	img
	{
	 border: 0px;
	}

	ul.ReleaseList
	{
	 margin-left: 0em;
	 padding-left: 1em;
	}

	ul.ReleaseList >li
	{
	 padding-top: 0.4em;
	 padding-bottom: 0.5em;
	 list-style-type: none;
	}

	ul.ReleaseList li li
	{
	 padding-top: 0.1em;
	 padding-bottom: 0.5em;
	}


	.dashed {
	 border: 1px dashed #1B7CAD;
	}
   --></style>
 </head>
 <body>
  <div style="text-align: center"><h1><acronym title="My emulator doesn't need a frickin' excellent name!"><a href="/"><img alt="Mednafen" width="696" height="204" src="/newlogo.png"></img></a></acronym></h1></div>
<div class="NavBox">
<a href="/releases/">Releases</a>
<a href="http://forum.fobby.net/">Forum</a>
<a href="/links/">Links</a>
<a href="/documentation/">Documentation</a>
<a href="/irc/">IRC</a>
<a href="http://forum.fobby.net/index.php?t=thread&frm_id=6&">FAQ</a>
</div>
<br />
<?php
}

function PageEnd()
{
 ?>
  <div class="CopyrightBox">
   Page design and original content copyright &copy; 2005-2017 Mednafen Team.  The Mednafen Beetle is copyright &copy; 2005 <a href="http://camilleart.com/">Camille Young</a>.  Nintendo,
   Nintendo Entertainment System, GameBoy, GameBoy Color, and GameBoy Advance are registered trademarks of <a href="http://www.nintendo.com/">Nintendo</a>.  Mednafen is <b>not</b> an official Nintendo product, and Mednafen is in no way affiliated with the Nintendo corporation.
  </div>
  </body>
</html>
 <?php
}
?>
