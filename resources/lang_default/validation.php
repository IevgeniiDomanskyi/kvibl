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

    'accepted'             => 'Поле :attribute повинне бути відміченим.',
    'active_url'           => 'Поле :attribute не є правильним посиланням.',
    'after'                => 'Поле :attribute повинне бути датою після :date.',
    'after_or_equal'       => 'Поле :attribute повинне бути датою після або рівне :date.',
    'alpha'                => 'Поле :attribute повинне містити лише літери.',
    'alpha_dash'           => 'Поле :attribute повинне містити літери, числа та дефіс.',
    'alpha_num'            => 'Поле :attribute повинне містити літери та числа.',
    'array'                => 'Поле :attribute повинне бути масивом.',
    'before'               => 'Поле :attribute повинне бути датою до :date.',
    'before_or_equal'      => 'Поле :attribute повинне бути датою до або рівне :date.',
    'between'              => [
        'numeric' => 'Поле :attribute повинне бути між :min та :max.',
        'file'    => 'Поле :attribute повинне бути між :min та :max кілобайтів.',
        'string'  => 'Поле :attribute повинне бути між :min та :max символів.',
        'array'   => 'Поле :attribute повинне бути між :min та :max кількістю елементів.',
    ],
    'boolean'              => 'Поле :attribute повинне бути істиним або хибним.',
    'confirmed'            => 'Підтвердження для поля :attribute не співпадає.',
    'date'                 => 'Поле :attribute не є коректною датою.',
    'date_format'          => 'Поле :attribute не співпадає з форматом :format.',
    'different'            => 'Поле :attribute та :other повинні відрізнятися.',
    'digits'               => 'Поле :attribute повинне містити :digits цифр.',
    'digits_between'       => 'Поле :attribute повинне бути між :min та :max цифрами.',
    'dimensions'           => 'Поле :attribute має неправильне розширення.',
    'distinct'             => 'Поле :attribute має дублююче значення.',
    'email'                => 'Поле :attribute повинне бути коректною електронною адресою.',
    'exists'               => 'Обране поле :attribute неправильне.',
    'file'                 => 'Поле :attribute повинне бути файлом.',
    'filled'               => 'Поле :attribute повинне бути заповнене.',
    'image'                => 'Поле :attribute повинне бути зображенням.',
    'in'                   => 'Обране поле :attribute неправильне.',
    'in_array'             => 'Поле :attribute відсутнє у :other.',
    'integer'              => 'Поле :attribute повинне бути цілим числом.',
    'ip'                   => 'Поле :attribute повинне бути коректною IP адресою.',
    'ipv4'                 => 'Поле :attribute повинне бути коректною IPv4 адресою.',
    'ipv6'                 => 'Поле :attribute повинне бути коректною IPv6 адресою.',
    'json'                 => 'Поле :attribute повинне бути валідною JSON строкою.',
    'max'                  => [
        'numeric' => 'Поле :attribute не повинне бути більшим ніж :max.',
        'file'    => 'Поле :attribute не повинне бути більшим ніж :max кілобайт.',
        'string'  => 'Поле :attribute не повинне бути більшим ніж :max символів.',
        'array'   => 'Поле :attribute не повинне бути більшим ніж :max елементів.',
    ],
    'mimes'                => 'Поле :attribute повинне бути файлом типу: :values.',
    'mimetypes'            => 'Поле :attribute повинне бути файлом типу: :values.',
    'min'                  => [
        'numeric' => 'Поле :attribute повинне бути не менше :min.',
        'file'    => 'Поле :attribute повинне бути не менше :min кілобайтів.',
        'string'  => 'Поле :attribute повинне бути не менше :min символів.',
        'array'   => 'Поле :attribute повинне бути не менше :min елементів.',
    ],
    'not_in'               => 'Обране поле :attribute неправильне.',
    'numeric'              => 'Поле :attribute повинне бути числом.',
    'present'              => 'Поле :attribute повинне бути присутнім.',
    'regex'                => 'Поле :attribute має неправильний формат.',
    'required'             => 'Поле :attribute обов\'язкове.',
    'required_if'          => 'Поле :attribute обов\'язкове якщо :other рівне :value.',
    'required_unless'      => 'Поле :attribute обов\'язкове якщо :other не є у :values.',
    'required_with'        => 'Поле :attribute обов\'язкове якщо :values присутні.',
    'required_with_all'    => 'Поле :attribute обов\'язкове якщо :values присутні.',
    'required_without'     => 'Поле :attribute обов\'язкове якщо :values відсутнє.',
    'required_without_all' => 'Поле :attribute обов\'язкове якщо жодне із :values не присутнє.',
    'same'                 => 'Поле :attribute та :other повинні співпадати.',
    'size'                 => [
        'numeric' => 'Поле :attribute повинне мати розмір :size.',
        'file'    => 'Поле :attribute повинне мати розмір :size кілобайт.',
        'string'  => 'Поле :attribute повинне мати розмір :size символів.',
        'array'   => 'Поле :attribute повинне мати розмір :size елементів.',
    ],
    'string'               => 'Поле :attribute повинне бути строкою.',
    'timezone'             => 'Поле :attribute повинне бути коректною часовою зоною.',
    'unique'               => 'Поле :attribute вже зайняте.',
    'uploaded'             => 'Поле :attribute не завантажене.',
    'url'                  => 'Формат поля :attribute неправильний.',

    'withinTime'           => 'Поле :attribute повинне бути між :from та :to.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
