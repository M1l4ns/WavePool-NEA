<?php
    $command = escapeshellcmd('PythonCode.py');
    $output = shell_exec($command);
    echo $output;
?>