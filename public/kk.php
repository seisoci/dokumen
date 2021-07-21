<?php
$fields = ['ID','Name'];
$columns = [];
$select = "SELECT ";
foreach($fields AS $field){
  array_push($columns,'`value` AS `'. $field .'`');
}
$select .= implode(',',$columns);

print_R($select);
