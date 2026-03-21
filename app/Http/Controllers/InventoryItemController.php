<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryItemRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;


class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $inventoryItems = InventoryItem::query()
            ->when($search, function ($query, $search) {
                return $query->whereRaw(
                    "to_tsvector('spanish', unaccent(concat (name , ' ', description))) @@ to_tsquery('spanish', regexp_replace(unaccent(cast(? as text)), '\s+', ':* | ', 'g') || ':*')",
                    [$search]
                );
            })
            ->orderBy('created_at', 'desc')
            ->paginate()
            ->appends(['search' => $search]);

        return view('inventory-item.index', compact('inventoryItems', 'search'))
            ->with('i', ($request->input('page', 1) - 1) * $inventoryItems->perPage());;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $inventoryItem = new InventoryItem();

        return view('inventory-item.create', compact('inventoryItem'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryItemRequest $request): RedirectResponse
    {
        InventoryItem::create($request->validated());

        return Redirect::route('inventory-items.index')
            ->with('success', 'InventoryItem created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $inventoryItem = InventoryItem::find($id);

        return view('inventory-item.show', compact('inventoryItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $inventoryItem = InventoryItem::find($id);

        return view('inventory-item.edit', compact('inventoryItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryItemRequest $request, InventoryItem $inventoryItem): RedirectResponse
    {
        $inventoryItem->update($request->validated());

        return Redirect::route('inventory-items.index')
            ->with('success', 'InventoryItem updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        InventoryItem::find($id)->delete();

        return Redirect::route('inventory-items.index')
            ->with('success', 'InventoryItem deleted successfully');
    }
}
