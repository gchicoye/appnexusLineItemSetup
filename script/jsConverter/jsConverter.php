<?php



$handle = fopen(__DIR__."/jsToConvert.js","r");


if ($handle) {

	$output = "\n\$output = \"\";\n";

    while (($buffer = fgets($handle, 4096)) !== false) {
        $buffer = str_replace("\"", "\\\"",$buffer);
        $buffer = str_replace("\t", "\\t",$buffer);
        $buffer = str_replace("\n", "\\n\";\n",$buffer);
        $buffer = "\$output .= \"".$buffer;

        $output .= $buffer;
    }
    if (!feof($handle)) {
        echo "Erreur: fgets() a échoué\n";
    }
    fclose($handle);
    $output .= "\n\n";
    echo $output;
}