<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());
        session()->flash('success', 'Registro creado exitosamente.');
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('category.edit', [
            'category' => $category,
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        session()->flash('success', 'Registro actualizado exitosamente.');

        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', 'Registro eliminado exitosamente.');
        return redirect()->route('categories.index');
    }
}

