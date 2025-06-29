<?php

namespace App\Http\Controllers\Backend\Artical;

use App\Http\Controllers\Controller;
use App\Models\Artical;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Yajra\DataTables\DataTables;

class ArticalController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
          new Middleware('permission:view articles', only: ['index']),
          new Middleware('permission:edit articles', only: ['edit']),
          new Middleware('permission:create articles', only: ['create']),
          new Middleware('permission:destroy articles', only: ['destroy']),
        ];
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Artical::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row) {
                    $url = asset('storage/' . $row->image);
                    return '<img src="'. $url .'" width="50" height="50">';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '';

                    if (auth()->user()->can('edit articles')) {
                        $buttons .= '<a href="'. route('article.edit', $row->id) .'" class="bg-blue-700 text-sm rounded-md py-2 text-white hover:bg-blue-500">Edit</a> ';
                    }

                    if (auth()->user()->can('destroy articles')) {
                        $buttons .= '<a href="javascript:void(0);" onclick="deleteArticle('. $row->id .')" class="bg-red-700 text-sm rounded-md py-2 text-white hover:bg-red-500">Delete</a>';
                    }

                    return $buttons;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('backend.article.list');
    }

    public function create()
    {
        return view('backend.article.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|min:5',
            'author' => 'required|max:255',
            'image' => 'required',
        ]);


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '.' . $file->getClientOriginalExtension();
            $path = 'images/' . $name; // storage/app/public/images/

            // Resize the image using Intervention
            $manager    = new ImageManager(new Driver());
            $image      = $manager->read($file)->resize(500, 300);
            // Encode as PNG and store in Laravel storage
            Storage::disk('public')->put($path, (string) $image->toPng());

        }

        if ($validatedData)
        {
            $article = new Artical();
            $article->title = $request->input('title');
            $article->description =  $request->input('content');
            $article->author = $request->input('author');
            $article->image = $path;
            $article->save();

            return redirect()->route('article.index')->with('success', 'Artical Added Successfully');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors($validatedData);
        }

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $data['article'] = Artical::findOrFail($id);
        return view('backend.article.edit')->with($data);

    }

    public function update(Request $request, $id)
    {
        $article = Artical::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|min:5',
            'author' => 'required|max:255',
        ]);

        if ($validatedData)
        {
            $article->title          = $request->input('title');
            $article->description    =  $request->input('content');
            $article->author         = $request->input('author');
            $article->save();

            return redirect()->route('article.index')->with('success', 'Article Update Successfully');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors($validatedData);
        }

    }

    public function destroy($id)
    {
        $article = Artical::findOrFail($id);

        if ($article == null)
        {
            session()->flash('error', 'Role Not Found');
           return response()->json([
               'status' => false,
           ]);
        }

        $article->delete();

        session()->flash('success', 'Artical Deleted Successfully');
        return response()->json([
            'status' => true,
        ]);
    }
}
