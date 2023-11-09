<?php


function generateWordsArrayFromFile ($path)
    /*
     * get path to file
     * in the file each word is on a new line
     * without punctuation marks
     * return array words
     * */
{
    $fileContent = file_get_contents($path);
    $wordsArray = preg_split("/\r\n|\n|\r/", $fileContent);

    return $wordsArray;
}


function generateNotLowerStringFromArray($arrayWords)
    /*
     * get array
     * generates the required string by substituting values from the array
     * return string*/
{
    $result = "";
    $separator = " or ";

    foreach ($arrayWords as $word) {
        $word = trim($word);

        if ($word != "")
        {
            $result .= "(not lower(http.user_agent) contains $word)" . $separator;
        }
    }
    $result = trim(substr($result,0,-strlen($separator)));

    return $result;
}


function generateRewriteCondStringFromArray($arrayWords)
    /*
     * get array
     * generates the required string by substituting values from the array
     * return string*/
{
    $staticPart = "RewriteCond %{HTTP_USER_AGENT} ";
    $generatePart = "";
    $separator = "|";

    foreach ($arrayWords as $word) {
        $word = trim($word);

        if ($word != "")
        {
            $generatePart .= $word . $separator;
        }
    }
    $generatePart = trim(substr($generatePart,0,-strlen($separator)));
    $result = $staticPart . "(" . $generatePart . ")";

    return $result;
}


//$qwe = generateNotLowerStringFromArray(generateWordsArrayFromFile('test_delme.txt'));
$qwe = generateNotLowerStringFromArray(generateWordsArrayFromFile('express_mode.txt'));
var_dump($qwe);

//$qwe = generateRewriteCondStringFromArray(generateWordsArrayFromFile('test_delme.txt'));
$qwe = generateRewriteCondStringFromArray(generateWordsArrayFromFile('express_mode.txt'));
var_dump($qwe);
