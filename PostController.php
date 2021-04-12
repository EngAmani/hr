<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use Excel;


use App\Exports\xA;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;

class PostController extends Controller


{



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function test(){  //i think no need for this ! 
        dd("dddddd");
    }
        public function users() {
            $posts = post::all();
            $users = User::with('post')->get();
            
    
            return view('posts.create', compact('users', 'posts'));
        }
   
    public function index()
    {
      
      //  dd(Post::where('absent_type','<>',NULL)->GroupBy('user_id')->get());
    
       $posts=Post::with('user')->orderBy('date')->paginate(30);
      
       //late in morning
       //$late_time = Carbon::createFromTime(8,10,00);  //late allowed 
      
      return view('posts.index',compact('posts'));
    }

    

                    // public function search(Request $request){

                    //     $fromDate=$request->get('from');
                    //     $toDate=$request->get('to');
                    //     $name=$request->get('empName');

                    //     $user=User::where('name','like','%'.$name.'%')->first();
                        
                    
                    //       $posts=Post::all()
                    //       ->where('date','>=',$fromDate)
                    //       ->where('date','<=',$toDate)
                    //       ->where('user_id','=',$user->id);
                        
                    
                    // return view('posts.index',compact('posts'));

                    // }

                    // public function abs($id){
                    //      $posts=Post::all();
                    //     foreach ($posts as $post){ 
                        
                    //     }

                    // }
                        
                    

                    // public function lateCal($id){

                    
                    //  $post=Post::find($id);
                    //     $x=int;
                    //     $y=int;
                    //    $posts=Post::all();
                    //          $startTime = Carbon::parse($post->date.' 08:00:00');
                    //          $startTime1 = Carbon::parse($post->date.' 08:10:00');

                    //          $endTime = Carbon::parse($post->date.' '.$post->inTime);
                    //         //  $recorded_time= $endTime->diffInMinutes($startTime);
                            
                    //          if(  $endTime->greaterThan($startTime1)){
                    //          $totalDuration= $endTime->diff($startTime)->format('%H:%I:%S');
                    //           $x=$totalDuration;
                    //              }else if ( $endTime->lessThanOrEqualTo($startTime1)) {
                    //                  $x=0;
                            
                    //             }

                    //       //early in evining
                    //       //$late_time = Carbon::createFromTime(16,00,00);  //late allowed 
                    //       $outTime1 = Carbon::parse($post->date.' 16:00:00');
                    //       $emp_time= Carbon::parse($post->date.' '.$post->time_out);
                    //     //   $recorded_time1=$emp_time->diffInMinutes($outTime1);
                    //     //   $totalDuration2 = $emp_time->diff($outTime1)->format('%H:%I:%S');


                    //      if($emp_time->lessThan($outTime1)){

                    //         $totalDuration2=$emp_time->diff($outTime1)->format('%H:%I:%S');
                    //        $y= $totalDuration2;
                        
                    //         }else $y=0;

                    //           $p=$x+$y;

