<?php

function accessDB() {
    $Server = new mysqli("localhost", "root", "mysql", "SuiteLiving");

    if ($Server->connect_error) {
        echo "something went wrong";
        return null;
    } else {
        return $Server;
    }
}

function changeData($query)
{
    $Connection = accessDB();
    if ($Connection != null) {
        if ($Connection->query($query) === FALSE) {
            $Connection -> close();
            return false;
        } else {
            $Connection -> close();
            return true;
        }
    } else {
        return false;
    }
}

function grabData($query) {
    $Connection = accessDB();
    $Results = array();

    if ($Connection != null) {
        if (($rows = $Connection->query($query)) === FALSE) {
            $Connection -> close();
            return null;
        } else {
            while ($row = $rows->fetch_array(MYSQLI_ASSOC)) {
                array_push($Results, $row);
            }
            $Connection -> close();
            return $Results;
        }
    } else {
        return null;
    }
}

function dataExist($query) {
    $Connection = accessDB();
    if ($Connection != null) {
        $result = $Connection->query($query);
        if ($result -> num_rows == 0) {
            $Connection -> close();
            return false;
        } else {
            $Connection -> close();
            return true;
        }
    } else {
        return false;
    }
}

function dataCount($query) {
    $Connection = accessDB();
    if ($Connection != null) {
        if (($result = $Connection->query($query)) === FALSE) {
            $Connection -> close();
            return false;
        } else {
            $Connection -> close();
            return $result -> num_rows;
        }
    } else {
        return false;
    }
}