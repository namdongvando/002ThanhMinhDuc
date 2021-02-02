<?php

namespace Controller;

/**
 * Controller mau 
 * @param {type} parameter
 */
interface IController {

    public function index();

    public function edit();

    public function delete();

    public function create();

    public function detail();
}
