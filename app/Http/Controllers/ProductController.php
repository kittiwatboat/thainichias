<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\productcatagoryModel;
use App\productlistModel;
use App\productminorModel;
use App\productsubminorModel;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
class ProductController extends Controller
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
    public function indexcat(){
        $procat=productcatagoryModel::paginate(10);
        return view('admin.productcat.index')->with('procat',$procat);
    }
    public function addcat(){
        return view('admin.productcat.add');
    }
    public function addcatsub(Request $request){
        $procat=new productcatagoryModel;
        $procat->pc_nameen=$request->pc_nameen;
        $procat->pc_nameth=$request->pc_nameth;
        $procat->pc_headen=$request->pc_headen;
        $procat->pc_headth=$request->pc_headth;
        $procat->pc_detailen=$request->pc_detailen;
        $procat->pc_detailth=$request->pc_detailth;
        $procat->save();
        return redirect('/product/catagory');
    }
    public function editcat($id){
        return view('admin.productcat.edit',[
            'procat'=>productcatagoryModel::find($id)
        ]);
    }
    public function editcatsub(Request $request){
        $procat= productcatagoryModel::find($request->pc_id);
        $procat->pc_nameen=$request->pc_nameen;
        $procat->pc_nameth=$request->pc_nameth;
        $procat->pc_headen=$request->pc_headen;
        $procat->pc_headth=$request->pc_headth;
        $procat->pc_detailen=$request->pc_detailen;
        $procat->pc_detailth=$request->pc_detailth;
        $procat->save();
        return redirect("/product/catagory/edit/$procat->pc_id");
    }
    public function deleteprocat($id){
        $procat=productcatagoryModel::find($id);
        $pc=productcatagoryModel::destroy($procat->pc_id);
        if($pc){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    public function indexminor(){
        $pro=DB::table('product_minor')
        ->join('product_catagory','product_minor.pc_id','=','product_catagory.pc_id')
        ->select('product_minor.*','product_catagory.pc_nameen')
        ->orderby('created','desc')
        ->paginate(10);
        return view('admin.productminor.index')->with('pro',$pro);
    }
    public function addminor(){
        return view('admin.productminor.add',[
            'procat'=>productcatagoryModel::paginate()
        ]);
    }
    public function addminorsub(Request $request){
        $prominor=new productminorModel;
        $prominor->pm_nameen=$request->pm_nameen;
        $prominor->pm_nameth=$request->pm_nameth;
        $prominor->pc_id=$request->pc_id;
        $filename = 'pm_img_' . date('dmY-His');
        $file = $request->pm_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/product/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $prominor->pm_img = $newLG;
            }
        }
        $prominor->save();
        return redirect("/product/minor/add/sub/$prominor->pm_id");
    }
    public function addsubminor($id){
        $prominor = productminorModel::find($id);
        $prosub = productsubminorModel::where('pm_id','=',$id)->paginate(10);
        return view('admin.productminor.addsub')->with('prominor',$prominor)->with('prosub',$prosub);
    }
    public function addsubminorsub(Request $request){
        $prosub=new productsubminorModel;
        $prosub->psm_nameen=$request->psm_nameen;
        $prosub->psm_nameth=$request->psm_nameth;
        $prosub->psm_detailen=$request->psm_detailen;
        $prosub->psm_detailth=$request->psm_detailth;
        $prosub->psm_link=$request->psm_link;
        $prosub->pm_id=$request->pm_id;
        $filename = 'psm_img_' . date('dmY-His');
        $file = $request->psm_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){    
                      
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/product/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $prosub->psm_img = $newLG;
            }
        }
        $prosub->save();
        return redirect("/product/minor/add/sub/$prosub->pm_id");
    }
    public function addlist($id){
        $prosub=productsubminorModel::find($id);
        $prolist=productlistModel::where('psm_id','=',$id)->paginate(10);
        return view('admin.productminor.addlist')->with('prosub',$prosub)->with('prolist',$prolist);
    }
    public function addlistsub(Request $request){
        $prolist=new productlistModel;
        $prolist->psm_id=$request->psm_id;
        $prolist->tombo_no=$request->tombo_no;
        $prolist->pl_nameen=$request->pl_nameen;
        $prolist->pl_nameth=$request->pl_nameth;
        $prolist->pl_desen=$request->pl_desen;
        $prolist->pl_desth=$request->pl_desth;
        $prolist->pl_filleren=$request->pl_filleren;
        $prolist->pl_fillerth=$request->pl_fillerth;
        if($request->file('pl_file')!=null){
            $file = $request->file('pl_file');
            $filename = 'pl_file-' . date('dmY-Hism');
            $ext = $file->getClientOriginalExtension();
            if($prolist->pl_file!=null){
                Storage::disk('public')->delete($prolist->pl_file);
            }
            if($ext!="pdf"){
                return view("$this->prefix/alert/sweet/videoerror", ['url' => $request->fullUrl()]);
            }
            $newfile = 'upload/product/' . $filename . '.' . $ext;
            $file->storeAs('', $newfile, 'public');
            $prolist->pl_file = $newfile;
            }
        $prolist->save();
        return redirect("/product/minor/add/sub/list/$prolist->psm_id");

    }
    public function deletelist($id){
        $prolist=productlistModel::find($id);
        if($prolist->pl_file!=null){Storage::disk('public')->delete($prolist->pl_file);}
        $pl=productlistModel::destroy($prolist->pl_id);
        if($pl){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    public function editminor($id){
        return view('admin.productminor.edit',[
            'procat'=>productcatagoryModel::paginate(10),
            'prominor'=>productminorModel::find($id),
            'prosub'=>productsubminorModel::where('pm_id','=',$id)->paginate(10),
        ]);
    }
    public function editminorsub(Request $request){
        $prominor=productminorModel::find($request->pm_id);
        $prominor->pm_nameen=$request->pm_nameen;
        $prominor->pm_nameth=$request->pm_nameth;
        $prominor->pc_id=$request->pc_id;
        $filename = 'pm_img_' . date('dmY-His');
        $file = $request->pm_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){  
                if($prominor->pm_img != null){
                    Storage::disk('public')->delete($prominor->pm_img);
                }            
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/product/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $prominor->pm_img = $newLG;
            }
        }
        $prominor->save();
        return redirect("/product/minor/edit/$prominor->pm_id");
    }
    public function editsubminor($id){
        return view('admin.productminor.editsub',[
        'prosub'=>productsubminorModel::find($id),
        'prolist'=>productlistModel::where('psm_id','=',$id)->paginate(10)
        ]);
    }
    public function editsubminorsub(Request $request){
        $prosub=productsubminorModel::find($request->psm_id);
        $prosub->psm_nameen=$request->psm_nameen;
        $prosub->psm_nameth=$request->psm_nameth;
        $prosub->psm_detailen=$request->psm_detailen;
        $prosub->psm_detailth=$request->psm_detailth;
        $prosub->psm_link=$request->psm_link;
        $filename = 'psm_img_' . date('dmY-His');
        $file = $request->psm_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){      
                if($prosub->psm_img != null){
                    Storage::disk('public')->delete($prosub->psm_img);
                }       
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/product/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $prosub->psm_img = $newLG;
            }
        }
        $prosub->save();
        return redirect("/product/minor/edit/sub/$prosub->psm_id");
    }
    public function editlist($id){
        $prolist=productlistModel::find($id);
        return view('admin.productminor.editlist')->with('prolist',$prolist);
    }
    public function editlistsub(Request $request){
        $prolist = productlistModel::find($request->pl_id);
        $prolist->psm_id=$request->psm_id;
        $prolist->tombo_no=$request->tombo_no;
        $prolist->pl_nameen=$request->pl_nameen;
        $prolist->pl_nameth=$request->pl_nameth;
        $prolist->pl_desen=$request->pl_desen;
        $prolist->pl_desth=$request->pl_desth;
        $prolist->pl_filleren=$request->pl_filleren;
        $prolist->pl_fillerth=$request->pl_fillerth;
        if($request->file('pl_file')!=null){
            $file = $request->file('pl_file');
            $filename = 'pl_file-' . date('dmY-Hism');
            $ext = $file->getClientOriginalExtension();
            if($prolist->pl_file!=null){
                Storage::disk('public')->delete($prolist->pl_file);
            }
            if($ext!="pdf"){
                return view("$this->prefix/alert/sweet/videoerror", ['url' => $request->fullUrl()]);
            }
            $newfile = 'upload/product/' . $filename . '.' . $ext;
            $file->storeAs('', $newfile, 'public');
            $prolist->pl_file = $newfile;
            }
        $prolist->save();
        return redirect("/product/minor/edit/sub/list/$prolist->pl_id");
    }
    public function deleteprominor($id){
        $pro=productminorModel::find($id);
        if($pro->pm_img!=null){Storage::disk('public')->delete($pro->pm_img);}
        $pm=productminorModel::destroy($pro->pm_id);
        if($pm){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    public function deleteprominorsub($id){
        $pro=productsubminorModel::find($id);
        if($pro->psm_img!=null){Storage::disk('public')->delete($pro->psm_img);}
        $pm=productsubminorModel::destroy($pro->psm_id);
        if($pm){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
}
