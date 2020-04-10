<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Requests\AreaRequest;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        if(request()->ajax()){
            return $this->indexDataTable();
        }
        $areas = Area::all();
        return view('areas.index');
    }

    function indexDataTable()
    {
        $areas = Area::query();
        return DataTables()::of($areas)
        ->addColumn('action', function(Area $area){
            $button = '<a name="show" id="'.$area->id.'" style="border-radius: 20px;" class="show btn btn-success btn-sm p-0" href="/areas/'.$area->id.'"><i class="fas fa-eye m-2"></i></a>';
            $button .= '<a name="edit" id="'.$area->id.'" style="border-radius: 20px;" class="edit btn btn-primary btn-sm p-0" href="/areas/'.$area->id.'/edit"><i class="fas fa-edit m-2"></i></a>';
            // $button .= '&nbsp;&nbsp;';
            $button .= '<button type="button" name="delete" id="'.$area->id.'" style="border-radius: 20px;" class="delete btn btn-danger btn-sm p-0"><i class="fas fa-trash m-2"></i></button>';
            return $button;
            
        })
        ->toJson();
    }

    public function show(Area $area)
    {
        
        return view('areas.show', [
            'areas' => $area
        ]);
    }

    public function edit(Area $area)
    {
        return view('areas.edit', [
            'areas' => $area
        ]);
    }

    public function update(AreaRequest $request)
    {
        $area = Area::find($request->area);
        $area->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);
        return redirect()->route('areas.index');
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(AreaRequest $request)
    {

        $request = $request->only(['name', 'address']);

        Area::create([
            'name' => $request['name'],
            'address' => $request['address'],
        ]);
        return redirect()->route('areas.index');
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return response()->json('deleted');
    }
}
