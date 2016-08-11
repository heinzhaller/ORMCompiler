<div class="row">
	<div class="col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
		<form class="reg-page" action="/User/Login" method="post">
			<div class="reg-header">
				<h2>Login to your account</h2>
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

			<div class="input-group margin-bottom-20">
				<span class="input-group-addon"><i class="icon-user"></i></span>
				<input type="text" placeholder="Username" class="form-control" name="username" />
			</div>
			<div class="input-group margin-bottom-20">
				<span class="input-group-addon"><i class="icon-envelope"></i></span>
				<input type="text" placeholder="or Email" class="form-control" name="email" />
			</div>
			<div class="input-group margin-bottom-20">
				<span class="input-group-addon"><i class="icon-lock"></i></span>
				<input type="password" placeholder="Password" class="form-control" required="true" name="password" />
			</div>


			<div class="row">
				<div class="col-md-6">
					<label class="checkbox"><input type="checkbox" name="use_cookie" /> Stay signed in</label>
				</div>
				<div class="col-md-6">
					<button class="btn-u pull-right" type="submit">Login</button>
				</div>
			</div>

			<hr>

			<h4>Forget your Password ?</h4>
			<p>no worries, <a class="color-green" href="/Password">click here</a> to reset your password.</p>
		</form>
	</div>
</div><!--/row-->