<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\User;

class UserController extends Controller
{
    //
    public function approveUser(Request $request){
        $user = User::where('id',$request->input('id'))->first();
//        dd($user);
//        $permissionsToBeGranted = $request->input('permissions');
//        forEach ($permissionsToBeGranted as $key => $value){
            try{
//                dd($request->input('permissions'));
                $user->givePermissionTo($request->input('permissions'));
            } catch (\Exception $e){
                throw $e;
            }
//        }
        return response()->json(['message'=>'Permissoins granted successfully.']);
    }
    
    public function getAssistantList(Request $request){
        try{
            $assistants = User::role('store_assistant')->get()->toArray();
            return response()->json([
                'assistants'=>$assistants
            ]);
        } catch (\Exception $e){
            throw new HttpException(500);
        }
    }
}
