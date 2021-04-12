@extends('layouts.app')
<!-- to  edit &&&&&&&& -->

@section('title', 'تعديل حضور') 

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



    <form method="POST" action="{{ route('posts.update',$post) }}">
     @csrf
     @method('PATCH')
        <div class="form-group">
        <label style="margin-left=200;">اختر الموظف</label>
            <!-- <select name="user_id" class="form-control" id="post-empName" rows="3"> 
                <option selected="true" disabled="disabled">--أختر احد الموظفين--</option>
                <option value=1 @if(old('user_id', $post->user_id)==1) selected @endif>هيام معتوق بكري</option>
                <option value=2  @if(old('user_id', $post->user_id)==2) selected @endif >علياء احمد مليح</option>
                <option value=3 @if(old('user_id', $post->user_id)==3) selected @endif >اروى عبدالله الحجي</option>
                <option value=4 @if(old('user_id', $post->user_id)==4) selected @endif >انوار صالح عنبر</option>
                <option value=5 @if(old('user_id', $post->user_id)==5) selected @endif >ابرار غرمان العمري</option>

                <option value=6 @if(old('user_id', $post->user_id)==6) selected @endif >صالحة الغامدي</option>

                <option value=7 @if(old('user_id', $post->user_id)=='رهام ناصر الهروبي') selected @endif >رهام ناصر الهروبي</option>
                <option value=8 @if(old('user_id', $post->user_id)=='بيان الزنبقي') selected @endif >بيان الزنبقي</option>
                <option value=9 @if(old('user_id', $post->user_id)=='رشا بوقس') selected @endif >رشا بوقس</option>
                <option value=10 @if(old('user_id', $post->user_id)=='أنفال الحربي') selected @endif >أنفال الحربي </option>
                <option value=11 @if(old('user_id', $post->user_id)=='هنوف بنجر') selected @endif >هنوف بنجر</option>
                <option value=12 @if(old('user_id', $post->user_id)=='شهد صديق') selected @endif >شهد صديق</option>
                <option value=13 @if(old('user_id', $post->user_id)=='غدير الغامدي') selected @endif >غدير الغامدي</option>
                <option value=14 @if(old('user_id', $post->user_id)=='تغريد الشهري ') selected @endif >تغريد الشهري </option>
                <option value=15 @if(old('user_id', $post->user_id)=='هاجر خالد خضري') selected @endif >هاجر خالد خضري </option>
                <option value=16 @if(old('user_id', $post->user_id)=='فاطمة الهذلي') selected @endif >فاطمة الهذلي </option>
                <option value=17 @if(old('user_id', $post->user_id)=='أمجاد المرعشي') selected @endif >أمجاد المرعشي </option>
                <option value=18 @if(old('user_id', $post->user_id)=='سارة سعد القرني') selected @endif >سارة سعد القرني</option>

            </select> -->
                                            <select name="user_id" class="select-input">

                                @foreach($user as $user)

                                    <option value="{{ $user->id }}" @if($post->user_id==$user->id) selected @endif >
                                        {{ $user->name }}
                                        </option>

                                @endforeach

                                </select>

            

        </div>
               


        <div class="form-group">
            <label for="post-description">وقت الحضور</label>
            <input type="time" name="time_in" step="2" class="form-control" id="post-inTime"  value="{{ $post->time_in}}"   >

        </div>


        <div class="form-group">
            <label>وقت الإنصراف</label>
            <input type="time" name="time_out" step="2"class="form-control" id="post-outTime"  value="{{ $post->time_out}}" >  
        </div>

     

        <div class="form-group">
            <label>اختر التاريخ</label>
            <input type="date" name="date" class="form-control" id="post-date"  value="{{ $post->date}}" >
        </div>

        <br>
        <div class="form-group" style="display: inline-block;" >
             <label>--غياب--</label>
        <input type="checkbox"class="form-control" id="post-abs"value="غياب" {{$post->absent=="غائبة"?'checked':''}} style="col-md-6 radio-inline;display: inline-block; transform: scale(0.8);" name="absent">
                       
        </div>
     <br><br>

        <div class="form-group absent-input">
        <label>نوع الغياب</label>
    
            <select name="absent_type" class="form-control" id="post-absType" > 
            <option selected="true" value="">--أختر نوع الغياب--</option>
                <option @if(old('absent_type', $post->absent_type)=='إعتيادي') selected @endif >إعتيادي</option>
                <option @if(old('absent_type', $post->absent_type)=='إضطراري') selected @endif >إضطراري</option>
                <option @if(old('absent_type', $post->absent_type)=='مرضي') selected @endif >مرضي</option>
                <option @if(old('absent_type', $post->absent_type)=='وفاة') selected @endif >وفاة</option>
                <option @if(old('absent_type', $post->absent_type)=='بدون عذر') selected @endif >بدون عذر</option>
            </select>
        </div>


        <div class="form-group">
        <label>عدد دقائق الإستئذان</label>
           <input type="text" name="excuse_time" class="form-control" id="post-escTime"  value="{{ $post->excuse_time}}" >
        </div>

        <div class="form-group">
        <label>ملاحظات</label>
        <input type="text" name="notes" class="form-control" id="post-note"  value="{{ $post->notes}}" >
        </div>

        <button type="submit" class="btn btn-success">تعديل</button>
    </form>
</div>
</div>



@endsection