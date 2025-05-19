<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;

class MenuController extends Controller
{
    public function index()
    {
        return MenuResource::collection(Menu::all());
    }

    public function store(StoreMenuRequest $request)
    {
        $menu = Menu::create($request->validated());
        return new MenuResource($menu);
    }

    public function show(Menu $menu)
    {
        return new MenuResource($menu);
    }

    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        return new MenuResource($menu);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
