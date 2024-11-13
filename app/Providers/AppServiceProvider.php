<?php

namespace App\Providers;

use Collective\Html\FormFacade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');
        
        FormFacade::component('fileInput', 'components.vendor.form-builder.file_input', ['name', 'value', 'attributes']);
        FormFacade::component('textInput', 'components.vendor.form-builder.text_input', ['name', 'value', 'attributes']);
        FormFacade::component('passwordInput', 'components.vendor.form-builder.password_input', ['name', 'value', 'attributes']);
        FormFacade::component('emailInput', 'components.vendor.form-builder.email_input', ['name', 'value', 'attributes']);
        FormFacade::component('textareaInput', 'components.vendor.form-builder.textarea_input', ['name', 'value', 'attributes']);
        FormFacade::component('dateInput', 'components.vendor.form-builder.date_input', ['name', 'value', 'attributes']);
        FormFacade::component('numberInput', 'components.vendor.form-builder.number_input', ['name', 'value', 'attributes']);
        FormFacade::component('radioInput', 'components.vendor.form-builder.radio_input', ['name', 'value', 'options' => [1 => 'yes', 0 => 'no'], 'attributes']);
        FormFacade::component('selectInput', 'components.vendor.form-builder.select_input', ['name', 'value', 'options' => [], 'attributes']);
        FormFacade::component('switchInput', 'components.vendor.form-builder.switch_input', ['name', 'value' => 1, 'attributes']);
        FormFacade::component('multipleInput', 'components.vendor.form-builder.multiple_input', ['name', 'type', 'values' => [''], 'attributes']);
        FormFacade::component('multipleColumnInput', 'components.vendor.form-builder.multiple_column_input', ['name', 'values' => [], 'columns', 'attributes']);
        FormFacade::component('select2Input', 'components.vendor.form-builder.select2_input', ['name', 'value', 'options' => [], 'attributes']);
        FormFacade::component('select2MultipleInput', 'components.vendor.form-builder.select2_multiple_input', ['name', 'value', 'options' => [], 'attributes']);
    }
}
