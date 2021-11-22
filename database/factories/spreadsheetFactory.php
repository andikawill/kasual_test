<?php

namespace Database\Factories;

use App\Models\spreadsheet;
use Illuminate\Database\Eloquent\Factories\Factory;

class spreadsheetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = spreadsheet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            '[first_name,' => $this->faker->word,
        '[last_name,' => $this->faker->word,
        '[gender,' => $this->faker->word,
        '[email,' => $this->faker->word,
        '[ip_address,' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
