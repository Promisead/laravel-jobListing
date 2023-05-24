<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\List_;

class ListingController extends Controller
{
      // Show all Listings
      public function index(){
    
    
        return view('listings.index',[
    
/*             "listings" => Listing::all()*/           
                "listings" => Listing::latest()->filter(request(['tag','search']))->paginate(6)
        ] );
    }


    //Show single Listing
    public function show(Listing $listing){

        return view('listings.show',[
            "listing" => $listing
          ]);   
    }
   /*  //Show create form
    public function create(){

        return view('listings.create');   
    } */

     // Show Create Form
     public function create() {
      return view('listings.create');
  }

  // Store listing data
  public function store(Request $request){
  
    $formFields = $request->validate([
      'title' => 'required',
        'company'=> ['required',Rule::unique('listings','company')],
        'location' =>'required',
        'website' => 'required',
        'email' => ['required','email'],
        'tags' => 'required',
        'description' =>'required'
    ]);

    $formFields['user_id'] =auth()->id();

if ($request->hasFile('logo')) {
  $formFields['logo'] = $request->file('logo')->store('logos','public');
}  

    Listing::create($formFields);
return redirect('/')->with('message', 'Listing created successfully!');
  }


  // Update listing data
  public function update(Request $request, Listing $listing){
     // Make sure logged in user is owner
     if($listing->user_id != auth()->id()) {
      abort(403, 'Unauthorized Action');
  }
  
    $formFields = $request->validate([
      'title' => 'required',
        'company'=> 'required',
        'location' =>'required',
        'website' => 'required',
        'email' => ['required','email'],
        'tags' => 'required',
        'description' =>'required'
    ]);
if ($request->hasFile('logo')) {
  $formFields['logo'] = $request->file('logo')->store('logos','public');
}  

    $listing->update($formFields);
return redirect('/')->with('message', 'Listing updated successfully!');
  }

//Delete listing 
public function destroy(Listing $listing){
 // Make sure logged in user is owner
 if($listing->user_id != auth()->id()) {
  abort(403, 'Unauthorized Action');
}

  $listing->delete();
  return redirect('/')->with('message', 'Listing deleted successfully!');  
}

  //Show edit form
  public function edit(Listing $listing){
 return view('listings.edit', ['listing' => $listing]);
  }
 
  //Manage Listings
 /*  public function manage(){
    return view('listings.manage', ['listings'=>auth()->user()->listings()->get()]);
  } */
    // Manage Listings
    public function manage() {
      return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
  }
}
