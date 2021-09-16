<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\technicalpaperModel;
use Intervention\Image\ImageManagerStatic as Image;

class TechnicalpaperController extends Controller
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
        $tech = technicalpaperModel::paginate(10);
        return view('admin.technicalPaper.index')->with('tech',$tech);
    }
    public function add(){
        return view('admin.technicalPaper.add');
    }
    public function addsub(Request $request){
       $tech = new technicalpaperModel;
       $tech->tp_nameen=$request->tp_nameen;
       $tech->tp_nameth=$request->tp_nameth;
       $tech->tp_type=$request->tp_type;
       if($request->file('tp_paper')!=null){
        $file = $request->file('tp_paper');
        $filename = 'file-' . date('dmY-Hism');
        $ext = $file->getClientOriginalExtension();
        if($ext!="pdf"){
            return view("$this->prefix/alert/sweet/videoerror", ['url' => $request->fullUrl()]);
        }
        $newfile = 'upload/paper/' . $filename . '.' . $ext;
        $file->storeAs('', $newfile, 'public');
        $tech->tp_paper = $newfile;
        }
        $filename1 = 'tp_paperimg_' . date('dmY-His');
        $file1 = $request->tp_paperimg;
        if($file1){ 
            $ima = $file1->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file1->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/paper/' . $filename1 . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $tech->tp_paperimg = $newLG;
            }
        }
        $tech->save();
        return redirect('technical/paper');
    }
    public function edit($id){
        $tech = technicalpaperModel::find($id);
        return view('admin.technicalPaper.edit')->with('tech',$tech);
    }
    public function editsub(Request $request){
       $tech = technicalpaperModel::find($request->tp_id);
       $tech->tp_nameen=$request->tp_nameen;
       $tech->tp_nameth=$request->tp_nameth;
       $tech->tp_type=$request->tp_type;
       if($request->file('tp_paper')!=null){
        $file = $request->file('tp_paper');
        $filename = 'file-' . date('dmY-Hism');
        $ext = $file->getClientOriginalExtension();
        if($tech->tp_paper!=null){
            Storage::disk('public')->delete($tech->tp_paper);
        }
        if($ext!="pdf"){
            return view("$this->prefix/alert/sweet/videoerror", ['url' => $request->fullUrl()]);
        }
        $newfile = 'upload/paper/' . $filename . '.' . $ext;
        $file->storeAs('', $newfile, 'public');
        $tech->tp_paper = $newfile;
        }
        $filename1 = 'tp_paperimg_' . date('dmY-His');
        $file1 = $request->tp_paperimg;
        if($file1){ 
            $ima = $file1->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){ 
                if($tech->tp_paperimg!=null){
                    Storage::disk('public')->delete($tech->tp_paperimg);
                }          
            $lg = image::make($file1->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/paper/' . $filename1 . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $tech->tp_paperimg = $newLG;
            }
        }
        $tech->save();
        return redirect("technical/paper/edit/$tech->tp_id");
    }
    public function deletetech($id){
        $tec=technicalpaperModel::find($id);

        if($tec->tp_paper!=null){Storage::disk('public')->delete($tec->tp_paper);}
        if($tec->tp_paperimg!=null){Storage::disk('public')->delete($tec->tp_paperimg);}
        $te=technicalpaperModel::destroy($tec->tp_id);
        if($te){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
}
