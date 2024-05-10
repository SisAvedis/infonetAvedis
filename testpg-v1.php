<?php

// Declare a new class for the pg_connect() connect parameters
class connectionParams {}
$param = new connectionParams;

// 'host' for the PostgreSQL server
$param->host = "localhost";

// default port for PostgreSQL is "5432"
$param->port = 5432;

// set the database name for the connection
$param->dbname = "python_test";

// set the username for PostgreSQL database
$param->user = "objectrocket";

// password for the PostgreSQL database
$param->password = "mypass";

// declare a new string for the pgconnect method
$hostString = "";

// use an iterator to concatenate a string to connect to PostgreSQL
foreach ($param as $key => $value) {

// concatenate the connect params with each iteration
$hostString = $hostString . $key . "=" . $value . " ";
}


// WARNING: For demonstration purposes only
// NEVER echo password credentials in PHP
echo "
\$hostString: ". $hostString. "
";


// use the pg_connect() to create a connection
$conn = pg_connect($hostString);

// echo the connection response
echo "
\$conn: ". $conn. "
";















?>