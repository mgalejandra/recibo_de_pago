<?php
$empty = $post = array();
foreach ($_POST as $varname => $varvalue) {
    if (empty($varvalue)) {
        $empty[$varname] = $varvalue;
    } else {
        $post[$varname] = $varvalue;
    }
}

print "<pre>";
if (empty($empty)) {
    print "Ninguno de los valores POSTeados esta vacío, se envió:\n";
    var_dump($post);
} else {
    print "Tenemos " . count($empty) . " valores vacíos\n";
    print "posteados:\n"; var_dump($post);
    print "Vacíos:\n";  var_dump($empty);
    exit;
}
?>

