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
        return $areas;
    }

    public function show()
    {
        $request = request();
        $area = Area::find($request->id);
        return $area;
    }

    public function edit()
    {
        $request = request();
        $area = Area::find($request->id);
        return $area;
    }

    public function update()
    {
        $request = request();
        $area = Area::find($request->id);
        $area::update([
            'name' => $request['name'],
            'address' => $request['address'],
        ]);
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

        return "tmam";
    }

    public function destroy()
    {
        $request = request();
        $areaid = $request->area;
        Area::destroy($areaid);
    }
}
