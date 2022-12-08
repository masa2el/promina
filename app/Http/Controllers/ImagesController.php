<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Album;
use App\Models\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index($album = '')
    {
        if($album==''){
            return redirect()->route('albums.index')->with('error', 'Please select album to manage images.');
        }else{
            $album = Album::find($album);
            $images = $album->images;
            return view("images", compact('album','images'));
        }
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required',
            'album' => 'required',
            'file' => 'required|image',
        ]);

        $media = $request->file->store('public');

        $image = new Image();
        $image->name = $request->name;
        $image->album = $request->album;
        $image->media = $media;

        if($image->save()){
            return back()->with('success', 'Image saved successfully.');
        }else{
            return back()->with('error', 'Image not saved!.');
        }
    }

    public function update(Request $request){
        $validated = $request->validate([
            'image' => 'required',
            'name' => 'required',
        ]);

        $image = Image::find($request->image);
        $image->name = $request->name;
        if($image->update()){
            return back()->with('success', 'Image updated successfully.');
        }else{
            return back()->with('error', 'Image not updated!.');
        }
    }

    public function delete(Request $request){

        $validated = $request->validate([
            'image' => 'required',
        ]);

        $image = Image::find($request->image);
        if($image->delete()){
            $file = storage_path('app/'.$image->media);
            if(isset($file)){ unlink($file); }
            return back()->with('success', 'Image deleted successfully.');
        }else{
            return back()->with('error', 'Image not deleted!.');
        }

    }
}
