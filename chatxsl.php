<?php
function loadFile($xml, $xsl)
{
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($xml);
    
    $xslDoc = new DOMDocument();
    $xslDoc->load($xsl);
    
    $proc = new XSLTProcessor();
    $proc->importStyleSheet($xslDoc);
    echo $proc->transformToXML($xmlDoc);
}

function updateFile($xml)
{
    $xmlLoad = simplexml_load_file($xml);
    $postKeys = array_keys($_POST);
    
    foreach($xmlLoad->children() as $x)
    { 
      foreach($_POST as $key=>$value)
      { 
        if($key == $x->attributes())
        { 
          $x->value = $value;
        }
      }
    }
    $xmlLoad->asXML($xml);
    loadFile($xml, "xml/chatxml.xsl");
}

$xml = "xml/" . $_COOKIE['chatfile'];

if($_POST["b"] == "")
{
  loadFile("xml/" . $_COOKIE['chatfile'], "xml/chatxml.xsl");
}
else
{
  updateFile("xml/" . $_COOKIE['chatfile']);
}
?>