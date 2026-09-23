<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\InventoryTransaction;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $totalItems = InventoryItem::count();

        $lowStockItems = InventoryItem::whereColumn(
            'quantity',
            '<=',
            'reorder_level'
        )
            ->whereColumn(
                'quantity',
                '<',
                'max_capacity'
            )
            ->orderBy('quantity')
            ->get();

        $lowStockCount = $lowStockItems->count();

        $stockInToday = InventoryTransaction::where(
            'type',
            'stock-in'
        )
            ->whereDate('date', today())
            ->count();

        $stockOutToday = InventoryTransaction::where(
            'type',
            'stock-out'
        )
            ->whereDate('date', today())
            ->count();

        $recentStockIns = InventoryTransaction::with('inventoryItem')
            ->where('type', 'stock-in')
            ->latest('date')
            ->latest('id')
            ->take(3)
            ->get();

        $recentStockOuts = InventoryTransaction::with('inventoryItem')
            ->where('type', 'stock-out')
            ->latest('date')
            ->latest('id')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'totalItems',
            'lowStockCount',
            'stockInToday',
            'stockOutToday',
            'lowStockItems',
            'recentStockIns',
            'recentStockOuts'
        ));
    }
}