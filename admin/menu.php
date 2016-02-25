<?php
$controller = new \Menu\Controller\Menu(new \Menu\Decorator\Menu);
$menu_items = $controller->getMenuItems();
echo $controller->getMenuDecorator()->renderMenu($menu_items);