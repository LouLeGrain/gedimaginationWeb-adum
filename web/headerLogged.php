<?if (session_status() == PHP_SESSION_NONE) {
    session_start();
}?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="lib/jquery/jquery.min.js"></script>
    <link href="gedimagination.css" rel="stylesheet">
    <script src="gedimagination.js"></script>
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <title>Gedimagination</title>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Gedima'Gination</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-target">
                    <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-user"></span> Bienvenue <?echo $_SESSION['auth']['nom']; ?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="tableaudebord.php">Tableau de bord</a></li>
                                    <li><a href="deconnexion.php">Déconnexion</a></li>
                                </ul>
                            </li>
                    </ul>
                </div>
            </div><!-- /.container -->
        </nav>