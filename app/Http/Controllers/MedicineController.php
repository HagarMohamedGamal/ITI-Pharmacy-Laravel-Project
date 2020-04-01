<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicineRequest;
class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::all();

        return view('medicines.index', [
            'medicines' => $medicines,
        ]);
    }


    public function show(Request $request)
    {
        $medicine = Medicine::find($request->medicine);
        return view('medicines.show', [
            'medicine' => $medicine
        ]);
    }


    public function create()
    {
        $medicines = Medicine::all();
        return view('medicines.create', [
            'medicines' => $medicines
        ]);
    }


    public function store(StoreMedicineRequest $request)
    {
        $medicine = $request->only(['name', 'quantity', 'type', 'price']);

        Medicine::create([
            'name' => $medicine['name'],
            'quantity' => $medicine['quantity'],
            'price' => $medicine['price'],
            'type' => $medicine['type'],

        ]);
        return redirect()->route('medicines.index');
    }

    public function edit(Request $request)
    {
        $medicines = Medicine::all();
        $medicine = Medicine::find($request-> medicine);
        return view('medicines.edit', [
            'medicine' => $medicine,
            'medicines' => $medicines
        ]);
    }


    public function update(Request $request)
    {
        $medicinecreater = Medicine::find($request->medicine);
        $medicine = $request->only(['name', 'type', 'price', 'quantity']);

        $medicinecreater->update([
            'name' => $medicine['name'],
            'type' => $medicine['type'],
            'price' => $medicine['price'],
            'quantity' => $medicine['quantity'],

        ]);
        return redirect()->route('medicines.index');
    }

    public function destroy($id)
    {
        Medicine::where('id',$id)->delete();

        return redirect()->route('medicines.index');
    }
}
