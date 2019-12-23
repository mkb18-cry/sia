<?php
function rupiah($angka){
  $rupiah=number_format($angka,0,',','.');
  return $rupiah;
}
?> 