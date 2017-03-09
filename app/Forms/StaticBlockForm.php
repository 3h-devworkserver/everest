<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class StaticBlockForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'label' => trans('Title')
            ])
            ->add('content', 'textarea', [
                'label' => trans('Content')
            ])
            ->add('url', 'url', [
                'label' => trans('URL')
            ])
            ->add('image', 'file', [
                'label' => trans('Image'),
                'attr' => ''
            ])
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}