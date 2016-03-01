<?php
$title = 'Startseite';
require('header.php');
?>
        <link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
        <script src="js/jquery-ui.min.js"></script>
        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href="css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" href="css/theme.css">

        <!-- elFinder JS (REQUIRED) -->
        <script src="js/elfinder.min.js"></script>

        <!-- elFinder translation (OPTIONAL) -->
        <script src="js/elfinder.de.js"></script>
        <?php if(isset($_SESSION['username']) || $GLOBALS['read']){?>
        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            // Documentation for client options:
            // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
            $(document).ready(function() {
                $('#elfinder').elfinder({
                    url : 'php/connector.minimal.php'  // connector URL (REQUIRED)
                    , lang: 'de'                    // language (OPTIONAL)
                });
            });
        </script>

        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder"></div>

<?php
}else{
    echo "<h2 class='text-center'>Der Zugriff auf die Daten ist nicht erlaubt</h2>";
}
require('footer.php');
?>