<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PackagesEditForm extends Form
{
    public function buildForm()
    {
       $this
            ->add('title', 'text', [
                'label' => trans('Title')
            ])
            ->add('short_desc', 'textarea', [
                'label' => trans('Short Description')
            ])
            ->add('content', 'textarea', [
                'label' => trans('Content')
            ])
            ->add('price', 'text', [
                'label' => trans('Price')
            ])
            // ->add('image', 'file', [
            //     'label' => trans('Image'),
            //     'attr' => ''
            // ])
            ->add('select_field', 'select', [
                'choices' => ['static_block' => 'Static Block', 'gallery' => 'Gallery', 'video' => 'Video'],
                'empty_value' => 'Select'
            ])
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}
