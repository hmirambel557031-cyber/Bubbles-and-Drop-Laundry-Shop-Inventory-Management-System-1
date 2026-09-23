<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryTransactionController extends Controller
{
    public function create()
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $items = InventoryItem::orderBy('item_name')->get();

        return view(
            'admin.inventory.stock-in',
            compact('items')
        );
    }

    public function storeStockIn(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $validated = $request->validate([
            'inventory_item_id' => [
                'required',
                'exists:inventory_items,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'date' => [
                'required',
                'date',
            ],

            'supplier' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $result = DB::transaction(function () use ($validated) {

            $item = InventoryItem::where(
                'id',
                $validated['inventory_item_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            $newQuantity = $item->quantity + $quantity;

            // Do not allow stock to exceed maximum capacity.
            if ($newQuantity > $item->max_capacity) {
                return [
                    'success' => false,
                    'message' =>
                        'Stock-In cannot be completed. ' .
                        'Maximum capacity is ' .
                        $item->max_capacity . ' ' .
                        $item->unit .
                        ', while the resulting quantity would be ' .
                        $newQuantity . ' ' .
                        $item->unit . '.',
                ];
            }

            // Update inventory quantity.
            $item->increment('quantity', $quantity);

            // Record transaction.
            InventoryTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => 'stock-in',
                'quantity' => $quantity,
                'date' => $validated['date'],
                'supplier' => $validated['supplier'],
                'reason' => null,
            ]);

            return [
                'success' => true,
                'message' => 'Stock-In recorded successfully.',
            ];
        });

        // If capacity was exceeded, stay on the form.
        if (!$result['success']) {
            return redirect()
                ->route('admin.inventory.stock-in')
                ->withInput()
                ->with('error', $result['message']);
        }

        // Only successful transactions get a success message.
        return redirect()
            ->route('admin.inventory.stock-in')
            ->with('success', $result['message']);
    }


    public function createStockOut()
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $items = InventoryItem::orderBy('item_name')->get();

        return view(
            'admin.inventory.stock-out',
            compact('items')
        );
    }


    public function storeStockOut(Request $request)
    {
        if (!in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403);
        }

        $validated = $request->validate([
            'inventory_item_id' => [
                'required',
                'exists:inventory_items,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'date' => [
                'required',
                'date',
            ],

            'reason' => [
                'required',
                Rule::in([
                    'Wash, Dry, and Fold',
                    'Self Service',
                ]),
            ],
        ]);

        $result = DB::transaction(function () use ($validated) {

            $item = InventoryItem::where(
                'id',
                $validated['inventory_item_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $validated['quantity'];

            // Prevent stock from becoming negative.
            if ($quantity > $item->quantity) {
                return [
                    'success' => false,
                    'message' =>
                        'Insufficient stock. Available quantity: ' .
                        $item->quantity . ' ' .
                        $item->unit . '.',
                ];
            }

            $item->decrement('quantity', $quantity);

            InventoryTransaction::create([
                'inventory_item_id' => $item->id,
                'type' => 'stock-out',
                'quantity' => $quantity,
                'date' => $validated['date'],
                'supplier' => null,
                'reason' => $validated['reason'],
            ]);

            return [
                'success' => true,
                'message' => 'Stock-Out recorded successfully.',
            ];
        });

        if (!$result['success']) {
            return redirect()
                ->route('admin.inventory.stock-out')
                ->withInput()
                ->with('error', $result['message']);
        }

        return redirect()
            ->route('admin.inventory.stock-out')
            ->with('success', $result['message']);
    }
}