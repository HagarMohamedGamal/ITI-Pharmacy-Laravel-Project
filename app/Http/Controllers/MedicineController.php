<?php

namespace App\Http\Controllers;

use App\Medicine;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMedicineRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MedicineController extends Controller
{
    public function index()
    {

       return view('medicines.index');


    }

    public function auto(Request $request)
    {
        $query =$request->input('query');
        $data = DB::table('medicines')->where('name','LIKE',"%{$query}%")->get();
        if($data->isNotEmpty())
        {
            return response()->json( $data);
        }
        return response()->json(['error' => 'Error msg'], 404);


    }

    public function getMedicines(Request $request)
    {
        $data =Medicine::all();
        Log::info($data);
        return \DataTables::of($data)
            ->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success" onclick="editMedicine('.$data->id.')" data-id="'.$data->id.'">Edit</button>
                    <button type="button" data-id="'.$data->id.'" data-toggle="modal" onclick="deleteMedicine('.$data->id.')" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
    }



    public function show(Request $request)
    {
        $medicine = Medicine::find($request->medicine);
        return view('medicines.show', [
            'medicine' => $medicine
        ]);
    }


//    public function create()
//    {
//        $medicines = Medicine::all();
//        return view('medicines.create', [
//            'medicines' => $medicines
//        ]);
//    }


    public function store(StoreMedicineRequest $request)
    {
        $medicine = $request->only(['name', 'quantity', 'type', 'price']);

        Medicine::create([
            'name' => $medicine['name'],
            'quantity' => $medicine['quantity'],
            'price' => $medicine['price'],
            'type' => $medicine['type'],

        ]);
        return response()->json(['success' => 'success']);
    }

    public function edit($id)
    {
        $data = Medicine::find($id);

        $html = '<div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="editName" value="'.$data->name.'">
                </div>
                <div class="form-group">
                    <label for="Name">Price:</label>
                    <input type="text" class="form-control" name="price" id="editPrice" value="'.$data->price.'">
                </div>
                <div class="form-group">
                    <label for="Name">Type:</label>
                    <input class="form-control" name="type" id="editType" value="'.$data->type.'">
                </div>
                <div class="form-group">
                    <label for="Name">Quantity:</label>
                    <input class="form-control" name="quantity" id="editQuantity" value="'.$data->quantity.'">
                </div>';

        return response()->json(['html'=>$html]);
    }


    public function update(StoreMedicineRequest $request)
    {
        $medicinecreater = Medicine::find($request->medicine);
        $medicine = $request->only(['name', 'type', 'price', 'quantity']);

        $medicinecreater->update([
            'name' => $medicine['name'],
            'type' => $medicine['type'],
            'price' => $medicine['price'],
            'quantity' => $medicine['quantity'],

        ]);
        return response()->json(['success' => 'success']);
    }

    public function destroy($id)
    {
        Medicine::where('id',$id)->delete();

        return response()->json(['success' => 'success']);
    }
}
