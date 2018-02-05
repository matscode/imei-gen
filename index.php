<?php
/**
 *
 * IMEI Generator
 * 
 * For Educational Use Only...
 * 
 * @author MAT <matscode@gmail.com>
 * @link http://michaelakanji.com
 * @package IMEIGeneretor
 *
 */
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title> IMEI Generator | Analyzer</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    </head>
    <body>
		<div style="width: 500px; " class="container">
			<nav class="navbar navbar-inverse">
				<div class="navbar-header">
					<div class="navbar-brand">
						<div class="brand">
							IMEI Generator | Analyzer
						</div>
					</div>
			</nav>
			<div class="alert alert-info">
				This IMEI generator also does the analyzing aspect of each imei generated. if 14 digit imei is inputed the first imei to be generated will be the actual imei supplied and also analyzed. Use this tools for educational purposes only
			</div>
			<form class="form">
				<p> 
					IMEI number <br />
					<input type="text" name="imei" placeholder="copy paste imei in here 10 digit minimum" class="form-control"/>
				</p>
				<p> 
					<button type="submit" class="btn btn-primary">Generate</button>
				</p>
			</form>
			<hr size="1" />
			<div class="panel panel-primary">
				<div class="panel-heading">
					Generated IMEIs
				</div>
				<div class="panel-body">

					<?php
					if (isset($_GET['imei']) && is_numeric($_GET['imei'])) {
						$imei = $_GET['imei'];
						// No checking if file's valid.. just hardcoded...
						$file = 'imei_log.md';
						
						@file_put_contents($file, $imei . ' - ' . @date("l, j F, Y") . "\n..........................\n", FILE_APPEND | LOCK_EX);
						
						$imei_length = strlen($imei);
						$chars_left = (14 - (int) $imei_length);

						$range_start = substr(pow(31, ($chars_left - 1)), 0, $chars_left);

						$range_diff = 842;

						$new_imei = $imei . $range_start;

						for ($i = 0; $i < 20; $i++) {
							$imei_total = 0;
							$imei_chunked = str_split($new_imei);

							for ($x = 0; $x < count($imei_chunked); $x++) {
								// echo $imei_chunked[$x] . ' - ' . $x . ' - ' . $x%2 . "<br >"; //debugging each only
								$imei_each = $imei_chunked[$x];
								if ($x % 2) {
									$imei_each = 2 * $imei_each;
									if (strlen($imei_each) == 2) {
										$imei_each = array_sum(str_split($imei_each));
									}
								}
								$imei_total += $imei_each;
							}

							// to get the imei check number..
							$love = str_split($imei_total);
							$check_number = (10 - (int) $love[1]);
							if ($check_number == 10) {
								$check_number = 0;
							}
							echo  "<input value=\"" . $new_imei . " - " . $check_number . "\" class=\"form-control\" /><br>";

							$new_imei += $range_diff;
						}
					} else {
						echo '<div class="text-center text-danger"> Only numeric values are valid and can not be empty </div>';
					}
					?>
				</div>
			</div>
			<hr size="1" />
			<a href="http://www.fb.me/matscode" class="btn btn-block btn-link text-center"> M.A.T </a>
		</div>
	</body>
</html>
