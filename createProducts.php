<?php

require_once 'autoload.php';
include "templates/functions.php";




/*
echo "<br/>";
echo $faker->address;
echo "<br/>";
echo $faker->company;
echo "<br/>";
echo $faker->bs;
*/


$db = db_connect();
$faker = Faker\Factory::create();

$count = 0;
while ($count < 100){


    $name = $faker->name;
    $description = $faker->sentence;
    $ingredients = $faker->paragraph;
    $instructions = $faker->text;
    $prep_time = rand(5, 130);
    $rating = rand(1, 5);

    $sql = "INSERT into recipes (id,name,description,ingredients,instructions,prep_time,rating, created_date, modified_date)
            VALUES (null, '$name', '$description','$ingredients' , '$instructions', $prep_time, $rating, now(), now())";
    echo $sql . "<br/>";
    $result = $db->query($sql);


    $recipe_id = $db->insert_id;
    $num_reviews = rand(0, 10);
    $review_num = 0;

    while ($review_num < $num_reviews){


        $author = $faker->company;
        $review = $faker->text;
        $rating = rand(1, 5);

        $sql = "insert into reviews (id, Author, review, rating, create_at, recipe_id) values (null, '$author', '$review', $rating, now(), $recipe_id)";
        echo $sql . "<br/>";
        $result = $db->query($sql);
        $review_num +=1;
    }

    $count +=1;

}



?>