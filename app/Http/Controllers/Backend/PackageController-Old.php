<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Laracasts\Flash\Flash;
use Datatable;
use Input;
use App\Models\Packages;
use App\Models\StaticBlock;
use App\Models\PackageGallery;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = $this->PackageDatatable();
        return view('backend.packages.index', compact('table'));
        // $pacakges = Packages::select('id','title');
        // return view('backend.packages.index');
    }

    public function PackageDatatable()
    {
        $pacakges = Packages::select('id','title'); 
        $route = route('api.table.package');              
        return Datatable::table()
            ->addColumn(trans('id'), trans('title'), trans('created_at'))
            ->addColumn(trans('actions'))
            ->setUrl($route)
            ->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\PackagesForm', [
            'method' => 'POST',
            'class' => 'package-form',
            'id' => 'package_create',
            'url' => route('admin.packages.store'),
            'enctype' => "multipart/form-data",
        ]);
        if (request()->ajax()) {
            $html = view('backend.packages.staticfields')->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
        return view('backend.packages.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request->all());
        $defaultInputs = array($request->image, $request->title, $request->short_desc, $request->content, $request->price);
        $defaultDatas = array_filter($defaultInputs);

        $staticInputs = array('simage' => $request->simage, 'stitle' => $request->stitle, 'scontent' => $request->scontent, 'surl' => $request->surl, 'uniqueId' => $request->uniqueId, 'counter' => $request->counter);
        $staticInputs = array_filter($staticInputs);

        $filename = '';
        $videoname = '';

        if($request->hasFile('image'))
        {     
          $file = $request->file('image');
          $destination_path = 'images/';
          $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
          $file->move($destination_path, $filename);
        }
        if($request->hasFile('video')){
            $video = $request->file('video');
            $destination_path = 'images/video';
            $videoname = uniqid(time()). '.' . $video->getClientOriginalExtension();
            $video->move($destination_path, $videoname);  
        }
        if(!empty($defaultDatas)){

            $Package = new Packages;
            $Package->title = $request->title;
            $Package->short_desc = $request->short_desc;
            $Package->content = $request->content;
            $Package->price = $request->price;
            $Package->image = $filename;
            $Package->video = $videoname;
            $Package->save();

        }else{

            return redirect()->route('admin.packages.create')->withFlashSuccess(trans("Fill Above fields."));
        }

        if($request->select_field == 'static_block' && !empty($staticInputs)){
            StaticBlock::poststaticblock($staticInputs, $Package->id, $block_type = '2');
        }

        if($request->hasFile('gallery') && !empty($Package->id)){
            $this->postgallery($request->all(), $Package->id);
        }
     
        // return response()->json(array('success' => 'true', 'stat' => 'ok'));
        return redirect()->route('admin.packages.create')->withFlashSuccess(trans("Packages Created."));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FormBuilder $formBuilder, $id)
    {
        $package = Packages::find( $id);
        $gallery = \DB::table('block_image')->where('package_id', $id)->get();
        $form = $formBuilder->create('App\Forms\PackagesEditForm', [
            'method' => 'PATCH',
            'id' => 'package_edit',
            'class' => 'package-form',
            'url' => route('admin.packages.update', ['id' => $id]),
            'model' => $package
        ]);
        $static = \DB::table('static_blocks')->where('pid',$id)->where('block_type', 2)->get();
        return view('backend.packages.edit', compact('form','package'))->with('static', $static)->with('gallery', $gallery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
       $filename = '';
       if($request->hasFile('image'))
        {     
          $file = $request->file('image');
          $destination_path = 'images/';
          $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
          $file->move($destination_path, $filename);
        }

        $inputs = array(
            'title' => $request->title,
            'short_desc' => $request->short_desc,
            'content' => $request->content,
            'price' => $request->price,
            'image' => $filename,
            );
        Packages::where('id', $id)->update($inputs);

        if($request->hasFile('video')){
            $video = $request->file('video');
            $destination_path = 'images/video';
            $videoname = uniqid(time()). '.' . $video->getClientOriginalExtension();
            $video->move($destination_path, $videoname); 
            Packages::where('id', $id)->update(array('video' => $videoname)); 
        }

        if($request->hasFile('gallery')){
            $gallery = Input::file('gallery');
            foreach(Input::file('gallery') as $key => $data){
            $file = $gallery[$key];
            $destination_path = 'images/packages';
            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            PackageGallery::where('package_id', $id)->where('id', $request->galleryId[$key])->update(array('image' => $filename, 'caption' => $request->caption[$key]));
           }
        }

        $staticDatas = array(
            'counter' => $request->counter,
            'uniqueId' => $request->uniqueId,
            'stitle' => $request->stitle,
            'scontent' => $request->scontent,
            'surl' => $request->surl,
            'simage' => $request->simage
            );
        $staticDatas = array_filter($staticDatas);

        if(!empty($staticDatas)){

            $datas = \DB::table('static_blocks')->where('pid', $id)->where('block_type', 2)->get();

            if(empty($datas)){
            
                StaticBlock::poststaticblock($staticDatas, $id, $block_type = '2');   
            }else{

                foreach ($_POST['uniqueId'] as $key => $value) {

                    $alreadyexist1 = \DB::table('static_blocks')->where('pid', $id)->where('uniqueid', $value)->get();
               
                    if(empty($alreadyexist1)){

                        $newDatas = array(
                            'counter'   =>  $_POST['counter'][$key],
                            'uniqueId'  =>  $_POST['uniqueId'][$key],
                            'stitle'    =>  $_POST['stitle'][$key],
                            'scontent'  =>  $_POST['scontent'][$key],
                            'surl'      =>  $_POST['surl'][$key],
                            'simage'    =>  Input::file('simage')[$key]
                            );


                        StaticBlock::postupdate($newDatas, $id, $block_type = '2');
                    }else{
                       
                        if (empty($_FILES['simage']['name'][$key])){
                            StaticBlock::where('pid', $id)->where('uniqueid', $value)->where('block_type', 2)->update(array('title' =>$_POST['stitle'][$key], 'content' =>$_POST['scontent'][$key], 'url' =>$_POST['surl'][$key]));
                        }else{
                            $file = Input::file('simage')[$key];
                            $destination_path = 'images/staticimages';
                            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                            $file->move($destination_path, $filename);
                            StaticBlock::where('pid', $id)->where('uniqueid', $value)->where('block_type', 2)->update(array('title' =>$_POST['stitle'][$key], 'content' =>$_POST['scontent'][$key], 'url' =>$_POST['surl'][$key], 'image' =>$filename));
                        }
                    }
                }
        }
    }


        return redirect()->back()->withFlashSuccess('Package Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destory($id)
    {
        $package = Packages::find($id);
        if ($package) {
            $package->delete();
            StaticBlock::where('pid', $id)->where('block_type', 2)->delete();
            PackageGallery::where('package_id', $id)->delete();
            return redirect()->back()->withFlashSuccess(trans("Package Deleted"));
        }else{
            return redirect()->back()->withFlashSuccess(trans("Package Not Found."));
        }

    }

    public function getstaticblock(FormBuilder $formBuilder, $pId)
    {
        $form = $formBuilder->create('App\Forms\StaticBlockForm', [
            'method' => 'POST',
            'class' => '',
            'url' => 'admin/packages/create/block',
        ]);
        return view('backend.staticblock.create', compact('form', 'pId'));
    }

    public function postgallery($inputs, $pId)
    {  
        $gallery = $inputs['gallery'];
        $caption = $inputs['caption'];
        $count = count($inputs['gallery']);
        for($i=0; $i<$count; $i++){
            $file = $gallery[$i];
            $destination_path = 'images/packages';
            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            PackageGallery::create(array('package_id' => $pId, 'image' => $filename, 'caption' => $caption[$i]));
        }
        return true;
    }
}
