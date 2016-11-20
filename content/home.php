<?php
//Contenu traduit
include('translation/homeT.php');
$textePresentation = traduction($connect, "texteHome", $lang);
?>

<div class="row">
    <div class="container">
        <?php

		$formregister = lireDonneePost("formregister", "");
		if ($formregister == 1){
			registerUser($connect);
		}
		?>

		<div class="col-sm-5" id="welcome">
			<h3><?php echo $tabTexteHome[0]; ?></h3>
			<p>
				<?php
				echo $textePresentation;
				?>
			</p>
		</div>
		
		<div class="col-sm-5 col-sm-offset-2" id="registerForm">
			<h3><?php echo $tabTexteHome[1]; ?></h3>
			<form method="post" role="form" data-toggle="validator">
				<fieldset>
					<legend><?php echo $tabTexteHome[2]; ?></legend>
					<div class="form-group">
						<input type="text" name="firstname" placeholder="<?php echo $tabTexteHome[3]; ?>" class="form-control" data-error="<?php echo $tabTexteHome[10]; ?>" required>
						<div class="help-block with-errors"></div>
					</div>
					<div class="form-group">
						<input type="text" name="lastname" placeholder="<?php echo $tabTexteHome[4]; ?>" class="form-control" data-error="<?php echo $tabTexteHome[11]; ?>" required>
						<div class="help-block with-errors"></div>
					</div>
					<div class="form-group">
						<input type="email" name="email" placeholder="<?php echo $tabTexteHome[5]; ?>" class="form-control" data-error="<?php echo $tabTexteHome[12]; ?>" required>
						<div class="help-block with-errors"></div>
					</div>
					<div class="form-group">
						<input type="text" name="username" placeholder="<?php echo $tabTexteHome[6]; ?>" class="form-control" data-error="<?php echo $tabTexteHome[13]; ?>" required>
						<div class="help-block with-errors"></div>
					</div>
					<div class="form-group">
						<input type="password" name="password" placeholder="<?php echo $tabTexteHome[7]; ?>" class="form-control" id="matchingPasswords" data-error="<?php echo $tabTexteHome[14]; ?>" data-minlength="6" required>
						<div class="help-block with-errors"></div>
					</div>
					<div class="form-group">
						<input type="password" name="confpassword" placeholder="<?php echo $tabTexteHome[8]; ?>" class="form-control" data-match="#matchingPasswords" data-match-error="<?php echo $tabTexteHome[15]; ?>" data-error="<?php echo $tabTexteHome[14]; ?>" required>
						<div class="help-block with-errors"></div>
					</div>
				</fieldset>
				<input type="hidden" name="formregister" value="1"/>
				<button type="submit" class="btn btn-primary"><?php echo $tabTexteHome[9]; ?></button>
			</form>
		</div>
		
	</div>
	
</div>