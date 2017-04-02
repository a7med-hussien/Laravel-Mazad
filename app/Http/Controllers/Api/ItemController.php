<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Item;
use App\User;
use Auth;

class ItemController extends Controller
{
	public function index()
	{
		$items = Item::all();

		return response()->json($items, 200);
	}

	public function show($id)
	{
		$item = Item::find($id);
		$item->user;

		return response()->json($item, 200);
	}

	public function bid(Request $request, $id)
	{
		$item = Item::find($id);

		if($item->highest_price < $request->bid_val){
            $item->highest_price = $request->bid_val;
        }

        $item->bids++;

        if($item->save()) {
        	return response()->json(['success' => true, 'message' => 'You bid on item Successfully!'], 200);
        }
        return response()->json(['success' => false, 'message' => 'oOoOpps!'], 400);
	}
}