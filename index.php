<!DOCTYPE html>
<html>
<head>
    <title>DM Simulator</title>

    <link rel="stylesheet" href="Css/bulma.min.css">
    <link rel="stylesheet" href="Css/app.css">
    <!--    for footer and header styles-->
    <link href="css/bootstrap.min.css" id="bootstrap-css" rel="stylesheet">
    <link href="css/bootstrap-glyphicons.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet"/>

    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom-scripts.js"></script>
    <!--    for multi select dropdowns-->
    <link rel="stylesheet" href="Searchable-Multi-select-jQuery-Dropdown/jquery.dropdown.min.css">
    <script src="Searchable-Multi-select-jQuery-Dropdown/jquery.dropdown.js"></script>
    <script src="https://use.fontawesome.com/5b17aee48f.js"></script>
    <!--    custom scripts-->
    <script defer src="Js/all.js"></script>
    <script defer src="Js/app.js"></script>
</head>
<body>
<nav class="navbar is-black" role="navigation" aria-label="main navigation">
    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                DAMAGE MECHANISM SIMULATOR
            </a>
        </div>
    </div>
</nav>
<div class="container">
    <?php include 'Templates/left-tile-section.php'; ?>
    <?php include 'Templates/right-tile-section.php'; ?>
</div>
<?php include_once 'footer.html'; ?>
</body>
</html>