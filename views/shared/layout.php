<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $viewdata['title']; ?> - My PHP MVC Application</title>
    <link href="/css/bootstrap.css" rel="stylesheet" />
    <link href="/css/site.css" rel="stylesheet" />
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
				<a href="/" class="navbar-brand">Application Name</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">Home</a></li>
                    <li><a href="/customers">Customers</a></li>
					<?php if (in_array('Admin', $_SESSION['roles'])) : ?>
					<li><a href="/users">Users</a></li>
					<?php endif; ?>
                </ul>
				<form id="logoutForm" class="navbar-right" method="post" action="/account/logoff">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="/account/manage">Hello <?php echo $_SESSION['firstname']; ?>!</a>
						</li>
						<li><a href="javascript:document.getElementById('logoutForm').submit()">Log off</a></li>
					</ul>
				</form>
            </div>
        </div>
    </div>
    <div class="container body-content">
        <?php require $viewdata['view']; ?>
        <hr />
        <footer>
            <p>&copy; <?php echo date("Y"); ?> - My PHP MVC Application</p>
        </footer>
    </div>
	
	<script src="/js/jquery-3.1.1.js"></script>
	<script src="/js/bootstrap.js"></script>
    <!--@RenderSection("scripts", required: false)-->
</body>
</html>
