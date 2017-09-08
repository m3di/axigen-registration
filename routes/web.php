<?php

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

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'PublicView@index')->name('home');
Route::get('/{domain}/validate', 'PublicView@validateUsername')->name('validate_email');
Route::post('/{domain}/request', 'PublicView@recordRequest')->name('request');

//Route::get('/save', function() {
//    include app_path('Helpers/simple_html_dom.php');
//
//    $page = session('page', 1);
//
//    $content = new simple_html_dom(file_get_contents("https://www.drugbank.ca/categories?page=".$page, false, stream_context_create([
//        "ssl" => [
//            "verify_peer"=>false,
//            "verify_peer_name"=>false,
//        ],
//    ])));
//
//    $table = $content->find('.table-condensed')[0];
//    foreach ($table->find('tr') as $k => $tr) {
//        if ($k < 2)
//            continue;
//
//        $category = new \App\Models\Category();
//
//        $description = html_entity_decode($tr->children[1]->plaintext);
//
//        if (preg_match("/more$/", $description))
//            $description = $tr->children[1]->find('a')[0]->attr['data-content'];
//
//        $category->name = html_entity_decode($tr->children[0]->plaintext);
//        if ($description != 'Not Available')
//            $category->description = $description;
//
//        $category->save();
//
//    }
//
//    echo "$page saved!";
//    session(['page' => ++$page]);
//});