<?php
#*****************************************************************************#
#  MySQL Connection Information                                               #
#                                                                             #
#  mysqlHost : Host domain of the MySQL server.                               #
#  mysqlUser : Username used by the site to log into the database.            #
#  mysqlPass : Password used by the site to log into the database.            #
#  mysqlDB   : Database on MySQL server to use.                               #
#                                                                             #
#  connection: Holds a mysql connection script. To be used when a server      #
#              connection is required.                                        #
#*****************************************************************************#
   $mysqlHost = "localhost";
    $mysqlUser = "root";
    $mysqlPass = "";
    $mysqlDB = "arena";
    
    $connection = mysqli_connect("$mysqlHost", "$mysqlUser", "$mysqlPass", "$mysqlDB") or die("Could not connect to the database.");
?>