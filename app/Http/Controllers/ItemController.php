<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request){
        $searchKey = ($request->has('key')) ? $request->key : null;
        return Inertia::render('Admin/Todo/ListItem', [
            'items' => Item::when($searchKey, function ($query, $searchKey){
                return $query->where('name', 'like', "%".$searchKey."%");
            })->latest()->paginate()
        ]);
    }

    public function create(){
        return Inertia::render('Admin/Todo/CreateItem');
    }

    public function store(Request $request){
        Item::create($request->validate([
            'name' => 'required|max:255',
        ]));
        return redirect()->route('todo-item.index')->with('success', 'Item created successfully');
    }

    public function edit($id){
        return Inertia::render('Admin/Todo/EditItem', [
            'item' => Item::find($id)
        ]);
    }

    public function update(Request $request, $id){
        $item = Item::find($id);
        $item->update($request->validate([
            'name' => 'required|min:4|max:255',
        ]));
        return redirect()->route('todo-item.index')->with('success', 'Item updated successfully');
    }

    public function destroy($id){
        $item = Item::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
    }
}
