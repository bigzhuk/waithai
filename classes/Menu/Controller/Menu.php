<?php
namespace Menu\Controller;


class Menu {
    /** @var null|\Menu\Decorator\Menu */
    private $decorator = null;


    public function __construct(\Menu\Decorator\Menu $decorator) {
        $this->setMenuDecorator($decorator);
    }

    public function setMenuDecorator($decorator) {
        $this->decorator = $decorator;
        return $this;
    }

    public function getMenuDecorator() {
        return $this->decorator;
    }


    public function getMenuItems() {
        return [
            'shlyapa',
            'huyapa'
        ];
    }
}