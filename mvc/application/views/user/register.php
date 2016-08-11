
<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">

		<form class="reg-page" method="post">
			<div class="reg-header">
				<h2>Register a new account</h2>
				<p>Already Signed Up? Click <a href="/Login" class="color-green">Sign In</a> to login your account.</p>
			</div>

			{if !empty(errorlist)}
			<div class="alert alert-warning fade in">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>Error</strong><br />

				{foreach errorlist as key => error}
					<code>{error}</code><br />
				{/foreach}
			</div>
			{/if}

			<label>Username</label>
			<input type="text" class="form-control margin-bottom-20" name="username" value="{user.username}" />

			<label>Email Address <span class="color-red">*</span></label>
			<input type="email" class="form-control margin-bottom-20" name="email" value="{user.email}" />

			<div class="row">
				<div class="col-sm-6">
					<label>Password <span class="color-red">*</span></label>
					<input type="text" class="form-control margin-bottom-20" name="password" />
				</div>
				<div class="col-sm-6">
					<label>Confirm Password <span class="color-red">*</span></label>
					<input type="text" class="form-control margin-bottom-20" name="password2" />
				</div>
			</div>

			<? if( !isset($_SESSION['captcha']['register']) ){?>

				<hr />

				<script type="text/javascript">
					function CaptchaReload()
					{
						// jquery
						$('#captcha').attr("src", '/start/captcha/?i=' + Math.random(1000) );
					}
					CaptchaReload();
				</script>

				<div class="row">
					<div class="col-sm-6">
						<img src="/start/captcha" border="0" title="Sicherheitscode" ID="captcha" name="captcha" alt="captcha" height="60px" />
					</div>
					<div class="col-sm-6">
						<label>Confirm Captcha <span class="color-red">*</span> (<a onclick="CaptchaReload(); return false;"><i class="fa fa-refresh"></i>reload</a>)</label>
						<input type="text" class="form-control margin-bottom-20" name="captcha" />
					</div>
				</div>
			<? } ?>

			<hr />

			<div class="row">
				<div class="col-lg-6">
					<label class="checkbox">
						<input type="checkbox">
						I read <a href="/Terms" class="color-green">Terms and Conditions</a>
					</label>
				</div>
				<div class="col-lg-6 text-right">
					<button class="btn-u" type="submit">Register</button>
				</div>
			</div>
		</form>
	</div>
</div>