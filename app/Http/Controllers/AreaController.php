<?php

namespace App\Http\Controllers;

use App\Area;
use App\Http\Requests\AreaRequest;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return view('areas.index');
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
