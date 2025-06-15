<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guard>
 */
class GuardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a fake Malaysian NRIC (YYMMDD#######)
        $dob = $this->faker->dateTimeBetween('-60 years', '-18 years');
        $dobFormatted = $dob->format('ymd');
        $randomDigits = str_pad((string) random_int(0, 9999999), 7, '0', STR_PAD_LEFT);
        $nric = $dobFormatted . $randomDigits;
        
        return [
            //
            'nric_hash'   => hash('sha256', $nric),
            'nric_cipher' => Crypt::encryptString($nric),
            'nric_last4'  => substr($nric, -4),
            'full_name'   => $this->faker->name,
            'dob'         => $dob->format('Y-m-d'),
            'photo_path'  => null,
            'contact_no'  => $this->faker->phoneNumber,
            'email'       => $this->faker->safeEmail,
            'gender'      => $this->faker->randomElement(['M', 'F']),
            'blood_type'  => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'remarks'     => $this->faker->optional()->sentence,

        ];
    }
}
