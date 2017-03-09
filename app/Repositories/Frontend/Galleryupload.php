<?php namespace App\Repositories\Frontend;

use Input;
use File;
use App\Models\Gallery;
use URL;



/**
 * Class Galleryupload
 * @package App\Repositories\Frontend
 */
class Galleryupload {

private $_result;


  public function upload() {
          $userid = Input::get('id');
          $dir = 'gallery';
          $file = Input::file('galleryPic');
          $path = config('access.uploadDir').'/'.$userid.'/'.$dir;
          $extension = Input::file('galleryPic')->getClientOriginalExtension();
          $file = Input::file('galleryPic');
          $result = false;
          
          /////before upload filename
          $filename = $this->filename($extension);
          $filenameWithPath = $path.'/'.$filename;
       
          $error_message = '';
      

         try {
              
             $this->doDirectory($path);
           
             Input::file('galleryPic')->move($path, $filename);
             
             $gallery = Gallery::create([
                'user_id' => $userid,
                'path' => $filenameWithPath,
                'type' => 'image'
              ]);


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

    public function delete($id)
    {
      $gallery = Gallery::find($id);
      if($gallery->delete()){
        $img = File::delete($gallery->path);
        return true;
      }
        
       return false;
    }

    public function filename($extension){
      return uniqid(time()).'.'.$extension;
    }

    public function doDirectory($path) {

        if(!File::exists($path)) {
         return File::makeDirectory($path,0775,true);
        }

        

    }

    public function result() {

        $result = $this->_result;
        $this->_result = [];
        return response()->json($result);

    }

 

}