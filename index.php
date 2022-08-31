<!DOCTYPE html>
<html>

<head>
	<title>Поиск</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
	<div class="container">
		<h1>Поиск</h1>
		<form action="" method="GET">
			<input class="form-control mb-2" type="text" name="query" placeholder="Поиск">
			<input class="btn btn-success" type="submit" name="submit" value="Найти">
		</form>
		<?php
		require 'include/db.php';

		if (isset($_GET['query'])) {
			$query = $_GET['query'];
			if (strlen($query) >= 3) {
				$stmt = $mysql->prepare("SELECT post.title, comment.body FROM post INNER JOIN comment ON comment.postid = post.id WHERE comment.body LIKE ?");
				$query = "%" . $query . "%";
				$stmt->bind_param("s", $query);
				$stmt->execute();
				$search = $stmt->get_result();
				$search_result = mysqli_num_rows($search); ?>
				<?php
				if ($search_result == 0) { ?>
					<h4>По запросу ничего не найдено</h4>

				<?php } else { ?>
					<table class="table">
						<thead>
							<tr>
								<h1 class="text-center">Статьи</h1>

								<td>Запись</td>
								<td>Комментарий</td>
							</tr>
						</thead>
						<tbody>
							<?php while (($search_result = $search->fetch_assoc()) ?? null) {
							?>

								<tr>
									<td><?= $search_result['title'] ?></td>
									<td><?= $search_result['body'] ?></td>
								</tr>

							<?php } ?>
						</tbody>
					</table>


				<?php } ?>

		<?php



			} else {
				echo "Минимальная длинна запроса 3 символа";
			}
		}
		?>



	</div>

</body>

</html>