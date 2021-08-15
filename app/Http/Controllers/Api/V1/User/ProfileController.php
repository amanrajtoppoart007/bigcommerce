<?php


namespace App\Http\Controllers\Api\V1\User;

use App\Models\Area;
use App\Models\Block;
use App\Models\District;
use App\Models\Order;
use App\Models\Pincode;
use App\Models\State;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ProfileController extends \App\Http\Controllers\Api\BaseController
{
    public function getProfileDetails()
    {
        try {
            $data = auth()->user();
            if (!empty($data)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Profile data fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Profile not found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|unique:users,mobile,' . auth()->user()->id,
            'email' => 'unique:users,email,' . auth()->user()->id,
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        try {

            $user = auth()->user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            if ($user->save()) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'updated', 'message' => 'Profile updated successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);

    }

    public function getStates(Request $request)
    {
        try {
            $query = State::query();
            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            $states = $query->select('id', 'name')->whereStatus(true)->get()->toArray();
            if ($states) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $states, 'message' => 'States fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No state found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getDistricts(Request $request)
    {
        try {
            $query = District::query();
            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            if ($request->input('state_id')) {
                $query->where('state_id', $request->input('state_id'));
            }

            $districts = $query->select('id', 'name')->whereStatus(true)->get()->toArray();
            if ($districts) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $districts, 'message' => 'Districts fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No District found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getBlocks(Request $request)
    {
        try {
            $query = Block::query();
            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            if ($request->input('district_id')) {
                $query->where('district_id', $request->input('district_id'));
            }

            $blocks = $query->select('id', 'name')->whereStatus(true)->get()->toArray();
            if ($blocks) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $blocks, 'message' => 'Blocks fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No Block found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getPincodes(Request $request)
    {
        try {
            $query = Pincode::query();
            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('pincode', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            if ($request->input('block_id')) {
                $query->where('block_id', $request->input('block_id'));
            }

            $pincodes = $query->select('id', 'pincode')->whereStatus(true)->get()->toArray();
            if ($pincodes) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $pincodes, 'message' => 'Pincodes fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No Pincode found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getAreas(Request $request)
    {
        try {
            $query = Area::query();
            if ($request->input('keyword')) {
                $query->where(function ($q) use ($request) {
                    $q->where('area', 'LIKE', "%" . $request->input('keyword') . "%");
                });
            }

            if ($request->input('pincode_id')) {
                $query->where('pincode_id', $request->input('pincode_id'));
            }

            $areas = $query->select('id', 'area')->whereStatus(true)->get()->toArray();

            if ($areas) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $areas, 'message' => 'Areas fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No Area found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getAddressTypes()
    {
        try {
            $addressTypes = [];
            foreach (UserAddress::ADDRESS_TYPE_RADIO as $key => $value) {
                $addressTypes[] = [
                    'name' => $value,
                    'value' => $key
                ];
            }

            if ($addressTypes) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $addressTypes, 'message' => 'Address Types fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No address type found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function addAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'nullable',
            'address_type' => 'nullable',
            'landmark' => 'required',
            'address_line_two' => 'nullable',
            'state_id' => 'required',
            'district_id' => 'required',
            'city_id' => 'nullable',
            'block_id' => 'required',
            'pincode' => 'required',
            'area_id' => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        try {
            $address = new UserAddress();
            $address->user_id = auth()->user()->id;
            $address->name = $request->input('name');
            $address->address = $request->input('address');
            $address->address_type = $request->input('address_type') ?? 'billing';
            $address->street = $request->input('landmark');
            $address->address_line_two = $request->input('address_line_two');
            $address->state_id = $request->input('state_id');
            $address->district_id = $request->input('district_id');
            $address->block_id = $request->input('block_id');
            $address->pincode_id = $request->input('pincode');
            $address->area_id = $request->input('area_id');

            if ($address->save()) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'added', 'message' => 'Address added successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_addresses',
            'name' => 'required',
            'address' => 'nullable',
            'address_type' => 'nullable',
            'landmark' => 'required',
            'address_line_two' => 'nullable',
            'state_id' => 'required',
            'district_id' => 'required',
            'city_id' => 'nullable',
            'block_id' => 'required',
            'pincode' => 'required',
            'area_id' => 'required',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }
        if (!UserAddress::whereId($request->input('id'))->whereUserId(auth()->user()->id)->exists()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'rejected', 'message' => "This address does not belong to you."];
            return response()->json($result, 200);
        }
        $result = [];

        try {
            $address = UserAddress::find($request->input('id'));
            if ($address) {
                $address->name = $request->input('name');
                $address->address = $request->input('address');
                $address->address_type = $request->input('address_type');
                $address->street = $request->input('landmark');
                $address->address_line_two = $request->input('address_line_two');
                $address->state_id = $request->input('state_id');
                $address->district_id = $request->input('district_id');
                $address->block_id = $request->input('block_id');
                $address->pincode_id = $request->input('pincode');
                $address->area_id = $request->input('area_id');

                if ($address->save()) {
                    $result = ['status' => 1, 'response' => 'success', 'action' => 'updated', 'message' => 'Address updated successfully'];
                } else {
                    $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                }
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function getAddresses()
    {
        try {
            $data = [];
            $addresses = UserAddress::where('user_id', auth()->user()->id)->get();

            foreach ($addresses as $address) {
                $data[] = [
                    'id' => $address->id,
                    'name' => $address->name,
                    'address' => $address->address,
                    'landmark' => $address->street,
                    'state_id' => $address->state_id,
                    'state' => $address->state->name ?? null,
                    'district_id' => $address->district_id,
                    'district' => $address->district->name ?? null,
                    'block_id' => $address->block_id,
                    'block' => $address->block->name ?? null,
                    'pincode_id' => $address->pincode_id,
                    'pincode' => $address->pincode->pincode ?? null,
                    'area_id' => $address->area_id,
                    'area' => $address->area->area ?? null,
                    'is_default' => (bool)$address->is_default,
                    'checked' => false,
                ];
            }

            if ($data) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Addresses fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No address found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function makeDefaultAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_addresses',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        if (!UserAddress::whereId($request->input('id'))->whereUserId(auth()->user()->id)->exists()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'rejected', 'message' => "This address does not belong to you."];
            return response()->json($result, 200);
        }

        $result = [];
        DB::beginTransaction();
        try {
            $address = UserAddress::find($request->input('id'));
            if ($address) {
                UserAddress::whereUserId(auth()->user()->id)->update(['is_default' => false]);
                $address->is_default = true;
                if ($address->save()) {
                    DB::commit();
                    $result = ['status' => 1, 'response' => 'success', 'action' => 'updated', 'message' => 'Address marked as default successfully'];
                } else {
                    DB::rollBack();
                    $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }

    public function removeAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_addresses',
        ]);

        if ($validator->fails()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => $validator->errors()];
            return response()->json($result, 200);
        }

        if (!UserAddress::whereId($request->input('id'))->whereUserId(auth()->user()->id)->exists()) {
            $result = ['status' => 0, 'response' => 'error', 'action' => 'rejected', 'message' => "This address does not belong to you."];
            return response()->json($result, 200);
        }

        try {
            $exceptOrderStatuses = [
                'PENDING' => 'PENDING',
                'APPROVED' => 'APPROVED',
                'CONFIRMED' => 'CONFIRMED',
                'DISPATCHED' => 'DISPATCHED',
            ];
            if (Order::whereAddressId($request->input('id'))->whereIn('status', $exceptOrderStatuses)->exists()) {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'This address has active order.'];
            } else {
                if (UserAddress::destroy($request->input('id'))) {
                    $result = ['status' => 1, 'response' => 'success', 'action' => 'updated', 'message' => 'Address deleted successfully'];
                } else {
                    $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'Something went wrong'];
                }
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }
}
