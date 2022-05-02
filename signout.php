<?php
session_start();
session_unset();
session_destroy();
header('Location: http://localhost/Site1/index.html'); ?>