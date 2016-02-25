<?php
namespace Menu\Decorator;

class Menu {
    public function renderMenu(array $menu_items) {
        $out = '';
        foreach($menu_items as $menu_item) {
            $out.='<div class="menu">'.$menu_item.'</div>';
        }
        return $out;
    }
}