<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use Datatable;
use Input;
use File;
use Validator;
use App\Http\Requests\Backend\Email\TravellerRegistrationEmailRequest;

class EmailController extends Controller
{

public function EmailTemplate(TravellerRegistrationEmailRequest $request){
  // return "here";
    $content = file_get_contents(base_path() . '/resources/views/backend/email/travellerregister/emailtemplate.blade.php');
    if(empty($content)){
      return view('backend.email.travellerregister.create');
    }else{
      return view('backend.email.travellerregister.edit', compact('content'));
    }

}



public function EmailTemplateStore(TravellerRegistrationEmailRequest $request){
	 $this->validate($request, [
        'content' => 'required',
    ]);

    $content = file_put_contents(base_path() . '/resources/views/backend/email/travellerregister/emailtemplate.blade.php', $request->content);
    return redirect('admin/email/travellerregister')->withFlashSuccess('Updated Successfully');
}




}
