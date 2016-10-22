<?php
/**
 * Valet Dashboard
 *
 * List Laravel Valet Sites within a parked directory
 */

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Valet Dashboard</title>
<link rel="apple-touch-icon" href="assets/img/favicon.png">
<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Miriam+Libre:400,700|Source+Sans+Pro:200,400,700,600,400italic,700italic" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="assets/styles/laravel.min.css">
<link rel="stylesheet" href="assets/styles/dashboard.css">
</head>
<body class="panel dark features">
	<main>
		<article>
			<h1>Valet Dashboard</h1>
		</article>
		<div class="container">
			<div class="blocks" id="list">
				<?php

					$dir              = "../";
					$ignore           = array( ".", "..", ".DS_Store", "valet-dashboard" );
					$contents         = scandir( $dir );
					$sites            = array_diff( $contents, $ignore );
					$home             = getenv( "HOME" );
					$valet_data       = file_get_contents( $home . '/.valet/config.json' );
					$config_json      = json_decode( $valet_data, true );
					$parked_directory = realpath(__DIR__ . '/..');

					if ( empty( $sites ) ) {
				?>
					<div class="block">
						<div class="text">
							<h2>hmmm</h2>
							<p>It looks like you don't have any sites available right now. Create a directory within <code class="language-php"><?php echo $parked_directory; ?></code> to add your first site!</p>
						</div>
					</div>
				<?php

					}

					foreach ( $sites as $site ) {

				?>
					<div class="block-wrapper">
						<div class="drag-handle">
							<svg height="25" width="25" class="drag-icon" viewBox="0 0 491 491" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M104.787 36.63v381.486h15.327V36.63l92.15 126.91 12.41-9.01L112.45 0 .23 154.53l12.41 9.01m373.052-91.2h-15.327v381.49l-92.158-126.914-12.394 9.01 112.215 154.53 112.2-154.53-12.393-9.01-92.143 126.91"/></svg>
						</div>
						<a href="http://<?php echo $site; ?>.<?php echo $config_json['domain']; ?>" class="block-link" title="<?php echo $site; ?>">
							<div class="block">
								<div class="text">
									<h2><?php echo $site; ?><span>.<?php echo $config_json['domain']; ?></span></h2>
								</div>
							</div>
						</a>
					</div>
				<?php

					} // end foreach

				?>
			</div>
		</div>
	</main>
	<footer class="main">
		<ul>
			<li class="nav-docs"><a target="_blank" href="https://laravel.com/docs/5.3/valet">Valet Documentation</a></li>
			<li class="nav-docs"><a target="_blank" href="https://github.com/josephfusco/valet-dashboard">Valet Dashboard Source</a></li>
		</ul>
		<p>Valet Dashboard styles adopted from <a target="_blank" href="https://laravel.com/">laravel.com</a></p>
	</footer>
	<script type="text/javascript" src="assets/js/Sortable.js"></script>
	<script type="text/javascript">
		var el = document.getElementById('list');
		var sortable = new Sortable(el, {
			handle: ".drag-handle",
			draggable: ".block-wrapper",
			animation: 150,
			group: "localStorage-valet-dash",
			store: {
				/**
				* Get the order of elements. Called once during initialization.
				* @param   {Sortable}  sortable
				* @returns {Array}
				*/
				get: function (sortable) {
					var order = localStorage.getItem(sortable.options.group.name);
					return order ? order.split('|') : [];
				},

				/**
				* Save the order of elements. Called onEnd (when the item is dropped).
				* @param {Sortable}  sortable
				*/
				set: function (sortable) {
					var order = sortable.toArray();
					localStorage.setItem(sortable.options.group.name, order.join('|'));
				}
			},
			ghostClass: 'ghost',
			onStart: function () {
				this.el.classList.remove('use-hover');
			},
			onEnd: function () {
				this.el.classList.add('use-hover');
			}
		});
	</script>
</body>
</html>
