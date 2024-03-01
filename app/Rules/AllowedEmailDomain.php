<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedEmailDomain implements Rule
{
    /**
     * The domain that is allowed.
     *
     * @var string
     */
    protected $allowedDomain;

    /**
     * Create a new rule instance.
     *
     * @param  string  $allowedDomain
     * @return void
     */
    public function __construct(string $allowedDomain)
    {
        $this->allowedDomain = $allowedDomain;
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
        return substr(strrchr($value, "@"), 1) === $this->allowedDomain;
    }

    /**
     * Get the validation error message.
     *
     * @param  string  $attribute
     * @return string
     */
    public function message()
    {
        return "The email domain is not recognized.";
    }
}
