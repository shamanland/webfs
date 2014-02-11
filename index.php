<?php
$FILES_DIR = "files/";

$orig = $_SERVER["SCRIPT_URL"];
if ($orig == "/") {
    echo "<!DOCTYPE html>";
    echo "\n";
    echo "<html><head><title>";
    echo $_SERVER["HTTP_HOST"];
    echo "</title></head>";
    echo "\n";
    echo "<body><h1>";
    echo $_SERVER["HTTP_HOST"];
    echo "</h1>";
    echo "\n";
    echo "<table>";

    if ($handle = opendir($FILES_DIR)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                if (endsWith($entry, ".meta")) {
                    $link = file_get_contents($FILES_DIR . $entry);
                    echo "<tr><td>";
                    echo "<a href=\"";
                    echo $link;
                    echo "\">";
                    echo $link;
                    echo "</a>";
                    echo "</td></tr>";
                    echo "\n";
                }
            }
        }

        closedir($handle);
    }

    echo "</table></body></html>";
    exit(0);
}

$hash = sha1($orig);
$file = $FILES_DIR . $hash . ".file";
$meta = $FILES_DIR . $hash . ".meta";

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    mkdir($path, 0777, true);

    $putdata = fopen("php://input", "r");
    $fp = fopen($file, "w");

    while ($data = fread($putdata, 1024)) {
        fwrite($fp, $data);
    }

    fclose($fp);
    fclose($putdata);

    $fp = fopen($meta, "w");
    fwrite($fp, $orig);
    fclose($fp);
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    unlink($file);
    unlink($meta);
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (file_exists($file)) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: Attachment");
        readfile($file);
    } else {
        http_response_code(404);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "HEAD") {
    if (file_exists($file)) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: Attachment");
        header("Content-Length: " . filesize($file));
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(405);
}

// http://stackoverflow.com/a/834355/1891118
function startsWith($haystack, $needle) {
    return !strncmp($haystack, $needle, strlen($needle));
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
?>
