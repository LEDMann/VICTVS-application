<?php

/**
 * this can be used to validate all of the values of the filter parameters in a get request to the api
 * 
 * @return bool for whether all of the values in the $_GET array are valid
 */
function validate_query() : bool {
    return  (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filterby"]) == 0 && strlen($_GET["filterby"]) < 20 && $_GET["filterby"] != "") && 
            (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filtermode"]) == 0 && strlen($_GET["filtermode"]) < 16 && $_GET["filtermode"] != "") && 
            (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filter"]) == 0 && $_GET["filter"] != "");
}

/**
 * this can be used to debug the issue within a set of filter values and will return an error message that describes the issue with the filter
 * 
 * @return string that describes the error in the filter
 */
function debug_query() : string {
    if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filterby"]) != 0 || strlen($_GET["filterby"]) > 20 || $_GET["filterby"] == "") {
        $pre = "invalid filter column";
        if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filterby"]) != 0) {
            return $pre . " - " . "invalid character(s)";
        } else if (strlen($_GET["filterby"]) > 20 ) {
            return $pre . " - " . "too long";
        } else if ($_GET["filterby"] == "") {
            return $pre . " - " . "is empty";
        }
    } else if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filtermode"]) != 0 || strlen($_GET["filtermode"]) > 16 || $_GET["filtermode"] == "") {
        $pre = "invalid filter mode";
        if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filtermode"]) != 0) {
            return $pre . " - " . "invalid character(s)";
        } else if (strlen($_GET["filtermode"]) > 16) {
            return $pre . " - " . "too long";
        } else if ($_GET["filtermode"] == "") {
            return $pre . " - " . "is empty";
        }
    } else if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filter"]) != 0 || $_GET["filter"] == "") {
        $pre = "invalid filter query string";
        if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_GET["filter"]) != 0) {
            return $pre . " - " . "invalid character(s)";
        } else if ($_GET["filter"] == "") {
            return $pre . " - " . "is empty";
        }
    }
    return "";
}

?>