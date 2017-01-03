<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot your password? - My PHP MVC Application</title>
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
                        <h3 class="panel-title">Reset password</h3>
                    </div>
                    <div class="panel-body">
						<form action="/account/forgotpassword" method="post" role="form">
							<fieldset>
								<div class="form-group">
									<input class="form-control" id="email" name="email" placeholder="Email" type="email" value="<?php echo $viewdata['email']; ?>" autofocus />
									<span class="text-danger"><?php echo $viewdata['emailerror']; ?></span>
								</div>
								<input type="submit" value="Reset" class="btn btn-lg btn-success btn-block" />
							</fieldset>
						</form>
						<br />
                        <p>
                            <a href="/account/login">Back to login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
