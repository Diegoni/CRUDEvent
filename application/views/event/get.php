<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<title>Hello, world!</title>
</head>
<body>
<div class="container">
	<main>
		<div class="py-5 text-center">
			<h2><?php echo $event[0]->name?></h2>
			<p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>
		</div>

		<div class="row g-3">
			<div class="col-md-5 col-lg-4 order-md-last">
				<h4 class="d-flex justify-content-between align-items-center mb-3">
					<span class="text-muted"><?php echo lang('enrolled');?></span>
					<span class="badge bg-secondary rounded-pill"><?php echo ($r_events_users) ? count($r_events_users) : 0?></span>
				</h4>
				<?php
				if($r_events_users){
					foreach ($r_events_users as $user){
				?>
					<ul class="list-group mb-3">
						<li class="list-group-item d-flex justify-content-between lh-sm">
							<div>
								<h6 class="my-0"><?php echo $user->name;?></h6>
								<small class="text-muted"><?php echo $user->position;?> </small>
							</div>
							<span class="text-muted"><?php echo date("H:i", strtotime('-4 hour' , strtotime($user->date_add))) ;?></span>
						</li>
					</ul>
				<?php
					}
				}
				?>
				<form class="card p-2">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="<?php echo lang('name') ?>">
						<button type="submit" class="btn btn-secondary"><?php echo lang('search') ?></button>
					</div>
				</form>
			</div>


			<div class="col-md-7 col-lg-8">
				<h4 class="mb-3"><?php echo lang('inscription')?></h4>
				<form class="needs-validation" method="post">
					<div class="row g-3">
						<div class="col-md-5">
							<label for="name" class="form-label"><?php echo lang('name');?></label>
							<input class="form-control" id="name" name="name" required="" autofocus>
						</div>

						<div class="col-md-4">
							<label for="position" class="form-label"><?php echo lang('position') ?></label>
							<select class="form-select" id="position" name="position" required="">
								<option value=""><?php echo lang('choose') ?>...</option>
								<?php
								if($positions){
									foreach ($positions as $position){
										echo '<option value="'.$position->position_id.'">'.$position->name.'</option>';
									}
								}
								?>
							</select>
							<div class="invalid-feedback">
								Please provide a valid state.
							</div>
						</div>

						<div class="col-md-3">
							<label for="zip" class="form-label">_</label>
							<button class="btn btn-primary form-control" type="submit">Continue </button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</main>

	<footer class="my-5 pt-5 text-muted text-center text-small">
		<p class="mb-1">© 2014–2021 Fulbito</p>
		<ul class="list-inline">
			<li class="list-inline-item"><a href="#">Privacy</a></li>
			<li class="list-inline-item"><a href="#">Terms</a></li>
			<li class="list-inline-item"><a href="#">Support</a></li>
		</ul>
	</footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
