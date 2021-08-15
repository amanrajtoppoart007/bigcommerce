<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserAddressRequest;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use App\Models\Area;
use App\Models\Block;
use App\Models\District;
use App\Models\Pincode;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAddressController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('user_address_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAddresses = UserAddress::with(['user', 'pincode', 'district', 'block', 'state', 'area'])->get();

        $users = User::get();

        $pincodes = Pincode::get();

        $districts = District::get();

        $blocks = Block::get();

        $states = State::get();

        $areas = Area::get();

        return view('frontend.userAddresses.index', compact('userAddresses', 'users', 'pincodes', 'districts', 'blocks', 'states', 'areas'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_address_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.userAddresses.create', compact('users', 'pincodes', 'districts', 'blocks', 'states', 'areas'));
    }

    public function store(StoreUserAddressRequest $request)
    {
        $userAddress = UserAddress::create($request->all());

        return redirect()->route('frontend.user-addresses.index');
    }

    public function edit(UserAddress $userAddress)
    {
        abort_if(Gate::denies('user_address_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pincodes = Pincode::all()->pluck('pincode', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $blocks = Block::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $states = State::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $areas = Area::all()->pluck('area', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userAddress->load('user', 'pincode', 'district', 'block', 'state', 'area');

        return view('frontend.userAddresses.edit', compact('users', 'pincodes', 'districts', 'blocks', 'states', 'areas', 'userAddress'));
    }

    public function update(UpdateUserAddressRequest $request, UserAddress $userAddress)
    {
        $userAddress->update($request->all());

        return redirect()->route('frontend.user-addresses.index');
    }

    public function show(UserAddress $userAddress)
    {
        abort_if(Gate::denies('user_address_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAddress->load('user', 'pincode', 'district', 'block', 'state', 'area', 'addressOrders');

        return view('frontend.userAddresses.show', compact('userAddress'));
    }

    public function destroy(UserAddress $userAddress)
    {
        abort_if(Gate::denies('user_address_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userAddress->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserAddressRequest $request)
    {
        UserAddress::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
