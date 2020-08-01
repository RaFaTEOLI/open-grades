<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Linhas de Idioma para Validação
    |--------------------------------------------------------------------------
    |
    | As linhas de idioma a seguir contém mensagens padrões de erro usado pela
    | classe validator. Algumas das regras tem várias version, por exemplo
    | as regras de tamanho. Fique à vontade para mexer em qualquer mensagem aqui.
    |
    */

    'accepted' => 'O campo deve ser aceito.',
    'active_url' => 'O campo não é uma URL válida.',
    'after' => 'A O campo deve ser uma data depois de :date.',
    'after_or_equal' => 'A O campo deve ser uma data depois ou igual à :date.',
    'alpha' => 'O campo deve conter apenas letras.',
    'alpha_dash' => 'O campo deve conter apenas letras, números, traços e sublinhado.',
    'alpha_num' => 'O campo deve conter apenas letras e números.',
    'array' => 'O campo deve ser uma array.',
    'before' => 'O campo deve ser uma data antes de :date.',
    'before_or_equal' => 'O campo  deve ser uma data antes ou igual à :date.',
    'between' => [
        'numeric' => 'O campo deve estar entre :min e :max.',
        'file' => 'O campo deve ter entre :min e :max kilobytes.',
        'string' => 'O campo deve ter entre :min e :max caracteres.',
        'array' => 'O campo deve ter entre :min e :max itens.',
    ],
    'boolean' => 'O campo O campo deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação não corresponde.',
    'date' => 'A O campo não é uma data válida.',
    'date_equals' => 'A O campo deve ser uma data igual à :date.',
    'date_format' => 'O campo não corresponde com o formato :format.',
    'different' => 'O campo e :other devem ser diferentes.',
    'digits' => 'O campo deve ter :digits dígitos.',
    'digits_between' => 'O campo deve ter entre :min e :max dígitos.',
    'dimensions' => 'A O campo tem dimensões de imagem inválidas.',
    'distinct' => 'O campo O campo tem valor duplicado.',
    'email' => 'O campo deve ser um endereço de email válido.',
    'ends_with' => 'O campo deve terminar com um dos valores a seguir: :values.',
    'exists' => 'O campo selecionado é inválido.',
    'file' => 'O campo deve ser um arquivo.',
    'filled' => 'O campo deve ter um valor.',
    'gt' => [
        'numeric' => 'O campo deve ser maior que :value.',
        'file' => 'O campo deve ter mais que :value kilobytes.',
        'string' => 'O campo deve ter mais que :value caracteres.',
        'array' => 'O campo deve ter mais que :value itens.',
    ],
    'gte' => [
        'numeric' => 'O campo deve ser maior ou igual à :value.',
        'file' => 'The O campo deve ter mais ou ser igual à :value kilobytes.',
        'string' => 'The O campo deve ter mais ou ser igual à :value caracteres.',
        'array' => 'The O campo deve ter :value itens ou mais.',
    ],
    'image' => 'O campo deve ser uma imagem.',
    'in' => 'O campo selecionado é inválido.',
    'in_array' => 'O campo O campo não existe em :other.',
    'integer' => 'O campo deve ser do tipo inteiro.',
    'ip' => 'O campo deve ser um endereço de IP válido.',
    'ipv4' => 'O campo deve ser um endereço IPv4 válido.',
    'ipv6' => 'O campo deve ser um endereço IPv6 válido.',
    'json' => 'O campo deve ser um texto JSON válido.',
    'lt' => [
        'numeric' => 'O campo deve ser menor que :value.',
        'file' => 'O campo deve ter menos que :value kilobytes.',
        'string' => 'O campo deve ter menos que :value caracteres.',
        'array' => 'O campo deve ter menos que :value itens.',
    ],
    'lte' => [
        'numeric' => 'O campo deve ser menor ou igual à :value.',
        'file' => 'O campo deve ter menos ou no máximo :value kilobytes.',
        'string' => 'O campo deve ter menos ou no máximo :value caracteres.',
        'array' => 'O campo não pode ter mais que :value itens.',
    ],
    'max' => [
        'numeric' => 'O campo não pode ser maior que :max.',
        'file' => 'O campo não pode ter mais que :max kilobytes.',
        'string' => 'O campo não pode ter mais que :max caracteres.',
        'array' => 'O campo não pode ter mais que :max itens.',
    ],
    'mimes' => 'O campo deve ser um arquivo do tipo: :values.',
    'mimetypes' => 'O campo deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O campo deve ser no mínimo :min.',
        'file' => 'O campo deve ter no mínimo :min kilobytes.',
        'string' => 'O campo deve ter no mínimo :min caracteres.',
        'array' => 'O campo deve ter no mínimo :min itens.',
    ],
    'not_in' => 'O campo selecionado é inválido.',
    'not_regex' => 'O formato dO campo é inválido.',
    'numeric' => 'O campo deve ser um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'O campo deve ser no presente.',
    'regex' => 'O formato do O campo é inválido.',
    'required' => 'O campo é obrigatório.',
    'required_if' => 'O campo O campo é obrigatório quando :other for :value.',
    'required_unless' => 'O campo O campo é obrigatório quando a menos que :other esteja em :values.',
    'required_with' => 'O campo O campo é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo O campo é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo O campo é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo O campo é obrigatório quando nenhum dos :values estão presentes.',
    'same' => 'O campo e :other devem ser iguais.',
    'size' => [
        'numeric' => 'O campo deve ser do tamanho :size.',
        'file' => 'O campo deve ter :size kilobytes.',
        'string' => 'O campo deve ter :size caracteres.',
        'array' => 'O campo deve ter :size itens.',
    ],
    'starts_with' => 'O campo deve começar com um do valores a seguir: :values.',
    'string' => 'O campo deve ser um texto.',
    'timezone' => 'O campo deve ser um fuso horário válido.',
    'unique' => 'O campo já existe.',
    'uploaded' => 'Falha ao realizar o upload de O campo',
    'url' => 'O formato de O campo é inválido.',
    'uuid' => 'O campo deve ser um UUID válido.',
    'invalid_card' => 'Cartão inválido',
    'username' => 'Este nome de usuário já está em uso',
    'no_space' => 'Esse campo não pode conter espaços',

    /*
    |--------------------------------------------------------------------------
    | Linhas de Idioma para Validação Customizadas
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar mensagens de validações customizadas para 
    | atributos, usando a convenção "atributo.regra" para nomear as linhas. 
    | Isso facilita para especificar uma linha customizada de um idioma 
    | para uma regra do atributo especifico
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atributos de Validação Customizados
    |--------------------------------------------------------------------------
    |
    | As linhas de idioma a seguir são usadas para trocar o nosso atributo placeholder
    | com algo que seja melhor para ler como "Endereço de Email" invés de "email".
    | Isso simplesmente nós ajuda a tornar nossa mensagem mais expressiva. 
    |
    */

    'attributes' => [],

];
