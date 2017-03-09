<?php namespace App\Repositories\Frontend;

use Input;
use File;
use App\Models\Profile;
use Image;
use URL;



/**
 * Class Profileupload
 * @package App\Repositories\Frontend
 */
class Profileupload {

private $_result;


	public function upload() {
        
          $userid = access()->user()->id;

          $dir = 'profilePic';
          $path = config('access.uploadDir').'/'.$userid.'/'.$dir;
          $extension = Input::file('profilePic')->getClientOriginalExtension();
          $file_size = Input::file('profilePic')->getSize();
          $file = Input::file('profilePic');
          $result = false;
          
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
          $newFilename = $this->filenameAdded($filename,100);
          $newFilenameWithPath = $path.'/'.$newFilename;
       
          $error_message = '';
      

         try {
              
             $this->doDirectory($path);
           
             Input::file('profilePic')->move($path, $filename);
              $image = Image::make($filenameWithPath);

             $imageResult1 = $image->fit(100,100)->save($newFilenameWithPath);
            
            // if(access()->hasRole('Guide')){
  
            //    $imageResult2 = $image->fit(163,180)->save($filenameWithPath);

            //  }
            //  else{
            //     $imageResult2 = $image->fit(247,280)->save($filenameWithPath);

            //  }
            
             Profile::where('user_id',$userid)->update(['profileImg'=>$filenameWithPath]);


             $result = true;

        } catch (Exception $e) {

            $error_message = $e->getMessage();
            $filename = null;
           

        }

          $this->_result = [
            'result' => $result,
            'insertId' => $userid,
            'imgPath' => URL::to($filenameWithPath),
            'saveMode' => 'insert'
        ];

        if(!empty($error_message)) {

            $this->_result['error_message'] = $error_message;

        }

        return $result;

       
        

    }

    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

    public function filenameAdded($filename,$resolution){
      $filename = explode('.', $filename);
      $filename = $filename[0].'_'.$resolution.'.'.$filename[1];
      return $filename;
    }

    public function doDirectory($path) {

        if(!File::exists($path)) {
         return File::makeDirectory($path,0775,true);
        }

        return File::cleanDirectory($path);

    }

    public function result() {

        $result = $this->_result;
        $this->_result = [];
        return response()->json($result);

    }

 

}