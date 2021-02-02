<?php

namespace Model;

interface IModel {

    public function GetAll();

    public function GetById($id);

    public function GetByName($name);

    public function InsertSubmit($model);

    public function UpdateSubmit($model);

    public function DeleteSubmit($id);
}
