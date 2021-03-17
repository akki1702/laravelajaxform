<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use validator;


class UserController extends Controller
{

	public function index(Request $request)
    {
   
        $leads = User::latest()->get();
        
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editLead">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLead">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('leads',compact('leads'));
    }
     
    public function store(Request $request)
    {

       
        if($request->hasfile('profile_pic'))
        {

            $file = $request->file('profile_pic');
            $extension = $file->getClientOriginalExtension();
            
            $filename = rand() . '.' . $file->getClientOriginalExtension();

            $file->move('uploads/leads/',$filename);
            $request->profile_pic = $filename;
        
        // dd($filename);
            }

        User::updateOrCreate(['id' => $request->user_id],
                [
                    'first_name' => $request->first_name, 
                    'last_name' => $request->last_name,
                    // 'profile_pic'=>$filename,
                    'mobile' => $request->mobile, 
                    'email' => $request->email, 
                    'status' => $request->status, 
                    'source' => $request->source, 
                ]);        
        



        return response()->json(['success'=>'User data added successfully.']);
    }
  
    public function edit($id)
    {
        $User = User::find($id);
        return response()->json($User);
    }
  
    public function destroy($id)
    {
        User::find($id)->delete();
     
        return response()->json(['success'=>'User deleted successfully.']);
    }
}
