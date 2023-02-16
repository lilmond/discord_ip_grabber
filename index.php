<?php
    $fileDir = "./frog.png";
    $logFile = "./logs.txt";

    function getUserInfo()
    {
        $targetInfo = array("REMOTE_ADDR", "HTTP_X_FORWARDED_FOR", "HTTP_USER_AGENT");
        $userInfo = array();

        foreach ($targetInfo as $infoVar)
        {
            if (isset($_SERVER[$infoVar]))
            {
                $varVal = $_SERVER[$infoVar];
                $userInfo[$infoVar] = $varVal;
            }
        }

        return $userInfo;
    }

    function logText(string $filePath, string $logText)
    {
        $fileHandler = fopen($filePath, "a+");
        fwrite($fileHandler, "${logText}\n");
        fclose($fileHandler);
    }

    $userInfoText = "";
    $userInfo = getUserInfo();
    
    foreach ($userInfo as $infoName => $infoVal)
    {
        $userInfoText = "${userInfoText}${infoName}: ${infoVal}\n";
    }

    logText($logFile, $userInfoText);

    $fileSplit = explode(".", $fileDir);
    $fileType = end($fileSplit);
    $fileSize = filesize($fileDir);

    header("Content-Type: image/${fileType}");
    header("Content-Length: ${fileSize}");

    readfile($fileDir);
