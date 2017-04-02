<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Item;
use App\User;
use Auth;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items  = Item::where("user_id", '=', Auth::id())->get();
        $drafts = Item::onlyTrashed()->where("user_id", '=', Auth::id())->get();
        $user   = User::find(Auth::id());

        return view('items', compact('items','drafts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required',
            'price'   => 'required|integer',
            'details' => 'required|min:20',
            'online'  => 'boolean',
            'image'   => 'required'
        ]);

        $item          = new Item;
        $item->name    = $request->name;
        $item->price   = $request->price;
        $item->details = $request->details;
        $item->online  = $request->online;
        $item->image   = $request->file('image')->store('images/items');
        $item->user_id = Auth::id();
        $item->save();

        return response()->json(['success' => true], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return response()->json($item, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $item          = Item::find($id);
        $item->name    = $request->name;
        $item->price   = $request->price;
        $item->online  = $request->online;
        $item->details = $request->details;

        if ($request->file("image")) {
            $item->image = $request->file("image")->store('images/items');
        }

        $item->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, $id)
    {
        $item = Item::find($id);
        $item->delete();
    }

    public function restoreItem($id)
    {
        $item = Item::withTrashed()->where('id', '=', $id)->first();
        $item->restore();

    }

    public function deleteItem($id)
    {
        $item = Item::withTrashed()->where('id', '=', $id)->first();
        $item->forceDelete();
    }

    public function editProfile(Request $request)
    {
        $user           = User::find(Auth::id());
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->gender   = $request->gender;
        $user->location = $request->location;
        if ($request->file("avatar")) {
            $user->avatar   = $request->file("avatar")->store("images/profile");
        }
        $user->save();
    }
}