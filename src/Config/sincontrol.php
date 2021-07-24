<?php

use Illuminate\Support\Facades\URL;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This value is the default currency that is going to be used in invoices.
    | You can change it on each invoice individually.
    */

    'currency' => 'BOB',

    /*
    |--------------------------------------------------------------------------
    | Default Decimal Precision
    |--------------------------------------------------------------------------
    |
    | This value is the default decimal precision that is going to be used
    | to perform all the calculations.
    */

   'decimals' => 2,

   
   /*
   |--------------------------------------------------------------------------
   | Default Invoice Logo
   |--------------------------------------------------------------------------
   |
   | This value is the default invoice logo that is going to be used in invoices.
   | You can change it on each invoice individually.
   */

  'logo' => file_exists(public_path().'/'.env('COMP_LOGO_URL', 'images/logo.png')) 
    ?base64_encode(file_get_contents(public_path().'/'.env('COMP_LOGO_URL', 'images/logo.png')))
    :'iVBORw0KGgoAAAANSUhEUgAAASwAAACCCAMAAADLwgVtAAAAS1BMVEX///+srKzW1tZtbW3Nzc3n5+fe3t7v7++GhoaRkZH8/Pympqb39/fy8vL19fXDw8O6urq2tracnJx6enrd3d3k5OTJycmysrLR0dGBIgWKAAAEVUlEQVR4nO2bDZeiIBSGSQTKxY8atf7/L11IEEw02z0zNt33OWfWDaGj79HHKyZjAAAAAAAAAAAAAAAAAAAAAADwTlR9nYli7634JdQHCwLbgj6MNDcEtk53mNDcOr33Jr0vt8MMBLZEMw8LgS2g01kNgeUIbEK3EtYQmKz23sa3wSnrXMr+vBTYGYENOGX19v+VzJcD69ty723dG6+s1jdUXb6gfBtYt+e27o5Xloob9XJg2V4b+g44ZV1nK3R3SwVW77CNb0OzlkEisNsPb9+7oIUYlbV8dhViEhhJaRVKZlk5Kkusdw6BESxSyy6zFOON4fPJhmEip/mBjXsrKpENtKOyNmRwJagsLdrME5T1PINyy+n6UdxFFdiqLEu79XT9EJyoAgXLN2u7p6QsLbJH0soqRJ4nxp/JKKtQ7SyqWFljOoXor8mzsiKjLJVIaqKsodIsun645B3OsZrMoSZ8TwLKSmcVKauKk5ocalra5sr1pKCs1DmYZXJU1pmxPEpqPN/KrPbrGzLKmrt9qqyeFYcHzoUKt4S570lAWUw/UVbLxGNYh/hIk349AWUxJlNhBWWVLJuFFVO5W0gKykpfDoOyrv4ueQFSyjKXulVl1feJ98UnFUZZTmkUlGV4vNGZKMtN/C1OvHeklGWLgBVlRQ+ekxPv2imNzPT7rNSS/nbPi2l8jqqn88hWWXV8BH4+s1JL+Nu9OJZeuueo8cR77if+iCgrUWqVTCYFFR48F2Io4DumSCmLzUutSFkzrpPAtJv4I6OsWan1qKxUYOND6p6WsmalVkpZ88DqITBiymKPpVa1oKxEYBmduayRaalVuHNrO4SUxaal1lNlzSGkLDYttTYpawolZU1Lrc3KGrlSUhablFpQ1jNCqQVlPaWAsl5gLLVUYtJ9HWrKikotwfT1eUAx1JTFQqnVmuCSP69dhJqyWFRq3Q308GvRVdSzr/48QqnlX8LcGBg9ZTFfakk12Xc/y7cCQWUxVhlfqdRRYgNbcT5BZVlWzqdCLQZGUFlbSAZGUlkbUe1DYCSV9QKqjX7cRlRZL1G27uVW8m9lbsQEVpN8uQkAAAAAAAAAAFm4fH1MzfnyM+h/+cLfAk+987zIZRhTrwTy2hf+Lty+qRM/ifuCn5T/ZLhwfpTjasmFfduCN2MXexyZP9/NLAmEdfwj/hzN4iKkaXGf7OpaXLl2DdJE0TBt/uW+ix1u/ly300XKzw9LGAkpLu3CtLhPbrUe2m1Dzv0Y3+LDundTw/Ad9+abGfbtngLPpwu/OjSEsHxLCGs67jMZ9k1yYyEu7MK0uE9+dWgIYfkWnkVhueE77s03wxshhGJfg4LMwkrnKzhrOHJcgzRnpGt0LcZSIhxgbvjHkltdn5g43i9uZvFljXT0V0N3tXMN+sK/XKMfYC6fR+W7yeP9YkqHjFPa2//CHDB4wrwVXZP7MS0AAAAAAAAAAAAAAAAAAAD4Mf4C4/Us4uEQYQwAAAAASUVORK5CYII=',

  /*
  |--------------------------------------------------------------------------
  | Default Invoice Logo Height
  |--------------------------------------------------------------------------
  |
  | This value is the default invoice logo height that is going to be used in invoices.
  | You can change it on each invoice individually.
  */

 'logo_height' => 60,

  /*
  |--------------------------------------------------------------------------
  | Default Invoice Buissness Details
  |--------------------------------------------------------------------------
  |
  | This value is going to be the default attribute displayed in
  | the customer model.
  */

  'business_details' => [
      'name'        => env('COMP_NAME', 'MI EMPRESA/SUCURSAL'),
      'id'          => env('COMP_NIT', '00000'),
      'phone'       => env('COMP_TELEFONO', '99-99999'),
      'location'    => env('COMP_DIRECCION', 'Calle S/N'),
      'zip'         => '00000',
      'city'        => env('COMP_CIUDAD', 'Tarija'),
      'country'     => env('COMP_PAIS', 'Bolivia'),
  ],

  /*
  |--------------------------------------------------------------------------
  | Default Invoice Footnote
  |--------------------------------------------------------------------------
  |
  | This value is going to be at the end of the document, sometimes telling you
  | some copyright message or simple legal terms.
  */

  'footnote' => '',

  /*
  |--------------------------------------------------------------------------
  | Default Tax Rates
  |--------------------------------------------------------------------------
  |
  | This array group multiple tax rates.
  |
  | The tax type accepted values are: 'percentage' and 'fixed'.
  | The percentage type calculates the tax depending on the invoice price, and
  | the fixed type simply adds a fixed ammount to the total price.
  | You can't mix percentage and fixed tax rates.
  */
  'tax_rates' => [
    [
        'name'      => '',
        'tax'       => 0,
        'tax_type'  => 'percentage',
    ],
  ],
  
  /*
  | Default Invoice Due Date
  |--------------------------------------------------------------------------
  |
  | This value is the default due date that is going to be used in invoices.
  | You can change it on each invoice individually.
  | You can set it null to remove the due date on all invoices.
  */
  'due_date' => date('M dS ,Y',strtotime('+3 months')),

  /*
  | Default pagination parameter
  |--------------------------------------------------------------------------
  |
  | This value is the default pagination parameter.
  | If true and page count are higher than 1, pagination will show at the bottom.
  */
  'with_pagination' => true,

  /*
  | Duplicate header parameter
  |--------------------------------------------------------------------------
  |
  | This value is the default header parameter.
  | If true header will be duplicated on each page.
  */
  'duplicate_header' => false,

];