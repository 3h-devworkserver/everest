<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class TravellerProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('fname', 'text', [
                'label' => trans('labels.fields.user.fname')
                
            ])
            
            ->add('lname', 'text', [
                'label' => trans('labels.fields.user.lname')
            ])
            ->add('phone', 'text', [
                'label' => trans('labels.fields.user.phone')

            ])
            ->add('state', 'select', [
                'label' => trans('labels.fields.user.state')
            ])
            ->add('city', 'text', [
                'label' => trans('labels.fields.user.city')
            ])
            ->add('country', 'select', [
                'attr' => ['onchange' => 'print_state(\'state\',this.selectedIndex);']
            ])
            ->add('zip', 'number', [
                'label' => trans('labels.fields.user.zip')
            ])
            ->add('address', 'text', [
                'label' => trans('labels.fields.user.address')
            ])
            
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-primary']
            ]);
            
    }
}