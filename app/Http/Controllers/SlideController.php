<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\slideModel;
use Intervention\Image\ImageManagerStatic as Image;

class SlideController extends Controller
{
    public function imageSize($find = null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x' => "100%", 'y' => "100%"],
            ],
            'gallery' => [
                'lg' => ['x' => "100%", 'y' => "100%"],
            ]
        ];
        if ($find == null) {
            return $arr;
        } else {
            switch ($find) {
                case 'cover':
                    return $arr['cover'];
                    break;
                case 'gallery':
                    return $arr['gallery'];
                    break;
                default:
                    return [];
                    break;
            }
        }
    }
    public function index(){
        $slide = slideModel::paginate(10);
        return view('admin.banner.index')->with('slide',$slide);
    }
    public function add(){
        return view('admin.banner.add');
    }
    public function addsub(Request $request){
        $slide = new slideModel;

        $filename = 'slide_image_' . date('dmY-His');
        $file = $request->slide_image;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/slide/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $slide->slide_image = $newLG;
            }
        }
        $slide->save();
        return redirect('/slidemange');
    }
    public function edit($id){
        return view('admin.banner.edit',[
            'slide'=>slideModel::find($id)
        ]);
    }
    public function editsub(Request $request){
        $slide =slideModel::find($request->slide_id);
        $filename = 'slide_image_' . date('dmY-His');
        $file = $request->slide_image;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){ 
                if($slide->slide_image != null){
                    Storage::disk('public')->delete($slide->slide_image);
                }          
            $lg = Image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/slide/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $slide->slide_image = $newLG;
            }
        }
        $slide->save();
        return redirect("/slidemange/edit/$slide->slide_id");
    }
    public function deleteslide($id)
    {
        $slide=slideModel::find($id);

        if($slide->slide_image!=null){Storage::disk('public')->delete($slide->slide_image);}
        
        $sli=slideModel::destroy($slide->slide_id);
        if($sli){
            return response()->json(true);
        }else{
            return response()->json(false);
        }

    }
}
