<?php
// requires $filename and $filepath to be set.
if (!isset($filename) || !isset($filepath)) 
    exit('Attachment parameter set improperly. Abort.');

function login()
{
    return $_SESSION['userid'];
}
if (login()) {
    if (!file_exists($filepath)) {
        http_response_code(404);
        echo "File not exist. Please contact the administrator.";
        exit();
    }
    header("Content-type:application/pdf");
    // It will be called downloaded.pdf
    header("Content-Disposition:attachment;filename=$filename");
    // The PDF source is in original.pdf
    readfile($filepath);
} else {
    print "<p><a href=\"../plogin.php\">登录</a></p>";
}