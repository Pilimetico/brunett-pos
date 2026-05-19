<?php

namespace App\Http\Controllers;

use App\Models\AuthorizationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorizationController extends Controller
{
    public function index()
    {
        $requests = AuthorizationRequest::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('authorizations.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'action' => 'required',
            'module' => 'required',
            'motive' => 'required',
        ]);

        AuthorizationRequest::create([
            'user_id' => 1, // Fixed for now, should be Auth::id()
            'action' => $request->action,
            'module' => $request->module,
            'motive' => $request->motive,
            'data' => json_encode($request->data),
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Solicitud enviada al administrador.']);
    }

    public function update(Request $request, AuthorizationRequest $authRequest)
    {
        $authRequest->update([
            'status' => $request->status,
            'manager_id' => 1, // Fixed for now
            'response_notes' => $request->response_notes
        ]);

        return back()->with('success', 'Solicitud ' . ($request->status == 'approved' ? 'Aprobada' : 'Denegada'));
    }
}
