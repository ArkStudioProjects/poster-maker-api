<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;

class CreateTestDesign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-design';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a new design for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $token = $user->createToken('test', ['*'])->plainTextToken;

        $response = Http::withToken($token)
            ->withOptions([
                'allow_redirects' => false,
            ])
            ->post(
                route('items.store'),
                [
                    'title' => 'Test Design',
                    'category' => Category::first()->id,
                    'preview' => base64_encode(file_get_contents('https://placehold.co/595x842.jpg?text=Hello%20World')),
                    'data' => [
                        'bg_image' => base64_encode(file_get_contents('https://placehold.co/595x842.jpg?text=_')),
                        'items' => [
                            [
                                'key' => '4:139',
                                'angle' => 0,
                                'offset' => [
                                    'dx' => 64,
                                    'dy' => 734
                                ],
                                'opacity' => 1,
                                'text_data' => [
                                    'text' => 'Not gonna match the preview',
                                    'width' => 78,
                                    'height' => 39,
                                    'text_align' => 'LEFT',
                                    'text_style' => [
                                        'color' => '#000000',
                                        'fontSize' => 26,
                                        'textCase' => 'ORIGINAL',
                                        'fontStyle' => null,
                                        'fontFamily' => 'Poppins',
                                        'fontWeight' => 400,
                                        'lineHeight' => 30,
                                        'letterSpacing' => 0,
                                        'textDecoration' => 'NONE'
                                    ],
                                    'text_stroke_color' => null,
                                    'text_stroke_width' => 1
                                ]
                            ]
                        ]
                    ]
                ]
            );

        dd($response->status(), $response->body() );
    }
}