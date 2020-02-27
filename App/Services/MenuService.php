<?php

namespace App\Services;

use App\Models\Menu;
use App\Core\Exceptions\AppException;

class MenuService
{
    function list()
    {
        /** @var Menu[] */
        $menu = Menu::whereRemoved_at(null)
            ->orderBy("name")
            ->take(10)
            ->fetch();

        return $menu;
    }

    function read($id)
    {
        /** @var Menu */
        $menu = Menu::findById($id);

        return $menu;
    }

    function create($model)
    {
        $menu = new Menu();

        $menu->name = $model->name;
        $menu->description = $model->description;
        $menu->price = $model->price;
        $menu->stock = $model->stock;
        $menu->role = $model->role;

        return $menu->create();
    }

    function update($id, $model)
    {
        /** @var Menu */
        $menu = Menu::findById($id);

        if ($menu == null) throw new AppException("Menu not found");

        $menu->name = $model->name;
        $menu->description = $model->description;
        $menu->price = $model->price;
        $menu->stock = $model->stock;
        $menu->role = $model->role;
        $menu->updated_at = date('Y-m-d H:i:s');

        return $menu->edit();
    }

    function remove($id)
    {
        /** @var Menu */
        $menu = Menu::findById($id);

        if ($menu == null) throw new AppException("Menu not found");

        $menu->removed_at = date('Y-m-d H:i:s');

        return $menu->edit();
    }

    function delete($id)
    {
        /** @var Menu */
        $menu = Menu::findById($id);

        if ($menu == null) throw new AppException("Menu not found");

        return $menu->delete();
    }
}
