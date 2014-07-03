<?php
if ($handle = opendir('.')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != ".." && (substr($entry, 0, 1) != ".") && (substr($entry, 0, 5) != "index")){
            echo "<a href='$entry'>$entry</a><br/>";
        }
    }
    closedir($handle);
}
?>