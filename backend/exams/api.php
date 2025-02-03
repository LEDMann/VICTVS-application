<?php
include 'exam.php';
include 'filter_validation.php';
include 'matching_funcs.php';

// setup the session so we can access the correct uploaded file for this user
session_start();

// store any error messages in here and if its empty we know theres been no errors
$errmsgs = [];

// validate and retrieve the latitude and logitude coordinates from the get request
// (look i like ternarys ok ive put the same thing commented out below but in a much more maintaiable way i just like it when its on 1 line doesnt mean i would actually do this in the role)
[$ulat,  $ulong] = ( isset($_GET['lat']) && isset($_GET['long']) ) ? ( ( is_numeric($_GET['lat']) && is_numeric($_GET['long']) ) ? ( ( strpos($_GET['lat'], '.') != false && strpos($_GET['long'], '.') != false ) ? [floatval($_GET['lat']), floatval($_GET['long'])] : null ) : null ) : null;
// sane version of that ternary below: 
// $ulat = null;
// $ulong = null;
// if (isset($_GET['lat']) && $_GET['long']) {
//     if (is_numeric($_GET['lat']) && is_numeric($_GET['long'])) {
//         if (strpos($_GET['lat'], '.') != false && strpos($_GET['long'], '.') != false) {
//             $ulat = floatval($_GET['lat']);
//             $ulong = floatval($_GET['long']);
//         }
//     }
// }

// switch the comment on the lines below to test the api 
// $examsjson = json_decode(file_get_contents(dirname(__DIR__) . "\\uploads\\" . (isset($_GET["sessid"]) ? $_GET["sessid"] : session_id()) . ".json"))->Exams;
$examsjson = json_decode(file_get_contents(dirname(__DIR__) . "\\uploads\\" . session_id() . ".json"))->Exams;

//init the array for holding exams that match the filter
$exams = [];

