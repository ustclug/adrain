<?php
session_start();
function login()
{
    return $_SESSION['userid'];
}
if (login()) {
    $filename = "/srv/priv/pmpi-2014.pdf";
    if (!file_exists($filename)) {
        http_response_code(404);
        echo "File not exist. Please contact the administrator.";
        exit();
    }
    header("Content-type:application/pdf");
    // It will be called downloaded.pdf
    header("Content-Disposition:attachment;filename=pmpi-2014.pdf");
    // The PDF source is in original.pdf
    readfile($filename);
} else {
    print "<p><a href=\"../plogin.php\">登录</a></p>";
}
