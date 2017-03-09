<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SummitteersForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Name',
                'required' => 'required'
            ])
            ->add('country', 'text', [
                'label' => 'Country'
            ])
            ->add('date', 'text', [
                'label' => 'Year'
            ])
            ->add('route', 'text', [
                'label' => 'Route'
            ])
            ->add('team_name', 'text', [
                'label' => 'Team Name'
            ])
            ->add('save', 'submit', [
                'label' => trans('labels.fields.save'),
                'attr' => ['class' => 'btn btn-orange']
            ]);
    }
}
