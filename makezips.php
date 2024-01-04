<?php

$conn = mysqli_connect("localhost", "rooter", "", "adrs", "3306") or die("Error: Cannot create connection");

// extract database entries for stores (owner, manager, shoppers)

$sql = 'SELECT manager, owner_id AS email, addr_str AS address, phone, store_name AS business, store_no, city, state, email AS store_email FROM franchise WHERE zip = ' . $_GET['a'];

$zip_code = $conn->query($sql) or die(mysqli_error($conn));

file_put_contents($_GET['a'] . ".xml", "<?xml version='1.0'?><accounts></accounts>");

  $dom = new \DomDocument();
  $dom->load($_GET['a'] .'.xml');

  $z = $dom->getElementsByTagName("accounts");
  $x = $dom->getElementsByTagName("accounts")[0];
    while ($zip = $zip_code->fetch_assoc()) {
      $tmp = $dom->createElement("links");
      foreach ($zip as $k => $v) {
        $tmp->setAttribute($k, $v);
      }
      $x->appendChild($tmp);
      $dom->appendChild($x);
    }
   
   
   $dom->save($_GET['a'] . ".xml");

header("Location: ./index.php")
?>