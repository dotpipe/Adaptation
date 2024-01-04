<?php

include("db.php");
function defineKeys($conn) {
    $sql = 'INSERT INTO keywords(keyword, definition) VALUES(:keyword, :definition)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':keyword', $_GET['a']);
    $stmt->bindParam(':definition', $_GET['c']);
    $stmt->execute();
    
}

function lookupKeys($conn) {
    $sql = 'SELECT keyword, definition FROM keywords WHERE keyword LIKE :str ORDER BY keyword ASC';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':str', $_GET['str'] . '%');
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($results) === 0) {
        return;
    }
    
    $form = '';
    $i = 0;
    foreach ($results as $row) {
        if ($i >= 2) {
            break;
        }
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
    lookupKeys($conn);    
else if ($_GET['b'] == 1)
    defineKeys($conn);
?>