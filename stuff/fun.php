<?php
/**
 * Created by PhpStorm.
 * User: Jack
 * Date: 1/26/2017
 * Time: 3:41 PM
 */

$a = 13;
echo "This is a fun page";
if ($a = 13){
    echo "You are too young for this page ";
}else if ( $a ){

}

//echo '<table><tr><td>1</td></tr><tr><td>1</td></tr><tr><td>1</td></tr></table>';

$count = 0;
while ($count < 20){
    echo "$count : hello\n<br/>";
    $count += 1;
}

$count = 0;
while ($count <= 100){
    if ($count % 5 == 0){
        echo "$count<br/>";
    }
    $count += 1;
}


for ($count=0; $count < 100; $count++){
    if($count % 3 ==0){
        echo "I'm $count years old<br/>";
    }
}

echo "<table border='1'>";
for ($count=0; $count < 100; $count++){
    echo "<tr><td>$count</td></tr>";
}
echo "</table>";



echo <<<ENDOFTABLE

<table>
    <tr>
        <td>
            $a
        </td>
    </tr>
    <tr>
        <td>
            $a
        </td>
    </tr>
    <tr>
        <td>
            $a
        </td>
    </tr>
</table>
ENDOFTABLE;

$table = <<<ENDOFTABLE

<table>
    <tr>
        <td>
            jack
        </td>
    </tr>
    <tr>
        <td>
            is
        </td>
    </tr>
    <tr>
        <td>
            kool
        </td>
    </tr>
</table>

ENDOFTABLE;

echo $table;

?>

<b>Hello</b>

<table>
    <tr>
        <td>
            1
        </td>
    </tr>
    <tr>
        <td>
            1
        </td>
    </tr>
    <tr>
        <td>
            1
        </td>
    </tr>
</table>


