<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Результат</title>
	<link rel="stylesheet" href="style/css/bootstrap.min.css" />
	<script type="text/javascript" src="style/js/jquery-3.2.0.min.js"></script>
	<script type="text/javascript" src="style/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="style/css/style.css" />
</head>
<body>
	<a href="/"><img src="style/img/logo.jpg" alt="Logo" class="center-block" style="width: 150px;"/></a>
	<div class="container">
		<?php
		$analyze_file = false;
		$textget = '';
		global $resultfile;
		if(!empty($_POST['URL'])) {
			$getfile = $_POST['URL'] . 'robots.txt'; // добавляем имя файла
			$file_headers = @get_headers($getfile); // подготавливаем headers страницы

			if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
				//echo 'Возникла ошибка, при получении файла или файл robots.txt отсутствует<br>';
			} else if ($file_headers[0] == 'HTTP/1.1 200 OK') {
				// открываем файл для записи, поехали!
				$file = fopen('robots.txt', 'w');
				// инициализация cURL
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $getfile);
				curl_setopt($ch, CURLOPT_FILE, $file);
				curl_exec($ch);
				fclose($file);
				curl_close($ch);

				 // описываем как глобальную переменную
				$resultfile = 'robots.txt'; // файл, который получили

				if (!file_exists($resultfile)) {
					//echo "Ошибка обработки файла: $resultfile";
					$analyze_file = true;
				} else {
					// Начинаем обрабатывать файл, если все прошло успешно
					// $file_arr = file("robots.txt");
					$textget = file_get_contents($resultfile);
					htmlspecialchars($textget); // при желании, можно вывести на экран через echo

					/*echo "Файл robots.txt присутствует<br>";
						if (preg_match("/Host/", $textget)) {
							echo "Деректива Host есть<br>";
							preg_match_all('~\bHost\b~i', $textget, $r);
							echo 'Деректива Host встречается ' . count($r[0]) . ' раз<br>';
						} else {
							echo "Дерективы Host нет <br>";
						}

					if (preg_match("/Sitemap/", $textget)) {
						echo "Деректива Sitemap есть<br>";
					} else {
						echo "Дерективы Sitemap нет<br>";
					}

					echo 'Размер файла ' . $resultfile . ': ' . filesize($resultfile) . ' байт<br>';
					*/
				}
			} ?>
			<table class="table table-hover table-condensed">
				<thead>
				<tr>
					<th>№</th>
					<th>Название проверки</th>
					<th>Статус</th>
					<th></th>
					<th>Текущее состояние</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<th scope="row">1</th>
					<td>Проверка наличия файла robots.txt</td>
					<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
						<td class="bg-success text-center"><strong>ОК</strong></td>
					<?php } else { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } ?>
					<td>
						Состояние<br/>
						Рекомендации
					</td>
					<td>
						<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
							Файл robots.txt отсутствует<br/>Программист: Создать файл robots.txt и разместить его на сайте.
						<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
							Файл robots.txt присутствует<br/>Доработки не требуются
						<?php } else { ?>
							Ошибка получения Файла
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">6</th>
					<td>Проверка указания директивы Host</td>
					<?php if(!$analyze_file){ ?>
						<?php if (preg_match("/Host/", $textget)) { ?>
							<td class="bg-success text-center"><strong>ОК</strong></td>
						<?php } else { ?>
							<td class="bg-danger text-center"><strong>Ошибка</strong></td>
						<?php } ?>
					<?php } else { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } ?>
					<td>
						Состояние<br/>
						Рекомендации
					</td>
					<td>
						<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
							Файл robots.txt отсутствует
						<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
							<?php if (preg_match("/Host/", $textget)) { ?>
								Директива Host указана<br/>Доработки не требуются
							<?php } else { ?>
								В файле robots.txt не указана директива Host<br/>Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.
							<?php } ?>
						<?php } else { ?>
							Ошибка получения Файла
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">8</th>
					<td>Проверка количества директив Host, прописанных в файле</td>
					<?php if(!$analyze_file){ ?>
						<?php if (preg_match("/Host/", $textget)) { ?>
							<td class="bg-success text-center"><strong>ОК</strong></td>
						<?php } else { ?>
							<td class="bg-danger text-center"><strong>Ошибка</strong></td>
						<?php } ?>
					<?php } else { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } ?>
					<td>
						Состояние<br/>
						Рекомендации
					</td>
					<td>
						<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
							Файл robots.txt отсутствует
						<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
							<?php if(!$analyze_file){ ?>
								<?php if (preg_match("/Host/", $textget)) { ?>
									<?php preg_match_all('~\bHost\b~i', $textget, $r); ?>
									<?php if(count($r[0]) == 1){ ?>
										Деректива Host встречается ' <?php echo count($r[0]); ?> ' раз <br/>
										Доработки не требуются
									<?php } else { ?>
										В файле прописано несколько директив Host<br/>
										Программист: Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта
									<?php } ?>
								<?php } else { ?>
									В файле robots.txt не указана директива Host<br/>Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил.
								<?php } ?>
							<?php } else { ?>
								Ошибка обработки файла: <?php echo $resultfile; ?>
							<?php } ?>
						<?php } else { ?>
							Ошибка получения Файла
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">10</th>
					<td>Проверка размера файла robots.txt</td>
					<?php if(!$analyze_file && $resultfile){ ?>
						<?php if(filesize($resultfile) < 32000) { ?>
							<td class="bg-success text-center"><strong>ОК</strong></td>
						<?php } else { ?>
							<td class="bg-danger text-center"><strong>Ошибка</strong></td>
						<?php } ?>
					<?php } else { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } ?>
					<td>
						Состояние<br/>
						Рекомендации
					</td>
					<td>
						<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
							Файл robots.txt отсутствует
						<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
							<?php if(!$analyze_file){ ?>
								<?php if(filesize($resultfile) < 32000) { ?>
									Размер файла <?php echo $resultfile;?> составляет <?php echo filesize($resultfile)?> байт, что находится в пределах допустимой нормы<br/>
									Доработки не требуются
								<?php } else { ?>
									Размера файла <?php echo $resultfile;?> составляет <?php echo filesize($resultfile)?> байт, что превышает допустимую норму<br/>
									Программист: Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб
								<?php } ?>
							<?php } else { ?>
								Ошибка обработки файла: <?php echo $resultfile; ?>
							<?php } ?>
						<?php } else { ?>
							Ошибка получения Файла
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">11</th>
					<td>Проверка указания директивы Sitemap</td>
					<?php if(!$analyze_file){ ?>
						<?php if (preg_match("/Sitemap/", $textget)) { ?>
							<td class="bg-success text-center"><strong>ОК</strong></td>
						<?php } else { ?>
							<td class="bg-danger text-center"><strong>Ошибка</strong></td>
						<?php } ?>
					<?php } else { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } ?>
					<td>
						Состояние<br/>
						Рекомендации
					</td>
					<td>
						<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
							Файл robots.txt отсутствует
						<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
							<?php if(!$analyze_file){ ?>
								<?php if (preg_match("/Sitemap/", $textget)) { ?>
									Директива Sitemap указана<br/>
									Доработки не требуются
								<?php } else { ?>
									В файле robots.txt не указана директива Sitemap<br/>
									Программист: Добавить в файл robots.txt директиву Sitemap
								<?php } ?>
							<?php } else { ?>
								Ошибка обработки файла: <?php echo $resultfile; ?>
							<?php } ?>
						<?php } else { ?>
							Ошибка получения Файла
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th scope="row">12</th>
					<td>Проверка кода ответа сервера для файла robots.txt</td>
					<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
						<td class="bg-success text-center"><strong>ОК</strong></td>
					<?php } else { ?>
						<td class="bg-danger text-center"><strong>Ошибка</strong></td>
					<?php } ?>
					<td>
						Состояние<br/>
						Рекомендации
					</td>
					<td>
						<?php if ($file_headers[0] == 'HTTP/1.1 404 Not Found') { ?>
							При обращении к файлу robots.txt сервер возвращает код ответа (указать код)<br/>
							Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200
						<?php } else if ($file_headers[0] == 'HTTP/1.1 200 OK') { ?>
							Файл robots.txt отдаёт код ответа сервера 200<br/>Доработки не требуются
						<?php } else { ?>
							Ошибка получения Файла
						<?php } ?>
					</td>
				</tr>
				</tbody>
			</table>
		<?php } else { ?>
			<div class="bs-callout bs-callout-danger">
				<h4>Вы ничего не ввели :(</h4>
			</div>
		<?php } ?>
	</div>
</body>
</html>