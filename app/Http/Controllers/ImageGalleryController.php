<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageGallery;

class ImageGalleryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $images = ImageGallery::paginate(6);
        $tags = ImageGallery::get()->pluck('tags');
        $tags = $this->validateTags($tags);

        return view('gallery', compact('images', 'tags'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'tags' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $input['image'] = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $input['image']);


        $input['title'] = $request->title;
        $input['tags'] = strtolower($request->tags);
        ImageGallery::create($input);


        return back()
            ->with('success', 'Image Uploaded successfully.');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        ImageGallery::find($id)->delete();
        return back()
            ->with('success', 'Image removed successfully.');
    }

    /**
     * @param $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getFiltredImages($tag)
    {
        $images = ImageGallery::where("tags", "like", "%" . $tag . "%")->paginate(6);
        $tags = ImageGallery::get()->pluck('tags');
        $tags = $this->validateTags($tags);

        return view('gallery', compact('images', 'tags'));
    }

    /**
     * @param $tags
     * @return mixed|string
     */
    public function validateTags($tags)
    {
        $tags = (string)$tags;
        $tags = str_replace('["', "", $tags);
        $tags = str_replace('","', " ", $tags);
        $tags = str_replace('"]', "", $tags);
        $tags = strtolower($tags);

        $tags = implode(' ', array_unique(explode(' ', $tags)));
        $tags = explode(" ", $tags);

        return $tags;
    }
}
