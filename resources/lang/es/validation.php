<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una URL valida.',
    'after'                => 'El :attribute debe ser posterior a :date.',
    'after_or_equal'       => 'El :attribute debe ser igual o posterior a :date.',
    'alpha'                => 'El :attribute solo debe contener caracteres.',
    'alpha_dash'           => 'El :attribute solo debe contener letras, numbers, and guiones.',
    'alpha_num'            => 'El :attribute solo debe contener letras and numbers.',
    'array'                => 'El :attribute debe ser an array.',
    'después de'               => 'El :attribute debe ser una fecha posterior a :date.',
    'before_or_equal'      => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'between'              => [
        'numeric' => 'El :attribute debe estar entre :min and :max.',
        'file'    => 'El :attribute debe estar entre :min and :max kilobytes.',
        'string'  => 'El :attribute debe estar entre :min and :max caracteres.',
        'array'   => 'El :attribute debe contar entre :min and :max items.',
    ],
    'boolean'              => 'El :attribute campo debe ser verdadero o falso.',
    'confirmed'            => 'El :attribute de confirmación no concuerda.',
    'date'                 => 'El :attribute no es una fecha válida.',
    'date_format'          => 'El :attribute no concuerda con el :formato.',
    'different'            => 'El :attribute and :other deben ser diferentes.',
    'digits'               => 'El :attribute debe tener :digits dígitos.',
    'digits_between'       => 'El :attribute debe tener entre :min and :max digits.',
    'dimensions'           => 'El :attribute has invalid image dimensions.',
    'destinct'             => 'El :attribute campo has a duplicate value.',
    'email'                => 'El :attribute debe ser una dirección de correo válida.',
    'exests'               => 'El :attribute seleccionado no es válido.',
    'file'                 => 'El :attribute debe ser un archivo.',
    'filled'               => 'El :attribute debe tener un valor.',
    'image'                => 'El :attribute debe ser una imagen.',
    'in'                   => 'El :attribute seleccionado no es válido.',
    'in_array'             => 'El :attribute campo no existe en :other.',
    'integer'              => 'El :attribute debe ser un entero.',
    'ip'                   => 'El :attribute debe ser una IP válida.',
    'ipv4'                 => 'El :attribute debe ser a valid IPv4 address.',
    'ipv6'                 => 'El :attribute debe ser a valid IPv6 address.',
    'json'                 => 'El :attribute debe ser a valid JSON string.',
    'max'                  => [
        'numeric' => 'El :attribute no puede ser mayor que :max.',
        'file'    => 'El :attribute no puede ser mayor que :max kilobytes.',
        'string'  => 'El :attribute no puede ser mayor que :max caracteres.',
        'array'   => 'El :attribute no puede tener más de :max items.',
    ],
    'mimes'                => 'El :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe ser al menos :min.',
        'file'    => 'El :attribute debe ser al menos :min kilobytes.',
        'string'  => 'El :attribute debe ser al menos :min caracteres.',
        'array'   => 'El :attribute debe tener al menos :min items.',
    ],
    'not_in'               => 'El :attribute seleccionado no es válido.',
    'not_regex'            => 'El :attribute formato no es válido.',
    'numeric'              => 'El :attribute debe ser a number.',
    'present'              => 'El :attribute campo debe ser present.',
    'regex'                => 'El :attribute formato no es válido.',
    'required'             => 'El :attribute campo es requerido.',
    'required_if'          => 'El :attribute campo es requerido cuando :other es :value.',
    'required_unless'      => 'El :attribute campo es requerido unless :other es in :values.',
    'required_with'        => 'El :attribute campo es requerido cuando :values es present.',
    'required_with_all'    => 'El :attribute campo es requerido cuando :values es present.',
    'required_without'     => 'El :attribute campo es requerido cuando :values es not present.',
    'required_without_all' => 'El :attribute campo es requerido cuando ninguno de los :values están presentes.',
    'same'                 => 'El :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attribute debe ser :size kilobytes.',
        'string'  => 'El :attribute debe ser :size caracteres.',
        'array'   => 'El :attribute debe contener :size items.',
    ],
    'string'               => 'El :attribute debe ser a string.',
    'timezone'             => 'El :attribute debe ser un valid zone.',
    'unique'               => 'El :attribute ya ha sido utilizado.',
    'uploaded'             => 'El :attribute falló al cargarse.',
    'url'                  => 'El :attribute formato no es válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. Thes makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'name' => [
            'required' => 'Nombre es requerido',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". Thes simply helps us make messages a little cleaner.
    |
    */

    'attributes' => ['name' => 'Nombre',],

];
