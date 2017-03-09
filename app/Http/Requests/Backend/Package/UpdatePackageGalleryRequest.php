<?php namespace App\Http\Requests\Backend\Package;

use App\Http\Requests\Request;


class UpdatePackageGalleryRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return access()->can('edit-package-gallerys');
	}

		/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}

	
}