<?php
if (isset($_GET['a'])) $string_a = htmlentities($_GET['a']);
if (isset($_GET['b'])) $string_b = htmlentities($_GET['b']);

$isEmpty = false;
if ((empty($string_a)) || (empty($string_b))) $isEmpty = true;

if (!$isEmpty) {
  $a = (int)$string_a;
  $b = (int)$string_b;

  $c = $a + $b;

  echo $c;
}
else {
  echo "error";
}
?>
