<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Pages\PageContract;
use Kris\LaravelFormBuilder\FormBuilder;
use Laracasts\Flash\Flash;
use Datatable;
use Input;
use File;
use DB;
use App\Models\BlockImage;
use App\Models\Page;
use App\Models\StaticBlock;
use App\Http\Requests\Backend\Page\CreatePageRequest;
use App\Http\Requests\Backend\Page\DeletePageRequest;
use App\Http\Requests\Backend\Page\StatusPageRequest;
use App\Http\Requests\Backend\Page\UpdatePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @var PageContract
     */
    protected $pages;

    public function __construct(PageContract $pages) {
        $this->pages = $pages;
        
    }

    public function index()
    {
        $table = $this->setDatatable('1');
        return view('backend.pages.index', compact('table'));
    }

    /**
     * Show the form for creating a new page.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\PagesForm', [
            'method' => 'POST',
            'class' => 'form-page',
            'id' => 'pagecreat',
            'enctype'=>'multipart/form-data',
            'url' => route('admin.pages.store'),
        ]);
        if (request()->ajax()) {
            $html = view('backend.packages.staticfields')->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
        return view('backend.pages.create', compact('form'));
    }

     /**
     * Store a newly created page in storage
     *
     * @param PageRequest $request
     * @return Response
     */
    public function store(CreatePageRequest $request){

          // dd($request->all());
        $inputs = $request->except(array('stitle','scontent','surl','simage','counter','_token','blockPic'));
        $staticDatas = array(
            'stitle' => $request->stitle,
            'scontent' => $request->scontent,
            'surl' => $request->surl,
            'simage' => $request->simage
            );
        $staticDatas = array_filter($staticDatas);

        $filename = '';
         if($request->hasFile('blockPic'))
        {     
          $file = $request->file('blockPic');
          $destination_path = 'images/';
          $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
          $file->move($destination_path, $filename);
        }

        $filename = array("blockPic" =>  $filename);
        $datas = array_merge($filename, $inputs);
        $filterdatas = array_filter($datas);

        if(!empty($filterdatas)){

            $pid = $this->pages->create($datas);
            if($pid && !empty($staticDatas)) {
                StaticBlock::poststaticblock($request->all(), $pid, $block_type = '1');   
            }
        }else{
            return redirect()->route('admin.pages.create')->withFlashSuccess(trans("Fill Title And Content Fields.")); 
        }
        return redirect()->route('admin.pages.index')->withFlashSuccess(trans("alerts.pages.created"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivated()
    {
       
        $table = $this->setDatatable('0');
        return view('backend.pages.deactivated', compact('table'));
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param Page $page
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        // $id = Input::get('id');
        $pages = $this->pages->findOrThrowException($id);
        $form = $formBuilder->create('App\Forms\PagesEditForm', [
            'method' => 'PATCH',
            'class' => 'edit-pageform',
            'id' => 'pageEdit',
            'enctype'=>'multipart/form-data',
            'url' => route('admin.pages.update', ['id' => $pages->id]),
            'model' => $pages
        ]);
        $static = \DB::table('static_blocks')->where('pid',$id)->where('block_type', 1)->get();
        return view('backend.pages.edit', compact('form','pages'))->with('static', $static);
    }

    /**
     * @param $id
     * @return mixed
     */

    public function update($id, UpdatePageRequest $request) {
        //dd($request->all());
        /*page update*/
        $inputs = $request->except('counter', 'stitle', 'scontent', 'surl', 'simage');
        $staticDatas = array(
            'counter' => $request->counter,
            'uniqueId' => $request->uniqueId,
            'stitle' => $request->stitle,
            'scontent' => $request->scontent,
            'surl' => $request->surl,
            'simage' => $request->simage
            );
        $staticDatas = array_filter($staticDatas);

        $this->pages->update($id, $inputs);
        if($this->pages->update($id, $inputs)){

            $image = Page::where('id', $id)->first();
            $blockImage = $image->block_image;
            if($request->hasFile('blockPic')){ 
                
                File::delete($blockImage);    
                $file = $request->file('blockPic');
                $destination_path = 'images/';
                $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                $file->move($destination_path, $filename);
                DB::table('pages')->where('id', $id)->update(['block_image'=>$filename]);
            }   
        }
        /*static_block update*/
        if(!empty($staticDatas)){

            $datas = \DB::table('static_blocks')->where('pid', $id)->where('block_type', 1)->get();

            if(empty($datas)){
                StaticBlock::poststaticblock($staticDatas, $id, $block_type = '1');   
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


                        StaticBlock::postupdate($newDatas, $id, $block_type = '1');
                    }else{
                        
                        if (empty($_FILES['simage']['name'][$key])){
                            StaticBlock::where('pid', $id)->where('uniqueid', $value)->where('block_type', 1)->update(array('title' =>$_POST['stitle'][$key], 'content' =>$_POST['scontent'][$key], 'url' =>$_POST['surl'][$key]));
                        }else{
                            $file = Input::file('simage')[$key];
                            $destination_path = 'images/staticimages';
                            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                            $file->move($destination_path, $filename);
                            StaticBlock::where('pid', $id)->where('uniqueid', $value)->where('block_type', 1)->update(array('title' =>$_POST['stitle'][$key], 'content' =>$_POST['scontent'][$key], 'url' =>$_POST['surl'][$key], 'image' =>$filename));
                        }
                    }
                }
        }
    }
        return redirect()->route('admin.pages.index')->withFlashSuccess(trans("alerts.pages.updated"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeletePageRequest $request)
    {
        $this->pages->delete($id);
        StaticBlock::where('pid', $id)->where('block_type', 1)->delete();
        return redirect()->back()->withFlashSuccess(trans("alerts.pages.deleted"));
    }

    public function deletestaticBlock($id){

        $staticBlock = StaticBlock::find($id);
        if($staticBlock){
            $staticBlock->delete();
        }
        return redirect()->back()->withFlashSuccess(trans("Static Block Deleted."));

    }

    public function status($id, $status, StatusPageRequest $request)
    {
        $this->pages->status($id, $status);
        return redirect()->back()->withFlashSuccess(trans("alerts.pages.updated"));
    }

    public function uploadblockimage()
    {
        $destinationPath = 'uploads'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
 
        $block_image = BlockImage::create([
              'path' => $fileName,
              ]);
        if ($upload_success) {
            return response()->json('success', 200);
        } else {
            return response()->json('error', 400);
        }

        // return response()->json(array('success' => true, 'stat' => 'ok'));
    }


    
     /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatable($status)
    {
        

        if($status)
            $route = route('api.table.page');

        else
            $route = route('api.table.page.deactivated');

            return Datatable::table()
            ->addColumn(trans('crud.pages.id'), trans('crud.pages.title'), trans('crud.pages.created'), trans('crud.pages.last_updated'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->setOptions(['oLanguage' => trans('crud.datatables')])
            ->render();

       
    }
}
