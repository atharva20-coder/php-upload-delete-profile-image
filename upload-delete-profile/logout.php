<?php
session_start();

session_unset();
session_destroy();

header('Location: index.php');


//NOW WE ACTUALLY JUST CREATED A LOGIN AND LOGOUT BUTTON THAT ACTUALLY WORKS