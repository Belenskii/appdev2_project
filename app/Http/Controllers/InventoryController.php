<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('product')->get();
        return response()->json($inventory);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
        ]);

        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    public function show($id)
    {
        $inventory = Inventory::with('product')->findOrFail($id);
        return response()->json($inventory);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'sometimes|required|exists:products,id',
            'quantity' => 'sometimes|required|integer',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());
        return response()->json($inventory);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();
        return response()->json(null, 204);
    }
}
