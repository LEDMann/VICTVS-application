<?php
// get a session so we can know whos file is whos after its been uploaded
session_start();

// well of course were returning json this aint no website
header('Content-Type: application/json; charset=utf-8');


// you did give us something to work with right
if (count($_FILES) > 0) {
    // right we'll just validate this isnt going to blow up the server then
    $uploadOk = true;
    $err = [];
    $msg = [];
    $target_file = 'uploads/' . session_id() . '.json';

    if (preg_match('/[\'^£$%&*()}{@#~?!:;><>,|=¬]/', $_FILES["file"]["name"]) == 0) {
        $uploadOk = true;
    } else {
        $uploadOk = false;
        array_push($err, "invalid file name");
    }

    if ($_FILES["file"]["size"] > 42069) {
        $uploadOk = false;
        array_push($err, "invalid file size");
    } else if (json_decode(file_get_contents($_FILES["file"]["tmp_name"])) == null) {
        $uploadOk = false;
        array_push($err, "invalid JSON");
    }
    if (file_exists($target_file)) {
        array_push($msg, "file replaced on server");
    }
    
    // cool we'll put your id on this, you just give us that id when you come back and you can get this stuff whenever you need it
    if ($uploadOk) {
        if (!file_exists(dirname(__DIR__) . "/uploads")) {
            mkdir(dirname(__DIR__) . "/uploads", 0777, true);
        }
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        echo json_encode(['success' => $msg]);
    } else {
        // cant be having that now lad, its into the incinerator with that, now thats gonna 30 years in the json mines for you
        http_response_code(500);
        echo json_encode(['error' => $err]);
    }
} else {
    // how did you do that
    array_push($err, "file uploaded incorrectly");
    http_response_code(500);
    echo json_encode(['error' => $err]);
}
?>