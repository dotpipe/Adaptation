<?php

include ("db.php");
function defineKeys($conn) {
// Prepare and execute the INSERT query using PDO
$sql = 'INSERT INTO keywords(id, keyword, definition) VALUES(null, :keyword, :definition)';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':keyword', $_GET['a']);
$stmt->bindParam(':definition', $_GET['c']);
$stmt->execute();
    
}

function lookupKeys($conn) {
    
// Prepare and execute the SELECT query using PDO
$sql = 'SELECT keyword, definition FROM keywords WHERE keyword LIKE :str ORDER BY keyword ASC';
$stmt = $conn->prepare($sql);
$stmt->bindValue(':str', $_GET['str'] . '%');
$stmt->execute();

// Fetch the results and generate the form
$i = 0;
$form = '';
while ($i < 2 && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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