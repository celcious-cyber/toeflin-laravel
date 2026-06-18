<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\TestPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@toeflin.com',
            'passwordHash' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Student User',
            'email' => 'student@toeflin.com',
            'passwordHash' => bcrypt('password'),
            'role' => 'student',
            'nim' => '12345678',
            'fakultas' => 'Teknik',
            'prodi' => 'Informatika',
        ]);
        
        $dummyQuestions = [
            [
                'id' => Str::uuid()->toString(),
                'section' => 'Listening',
                'content' => 'What is the man talking about?',
                'choices' => ['a' => 'A new book', 'b' => 'His recent trip', 'c' => 'A computer problem', 'd' => 'The weather'],
                'answerKey' => 'c',
                'shuffledEntries' => [['a', 'A new book'], ['b', 'His recent trip'], ['c', 'A computer problem'], ['d', 'The weather']],
                'audio' => ['fileUrl' => '/audio-test.mp3']
            ],
            [
                'id' => Str::uuid()->toString(),
                'section' => 'Structure',
                'content' => 'The committee _____ tomorrow to discuss the new policy.',
                'choices' => ['a' => 'meets', 'b' => 'meeting', 'c' => 'will met', 'd' => 'are meet'],
                'answerKey' => 'a',
                'shuffledEntries' => [['a', 'meets'], ['b', 'meeting'], ['c', 'will met'], ['d', 'are meet']]
            ],
            [
                'id' => Str::uuid()->toString(),
                'section' => 'Reading',
                'content' => 'Based on the passage, why did the author leave the city?',
                'choices' => ['a' => 'To find a new job', 'b' => 'To be closer to nature', 'c' => 'Because of the noise', 'd' => 'To visit family'],
                'answerKey' => 'b',
                'shuffledEntries' => [['a', 'To find a new job'], ['b', 'To be closer to nature'], ['c', 'Because of the noise'], ['d', 'To visit family']],
                'passage' => [
                    'title' => 'A Retreat to the Woods',
                    'content' => 'After spending ten years in the bustling city, the constant noise and pollution finally took their toll. I decided to pack my bags and move to a small cabin in the woods, seeking tranquility and a closer connection to nature.'
                ]
            ]
        ];

        TestPackage::create([
            'id' => Str::uuid()->toString(),
            'name' => 'TOEFL ITP Simulation - Practice Test 1',
            'type' => 'Full Test',
            'questions' => $dummyQuestions,
            'durations' => ['listening' => 35, 'structure' => 25, 'reading' => 55],
            'status' => 'published',
        ]);
        
        TestPackage::create([
            'id' => Str::uuid()->toString(),
            'name' => 'TOEFL ITP Simulation - Practice Test 2',
            'type' => 'Mini Test',
            'questions' => [],
            'durations' => ['listening' => 10, 'structure' => 10, 'reading' => 10],
            'status' => 'published',
        ]);
    }
}
