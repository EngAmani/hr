<?php

use Illuminate\Support\Facades\Route;
use app\controllers\PostController;
use app\controllers\UserController;
use App\Models\User;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user/{name?}', function ($name = 'John') {
    return $name;
});
Route::resource('posts','PostController');
Route::get('/delete/{id}','PostController@delete')->name('delete');
Route::post('search','PostController@search')->name('search');

Route::get('/b','PostController@exportEx')->name('exportEx');
Route::post('/pp','PostController@exportPdf')->name('exportPdf');


Route::get('/sEmp/{id}','PostController@selectedEmp')->name('selectedEmp');
Route::get('/add_user','UserController@add_emp_form')->name('add_user');
Route::post('/store_user','UserController@store')->name('store_user');


Route::get('/test_user','PostController@test')->name('test_user');

Route::get('/dashboard', function () {

    $now = Carbon::now();
    $now->subMonth();
  
    $users = User::all();

    foreach($users as $user){
        $late_users[$user->id]['name'] = $user->name;
        $late_users[$user->id]['late'] = $user->total_late();
        $totals[$user->id] = $user->total_late();
    }

    array_multisort($totals, SORT_DESC, $late_users);

   // krsort($late_users);

        dd($late_users);

    $user_info = DB::table('posts')
    ->where('absent_type','<>',NULL)
    ->whereYear('date', $now->year)
    ->whereMonth('date', $now->month)
     ->select('user_id', DB::raw('count(*) as total'))
     ->groupBy('user_id')
     ->orderByDesc('total')
     ->get();

  //dd($);
  //dd($user_info); // Sort by surname

  $max_limit = 10;
    $labels = array();

    $data = array();
    for($i=0;$i < count($user_info); $i++){
        if($i < $max_limit){
            $labels[] = User::find($user_info[$i]->user_id)->name;
            $data[] = $user_info[$i]->total;
        }
 
    }

  //  dd($labels);
    $data = implode(',',$data);
  //  $labels = implode(',',$labels);
    //dd($labels);
    return view('dashboard/dashboard',compact('data','labels'));
})->name('dashboard');







