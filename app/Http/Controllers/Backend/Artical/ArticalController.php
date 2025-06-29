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
    public function index()
    {
        $data['articles'] = Artical::orderBy('created_at', 'desc')->paginate(2);
        return view('backend.article.list')->with($data);
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
