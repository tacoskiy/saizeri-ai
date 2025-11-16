<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    //
    public function index(Request $request)
    {
        $menus = Menu::all();
        $menus->map(function ($menu) {
            $menu->image_path = url("assets/images/saizeriya_img/" . basename($menu->image_path));
        });
        return response()->json([
            'success' => true,
            'menus' => $menus,
        ]);
    }

    public function search(Request $request)
    {
        $searchIds = $request->searchIds;
        $menus = Menu::whereIn('id', $searchIds)->get();
        $menus->map(function ($menu) {
            $menu->image_path = url("assets/images/saizeriya_img/" . basename($menu->image_path));
        });
        return response()->json([
            'success' => true,
            'menus' => $menus,
        ]);
    }

    public function update(Request $request, $menuId)
    {
        
    }
    

}
