<?php

error_reporting(0);

// Connect To Database
mysql_connect('localhost', 'admin_user', 'Trunks15');
mysql_select_db('admin_demo');

// Include Pagination Class
include('pagination.php');

// Display Links for Demo Purposes (not required)
include('links.html');