                    //             return $p;
                    //       // return view('posts.edit',compact('post'));
                    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('posts.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=> 'required',
            'date'=> 'required'
           // 'absType'=> 'required'
        ]);

  
          //  dd($request->get('user_id'));

          $timeIN = $request->get('time_in');
            $timeOUT = $request->get('time_out');

            if($request->get('absent') != null){
                $timeIN = 0;
                $timeOUT = 0;
                $request->validate([

                    'absent_type'=> 'required'
                    ]);
            }
        $post = new Post([
            'user_id' => $request->get('user_id'),
            'time_in' => $timeIN,
            'time_out' => $timeOUT,
            'date' => $request->get('date'),
            'absent' => $request->get('absent'),
            'absent_type' => $request->get('absent_type'),
            'excuse_time' => $request->get('excuse_time'),
            'notes' => $request->get('notes')
        ]);
    // dd($post->absent);
    
        $post->save();

        return redirect('/posts')->with('success', 'تم الإرسال بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post=Post::find($id);
        $user=User::all();
    
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $post=Post::find($id);
        $user= User::all();
        return view('posts.edit',compact('post','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'user_id'=> 'required',
            'date'=> 'required'
           // 'absType'=> 'required'
        ]);

        $post=Post::find($id);

        $post->user_id = $request->get('user_id');
      

        $post->absent = $request->get('absent');
        
        $post->absent_type = $request->get('absent_type');
        $post->date = $request->get('date');

        $post->excuse_time = $request->get('excuse_time');
        $post->notes = $request->get('notes');
         if($post->absent==null){
            $post->time_in= $request->get('time_in');
            $post->time_out = $request->get('time_out');
        }
        else if($post->absent!==null){
            $post->time_in="00:00:00";
            $post->time_out ="00:00:00";
        
        }
       
        
      
    $post->save();

    return redirect('/posts')->with('success', 'تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {    

        $post=Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success','تم الحذف بنجاح');
    }
    public function delete($id)
    {    

        $post=Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success','تم الحذف بنجاح');
    }

    // public function export(){

    //    return Excel::download(new PostExport,'invoices.xlsx');
       
    // }
  
    public function exportEx(Request $request){
        
        $from=$request->from;
        $to=$request->to;
        $empName=$request->empName;
 
 
         return Excel::download(new xA($from,$to,$empName),'excelname.xlsx');       
    }



    // public function exportPdf(Request $request){
    //     $fromDate=$request->get('from');
    //     $toDate=$request->get('to');
    //     $name=$request->get('empName');
    //     dd($name);

    // $posts=Post::with('user')->paginate(31)->orderBy('date')->where('date','>=',$from)
    // ->where('date','<=',$to)
    // ->where('name','like','%'.$empName.'%');

    //    $data = [
    //     'posts' => $posts
    // ];

    // $pdf = PDF::loadView('pdf', $data);
    // $pdf->autoScriptToLang = true;
    // $pdf->autoArabic = true;
    // $pdf->autoLangToFont = true;
    // return $pdf->stream('document.pdf');

      
    // //   // orderBy('date')->paginate(31)

    // //   $pdf=PDF::loadView('x',compact('posts'));

    // //     return $pdf->download('invoice.pdf');    
        
      
    //  }
 

    public function selectedEmp($id){
        
        $post=Post::find($id);
       //$empName= $request->get('user_id');
       return  $post->user_id;
       
    }


    // public function dashboard(){

    //     return view('/dashboard');
    //  }



    public function search(Request $request){
        $method = $request->method();
        

        if ($request->isMethod('post'))
        {
           //call filter inputs values
            $fromDate=$request->get('from');
            $toDate=$request->get('to');
            $name=$request->get('empName');

            // take id user by searching the name 
            $user=User::where('name','like','%'.$name.'%')->first();

            // call all posts from DB with filter spacification 
            $posts=Post::all()->sortBy('date')
            ->where('date','>=',$fromDate)
            ->where('date','<=',$toDate)
            ->where('user_id','=',$user->id);
            $data = [
                'posts' => $posts
            ];
              // if button search hits return posts in view
                if ($request->has('search'))
                {  
                        return view('posts.index',compact('posts'));
                }//first if

              // if export button hits return pdf file 
            elseif ($request->has('exportPDF')){       
  
                   
                    $pdf = PDF::loadView('pdf', $data);
                    $pdf->autoScriptToLang = true;
                    $pdf->autoArabic = true;
                    $pdf->autoLangToFont = true;
                    return $pdf->stream('حضور موظف.pdf');
                }

                elseif($request->has('Excel')){
                    return Excel::download(new xA($fromDate,$toDate,$name),'excelname.xlsx');       

                }

                     

               

            
                   
        }//end big if
            
    }//end function

   

   


}// end controll class
