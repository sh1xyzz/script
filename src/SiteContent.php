<?php
declare(strict_types=1);

class SiteContent
{
    public static function getDefaultTracks(): array
    {
        return [
            new Track([
                'id' => 0,
                'title' => 'English FastTalk',
                'slug' => 'english-fasttalk',
                'short_description' => 'Boost spoken fluency for interviews, travel, and everyday conversations.',
                'level_description' => 'A1–C1 trajectory',
                'created_at' => date('Y-m-d H:i:s'),
            ]),
            new Track([
                'id' => 0,
                'title' => 'German StartKraft',
                'slug' => 'german-startkraft',
                'short_description' => 'Learn practical German with clear structure, conversation tasks, and coach support.',
                'level_description' => 'A1–B2 trajectory',
                'created_at' => date('Y-m-d H:i:s'),
            ]),
            new Track([
                'id' => 0,
                'title' => 'Spanish VivaVoice',
                'slug' => 'spanish-vivavoice',
                'short_description' => 'Move from passive vocabulary to active conversations with daily speaking practice.',
                'level_description' => 'A1–B1 trajectory',
                'created_at' => date('Y-m-d H:i:s'),
            ]),
        ];
    }

    public static function getContentSections(): array
    {
        return [
            'about' => [
                [
                    'topline' => 'Approach',
                    'title' => 'Practice-first curriculum',
                    'description' => 'Every week has a speaking target and small, measurable outcomes so progress is visible and motivating.',
                ],
                [
                    'topline' => 'Coaching',
                    'title' => 'Human feedback',
                    'description' => 'Small groups allow coaches to give immediate, actionable feedback that sticks.',
                ],
                [
                    'topline' => 'Results',
                    'title' => 'Real conversations',
                    'description' => 'We prioritize spoken fluency and usable phrases over exhaustive grammar lists.',
                ],
            ],
            'features' => [
                [
                    'topline' => 'Micro-practice',
                    'title' => 'Short drills',
                    'description' => 'Five-minute micro-drills built into lessons increase retention and confidence.',
                ],
                [
                    'topline' => 'Progress',
                    'title' => 'Visible checkpoints',
                    'description' => 'Weekly checkpoints help students track growth and stay accountable.',
                ],
                [
                    'topline' => 'Flex',
                    'title' => 'Hybrid delivery',
                    'description' => 'Attend live online classes or join hybrid studio sessions depending on your schedule.',
                ],
            ],
            'testimonials' => [
                [
                    'topline' => 'Student story',
                    'title' => '"I speak with less hesitation"',
                    'description' => 'After two weeks I stopped translating in my head and began responding naturally in conversations.',
                ],
                [
                    'topline' => 'Student story',
                    'title' => '"Real improvement"',
                    'description' => 'The small squads made feedback feel personal and useful — I improved faster than on previous courses.',
                ],
                [
                    'topline' => 'Student story',
                    'title' => '"Practical and focused"',
                    'description' => 'Lessons are always aimed at usable output, not just theory. I felt progress every session.',
                ],
            ],
            'faq' => [
                [
                    'topline' => 'Format',
                    'title' => 'How long are classes?',
                    'description' => 'Sessions are typically 60 minutes, with short drills before and after for reinforcement.',
                ],
                [
                    'topline' => 'Levels',
                    'title' => 'Can beginners join?',
                    'description' => 'Yes — tracks include starter-friendly entry points and diagnostic checks to place you correctly.',
                ],
                [
                    'topline' => 'Cost',
                    'title' => 'Are trials free?',
                    'description' => 'First diagnostic sessions are free; follow-up plans are presented after the trial.',
                ],
            ],
        ];
    }

    public static function getTrackCompare(): array
    {
        return [
            'English FastTalk' => [
                'format' => 'Live online + coaching',
                'level' => 'A1–C1',
                'intensity' => 'High',
                'duration' => '8 weeks',
            ],
            'German StartKraft' => [
                'format' => 'Hybrid group sessions',
                'level' => 'A1–B2',
                'intensity' => 'Medium',
                'duration' => '10 weeks',
            ],
            'Spanish VivaVoice' => [
                'format' => 'Conversation labs',
                'level' => 'A1–B1',
                'intensity' => 'Medium-low',
                'duration' => '6 weeks',
            ],
        ];
    }

    public static function getQuizQuestions(): array
    {
        return [
            [
                'question' => 'What is your main learning priority?',
                'options' => ['Speak confidently', 'Prepare for travel', 'Pass an exam'],
            ],
            [
                'question' => 'How much practice can you commit each week?',
                'options' => ['1–2 hours', '3–5 hours', '5+ hours'],
            ],
            [
                'question' => 'What feels most motivating?',
                'options' => ['Live interaction', 'Structured lessons', 'Personal coaching'],
            ],
        ];
    }
}
