<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ImportExcelRequest;
use App\Imports\CategoryImport;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function page() {
        $categories = Category::all();
        $metadata = [
            'pageTitle' => 'Categories',
            'breadcrumbs' => [
                [
                    'name' => 'Categories',
                    'route' => 'categories.page'
                ],
                [
                    'name' => 'List',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.category.index', compact('categories', 'metadata'));
    }

    public function storePage() {
        $metadata = [
            'pageTitle' => 'Create Category',
            'breadcrumbs' => [
                [
                    'name' => 'Categories',
                    'route' => 'categories.page'
                ],
                [
                    'name' => 'Create',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.category.store', compact('metadata'));
    }

    public function updatePage(string $id) {
        $category = Category::findOrFail($id);
        $metadata = [
            'pageTitle' => 'Update Category',
            'breadcrumbs' => [
                [
                    'name' => 'Categories',
                    'route' => 'categories.page'
                ],
                [
                    'name' => 'Update',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.category.update', compact('metadata', 'category'));
    }

    public function list(Request $request) {
        $categories = Category::all();

        return DataTables::of($categories)
        ->addIndexColumn()
        ->addColumn('actions', function ($category) {
            $btn = '<a href="' . route('categories.show', ['id' => $category->category_id]) . '" class="btn btn-primary btn-sm">Details</a>';
            $btn .= '<a href="' . route('categories.update-page', ['id' => $category->category_id]) . '" class="btn btn-warning btn-sm ml-0 ml-md-2">Update</a>';
            $btn .= '<form action="' . route('categories.delete', ['id' => $category->category_id]) . '" method="POST" style="display:inline-block;">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm ml-0 ml-md-2" onclick="return confirm(\'Are you sure you want to delete this category?\')">Delete</button></form>';

            return $btn;
        })
        ->addColumn('actions-ajax', function ($category) {
            $btn = '<button type="button" class="details-category-ajax-btn btn btn-primary btn-sm ml-0 ml-md-2" data-toggle="modal" data-target="#detailsCategoryAjaxModal" data-id="' . $category->category_id . '">Details</button>';
            $btn .= '<button type="button" class="update-category-ajax-btn btn btn-warning btn-sm ml-0 ml-md-2" data-toggle="modal" data-target="#updateCategoryAjaxModal" data-id="' . $category->category_id . '">Update</button>';
            $btn .= '<button type="button" class="delete-category-ajax-btn btn btn-danger btn-sm ml-0 ml-md-2" data-id="' . $category->category_id . '">Delete</button>';

            return $btn;
        })
        ->rawColumns(['actions', 'actions-ajax'])
        ->make(true);
    }

    public function store(CategoryRequest $request) {
        $validatedData = $request->validated();

        Category::create([
            'category_code' => $validatedData['category_code'],
            'category_name' => $validatedData['category_name'],
        ]);

        return redirect()->route('categories.page')->with('success', 'Caetgory created successfully.')->withInput($request->only('category_code', 'category_name'));
    }

    public function storeAjax(CategoryRequest $request) {
        if (!$request->validated()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category. Please check again your data.',
                'errors' => $request->errors(),
            ]);
        }

        $validatedData = $request->validated();
        Category::create([
            'category_code' => $validatedData['category_code'],
            'category_name' => $validatedData['category_name'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'data' => $validatedData
        ]);
    }

    public function show(string $id) {
        $category = Category::findOrFail($id);
        $metadata = [
            'pageTitle' => 'Category Details',
            'breadcrumbs' => [
                [
                    'name' => 'Categories',
                    'route' => 'categories.page'
                ],
                [
                    'name' => 'Details',
                    'route' => '#'
                ],
            ]
        ];

        return view('pages.category.show', compact('category', 'metadata'));
    }

    public function showAjax(string $id) {
        $category = Category::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Category details found.',
            'data' => $category
        ]);
    }

    public function update(CategoryRequest $request, string $id) {
        $validatedData = $request->validated();

        $category = Category::findOrFail($id);
        $category->update([
            'category_code' => $validatedData['category_code'],
            'category_name' => $validatedData['category_name'],
        ]);

        return redirect()->route('categories.page')->with('success', 'Category updated successfully.')->withInput($request->only('category_code', 'category_name'));
    }

    public function updateAjax(CategoryRequest $request, string $id) {
        if (!$request->validated()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category. Please check again your data.',
                'errors' => $request->errors(),
            ]);
        }

        $validatedData = $request->validated();

        $category = Category::findOrFail($id);
        $category->update([
            'category_code' => $validatedData['category_code'],
            'category_name' => $validatedData['category_name'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'data' => $validatedData
        ]);
    }

    public function delete(string $id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.page')->with('success', 'Category deleted successfully.');
    }

    public function deleteAjax(string $id) {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
            'data' => $category
        ]);
    }

    public function importExcelAjax(ImportExcelRequest $request) {
        if (!$request->validated()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to import Excel file. Please check again your data.',
                'errors' => $request->errors(),
            ]);
        }

        $excelFile = $request->file('file');
    
        try {
            Excel::import(new CategoryImport, $excelFile);
    
            return response()->json([
                'success' => true,
                'message' => 'Category data imported successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to import Excel file.',
                'errors' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function exportExcel() {
        return Excel::download(new CategoryExport, 'categories.xlsx');
    }

    public function exportPdf() {
        $categories = Category::all();

        $pdf = Pdf::loadView('pages.category.export-pdf', compact('categories'));
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Categories data ' . Carbon::now()->format('d-m-Y') . '.pdf');
    }
}
