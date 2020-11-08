<?php

namespace Bageur\Auth\Rules;
use Illuminate\Contracts\Validation\Rule;

class checkUserByemail implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cek = \Bageur\Auth\model\user::where('email',$value)->count();
        if($cek > 0){
            return  true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kami tidak menemukan email yang anda masukan';
    }
}
