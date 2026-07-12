<?php

session_start();

/* Destroy Session */

session_unset();

session_destroy();

/* Redirect */

header("Location: ../index.php");

exit();

?>