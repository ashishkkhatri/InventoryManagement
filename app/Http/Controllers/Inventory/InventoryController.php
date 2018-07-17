<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\Http\Requests\AddInventoryRequest;
use App\Http\Requests\EditInventoryRequest;
use App\Http\Requests\DeleteInventoryRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InventoryController extends Controller
{
    //
    public function getInventory(Request $request){
        $invenrtory = Inventory::select('id','name','vendor','price','batch_number','batch_date','stock_in_hand','status')->get()->toArray();
        return response()->json(['inventory'=>$invenrtory]);
    }
    
    public function addInventory(AddInventoryRequest $request){
        try{
            $inventory = Inventory::create([
                'name'=>$request->input('name'),
                'vendor'=>$request->input('vendor'),
                'price'=>$request->input('price'),
                'batch_number'=>$request->input('batch_number'),
                'batch_date'=>$request->input('batch_date'),
                'stock_in_hand'=>$request->input('stock_in_hand')
            ]);
            return response()->json([
                'message' => 'Added inventory successfully.',
                'inventory' => $inventory
            ],200);
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function editInventory(EditInventoryRequest $request){
        try{
            $updatedInventory = Inventory::where('id','=',$request->input('id'))
                    ->update([
                        'name'=>$request->input('name'),
                        'vendor'=>$request->input('vendor'),
                        'price'=>$request->input('price'),
                        'batch_number'=>$request->input('batch_number'),
                        'batch_date'=>$request->input('batch_date'),
                        'stock_in_hand'=>$request->input('stock_in_hand')
                    ]);
            $inventory = Inventory::select('id','name','vendor','price','batch_number','batch_date','stock_in_hand','status')
                    ->where('id',$request->input('id'))->get()->first();
            return response()->json([
                'message'=>'Inventory updated successfully.',
                'inventory'=> $inventory
            ],200);
        } catch (\Exception $e){
            throw new HttpException(500);
        }
    }
    
    public function deleteInventory(DeleteInventoryRequest $request){
        try{
            $inventoryDeleted = Inventory::where('id',$request->input('id'))->delete();
            
            return response()->json(['message'=>'Inventory deleted successfully.'],200);
        } catch (\Exception $e){
            throw new HttpException(500);
        }
    }
    
    public function approveInventory(Request $request){
        try{
            $updatedInventory = Inventory::where('id',$request->input('id'))->update([
                'status' => 1
            ]);

            return response()->json(['message'=>'Inventory approved successfully.'],200);
        } catch (\Exception $e){
            throw new HttpException(500);
        }
    }
}
