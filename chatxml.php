
<?php

function findMyFile($con) {
    $temp = "";
    $files = [];
    $alias = [];
    $email = [];
    setcookie("chatfiles","");
    $results = $con->query('SELECT start, aim, filename, alias, email, username FROM ad_revs, franchise, chat WHERE (aim = "' . $_COOKIE['myemail'] . '" || start = "' .  $_COOKIE['myemail'] . '") && ((aim = username || start = username) || (email = aim || start = email)) ORDER BY last DESC') or die("asd");
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            if (!in_array($row['filename'], $files))
                $files[] = $row['filename'];
            if (!in_array($row['aim'], $email))
                $email[] = ($row['aim'] == $_COOKIE['myemail']) ? $row['start'] : $row['aim'];
            if (!in_array($row['alias'], $alias))
                $alias[] = $row['alias'];
            $con->query('UPDATE chat SET `checked` = 0 WHERE `filename` = "' . $row['filename'] . '"');
        }
    }
    echo json_encode($files);
    if (sizeof($files) > 0) {
        $f = [];
        foreach ($files as $v)
            $f[] = $v;
        $e = [];
        foreach ($email as $v)
            $e[] = $v;
        $a = [];
        foreach ($alias as $v)
            $a[] = $v;
        setcookie("chatfiles", json_encode($f));
        setcookie("aliases", json_encode($e));
        setcookie("names", json_encode($a));
        if (count($f) == 1)
            setcookie("chatfile", $f[0]);
        return 1;
    }
    return makeMyFile($con);
}

function makeMyFile($cnxn) {
    $temp = 0;
    
    $results = $cnxn->query('SELECT * FROM chat WHERE 1');
    
    $row = $results->num_rows;
    srand($row);
    $temp = $row + rand(1,25);
    srand($row + $temp);
    $temp += rand(1,25);
    srand($temp);
    $temp += rand(1,25);
    
    if (!file_exists("xml/" . md5($temp) . ".xml")) {
        file_put_contents("xml/" . md5($temp) . ".xml", "<?xml version=\'1.0\'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
        chmod('xml/' . md5($temp) . ".xml", 0644);
    }
    $sql = 'INSERT INTO chat(id,start,aim,filename,last,altered,checked) VALUES (null, "' . $_COOKIE["myemail"] . '", "' . $_COOKIE["store_id"] . '", "' . md5($temp) . '.xml", CURRENT_TIMESTAMP,null,0)';

    $results = $cnxn->query($sql);
    return findMyFile($cnxn);
}
//$con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");

$con = mysqli_connect('localhost', 'root', '', 'adrs','3306') or die("Error: Can't connect");
findMyFile($con);
?>