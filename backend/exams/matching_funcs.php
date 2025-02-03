<?php

/**
 * a wrapper for the similar_text() function that instead of returning the similarity between values returns a boolean specifying whether the 
 * similarity between those 2 values is within the specified threshold or are close enough to each other to "match"
 * 
 * @param string $a                     the value that the $b will be evaluated against
 * @param string $b                     the value that will be evaluated against $a to find their similarity
 * @param int $similarityThreshold      threshold which the result of the simialrity rating between $a and $b must be more than or equal to pass
 * @param int $percentageThreshold      threshold which the percentage of the simialrity between $a and $b must be more than or equal to pass
 * 
 */
function str_matches_similar($a, $b, $similarityThreshold = 4, $percentageThreshold = 70) : bool {
    $similarity = similar_text($a, $b, $percentage);
    return $similarity >= $similarityThreshold && $percentage >= $percentageThreshold;
}
/**
 * to be used with longer strings (haystacks) to be able to find any words within the string are similar enough to the specidied string,
 * this also allows custom thresholds to be set defining how similar 2 values need to be to "match"
 * 
 * @param string $haystack              the values that the $needle will be evaluated against
 * @param string $needle                the value that will be evaluated against each word in the $haystack to find their similarity
 * @param int $similarityThreshold      threshold which the result of the simialrity rating between each word in the $haystack and the $needle must be more than or equal to pass
 * @param int $percentageThreshold      threshold which the percentage of the simialrity between each word in the $haystack and the $needle must be more than or equal to pass
 * 
 */
function str_contains_similar($haystack, $needle, $similarityThreshold = 4, $percentageThreshold = 70) : bool {
    $bool = false;
    foreach(explode(" ", $haystack) as $hay) {
        if (str_matches_similar($hay, $needle, $similarityThreshold, $percentageThreshold)) {
            $bool = true;
            break;
        }
    }
    return $bool;
}

/**
 * a wrapper for the levenshtein() function that instead of returning the levenshtein distance between those values returns a boolean specifying whether the 
 * levenshtein distance between those 2 values is within the specified threshold (are close enough to each other) to "match"
 * 
 * @param string $a                         string a
 * @param string $b                         string b
 * @param int $similarityThreshold          threshold that the distance between $a and $b must be below to pass
 * 
 */
function str_matches_levenshtein($a, $b, $similarityThreshold = 2) : bool {
    $s = levenshtein($a, $b);
    return $s <= $similarityThreshold;
}
/**
 * to be used with longer strings (haystacks) to be able to find any words within the string with a levenshtein distance close enough to the specidied string,
 * this also allows custom thresholds to be set defining how close those 2 values need to be to "match"
 * 
 * @param string $haystack                  long string to be searched through
 * @param string $needle                    short string to be matched against each word in $haystack
 * @param int $similarityThreshold          threshold that the distance between any word in $haystack and $needle must be below to pass
 * 
 */
function str_contains_levenshtein($haystack, $needle, $similarityThreshold = 2) : bool {
    $bool = false;
    foreach(explode(" ", $haystack) as $hay) {
        if (str_matches_levenshtein($hay, $needle, $similarityThreshold)) {
            $bool = true;
            break;
        }
    }
    return $bool;
}

/**
 * another wrapper for the levenshtein() function, this one however incorporates the soundex() function to be able to find the levenshtein distance between 
 * the sound of the word instead of simply the characters
 * 
 * @param string $a                         string a
 * @param string $b                         string b
 * @param int $similarityThreshold          threshold that the distance between $a and $b must be below to pass
 * 
 */
function str_matches_soundex($a, $b, $similarityThreshold = 1) : bool {
    return str_matches_levenshtein(soundex($a), soundex($b), $similarityThreshold);
}
/**
 * to be used with longer strings (haystacks) to be able to find any words within the string with a sound that has a levenshtein distance close enough to the specidied string
 * 
 * @param string $haystack                  long string to be searched through
 * @param string $needle                    short string to be matched against each word in $haystack
 * @param int $similarityThreshold          threshold that the distance between any word in $haystack and $needle must be below to pass
 * 
 */
function str_contains_soundex($haystack, $needle, $similarityThreshold = 1) : bool {
    $bool = false;
    foreach(explode(" ", $haystack) as $hay) {
        if (str_matches_soundex($hay, $needle, $similarityThreshold)) {
            $bool = true;
            break;
        }
    }
    return $bool;
}

/**
 * another wrapper for the levenshtein() function, this one however incorporates the metaphone() function to be able to find the levenshtein distance between 
 * the more accurate sound of the word instead of simply the characters
 * 
 * @param string $a                         string a
 * @param string $b                         string b
 * @param int $similarityThreshold          threshold that the distance between $a and $b must be below to pass
 * 
 */
function str_matches_metaphone($a, $b, $similarityThreshold = 1) : bool {
    return str_matches_levenshtein(metaphone($a), metaphone($b), $similarityThreshold);
}
/**
 * to be used with longer strings (haystacks) to be able to find any words within the string with a more accurate sound that has a levenshtein distance close enough to the specidied string
 * 
 * @param string $haystack                  long string to be searched through
 * @param string $needle                    short string to be matched against each word in $haystack
 * @param int $similarityThreshold          threshold that the distance between any word in $haystack and $needle must be below to pass
 * 
 */
function str_contains_metaphone($haystack, $needle, $similarityThreshold = 1) : bool {
    $bool = false;
    foreach(explode(" ", $haystack) as $hay) {
        if (str_matches_metaphone($hay, $needle, $similarityThreshold)) {
            $bool = true;
            break;
        }
    }
    return $bool;
}

?>