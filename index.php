<!DOCTYPE html>
<html>
<head>
<title>Поиск</title>
<meta charset="UTF-8">
<style>
table, th, td {border: 1px solid black;border-collapse: collapse;}
</style>
</head>
<body>
<form action="" method="GET">
        <input type="text" name="query" />
		<input type="submit" name="submit" value="Найти" />
</form>
<?php
require 'db.php';

if(isset($_GET['query'])) {
	$query = $_GET['query'];
	if(strlen($query) >= 3){
		$stmt = $mysql -> prepare("SELECT post.title, comment.body FROM post INNER JOIN comment ON comment.postid = post.id WHERE comment.body LIKE ?");
		$query = "%" . $query . "%";
		$stmt -> bind_param("s", $query);
		$stmt -> execute();
		$arr = $stmt -> get_result()->fetch_all(MYSQLI_ASSOC);
		$stmt -> close(); }
	else {
		echo "Min search length is 3 characters | Минимальная длинна запроса 3 символа"; }

if (isset($arr)){
	if (count($arr) > 0){
		echo "<h2>Результаты Поиска</h2>";
		echo "<table style=\"width:80%\"><tr><th>Запись</th><th>Комментарий</th></tr>";
		foreach ($arr as $item) {
			echo("<tr><td>{$item['title']}</td><td>{$item['body']}</td></tr>"); }
} 	else {
		echo "Результаты не найдены";}

echo "</table>";
}
}
?>
</body>
</html>