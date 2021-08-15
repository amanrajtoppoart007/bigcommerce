<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Block;
use App\Models\District;
use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    /* get state wise district list */
    public function getDistricts(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "state_id"=>"required|numeric"
        ]);
        if(!$validator->fails())
        {
            $districts = District::where(['state_id'=>$request->input('state_id')])->get();
            if(!$districts->isEmpty())
            {
                $result = ["status"=>1,"response"=>"success","data"=>$districts,"message"=>"Data fetched"];
            }
            else
            {
                $result = ["status"=>0,"response"=>"error","message"=>"No data found"];
            }

        }
        else
        {
            $result = ["status"=>0,"response"=>"error","message"=>$validator->errors()->all()];
        }
        return response()->json($result);
    }

      public function getBlockList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "district_id"=>"required|numeric"
        ]);
        if(!$validator->fails())
        {
            $blocks = Block::where(['district_id'=>$request->input('district_id')])->get();
            if(!$blocks->isEmpty())
            {
                $result = ["status"=>1,"response"=>"success","data"=>$blocks,"message"=>"Data fetched"];
            }
            else
            {
                $result = ["status"=>0,"response"=>"error","message"=>"No data found"];
            }

        }
        else
        {
            $result = ["status"=>0,"response"=>"error","message"=>$validator->errors()->all()];
        }
        return response()->json($result);
    }

    public function getPincodeList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "block_id"=>"required|numeric"
        ]);
        if(!$validator->fails())
        {
            $pincodes = Pincode::where(['block_id'=>$request->input('block_id')])->get();
            if(!$pincodes->isEmpty())
            {
                $result = ["status"=>1,"response"=>"success","data"=>$pincodes,"message"=>"Data fetched"];
            }
            else
            {
                $result = ["status"=>0,"response"=>"error","message"=>"No data found"];
            }

        }
        else
        {
            $result = ["status"=>0,"response"=>"error","message"=>$validator->errors()->all()];
        }
        return response()->json($result);
    }

    public function getAreaList(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "pincode_id"=>"required|numeric"
        ]);
        if(!$validator->fails())
        {
            $areas = Area::where(['pincode_id'=>$request->input('pincode_id')])->get();
            if(!$areas->isEmpty())
            {
                $result = ["status"=>1,"response"=>"success","data"=>$areas,"message"=>"Data fetched"];
            }
            else
            {
                $result = ["status"=>0,"response"=>"error","message"=>"No data found"];
            }

        }
        else
        {
            $result = ["status"=>0,"response"=>"error","message"=>$validator->errors()->all()];
        }
        return response()->json($result);
    }

    public function getPincodesAndAreasByBlock(Request $request)
    {
        $pincodes = Pincode::whereBlockId($request->blockId)->whereStatus(1)->get();
        $data = [];
        foreach ($pincodes as $pincode)
        {
            $data[] = [
                'id' => $pincode->id,
                'pincode' => $pincode->pincode,
                'areas' => Area::wherePincodeId($pincode->id)->whereStatus(true)->get(),
            ];
        }

        $result = array('status' => true, 'msg' => 'Pincode data.', 'data' => $data);
        return json_encode($result);
    }
}
