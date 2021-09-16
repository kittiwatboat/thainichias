<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\newsModel;
use Intervention\Image\ImageManagerStatic as Image;
class NewsController extends Controller
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
        $news = newsModel::paginate(10);
        return view('admin.news.index')->with('news',$news);
    }
    public function add(){
        return view('admin.news.add');
    }
    public function addsub(Request $request){
        $news = new newsModel;
        $news->news_nameen=$request->news_nameen;
        $news->news_nameth=$request->news_nameth;
        $news->news_detailen=$request->news_detailen;
        $news->news_detailth=$request->news_detailth;
        $news->news_type=$request->news_type;
        $news->news_link=$request->news_link;
        $filename = 'news_image_' . date('dmY-His');
        $file = $request->news_image;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/news/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $news->news_image = $newLG;
            }
        }
        $news->save();
        return redirect("/newsmanage");
    }
    public function edit($id){
        return view('admin.news.edit',[
            'news'=>newsModel::find($id),
        ]);
    }
    public function editsub(Request $request){
        $news=newsModel::find($request->news_id);
        $news->news_nameen=$request->news_nameen;
        $news->news_nameth=$request->news_nameth;
        $news->news_detailen=$request->news_detailen;
        $news->news_detailth=$request->news_detailth;
        $news->news_type=$request->news_type;
        $news->news_link=$request->news_link;
        $filename = 'news_image_' . date('dmY-His');
        $file = $request->news_image;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){ 
                if($news->news_image != null){
                    Storage::disk('public')->delete($news->news_image);
                }          
            $lg = Image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/news/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $news->news_image = $newLG;
            }
        }
        $news->save();
        return redirect("/news/edit/$news->news_id");
    }
    public function deletenews($id)
    {
        $news=newsModel::find($id);

        if($news->news_image!=null){Storage::disk('public')->delete($news->news_image);}
        
        $new=newsModel::destroy($news->news_id);
        if($new){
            return response()->json(true);
        }else{
            return response()->json(false);
        }

    }
}
