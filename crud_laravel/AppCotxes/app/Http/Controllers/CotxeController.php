<?php

namespace App\Http\Controllers;

use App\Models\Cotxe;
use Illuminate\Http\Request;

class CotxeController extends Controller
{
    public function index()
    {
        $cotxes = Cotxe::all();
        return view('cotxes.index', compact('cotxes'));
    }

    public function create()
    {
        return view('cotxes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'marca'      => 'required|string|max:100',
            'model'      => 'required|string|max:100',
            'cilindrada' => 'required|integer',
            'potencia'   => 'required|integer',
        ]);

        Cotxe::create($validated);

        return redirect()->route('cotxes.index')
            ->with('success', 'Cotxe creat correctament.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cotxe = Cotxe::findOrFail($id);
        $cotxe->delete();

        return redirect()->route('cotxes.index')
            ->with('success', 'Cotxe eliminat correctament.');
    }
}
