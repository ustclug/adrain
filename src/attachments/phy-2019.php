<?php
session_start();
function login()
{
    return $_SESSION['userid'];
}
if (login()) {
    header("Content-type:application/pdf");
    // It will be called downloaded.pdf
    header("Content-Disposition:attachment;filename=phy-2019.pdf");
    // The PDF source is in original.pdf
    readfile("/srv/priv/phy-2019.pdf");
} else {
    print "<p><a href=\"../plogin.php\">登录</a></p>";
}
