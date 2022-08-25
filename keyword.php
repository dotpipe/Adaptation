<?php

function defineKeys() {
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", 3306);
    
    $sql = 'INSERT INTO keywords(id,keyword,definition) VALUES(null,"' . $_GET['a'] . '", "' . $_GET['c']. '")';

    $results = $conn->query($sql) or die(mysqli_error($conn));
    
}

function lookupKeys() {
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", 3306);
    
    $sql = 'SELECT keyword, definition FROM keywords WHERE keyword LIKE "' . $_GET['str'] . '%" ORDER BY keyword ASC';
    
    $results = $conn->query($sql) or die(mysqli_error($conn));
    
    $i = 0;
    if ($results->num_rows === 0)
        return;
    $form = ''; // '<div id="div-keys" style="width:200px;border-radius:25%;border:2px solid lightblue;background:lightgray;display:table;">';
    while ($i < 2 && $row = $results->fetch_assoc()) {
        $form .= '<div onclick="choseKeyword(\'' . $row['keyword'] . '\');this.parentNode.removeChild(this);" style="width:130px;display:table-cell;padding:10px;margin:10px;border-radius:25px;border:2px dashes white;background:black;">';
        $form .= '<b style="font-size:14px">' . $row['keyword'] . '</b><br>';
        $form .= '<i><font style="width:90px;font-size:11px">' . $row['definition'] . '</font></i>';
        $form .= '</div>';
        $i++;
    }
    $form .= '</div>';
    echo $form;
}

if ($_GET['b'] == 2 && strlen($_GET['str']) > 1)
    lookupKeys();    
else if ($_GET['b'] == 1)
    defineKeys();
?>