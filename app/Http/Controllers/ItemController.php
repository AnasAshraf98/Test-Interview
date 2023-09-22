<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function __construct()
     {
         $this->middleware('auth:api');
     }

    public function checkdate(){
        $expirationDate = Carbon::now()->format('Y-m-d');
        Item::where([['due_date','<',$expirationDate],['completed',false]])->update(['completed' => true]);
        return "succeeded";
    }
    public function getItemsremained(){
        return Item::where('completed',false)->count();
    } 

    public function getItemsCompleted(){
        return Item::where('completed',true)->count();
    }
    public function index()
    {
        return Item::orderBy('created_at','DESC')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newItem = new Item;
        
        $newItem->title = $request->item['title'];
        $newItem->note = $request->item['note'];
        $newItem->due_date = $request->item['date'];

        $newItem->save();

        return $newItem;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function updateTask(Request $request,string $id)
    {
        $existingItem = Item::find($id);

        if($existingItem){
            $existingItem->title = $request->item['title'];
            $existingItem->note = $request->item['note'];
            $existingItem->due_date = $request->item['date'];
            $existingItem->save();
            return $existingItem;
        }

        return "Item not found";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $existingItem = Item::find($id);

        if($existingItem){
            $existingItem->completed = $request->item['completed'] ? false : true;
            $existingItem->completed_at = $request->item['completed'] ? Carbon::now() : null;
            $existingItem->save();
            return $existingItem;
        }

        return "Item not found";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $existingItem = Item::find($id);

        if($existingItem){
            $existingItem->delete();
            return "Item successfully deleted.";
        }

        return "Item not found";
    }
}
