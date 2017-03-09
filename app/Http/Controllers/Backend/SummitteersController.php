<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilder;
use DB;
use Datatable;
use App\Models\Summitteers;


class SummitteersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = $this->setDatatableSummitteer(); //role of users
        return view('backend.summitteer.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\SummitteersForm', [
            'method' => 'POST',
            'class' => 'summitteer-form',
            'enctype'=>'multipart/form-data',
            'url' => route('admin.summitteers.store'),
        ]);
       return view('backend.summitteer.create',compact('form'));     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = array(
            'name' => $request->name,
            'country' => $request->country,
            'date' => $request->date,
            'route' => $request->route,
            'team_name' => $request->team_name
            );
        \DB::table('summitteers')->insert($inputs);
        return redirect()->back()->withFlashSuccess('Successfully added.');
    }
  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, FormBuilder $formBuilder)
    {
        $summitteer = Summitteers::find($id);
        $form = $formBuilder->create('App\Forms\SummitteersEditForm', [
            'method' => 'PATCH',
            'class' => 'summitteer-form',
            'url' => route('admin.summitteers.update', ['id' => $id]),
            'model' => $summitteer
        ]);
         return view('backend.summitteer.edit', compact('form','summitteer'));
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
        $dataExist = Summitteers::find($id);
        if($dataExist){
            $summitteer = array(
                'name' => $request->name,
                'country' => $request->country,
                'date' => $request->date,
                'route' => $request->route,
                'team_name' => $request->team_name
                );
            Summitteers::where('id', $id)->update($summitteer);
            return redirect()->to('admin/summitteers')->withFlashSuccess('Successfully Updated.');
        }else{
          return redirect()->to('admin/summitteers')->withFlashError('Summitteer Not Found.');  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteSummitteer($id)
    {
       $summitteer = Summitteers::find($id);
       if($summitteer){
            $summitteer->delete();
            return redirect()->back()->withFlashSuccess('Deleted Successfully.');
       }else{
            return redirect()->back()->withFlashError('Summitteer Not Found.');
       }
    }

    public function setDatatableSummitteer()
    {
        $route = route('api.table.summitteer');

            return Datatable::table()
            ->addColumn(trans('ID'), trans('Name'), trans('Country'), trans('Year'), trans('Route'), trans('Team Name'), trans('Created'))
            ->addColumn(trans('crud.actions'))
            ->setUrl($route)
            ->render();

    }
}
