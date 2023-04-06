<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
class categoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category.index',compact('categories'));
   }

   public function create(){
       return view('category/create');
   }
  
   public function insert(Request $request)
   {
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);
    $category = Category::create($data);
    return redirect()->back()->with('success', 'Category created successfully.');
   }

   public function edit($id){
    $category = Category::find($id);
    return view('category.edit', compact('category'));
   }
   public function update(Request $request,$id){
    $category = Category::find($id);
    
    if (!$category) {
        return back()->withErrors([
            'message' => 'Category not found',
        ]);
    }
    
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);
    
    $category->name = $validatedData['name'];
    $category->save();
    return redirect('/category/index')->with('success', 'Category updated successfully');

   }
   public function delete($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');

   }
}
