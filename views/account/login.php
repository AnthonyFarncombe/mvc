<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in - My PHP MVC Application</title>
    <link href="/css/bootstrap.css" rel="stylesheet" />
    <link href="/css/site.css" rel="stylesheet" />
    <style>
        input {
            max-width: 4000px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
						<form action="/account/login?returnurl=<?php echo $viewdata['returnurl']; ?>" method="post" onsubmit="return validateForm()" role="form">
							<fieldset>
								<div class="form-group">
									<input class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?php echo $viewdata['email']; ?>" autofocus />
									<span class="text-danger" id="emailerror"><?php echo $viewdata['emailerror']; ?></span>
								</div>
								<div class="form-group">
									<input class="form-control" id="password" name="password" placeholder="Password" type="password" />
									<span class="text-danger" id="passworderror"><?php echo $viewdata['passworderror']; ?></span>
								</div>
								<input type="submit" value="Login" class="btn btn-lg btn-success btn-block" />
							</fieldset>
						</form>
						<br />
                        <p>
                            <a href="/account/forgotpassword<?php echo empty($viewdata['email']) ? '' : ('?email=' . urlencode($viewdata['email'])); ?>">Forgot your password?</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<script src="/js/jquery-3.1.1.js"></script>
	<script src="/js/app/account/login.js"></script>
</body>
</html>
