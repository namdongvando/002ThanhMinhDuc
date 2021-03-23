<?php

namespace data\tables\thanhminhducoptions;

interface IoptionsForm {
static public function Id($value = null, $title = ""); 
static public function Name($value = null, $title = ""); 
static public function Code($value = null, $title = ""); 
static public function Note($value = null, $title = ""); 
static public function Groups($value = null, $title = ""); 
static public function Parents($value = null, $title = ""); 
static public function OrderBy($value = null, $title = ""); 
static public function Active($value = null, $title = ""); 

}
?>
