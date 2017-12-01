<?php

$page_title = "Calendar";
require "templates/header.php";
require "templates/functions.php";

$month = $_GET['month'];
$year = $_GET['year'];


//echo "<a href='/calendar.php?month=9'>Previous</a>&nbsp<a href='/calendar.php?month=11'>Next</a>";
//echo date("F j, Y");
//echo "<br/>Time started seconds since: ";
//echo mktime(0,0,0,10,1,2016);
//$current_month = $month;//date("n");
//$current_year = $year;//date("Y");

miniCalendar($month, $year);

require "templates/footer.php";

?>
