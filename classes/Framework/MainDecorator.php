<?php
namespace Framework;

abstract class MainDecorator {
    /**
     * @var string Строка содержащая страницу, на которой будет выводиться данный декоторатор
     */
    protected $home_page = '';
    abstract function getHomePage();
    abstract function setHomePage($home_page);
}