@extends('layouts.app')

@section('title', 'حضور الموظفين')

@section('content')

<a href="{{ route('posts.create') }}" class="btn btn-light mt-3" style="background-color:#4F2683; color:white; float:right;">إضافة حضور موظف</a>

<form action="{{route('search')}}" method ="POST" class="form-search" style="margin-top:0px; ">
@csrf
<br>
          <div class="search-input">
            <label for="date" class="col-form-label col-sm-12"> التاريخ من: </label>
            
            <input type="date" style="width:159px;" class="form-control input-sm" id="from" name="from"  min="2021-01-01"  value="{{now()->startOfMonth()->format('Y-m-d')}}" required/>
        
          </div>
            
          <div class="search-input">
            <label for="date" class="col-form-label col-sm-12"> التاريخ الى:</label>
      
              <input type="date" style="width:159px;" class="form-control input-sm" id="from" name="to"  min="2021-01-01"  value="{{now()->lastOfMonth()->format('Y-m-d')}}" required/>
</div>

<div class="search-input">
            <label for="date" class="col-form-label col-sm-12">الموظف</label>

              <input type="text" style="width:159px;" class="form-control input-sm" id="empName" name="empName" required/>
            </div>
          
            <div class="search-input">
            <button type="submit" class="btn" name="search" ><img src="https://img.icons8.com/android/24/000000/search.png"/></button>
            <button type="submit" class="btn btn-light mt-12"  style="background-color:#4F2683; color:white;" name = "exportPDF">PDF</button>
            <button type="submit" class="btn btn-light mt-12"  style="background-color:#4F2683; color:white;" name = "Excel">Excel</button>

            
              </div>

</form>

@if(session()->get('success'))
    <div class="alert alert-success mt-12">
      {{ session()->get('success') }}  
    </div>
@endif
<table id="x" class="table table-striped mt-3">
  <thead>
    <tr>
    <th scope="col"></th>
      <th scope="col">اسم الموظف</th>
      <th scope="col">التاريخ</th>
      <th scope="col">وقت الحضور</th>
      <th scope="col">وقت الإنصراف</th>
      <th scope="col">عدد دقائق الإستئذان</th>
      <th scope="col">وقت إضافي</th>
      <th scope="col">التأخير</th>
      <th scope="col">غياب</th>
      <th scope="col">نوع الغياب</th>
      <th scope="col">ملاحظات</th>
      <th ></th>
    </tr>
  </thead>
  <tbody>
   @foreach($posts as $post)
    <tr>

    <!-- <th scope="row">{{ $post->id}}</th> -->
    <th scope="row" class="table-buttons">
        <a href="{{ route('posts.show', $post) }}" class="btn btn-light" style="background-color:#009F93; color:white;">
        <i class="fa fa-eye"></i>
      </a>
        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary" stule="background-color:7399C6; color:white;">
          <i class="fa fa-pencil"></i>
        </a>

         
        <a href="{{ route('delete', $post) }}" class="btn btn-danger" stule="background-color:7399C6; color:white;">
          <i class="fa fa-trash"></i>
        </a>
</th>
        <!-- <form class="delete-form" style="margin:0;padding:0;"method="POST"action="{{ route('posts.destroy',$post)}}">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-delete" style="background-color:#bf311a;color:white;">
        <i class="fa fa-trash"></i></button>
      </form> -->
     
      <?php $global_format = env("GLOBAL_DATE_FORMAT","d-m-Y"); ?>

       <?php 
       $late=$post->lateCal($post->id);
       $excus=$post->excuse_time;
       if($late>=$excus){
        $late=$late-$excus;
       }
       else{
        $late=$post->lateCal($post->id);
       }
       ?>
     
   


    <td>{{ $post->user->name }}</td>
    <td>{{ Carbon\Carbon::parse($post->date)->format('d/m/y')}}</td>
    <td>{{$post->timeInCal($post->id)}}</td>
    <td>{{$post->timeOutCal($post->id)}}</td>
    <td>{{ $post->excuse_time }}</td>
    <td>{{$post->offerTime($post->id)}}</td>
    <td>{{ $late }}</td>
    <td>{{ $post->absent }}</td>
    <td>{{ $post->absent_type }}</td>
    <td>{{ $post->notes }}</td>
    
      


      </td>
 
    </tr>

  @endforeach
  </tbody>
</table>




<button  class="btn btn-light mt-12" style="background-color:#4F2683; color:white;" onclick="tablesToExcel(['x'],['posts'],'تقرير_الموظفين.xls','Excel')">تصدير ملف</button>
<br></br>

<!-- <button type="submit" class="btn" name="exportExcel" title="exportExcel" onclick="{{('exportEx')}}">exportExcel</button> -->
             <!-- <button type="submit" class="btn" name="exportPDF" title="exportPDF">exportPDF</button> -->
            <a href="{{action('PostController@exportEx')}}"> Excel تصدير </a> 
           

<script src="{{URL::to('js_export/export.js')}}"></script>
@endsection