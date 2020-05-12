<?php
if (isset($_POST['a'])) $string_a = htmlentities($_POST['a']);
if (isset($_POST['b'])) $string_b = htmlentities($_POST['b']);

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