<?php

use App\Models\Listing;
use Mockery\Matcher\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Mail\Mailables\Content;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing 
|
*/
// All Listings
Route::get('/', [ListingController::class, 'index']);

/* Route::get('/hello', function () {
    return response("<h1>Hello Laravel</h1>")
    ->header("Content-Type","text/plain");
});
Route::get('/posts/{id}',function($id){
 return response("Post ".$id );
})->where('id','[0-9]+');
Route::get('/search', function(Request $request){
    return($request->name . ' ' . $request->city);
});
 */


// Show create form 
/* Route::get('/listings/create',[ListingController::class, 'create']); */
// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

  //Store listing data
  Route::post('/listings',[ListingController::class, 'store'])->middleware('auth');

// Show edit form
Route::get('/listings/{listing}/edit',[ListingController::class, 'edit'])->middleware('auth');

// Update listing
Route::put('/listings/{listing}',[ListingController::class, 'update'])->middleware('auth');

// Delete listing
Route::delete('/listings/{listing}',[ListingController::class, 'destroy'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage',[ListingController::class, 'manage'])->middleware('auth');

// Single Listing
/* Route::get('/listings/{id}',function ($id){
  $listing= Listing::find($id);
  if ($listing) {
      return view('listing',[
          "listing" => $listing
        ]);
  } else {
   abort('404');
  }
      
}); */
/* Using Eloquent Model */
// Route Model Binding
Route::get('/listings/{listing}',[ListingController::class, 'show']);



/* All User Routes Now */

// Show Register/Create User Form
Route::get('/register',[UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users',[UserController::class, 'store']);

// Log User  Out
Route::post('/logout',[UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login',[UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User or Authenticate User
Route::post('/users/authenticate',[UserController::class, 'authenticate']);