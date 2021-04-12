@extends('layouts.app')

@section('title', 'إضافة حضور')

@section('content')
<div class="row">
<div class="col-lg-6 mx-auto">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('posts.store') }}">
     @csrf
        <div class="form-group">

        <label style="margin-left=200;">اختر الموظف</label>


    <select name="user_id">
    <option selected="true" disabled="disabled">--أختر احد الموظفين--</option>

            @foreach($users as $user)

                 <option value="{{ $user->id }}" >
                    {{ $user->name }}
                    </option>

            @endforeach

        </select>


        </div>
               


        <div class="form-group">
            <label for="post-description">وقت الحضور</label>
            <input type="time" name="time_in" step="2" class="form-control" id="post-inTime" value="08:00:00">

        </div>


        <div class="form-group">
            <label>وقت الإنصراف</label>
            <input type="time" name="time_out" step="2"class="form-control" id="post-outTime" value="16:00:00"> 
        </div>

     <?php
     ?>

        <div class="form-group">
            <label>اختر التاريخ</label>
            <input type="date" name="date" class="form-control" id="post-date" value="{{now()->startOfMonth()->format('Y-m-d')}}">
        </div>

        <br>
        <div class="form-group" style="display: inline-block;" >
             <label>--غياب--</label>
                        <input type="checkbox" name="absent" value="غياب" class="form-control" id="post-abs" style="col-md-6 radio-inline;display: inline-block; transform: scale(0.8);">
                    
        </div>
<br><br>

        <div class="form-group absent-input">
        <label>نوع الغياب</label>
            <select name="absent_type" class="form-control" id="post-absType"> 
            <option selected="true" value="">--أختر نوع الغياب--</option>
                <option value="إعتيادي">إعتيادي</option>
                <option value="إظطراري">إضطراري</option>
                <option value="مرضي">مرضي</option>
                <option value="وفاة">وفاة</option>
                <option value="بدون عذر">بدون عذر</option>
            </select>
        </div>


        <div class="form-group ">
        <label>عدد دقائق الإستئذان</label>
           <input type="text" name="excuse_time" class="form-control" id="post-escTime" >
        </div>

        <div class="form-group">
        <label>ملاحظات</label>
        <input type="text" name="notes" class="form-control" id="post-note">
        </div>

        <button type="submit" class="btn btn-success">إرسال</button>
    </form>
</div>
</div>
@endsection