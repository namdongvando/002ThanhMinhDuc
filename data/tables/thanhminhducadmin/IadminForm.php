<?php

namespace data\tables\thanhminhducadmin;

interface IadminForm {
static public function Id($value = null, $title = ""); 
static public function Username($value = null, $title = ""); 
static public function Password($value = null, $title = ""); 
static public function Random($value = null, $title = ""); 
static public function Name($value = null, $title = ""); 
static public function Email($value = null, $title = ""); 
static public function Phone($value = null, $title = ""); 
static public function Address($value = null, $title = ""); 
static public function Note($value = null, $title = ""); 
static public function Groups($value = null, $title = ""); 
static public function Image($value = null, $title = ""); 
static public function Active($value = null, $title = ""); 

}
?>
