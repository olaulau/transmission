<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/index.ctrl.php';

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<title>Transmission</title>

<!-- Bootstrap core CSS -->
<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css"
	rel="stylesheet">

<!-- Custom styles for this template -->
<link href="sticky-footer-navbar.css" rel="stylesheet">
</head>

<body>

	<header>
		<!-- Fixed navbar -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="#">Transmission</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse"
				data-target="#navbarCollapse" aria-controls="navbarCollapse"
				aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active"><a class="nav-link" href="#">Home <span
							class="sr-only">(current)</span></a></li>
					<li class="nav-item"><a class="nav-link" href="#">Link</a></li>
					<li class="nav-item"><a class="nav-link disabled" href="#">Disabled</a>
					</li>
				</ul>
				<form class="form-inline mt-2 mt-md-0">
					<input class="form-control mr-sm-2" type="text"
						placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</nav>
	</header>

	<!-- Begin page content -->
	<main role="main" class="container-fluid">
	<h2 class="mt-5">
		Stats
		</h1>
		<div style="display: inline-block;">
			<h5># torrents</h5>
			<table class="table table-dark table-sm table-nonfluid">
				<thead class="thead-light">
					<tr>
						<th scope="col">active</th>
						<th scope="col">paused</th>
						<th scope="col">total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= $stats['activeTorrentCount'] ?></td>
						<td><?= $stats['pausedTorrentCount'] ?></td>
						<td><?= $stats['torrentCount'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div style="display: inline-block;">
			<h5>speed</h5>
			<table class="table table-dark table-sm table-nonfluid">
				<thead class="thead-light">
					<tr>
						<th scope="col">download</th>
						<th scope="col">upload</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= convert_bandwidth($stats['downloadSpeed']) ?></td>
						<td><?= convert_bandwidth($stats['uploadSpeed']) ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div style="display: inline-block;">
			<h5>misc</h5>
			<table class="table table-dark table-sm table-nonfluid">
				<thead class="thead-light">
					<tr>
						<th scope="col">&nbsp;</th>
						<th scope="col">downloaded</th>
						<th scope="col">uploaded</th>
						<th scope="col">filesAdded</th>
						<th scope="col">secondsActive</th>
						<th scope="col">sessionCount</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">current</th>
						<td><?= convert_size($stats['current-stats']['downloadedBytes']) ?></td>
						<td><?= convert_size($stats['current-stats']['uploadedBytes']) ?></td>
						<td><?= $stats['current-stats']['filesAdded'] ?></td>
						<td><?= $stats['current-stats']['secondsActive'] ?></td>
						<td><?= $stats['current-stats']['sessionCount'] ?></td>
					</tr>
					<tr>
						<th scope="row">cumulatives</th>
						<td><?= convert_size($stats['cumulative-stats']['downloadedBytes']) ?></td>
						<td><?= convert_size($stats['cumulative-stats']['uploadedBytes']) ?></td>
						<td><?= $stats['cumulative-stats']['filesAdded'] ?></td>
						<td><?= $stats['cumulative-stats']['secondsActive'] ?></td>
						<td><?= $stats['cumulative-stats']['sessionCount'] ?></td>
					</tr>
				</tbody>
			</table>
		</div>


		<br />


		<h2>Torrents object</h2>
		<table class="table table-dark">
			<thead class="thead-light ">
				<tr>
					<th scope="col">name</th>
					<th scope="col">status</th>
					<th scope="col">actions</th>
				</tr>
			</thead>
			<tbody>
		<?php
		foreach ($torrents as $torrent) {
			?>
			<tr>
					<td><?= $torrent->getName() ?></td>
					<td>
						<?php
						switch ($torrent->getStatus()) {
							case 'downloading':
							?> <span class="badge badge-pill badge-danger"><?= $torrent->getStatus() ?></span> <?php
							break;
							
							case 'seeding':
							?> <span class="badge badge-pill badge-warning"><?= $torrent->getStatus() ?></span> <?php
							break;
							
							case 'finished':
							?> <span class="badge badge-pill badge-success"><?= $torrent->getStatus() ?></span> <?php
							break;
							
							default:
							?> <span class="badge badge-pill badge-dark"><?= $torrent->getStatus() ?></span> <?php
							break;
						}
						?>
					</td>
					<td>
						<a class="btn btn-primary" href="transfert.php?hashString=<?= $torrent->getHashString() ?>"> 
							<i class="fas fa-download"></i> <?= $torrent->getTransfertDate() ? 'retransfert' : 'transfert' ?>
						</a>
						<a class="btn btn-danger" href="remove.php?hashString=<?= $torrent->getHashString() ?>"> 
							<i class="fas fa-trash"></i> delete
						</a>
					</td>
				</tr>
			<?php
		}
		?>
		</tbody>
		</table>


		<h2><a href="#" id="torrents_assoc_toggle">Torrents assoc</a></h2>
		<table id="torrents_assoc" class="table table-dark collapse">
			<thead class="thead-light ">
				<tr>
			<?php
			foreach (array_keys(reset($torrents)->getInfos()) as $title) {
				?>
				<th scope="col"><?= $title ?></th>
				<?php
			}
			?>
	    	</tr>
			</thead>
			<tbody>
		<?php
		foreach ($torrents as $torrent) {
			?>
			<tr>
				<?php
			foreach ($torrent->getInfos() as $key => $value) {
				;
				?>
				<td>
					<?php
				if ($key === 'comment' || $key === 'magnetLink' ||
						$key === 'pieces') {
					$value = '[...]';
				}
				$pos = stripos($key, 'date');
				if ($pos > 0 || $pos === 0) {
					$value = date('Y-m-d H:i:s P', $value);
				}
				if (! is_array($value)) {
					echo $value;
				}
				?>
				</td>
					<?php
			}
			?>
			</tr>
				<?php
		}
		?>
		</tbody>
		</table>



		<footer class="footer">
			<div class="container">
				<span class="text-muted">Place sticky footer content here.</span>
			</div>
		</footer>
		<!-- Bootstrap core JavaScript
    ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="vendor/components/jquery/jquery.min.js"></script>
<!-- 		<script src="../../assets/js/vendor/popper.min.js"></script> -->
		<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
		<script defer src="./vendor/fortawesome/font-awesome/js/all.min.js" crossorigin="anonymous"></script>
		<script src="index.js"></script>

</body>
</html>
