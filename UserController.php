<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{   
    public function add_emp_form(){

           return view('adduser.adduser');
          //  return view('adduser.adduser');
    }

    // public function test(){
    //     dd('test');
    // }
    public function store(Request $request){
       

         $request->validate([
            'name'=> 'required',
            'email'=> 'required',
           'password'=> 'required'
        ]); 

    

        
      
          //  dd($request->get('user_id'));
        //   $name = $request->get('name');
        //     $addemail = $request->get('email');
        //     $password = $request->get('password');
        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
          
        ]);

        
        $user->save();
                return redirect('/posts')->with('success', 'تم إضافة الموظف بنجاح');


    }
}
