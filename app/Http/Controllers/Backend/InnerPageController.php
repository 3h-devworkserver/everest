<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use Laracasts\Flash\Flash;
use App\Models\InnerPage;
use Datatable;
use File;
use Input;
use App\Models\StaticBlock;
use App\Http\Requests\Backend\Page\CreatePageRequest;
use App\Http\Requests\Backend\Page\DeletePageRequest;
use App\Http\Requests\Backend\Page\StatusPageRequest;
use App\Http\Requests\Backend\Page\UpdatePageRequest;

class InnerPageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $table = $this->setDatatable();
        return view('backend.innerpage.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder, CreatePageRequest $request) {
        $form = $formBuilder->create('App\Forms\InnerPageForm', [
            'method' => 'POST',
            'class' => 'form-page',
            'id' => 'pagecreat',
            'enctype' => 'multipart/form-data',
            'url' => route('admin.innerpages.store'),
        ]);
        if (request()->ajax()) {
            $html = view('backend.packages.staticfields')->render();
            return response()->json(array('success' => true, 'html' => $html));
        }
        return view('backend.innerpage.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePageRequest $request) {
        // dd($request->all());
        /* staticblock inputs */
        $staticDatas = array(
            'counter' => $request->counter,
            'stitle' => $request->stitle,
            'scontent' => $request->scontent,
            'surl' => $request->surl,
            'simage' => $request->simage
        );
        $staticDatas = array_filter($staticDatas);

        /* inner page create */
        $innerpage = new InnerPage;
        $innerpage->title = $request->title;
        $innerpage->content = $request->content;
        $innerpage->meta_key = $request->meta_key;
        $innerpage->meta_desc = $request->meta_desc;
        $innerpage->meta_title = $request->meta_title;
        $innerpage->created_at = date("Y-m-d H:i:s");
        $innerpage->save();
        $pid = $innerpage->id;

        if ($request->hasFile('blockPic')) {
            $file = $request->file('blockPic');
            $destination_path = 'images/';
            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            InnerPage::where('id', $pid)->update(array('image' => $filename));
        }

        if (!empty($staticDatas)) {
            StaticBlock::poststaticblock($staticDatas, $pid, $block_type = '1');
        }
        return redirect()->route('admin.innerpages.index')->withFlashSuccess('Inner Page Created Successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder, UpdatePageRequest $request) {
        $innerpage = InnerPage::find($id);
        $form = $formBuilder->create('App\Forms\InnerPageEditForm', [
            'method' => 'PATCH',
            'class' => 'edit-pageform',
            'id' => 'pageEdit',
            'enctype' => 'multipart/form-data',
            'url' => route('admin.innerpages.update', ['id' => $innerpage->id]),
            'model' => $innerpage
        ]);
        $static = \DB::table('static_blocks')->where('pid', $id)->where('block_type', 1)->get();
        return view('backend.innerpage.edit', compact('form', 'innerpage'))->with('static', $static);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageRequest $request, $id) {
        //  print_r($_POST);exit;
        $inputs = $request->except('counter', 'stitle', 'scontent', 'surl', 'simage');
        $staticDatas = array(
            'counter' => $request->counter,
            'uniqueId' => $request->uniqueId,
            'stitle' => $request->stitle,
            'scontent' => $request->scontent,
            'surl' => $request->surl,
            'simage' => $request->simage,
            'sposition' => $request->sposition,
        );
        $staticDatas = array_filter($staticDatas);

        $inputs = array(
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'meta_desc' => $request->meta_desc,
            'meta_title' => $request->meta_title,
            'meta_key' => $request->meta_key,
            'updated_at' => date("Y-m-d H:i:s")
        );
        InnerPage::where('id', $id)->update($inputs);

        if ($request->hasFile('blockPic')) {
            $image = InnerPage::where('id', $id)->first();
            $blockImage = $image->block_image;
            File::delete($blockImage);
            $file = $request->file('blockPic');
            $destination_path = 'images/';
            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            InnerPage::where('id', $id)->update(array('image' => $filename));
        }


        /* static_block update */
        if (!empty($staticDatas)) {

            $datas = \DB::table('static_blocks')->where('pid', $id)->where('block_type', 1)->get();

            if (empty($datas)) {
                StaticBlock::poststaticblock($staticDatas, $id, $block_type = '1');
            } else {

                foreach ($_POST['uniqueId'] as $key => $value) {

                    $alreadyexist1 = \DB::table('static_blocks')->where('pid', $id)->where('uniqueid', $value)->get();

                    if (empty($alreadyexist1)) {
                        $newDatas = array(
                            'counter' => $_POST['counter'][$key],
                            'uniqueId' => $_POST['uniqueId'][$key],
                            'stitle' => $_POST['stitle'][$key],
                            'scontent' => $_POST['scontent'][$key],
                            'surl' => $_POST['surl'][$key],
                            'simage' => Input::file('simage')[$key],
                            'sposition' => $_POST['sposition'][$key]
                        );


                        StaticBlock::postupdate($newDatas, $id, $block_type = '1');
                    } else {

                        if (empty($_FILES['simage']['name'][$key])) {
                            StaticBlock::where('pid', $id)->where('uniqueid', $value)->where('block_type', 1)->update(array('position' => $_POST['sposition'][$key], 'title' => $_POST['stitle'][$key], 'content' => $_POST['scontent'][$key], 'url' => $_POST['surl'][$key]));
                        } else {
                            $file = Input::file('simage')[$key];
                            $destination_path = 'images/staticimages';
                            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                            $file->move($destination_path, $filename);

                            StaticBlock::where('pid', $id)->where('uniqueid', $value)->where('block_type', 1)->update(array('position' => $_POST['sposition'][$key], 'title' => $_POST['stitle'][$key], 'content' => $_POST['scontent'][$key], 'url' => $_POST['surl'][$key], 'image' => $filename));
                        }
                    }
                }
                //exit;
            }
        }
        return redirect()->route('admin.innerpages.index')->withFlashSuccess('Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id, DeletePageRequest $request) {
        $innerPage = InnerPage::find($id);

        #dd($innerPage);
        if ($innerPage) {

            $innerPage->delete();
            StaticBlock::where('pid', $id)->where('block_type', 1)->delete();
            return redirect()->back()->withFlashSuccess('Deleted Successfully.');
        } else {
            return redirect()->back()->withFlashError('Page Not Found.');
        }
    }

    /**
     * Remove the specified static contents from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletestaticBlock($id) {
        $StaticBlock = StaticBlock::find($id);

        if ($StaticBlock) {
            $StaticBlock->delete();
            return redirect()->back()->withFlashSuccess('Deleted Successfully.');
        } else {
            return redirect()->back()->withFlashError('Page Not Found.');
        }
    }

    private function setDatatable() {

        $route = route('api.table.innerpage');

        return Datatable::table()
                        ->addColumn(trans('Id'), trans('Title'), trans('Created'), trans('Last Updated'))
                        ->addColumn(trans('Actions'))
                        ->setUrl($route)
                        ->render();
    }

}
