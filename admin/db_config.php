<?php

$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'resortwebsite';

$con = mysqli_connect($hname,$uname,$pass,$db);

if(!$con){
    die("Cannot Connect to Database".mysqli_connect_error());
}

function filtration($data){
    foreach($data as $key => $value){
    $data[$key] = trim($value);
    $data[$key] = stripslashes($value);
    $data[$key] = htmlspecialchars($value);
    $data[$key] = strip_tags($value);

    }
    return $data;
}




function select($sql, $values, $datatypes) 
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Dynamically bind parameters
        if (!empty($values) && !empty($datatypes)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        }
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            // Fetch and return the result set
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Select");
        }
    } else {
        // Display error message from mysqli_prepare
        die("Query preparation failed - Select: " . mysqli_error($con));
    }
}


function update($sql, $values, $datatypes) 
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
      
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
         else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Update");
        }
    } else {
        // Display error message from mysqli_prepare
        die("Query preparation failed - Update: " . mysqli_error($con));
    }
}

function insert($sql, $values, $datatypes) 
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
      
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
         else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Insert");
        }
    } else {
        // Display error message from mysqli_prepare
        die("Query preparation failed - Insert: " . mysqli_error($con));
    }
}


function selectAll($table)
{
    $con = $GLOBALS['con'];
    $res = mysqli_query($con,"SELECT * FROM $table");
    return $res;
}

function delete($sql, $values, $datatypes) 
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
      
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        }
         else {
            mysqli_stmt_close($stmt);
            die("Query execution failed - Delete");
        }
    } else {
        // Display error message from mysqli_prepare
        die("Query preparation failed - Delete: " . mysqli_error($con));
    }
}


?>