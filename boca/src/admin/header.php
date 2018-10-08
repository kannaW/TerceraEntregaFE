<?php
////////////////////////////////////////////////////////////////////////////////
//BOCA Online Contest Administrator
//    Copyright (C) 2003-2012 by BOCA Development Team (bocasystem@gmail.com)
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
////////////////////////////////////////////////////////////////////////////////
// Last modified 19/oct/2017 by cassio@ime.usp.br

ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
if(!isset($_POST['noflush']))
	ob_end_flush();
//$loc = $_SESSION['loc'];
//$locr = $_SESSION['locr'];
$loc = $locr = "..";
$runphp = "run.php";
$runeditphp = "runedit.php";

require_once("$locr/globals.php");
require_once("$locr/db.php");

if(!isset($_POST['noflush'])) {
	require_once("$locr/version.php");
	echo "<html><head><title>BOCA Administrador en línea de Olimpiadas de Programación - Admin</title>\n";
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
	echo "<link rel=stylesheet href=\"$loc/Css.php\" type=\"text/css\">\n";
	echo "<link rel=stylesheet href=\"../css/estilos.css\" type=\"text/css\">\n";
	echo "<link rel=stylesheet href=\"../css/formularios.css\" type=\"text/css\">\n";
	echo "<link rel=stylesheet href=\"../css/boton.css\" type=\"text/css\">\n";
	echo "<link rel=stylesheet href=\"../css/desplegables.css\" type=\"text/css\">\n";
}

if(!ValidSession()) {
	InvalidSession("admin/index.php");
        ForceLoad("$loc/index.php");
}
if($_SESSION["usertable"]["usertype"] != "admin") {
	IntrusionNotify("admin/index.php");
	ForceLoad("$loc/index.php");
}

if ((isset($_GET["Submit1"]) && $_GET["Submit1"] == "Transfer") ||
    (isset($_GET["Submit3"]) && $_GET["Submit3"] == "Transfer scores")) {
  echo "<meta http-equiv=\"refresh\" content=\"60\" />";
}

if(!isset($_POST['noflush'])) {
	echo "</head><body id=\"body\"><table border=1 width=\"100%\">\n";
	echo "<header>\n";
	echo "<img src=\"../img/banner.jpg\" width=\"80%\" left=\"20%\">\n";
	echo "<div id=\"header\">\n";
	echo "<ul class=\"nav\">\n";
	echo "<li><a href=\"Admin.html\">Home</a></li>\n";
	echo "<li><a href=\"\">Competition</a>\n";
		echo "<ul class=\"sub\">\n";
			echo "<li><a href=run.php>Runs</a></li>\n";
			echo "<li><a href=score.php>Score</a></li>\n";
			echo "<li><a href=clar.php>Clarifications</a></li>\n";
		echo "</ul>\n";
	echo "</li>\n";
	echo "<li><a href=\"\">Users</a>\n";
		echo "<ul class=\"sub\">\n";
			echo "<li><a href=problem.php>Problems</a></li>\n";
			echo "<li><a href=answer.php>Answers</a></li>\n";
			echo "<li><a href=misc.php>Misc</a></li>\n";
			echo "<li><a href=task.php>Task</a></li>\n";
		echo "</ul>\n";
	echo "</li>\n";		
	echo "<li><a href=\"\">Options</a>\n";
		echo "<ul class=\"sub\">\n";
			echo "<li><a href=site.php>Site</a></li>\n";
			echo "<li><a href=contest.php>Contest</a></li>\n";
			echo "<li><a href=log.php>Logs</a></li>\n";
			echo "<li><a href=language.php>Languajes</a></li>\n";
			echo "<li><a href=files.php>BackUps</a></li>\n";
		echo "</ul>\n";
	echo "</li>\n";
	echo "<li><a href=\"\">Reports</a>\n";
		echo "<ul class=\"sub\">\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=2', ".
		"'Complete Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Scoreboard</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=0', ".
		"'Complete Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Detailed Scoreboard</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=0&hor=0', ".
		"'Complete Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Interactive Scoreboard</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=1', ".
		"'Public Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Delayed Scoreboard</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/run.php', ".
		"'Run List','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Run List</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/clar.php', ".
		"'Clarification List','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Clarification List</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/task.php', ".
		"'Task List','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Task List</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/site.php', ".
		"'Start/Stop Logs','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Site Star/Stop Logs</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/icpc.php', ".
		"'ICPC File','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">ICPC File</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/webcast.php', ".
		"'Webcast File','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">WebCast File</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/s4ris.php', ".
		"'S4ris File','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">S4RIS File</a></li>\n";
			echo "<li><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/stat.php', ".
		"'Problem Statistics','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Statistics</a></li>\n";
		echo "</ul>\n";
	echo "</li>\n";
	echo "<li class=\"item-r\"><a href=$loc/index.php>Logout</a></li>\n";
	echo "</ul>\n";
	echo "</div>\n";
	echo "</header>\n";

	/*echo "<tr><td nowrap bgcolor=\"eeee00\" align=center>";
	echo "<img src=\"../images/smallballoontransp.png\" alt=\"\">";
	echo "<font color=\"#000000\">BOCA</font>";
	echo "</td><td bgcolor=\"#eeee00\" width=\"99%\">\n";
	echo "Username: " . $_SESSION["usertable"]["userfullname"] . " (site=".$_SESSION["usertable"]["usersitenumber"].")<br>\n";
	list($clockstr,$clocktype)=siteclock();
	echo "</td><td bgcolor=\"#eeee00\" align=center nowrap>&nbsp;".$clockstr."&nbsp;</td></tr>\n";
	echo "</table>\n";
	echo "<table border=0 width=\"100%\" align=center>\n";
	echo " <tr>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=run.php>Runs</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=score.php>Score</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=clar.php>Clarifications</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=user.php>Users</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=problem.php>Problems</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=language.php>Languages</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=answer.php>Answers</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=misc.php>Misc</a></td>\n";
//echo " </tr></table><hr><table border=0 width=\"100%\" align=center><tr>\n";
	echo " </tr><tr>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=task.php>Tasks</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=site.php>Site</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=contest.php>Contest</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=log.php>Logs</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=report.php>Reports</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=files.php>Backups</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=option.php>Options</a></td>\n";
	echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=$loc/index.php>Logout</a></td>\n";
	echo " </tr>\n"; 
	echo "</table>\n";*/
}

?>
