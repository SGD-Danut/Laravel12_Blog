<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function showCategories() {
        $categories = Category::all()->sortBy('title');
        $title = 'Categorii';
        return view('admin.categories.show-categories')->with('categories', $categories)->with('title', $title);
    }

    public function showAddCategory() {
        $title = 'Adăugare categorie';
        return view('admin.categories.show-add-category')->with('title', $title);
    }

    public function createCategory(AddCategoryRequest $request) {
        $category = new Category;

        $category->title = $request->title;
        $category->slug = Str::slug($request->slug);
        $category->subtitle = $request->subtitle;
        $category->presentation = $request->presentation;

        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;

        if ($request->hasFile('image')) {
            $imageExtension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . time() . '.' . $imageExtension;
            $request->file('image')->move('storage/admin/images/categories', $imageName);

            $category->image = $imageName;
        }

        $confirmationCreateMessage = "Categoria " . $request->title . " a fost adăugată cu succes!";
    
        $category->save();
    
        return redirect(route('admin.show-categories'))->with('success', $confirmationCreateMessage);
    }
}
