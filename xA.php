<?php

namespace App\Exports;

use App\Models\post;
use App\Models\user;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class xA implements FromCollection,WithHeadings
{

    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */

    protected $from;
    protected $to;
    protected $empName;

    function __construct(string $from=null,string $to=null ,string $empName=null) {
   
        $this->from = $from;
            $this->to = $to;
            $this->empName=$empName;
  }

//   public function map($posts): array
//   {

//     return [
//         $posts->date,
//         $posts->user->name,
//         Date::dateTimeToExcel($posts->created_at),
//     ];
//   }
    public function collection()
    {



        $user=User::where('name','like','%'.$this->empName.'%')->first();
    
        $posts=Post::get(['user_id','date','time_in','time_out','excuse_time','absent','absent_type','notes'])->where('date','>=',$this->from)
        ->where('user_id','=',$user->id)
        ->where('date','<=',$this->to);
     
     //   dd($posts);
        //  ->where('date','>=',$this->from)
        //  ->where('date','<=',$this->to)
        //  ->where('user_id','=',$user->id);
        
      //  $us = $posts->first();

        //  dd($posts->first());
        foreach($posts as $post){
            $post->user_id = $user->name;
        }
        return $posts;
                
        
        
        // where('date','>=',$this->from)
        // ->where('date','<=',$this->to)
        // ->where('user_id','=',$user->id)
        // ->select('date','time_in','Time_out')
        // ->orderBy('date')->get();
       
    }
            /**
                    * @return \Illuminate\Support\Collection
                    */
       
  
    
    
                    public function headings(): array
                    {
                        return [
                            
                            'اسم الموظف',
                            'تاريخ الحضور',
                            'وقت الحضور',
                            'وقت الإنصراف',
                            'دقائق الإستئذان',
                            'الغياب',
                            'نوع الغياب',
                            'ملاحظات'
                        ];
                    }
}
