<?php

function miniCalendar($month, $year)
{
    if (empty($month)) {
        $current_month = date("n");
    } else {
        $current_month = $month;
    }

    if (empty($year)) {
        $current_year = date("Y");
    } else {
        $current_year = $year;
    }

    $first_day_of_month = mktime(0, 0, 0, $current_month, 1, $current_year);
    $last_day_of_month = mktime(0, 0, 0, $current_month - 1, 1, $current_year);

    //$end_day_of_month = date("w", $last_day_of_month) - 1;
    //echo $end_day_of_month;

    $numberDays = date('t', $first_day_of_month);
    $numberDaysPrev = date('t', $last_day_of_month);

    echo $numberDaysPrev;

    $start_day_of_month = date("w", $first_day_of_month);
    $month_string = date("F", $first_day_of_month);

    echo $start_day_of_month;

    $nextMonth = $current_month + 1;
    $prevMonth = $current_month - 1;

    $prevYear = $current_year;
    $nextYear = $current_year;

    if ($current_month == 12) {
        $nextMonth = 1;
        $nextYear = $current_year + 1;
    } elseif ($current_month == 1) {
        $prevMonth = 12;
        $prevYear = $current_year - 1;
    }

    echo "<div class='center fontChange'>$month_string" . " " . "$current_year</div>";
    echo "<div class='center'><a  href='/calendar.php?month=$prevMonth&year=$prevYear'>Previous</a>&nbsp<a href='/calendar.php?month=$nextMonth&year=$nextYear'>Next</a></div>";

    echo "<table border='1'><tr><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr><tr>";
    $count = 0;
    $prevMonDays = $numberDaysPrev - $start_day_of_month + 1;
    while ($count < $start_day_of_month) {
        echo "<td class='smallerDates'>$prevMonDays</td>";
        $count++;
        $prevMonDays++;
    }
    $countDate = 1;
    while ($count < 7) {
        while ($countDate <= $numberDays) {
            echo "<td>$countDate</td>";
            if (($count + 1) % 7 == 0) {
                echo "</tr><tr>";
            }
            $countDate++;
            $count += 1;
        }
        $nextDates = 1;
        while ($count % 7 != 0) {
            echo "<td class='smallerDates'>$nextDates</td>";
            $count++;
            $nextDates++;
        }
    }
    echo "</tr></table>";
}



function db_connect()
{
    $db = new mysqli("mysql.zhaowenluo.com", "jackluo", "blackjack1010", "mysql_zhaowenluo_com");
    if ($db->connect_errno) {

        echo "Failed to connect to MySQL: (" .
            $db->connect_errno . ") " .
            $db->connect_error;
        return $db;

    }
    return $db;
}



function product_form($action, $name, $description, $price, $cost, $qty_on_hand, $button_name)
{
    $form = <<<FORM

<form class="halfwidth" action="$action" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" value="$name"><br/>
    <label for="description">Description:</label>
    <textarea name="description">$description</textarea><br/>

    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" value="$price"><br/>
    <label for="cost">Cost:</label>
    <input type="number" step="0.01" name="cost" value="$cost"><br/>

    <label for="qty_on_hand">QTY On Hand:</label>
    <input type="number" name="qty_on_hand" value="$qty_on_hand"><br/>
    
    <label for="image">Image:</label>
    <input type="file" name="image"><br/>

    
    <input type="submit" name="submit" value="$button_name">
</form>

FORM;
    return $form;
}




function articles_form($action, $article_title, $author, $date_posted, $article_text, $type)
{
    $form = <<<ENDOFFORM

<form action="$action" method="post">
   <div class="halfwidth">
        <label for="article_title">Article Title</label>
        <input type="text" name="article_title" id="article_title" value="$article_title">
        <br/>
            
        <label for="author">Author</label>
        <input type="text" name="author" id="author" value="$author">
        <br/>
        
        <label for="date_posted">Date</label>
        <input type="date" name="date_posted" id="date_posted" value="$date_posted">
        <br/>
        
        <label for="article_text">Text</label>
        <textarea class="adjustT" name="article_text" id="article_text">$article_text</textarea>
        <br/>
        
        <input type="submit" name="submit" id="submit" value="$type">
   </div>
    
</form>

ENDOFFORM;
    return $form;
}



function blogs_form($action, $blog_title, $author, $date_posted, $blog_text, $type)
{
    $form = <<<ENDOFFORM

<form action="$action" method="post">
   <div class="halfwidth">
        <label for="blog_title">Blog Title</label>
        <input type="text" name="blog_title" id="blog_title" value="$blog_title">
        <br/>
            
        <label for="author">Author</label>
        <input type="text" name="author" id="author" value="$author">
        <br/>
        
        <label for="date_posted">Date</label>
        <input type="date" name="date_posted" id="date_posted" value="$date_posted">
        <br/>
        
        <label for="blog_text">Text</label>
        <textarea class="adjustT" name="blog_text" id="blog_text">$blog_text</textarea>
        <br/>
        
        <input type="submit" name="submit" id="submit" value="$type">
   </div>
    
</form>

ENDOFFORM;
    return $form;
}



function CreateSelectBox($select_name, $items, $selected)
{

    $select_box = "<select name='$select_name'>";

    $count = 0;
    for ($count = 0; $count < count($items); $count++) {
        $select_box .= "<option ";
        if ($items[$count] == $selected) {
            $select_box .= "selected ='selected'";
        }
        $select_box .= '>' . $items[$count] . '</option>';
    }

    $select_box .= '</select>';

    return $select_box;
}


?>