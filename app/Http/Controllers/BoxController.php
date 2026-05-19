<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\BoxMovement;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    public function index()
    {
        $currentBox = Box::where('status', 'open')->first();
        $history = Box::orderBy('created_at', 'desc')->paginate(10);
        
        return view('boxes.index', compact('currentBox', 'history'));
    }

    public function open(Request $request)
    {
        $request->validate(['opening_balance' => 'required|numeric|min:0']);

        if (Box::where('status', 'open')->exists()) {
            return back()->with('error', 'Ya existe una caja abierta.');
        }

        Box::create([
            'user_id' => 1, // Default user
            'opening_balance' => $request->opening_balance,
            'opened_at' => Carbon::now(),
            'status' => 'open'
        ]);

        return redirect()->route('boxes.index')->with('success', 'Caja abierta correctamente.');
    }

    public function close(Request $request, Box $box)
    {
        $request->validate(['closing_balance' => 'required|numeric|min:0']);

        // Calculate expected balance
        // opening + sales (cash) + movements(in) - movements(out)
        $salesTotal = Sale::where('created_at', '>=', $box->opened_at)->sum('total');
        $movementsIn = BoxMovement::where('box_id', $box->id)->where('type', 'in')->sum('amount');
        $movementsOut = BoxMovement::where('box_id', $box->id)->where('type', 'out')->sum('amount');

        $expected = $box->opening_balance + $salesTotal + $movementsIn - $movementsOut;
        $difference = $request->closing_balance - $expected;

        $box->update([
            'closing_balance' => $request->closing_balance,
            'expected_balance' => $expected,
            'difference' => $difference,
            'closed_at' => Carbon::now(),
            'status' => 'closed',
            'notes' => $request->notes
        ]);

        return redirect()->route('boxes.index')->with('success', 'Caja cerrada exitosamente.');
    }

    public function addMovement(Request $request)
    {
        $request->validate([
            'box_id' => 'required|exists:boxes,id',
            'type' => 'required|in:in,out',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'required|string|max:255'
        ]);

        BoxMovement::create([
            'box_id' => $request->box_id,
            'user_id' => 1,
            'type' => $request->type,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'person_involved' => $request->person_involved,
            'notes' => $request->notes
        ]);

        return back()->with('success', 'Movimiento registrado correctamente.');
    }
}
