<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Mail;

class HomeController extends Controller
{

    public function about()
    {
        return view("about");
    }

    public function index() {
        $items  = Item::where("online", "=", 1)->get();
        return view('welcome', compact('items'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return view("item", compact('item'));
    }

    public function bid(Request $request, $id){
        $item = Item::find($id);
        if($item->highest_price < $request->get('bid_val')){
            $item->highest_price = $request->get('bid_val');
        }
        $item->bids++;
        if ($item->save()) {
            
            $data = [
                'price' => $request->get('bid_val'),
                'item'  => $item
            ];

            Mail::send('email.index', $data, function ($message) use ($item) {
                $message->from('awadelbana@gmail.com', 'MAZAD - New Bid On ' . $item->name);
                $message->sender('awadelbana@gmail.com', 'MAZAD - New Bid On ' . $item->name);
                $message->to($item->user->email, $item->user->name);
                $message->subject('MAZAD - New Bid On ' . $item->name);
                $message->priority(3);
            });
        }
    }
}