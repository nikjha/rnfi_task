<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::all();
        return view('slots.index', compact('slots'));
    }

    public function add()
    {
        $slot = new Slot();
        $slot->save();
        return redirect('/slots')->with('success', 'Slot added successfully!');
    }

    public function update(Request $request, $id)
    {
        $slot = Slot::findOrFail($id);
        $slot->update($request->all());
        return redirect('/slots')->with('success', 'Slot updated successfully!');
    }
}

