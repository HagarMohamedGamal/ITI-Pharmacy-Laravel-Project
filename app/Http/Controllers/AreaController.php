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
        ->addColumn('action', function(Area $area) {

            $button = '<a name="show" id="'.$area->id.'" class="show btn btn-success btn-sm" href="/areas/'.$area->id.'">Show</a>';
            $button .= '<a name="edit" id="'.$area->id.'" class="edit btn btn-primary btn-sm" href="/areas/'.$area->id.'/edit">Edit</a>';
            // $button .= '&nbsp;&nbsp;';
            $button .= '<button type="button" name="delete" id="'.$area->id.'" class="delete btn btn-danger btn-sm">Delete</button>';
            return $button;
            
        })
        ->toJson();
    }

    public function show()
    {
        $request = request();
        $area = Area::find($request->area);
        return view('areas.show', [
            'areas' => $area
        ]);
    }

    public function edit()
    {
        $request = request();
        $area = Area::find($request->area);
        return view('areas.edit', [
            'areas' => $area
        ]);
    }

    public function update()
    {
        $request = request();
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

    public function destroy()
    {
        $request = request();
        $areaid = $request->area;
        Area::destroy($areaid);
    }
}
