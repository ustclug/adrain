<?php
require '../global.php';
if(login()){
    header("Content-type:application/pdf");
    // It will be called downloaded.pdf
    header("Content-Disposition:attachment;filename='cs.pdf'");
    // The PDF source is in original.pdf
    readfile("/srv/priv/cs-merge.pdf");
} else
{
    print "<p><a href=\"../plogin.php\">登录</a></p>";
}