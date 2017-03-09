<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class PagesEditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'label' => trans('labels.fields.page.title')
            ])
            ->add('slug', 'text', [
                'label' => trans('labels.fields.page.slug')
            ])
            ->add('content', 'textarea', [
                'label' => trans('labels.fields.page.content')
            ])
             ->add('url', 'text', [
               'label' => trans('URL')
            ])
            ->add('seo_fields', 'checkbox', [
                'wrapper' => ['class' => 'form-group', 'id' => 'seo'],
                'label' => trans('SEO Setting')
            ])

            ->add('meta_title', 'text',[
                'wrapper' => ['class' => 'form-group test'],
                'label' => trans('Meta Title'),
            ])
            
            ->add('meta_keyword', 'text',[
                'wrapper' => ['class' => 'form-group test'],
                'label' => trans('Meta Keyword')
            ])
            ->add('meta_desc', 'textarea',[
                'wrapper' => ['class' => 'form-group test'],
                'label' => trans('Meta Description')
            ])
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}