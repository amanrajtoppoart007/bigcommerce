<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnitType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class UnitTypeController extends Controller
{
    public function index()
    {
        $unitTypes = UnitType::all();

        return view('admin.unitTypes.index', compact('unitTypes'));
    }

    public function getUnitType(Request $request)
    {
        $unitType = UnitType::find($request->id);
        if ($unitType) {
            $result = array('status' => true, 'msg' => 'Unit type found.', 'data' => $unitType);
        } else {
            $result = array('status' => false, 'msg' => 'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function addUnitType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return array('status' => false, 'msg' => 'Please enter name!!');
        }

        $unitType = new UnitType();
        $unitType->name = $request->name;
        if($unitType->save()){
            $result = array('status'=> true, 'msg'=>'Unit Type added successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function updateUnitType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return array('status' => false, 'msg' => 'Please enter name!!');
        }

        $unitType = UnitType::find($request->id);
        $unitType->name = $request->name;
        if($unitType->save()){
            $result = array('status'=> true, 'msg'=>'Unit Type updated successfully.');
        }else {
            $result = array('status'=>false, 'msg'=>'Something went wrong!!');
        }
        return json_encode($result);
    }

    public function destroy(UnitType $unitType)
    {
        $unitType->delete();
        return back();
    }

    public function massDestroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:unit_types,id',
        ]);

        if ($validator->fails()) {
            return array('status' => false, 'msg' => 'Please select!!');
        }

        UnitType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
