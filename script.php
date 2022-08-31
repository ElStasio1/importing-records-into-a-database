<?php
require 'db.php';
$post_count = 0;
$comment_count = 0;


$jsonStringPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$jsonArrayPosts = json_decode($jsonStringPosts, true);

$jsonStringComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$jsonArrayComments = json_decode($jsonStringComments, true);

foreach ($jsonArrayPosts as $item) 
{	
	$stmt = $mysql -> prepare("INSERT INTO post (userId, id, title, body) VALUES (?, ?, ?, ?)");
	$stmt -> bind_param("iiss", $item['userId'], $item['id'], $item['title'], $item['body']);	
	$stmt -> execute();
	$post_count +=1;
}

foreach ($jsonArrayComments as $item) 
{	
	$stmt = $mysql -> prepare("INSERT INTO comment (postId, id, name, email, body) VALUES (?, ?, ?, ?, ?)");
	$stmt -> bind_param("iisss", $item['postId'], $item['id'], $item['name'], $item['email'], $item['body']);	
	$stmt -> execute();
	$comment_count +=1;
}

$mysql -> close();

echo "Загружено {$post_count} записей и {$comment_count} комментариев";
?>