// loop over each exam from the file and match it against the filter
foreach ($examsjson as $examraw) {
    // parse the exam json object into an actual object so that its data can be more easily verified
    $exam = new Exam($examraw, $ulat, $ulong);
    // validate that the filter is included in the request
    // match statements are so cool at least i got something out of my rust 🦀 phase
    match (isset($_GET['filterby']) && isset($_GET['filtermode']) && isset($_GET['filter'])) {
        // validate that the filter values are valid
        true => match(validate_query()) {
            // which value in the object does this need to be filtered by
            true => match ($_GET['filterby']) {
                // what method should we use to filter this value
                'title' => match ($_GET['filtermode']) {
                    'exact'          => match (strtoupper($exam->Title) == strtoupper($_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'contains_exact' => match (str_contains(strtoupper($exam->Title), strtoupper($_GET['filter']))) { true => array_push($exams, $exam), default => null },
                    'similar'        => match (str_matches_similar($exam->Title, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'soundex'        => match (str_matches_soundex($exam->Title, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'levenshtein'    => match (str_matches_levenshtein($exam->Title, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    // use metaphone as the default filter if none is specified as its the most dynamic method being able to get the more accurate 
                    // representation of the sound of a word as well as using more accurate method of finding the similarity
                    default          => match (str_matches_metaphone($exam->Title, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                },
                'description' => match ($_GET['filtermode']) {
                    'contains_exact' => match (str_contains(strtoupper($exam->Description), strtoupper($_GET['filter']))) { true => array_push($exams, $exam), default => null },
                    'similar'        => match (str_contains_similar($exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'soundex'        => match (str_contains_soundex($exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'levenshtein'    => match (str_contains_levenshtein($exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    default          => match (str_contains_metaphone($exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                },
                'titledescription' => match ($_GET['filtermode']) {
                    'contains_exact' => match (str_contains(strtoupper($exam->Title) . " " . strtoupper($exam->Description), strtoupper($_GET['filter']))) { true => array_push($exams, $exam), default => null },
                    'similar'        => match (str_contains_similar($exam->Title . " " . $exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'soundex'        => match (str_contains_soundex($exam->Title . " " . $exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'levenshtein'    => match (str_contains_levenshtein($exam->Title . " " . $exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    default          => match (str_contains_metaphone($exam->Title . " " . $exam->Description, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                },
                'name' => match ($_GET['filtermode']) {
                    'exact'          => match (strtoupper($exam->CandidateName) == strtoupper($_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'contains_exact' => match (str_contains(strtoupper($exam->CandidateName), strtoupper($_GET['filter']))) { true => array_push($exams, $exam), default => null },
                    'similar'        => match (str_matches_similar($exam->CandidateName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'soundex'        => match (str_matches_soundex($exam->CandidateName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'levenshtein'    => match (str_matches_levenshtein($exam->CandidateName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    default          => match (str_matches_metaphone($exam->CandidateName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                },
                'location' => match ($_GET['filtermode']) {
                    'exact'          => match (strtoupper($exam->LocationName) == strtoupper($_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'contains_exact' => match (str_contains(strtoupper($exam->LocationName), strtoupper($_GET['filter']))) { true => array_push($exams, $exam), default => null },
                    'similar'        => match (str_matches_similar($exam->LocationName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'soundex'        => match (str_matches_soundex($exam->LocationName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    'levenshtein'    => match (str_matches_levenshtein($exam->LocationName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                    default          => match (str_matches_metaphone($exam->LocationName, $_GET['filter'])) { true => array_push($exams, $exam), default => null },
                },
                // here imagine the filter key "filter" says distance as thats what that value means here
                'distance' => match (isset($_GET['lat']) && isset($_GET['long'])) {
                    true => match ($_GET['filtermode']) {
                        // make sure were working with numbers
                        'less'    => match (is_numeric($_GET['filter'])) { 
                                        true => match ($exam->Distance < intval($_GET['filter'])) { 
                                            true => array_push($exams, $exam), 
                                            default => null 
                                        }, 
                                        default => array_push($errmsgs, "invalid filter query value" . $_GET['filter'] . " is not a numeric value") 
                                    },
                        'more'    => match (is_numeric($_GET['filter'])) { 
                                        true => match ($exam->Distance > intval($_GET['filter'])) { 
                                            true => array_push($exams, $exam), 
                                            default => null 
                                        }, 
                                        default => array_push($errmsgs, "invalid filter query value" . $_GET['filter'] . " is not a numeric value") 
                                    },
                        'between' => match (is_numeric($_GET['filter'])) { 
                                        true => match (intval(min(explode(".", $_GET['filter']))) < $exam->Distance && $exam->Distance < intval(max(explode(".", $_GET['filter'])))) { 
                                            true => array_push($exams, $exam), 
                                            default => null 
                                        }, 
                                        default => array_push($errmsgs, "invalid filter query values, either " . min(explode(".", $_GET['filter'])) . " or " . max(explode(".", $_GET['filter'])) . " are not a numeric value") 
                                    },
                        // cant use a default filter mode if none is specified here as we dont know how to use the number(s) even if they were included in the request
                        default   => array_push($errmsgs, "invalid filter mode " . htmlspecialchars($_GET['filtermode']) . " mode does not exist")
                    },
                    // cant use this filter if you didnt tell us where you are
                    default => array_push($errmsgs, "no user coordinates given, unable to calculate distance and filter by it")
                },
                // column/parameter whatever doesnt match cant use it
                default => array_push($errmsgs, "unable to filter by " . htmlspecialchars($_GET['filterby']) . ", column does not exist")
            },
            // oh heck somehting in the filter parameters are invalid gotta debug it
            default => array_push($errmsgs, debug_query())
        },
        // no filter? no problem! we'll just chuck all of them in there then shall we
        default => array_push($exams, $exam)
    };
    // was there an error during the last iteration? better break out and run back to the client
    if ($errmsgs && $errmsgs[0] != "") {
        break;
    }
}

// we got an error no point reordering the exams if theres an error
match ($errmsgs && $errmsgs[0] != "") {
    // \o/ no error hope they told us how to order this
    false => match (isset($_GET['orderby'])) {
        // cool so how do we order this then
        true => match ($_GET['orderby']) {
            // and you told us which direction to order it too?
            "title" => match (isset($_GET['dir'])) {
                // cool we'll get that back to u in ascending order then lad
                true => match ($_GET['dir']) {
                    'desc' => usort($exams, fn($a, $b) => $b->Title <=> $a->Title), //cmpTitleDesc
                    default => usort($exams, fn($a, $b) => $a->Title <=> $b->Title), //cmpTitleAsc
                },
                default => usort($exams, fn($a, $b) => $a->Title <=> $b->Title) //cmpTitleAsc
            },
            "name" => match (isset($_GET['dir'])) {
                true => match ($_GET['dir']) {
                    'desc' => usort($exams, fn($a, $b) => $b->CandidateName <=> $a->CandidateName), //cmpCandidateNameDesc
                    default => usort($exams, fn($a, $b) => $a->CandidateName <=> $b->CandidateName), //cmpCandidateNameAsc
                },
                default => usort($exams, fn($a, $b) => $a->CandidateName <=> $b->CandidateName) //cmpCandidateNameAsc
            },
            "id" => match (isset($_GET['dir'])) {
                true => match ($_GET['dir']) {
                    'desc' => usort($exams, fn($a, $b) => $b->Candidateid <=> $a->Candidateid), //cmpCandidateidDesc
                    default => usort($exams, fn($a, $b) => $a->Candidateid <=> $b->Candidateid), //cmpCandidateidAsc
                },
                default => usort($exams, fn($a, $b) => $a->Candidateid <=> $b->Candidateid) //cmpCandidateidAsc
            },
            // might help if you told us where you are if you want us to order this by your distance to it
            "distance" => match (isset($_GET['lat']) && isset($_GET['long'])) {
                true => match (isset($_GET['dir'])) {
                    true => match ($_GET['dir']) {
                        'desc' => usort($exams, fn($a, $b) => $b->Distance <=> $a->Distance), //cmpDistanceDesc
                        default => usort($exams, fn($a, $b) => $a->Distance <=> $b->Distance) //cmpDistanceAsc
                    },
                    default => usort($exams, fn($a, $b) => $a->Distance <=> $b->Distance) //cmpDistanceAsc
                },
                default => array_push($errmsgs, "no user coordinates given, unable to calculate distance and sort by it")
            },
            "date" => match (isset($_GET['dir'])) {
                true => match ($_GET['dir']) {
                    'desc' => usort($exams, fn($a, $b) => $b->Date->getTimestamp() <=> $a->Date->getTimestamp()), //cmpDateTimestampDesc
                    default => usort($exams, fn($a, $b) => $a->Date->getTimestamp() <=> $b->Date->getTimestamp()) //cmpDateTimestampAsc
                },
                default => usort($exams, fn($a, $b) => $a->Date->getTimestamp() <=> $b->Date->getTimestamp()) //cmpDateTimestampAsc
            },
            default => usort($exams, fn($a, $b) => $a->Date->getTimestamp() <=> $b->Date->getTimestamp()) //cmpDateTimestampAsc
        },
        default => usort($exams, fn($a, $b) => $a->Date->getTimestamp() <=> $b->Date->getTimestamp()) //cmpDateTimestampAsc
    },
    default => null
};

// you want some json with that mate
header('Content-Type: application/json; charset=utf-8');
// did we get an error? better tell em if so
if ($errmsgs) {
    echo json_encode([
        "get" => $_GET,
        "request" => $_REQUEST,
        "error" => true,
        "error_message" => $errmsgs
    ]);
} else {
    echo json_encode([
        "get" => $_GET,
        "request" => $_REQUEST,
        "error" => false,
        "exams" => $exams
    ]);
}

?>