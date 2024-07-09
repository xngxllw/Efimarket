<?php
session_start();
session_unset();
session_destroy();
header('Location: ../Vista/index.php');
exit();
