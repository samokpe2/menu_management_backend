<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Menu;

class MenuItemController extends Controller
{
    public function store(Request $request, $menuId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menu_items,id',
            'position' => 'integer',
        ]);

        $menu = Menu::findOrFail($menuId);
        $menuItem = $menu->items()->create($request->all());

        return response()->json($menuItem, 201);
    }

    public function update(Request $request, $id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($request->all());

        return response()->json($menuItem, 200);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->delete();

        return response()->json(null, 204);
    }

    public function index(Menu $menu)
    {
        $menuItems = $menu->items()
                          ->orderBy('position', 'asc')
                          ->get();

        return response()->json($menuItems, 200);
    }
}