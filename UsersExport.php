<?php
    
    namespace App\Exports;
    
    use Illuminate\Support\Facades\DB;
    
    use Maatwebsite\Excel\Concerns\FromQuery;
    
    use Maatwebsite\Excel\Concerns\Exportable;
    
    use Maatwebsite\Excel\Concerns\WithHeadings;
    
    class PostsExport implements FromQuery, WithHeadings
    {
        /**
        * @return \Illuminate\Support\Collection
        */
       
        use Exportable;
    
        protected $from;
        protected $to;
        protected $empName;
    
        function __construct($from,$to,$empName) {
                $this->from = $from;
                $this->to = $to;
                $this->empName=$empName;
        }
    
        public function query()
        {
            $user=User::where('name','like','%'.$this->empName.'%')->first();

            $data =Post::all()
            ->whereBetween('date',[ $this->from,$this->to])
            ->where('user_id','=',$user->id)
            ->select('date','time_in','Time_out')
            ->orderBy('date');
                
    
            return $data;
        }


    
        public function headings(): array
        {
            return [
                'date',
                'Time in',
                'Time out',
            ];
        }
    }