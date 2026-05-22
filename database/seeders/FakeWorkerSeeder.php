<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\WorkerProfile;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FakeWorkerSeeder extends Seeder
{
    public function run(): void
    {
        $workers = [
            ['name' => 'Amine Rezgui', 'cat' => 'Painting', 'city' => 'Casablanca', 'price' => 160, 'unit' => 'per_day', 'exp' => 7, 'rating' => 4.5, 'reviews' => 15],
            ['name' => 'Nour El Houda', 'cat' => 'Painting', 'city' => 'Rabat', 'price' => 180, 'unit' => 'per_day', 'exp' => 9, 'rating' => 4.7, 'reviews' => 22],
            ['name' => 'Samir Bennis', 'cat' => 'Painting', 'city' => 'Tangier', 'price' => 140, 'unit' => 'per_day', 'exp' => 5, 'rating' => 4.3, 'reviews' => 11],
            ['name' => 'Malak Idrissi', 'cat' => 'Painting', 'city' => 'Marrakech', 'price' => 200, 'unit' => 'per_day', 'exp' => 12, 'rating' => 4.9, 'reviews' => 35],
            ['name' => 'Ismail Gharbi', 'cat' => 'Plumbing', 'city' => 'Fes', 'price' => 180, 'unit' => 'per_day', 'exp' => 11, 'rating' => 4.6, 'reviews' => 20],
            ['name' => 'Kawtar El Alami', 'cat' => 'Plumbing', 'city' => 'Tangier', 'price' => 160, 'unit' => 'per_day', 'exp' => 6, 'rating' => 4.4, 'reviews' => 13],
            ['name' => 'Hicham Bennani', 'cat' => 'Plumbing', 'city' => 'Agadir', 'price' => 220, 'unit' => 'per_day', 'exp' => 15, 'rating' => 4.8, 'reviews' => 40],
            ['name' => 'Mouna Tazi', 'cat' => 'Electrical', 'city' => 'Casablanca', 'price' => 230, 'unit' => 'per_day', 'exp' => 9, 'rating' => 4.6, 'reviews' => 18],
            ['name' => 'Adil Benchekroun', 'cat' => 'Electrical', 'city' => 'Fes', 'price' => 200, 'unit' => 'per_day', 'exp' => 7, 'rating' => 4.5, 'reviews' => 14],
            ['name' => 'Chaimae El Fassi', 'cat' => 'Electrical', 'city' => 'Meknes', 'price' => 260, 'unit' => 'per_day', 'exp' => 10, 'rating' => 4.7, 'reviews' => 25],
            ['name' => 'Saida Amrani', 'cat' => 'Carpentry', 'city' => 'Casablanca', 'price' => 200, 'unit' => 'per_day', 'exp' => 14, 'rating' => 4.8, 'reviews' => 30],
            ['name' => 'Taha Bennis', 'cat' => 'Carpentry', 'city' => 'Rabat', 'price' => 170, 'unit' => 'per_day', 'exp' => 8, 'rating' => 4.5, 'reviews' => 16],
            ['name' => 'Rim Kabbaj', 'cat' => 'Cleaning', 'city' => 'Casablanca', 'price' => 120, 'unit' => 'per_day', 'exp' => 6, 'rating' => 4.6, 'reviews' => 19],
            ['name' => 'Walid Mouline', 'cat' => 'Cleaning', 'city' => 'Marrakech', 'price' => 130, 'unit' => 'per_day', 'exp' => 4, 'rating' => 4.4, 'reviews' => 12],
            ['name' => 'Lamiae Berrada', 'cat' => 'Gardening', 'city' => 'Rabat', 'price' => 110, 'unit' => 'per_day', 'exp' => 5, 'rating' => 4.5, 'reviews' => 14],
            ['name' => 'Aziz Ouazzani', 'cat' => 'Gardening', 'city' => 'Marrakech', 'price' => 140, 'unit' => 'per_day', 'exp' => 8, 'rating' => 4.7, 'reviews' => 22],
            ['name' => 'Siham El Amrani', 'cat' => 'Tiling', 'city' => 'Casablanca', 'price' => 200, 'unit' => 'per_square_meter', 'exp' => 11, 'rating' => 4.7, 'reviews' => 24],
            ['name' => 'Jawad Rezgui', 'cat' => 'Tiling', 'city' => 'Fes', 'price' => 170, 'unit' => 'per_square_meter', 'exp' => 7, 'rating' => 4.5, 'reviews' => 15],
            ['name' => 'Najat Chraibi', 'cat' => 'AC Repair', 'city' => 'Marrakech', 'price' => 350, 'unit' => 'per_project', 'exp' => 8, 'rating' => 4.6, 'reviews' => 18],
            ['name' => 'Kamal Alaoui', 'cat' => 'AC Repair', 'city' => 'Rabat', 'price' => 280, 'unit' => 'per_project', 'exp' => 5, 'rating' => 4.3, 'reviews' => 10],
            ['name' => 'Houda Benali', 'cat' => 'Makeup Artist', 'city' => 'Tangier', 'price' => 450, 'unit' => 'per_session', 'exp' => 7, 'rating' => 4.7, 'reviews' => 34],
            ['name' => 'Douae Fassi', 'cat' => 'Makeup Artist', 'city' => 'Fes', 'price' => 380, 'unit' => 'per_session', 'exp' => 5, 'rating' => 4.5, 'reviews' => 22],
            ['name' => 'Marouane Tazi', 'cat' => 'Photography', 'city' => 'Fes', 'price' => 1200, 'unit' => 'per_event', 'exp' => 6, 'rating' => 4.6, 'reviews' => 29],
            ['name' => 'Ghita Bennis', 'cat' => 'Photography', 'city' => 'Rabat', 'price' => 1800, 'unit' => 'per_event', 'exp' => 10, 'rating' => 4.9, 'reviews' => 52],
            ['name' => 'Fouad Amrani', 'cat' => 'Auto Mechanic', 'city' => 'Meknes', 'price' => 220, 'unit' => 'per_hour', 'exp' => 14, 'rating' => 4.7, 'reviews' => 65],
            ['name' => 'Salma Chraibi', 'cat' => 'Interior Design', 'city' => 'Rabat', 'price' => 1600, 'unit' => 'per_project', 'exp' => 7, 'rating' => 4.6, 'reviews' => 28],
            ['name' => 'Younes Kabbaj', 'cat' => 'Tailoring', 'city' => 'Marrakech', 'price' => 110, 'unit' => 'per_piece', 'exp' => 14, 'rating' => 4.7, 'reviews' => 55],
            ['name' => 'Safa Ouazzani', 'cat' => 'Computer Repair', 'city' => 'Marrakech', 'price' => 140, 'unit' => 'per_hour', 'exp' => 5, 'rating' => 4.5, 'reviews' => 18],
            ['name' => 'Mouad Berrada', 'cat' => 'Tutoring', 'city' => 'Fes', 'price' => 110, 'unit' => 'per_hour', 'exp' => 12, 'rating' => 4.8, 'reviews' => 65],
            ['name' => 'Ines El Amrani', 'cat' => 'Pet Care', 'city' => 'Rabat', 'price' => 60, 'unit' => 'per_visit', 'exp' => 3, 'rating' => 4.4, 'reviews' => 14],
            ['name' => 'Yahya Benjelloun', 'cat' => 'Security Guard', 'city' => 'Casablanca', 'price' => 180, 'unit' => 'per_day', 'exp' => 9, 'rating' => 4.5, 'reviews' => 22],
            ['name' => 'Maha Tazi', 'cat' => 'Security Guard', 'city' => 'Rabat', 'price' => 220, 'unit' => 'per_day', 'exp' => 7, 'rating' => 4.6, 'reviews' => 18],
            ['name' => 'Ilyas Mouline', 'cat' => 'Driver', 'city' => 'Fes', 'price' => 280, 'unit' => 'per_day', 'exp' => 8, 'rating' => 4.5, 'reviews' => 31],
            ['name' => 'Rania Benali', 'cat' => 'Welding', 'city' => 'Casablanca', 'price' => 270, 'unit' => 'per_day', 'exp' => 10, 'rating' => 4.7, 'reviews' => 24],
            ['name' => 'Hatim Kabbaj', 'cat' => 'Welding', 'city' => 'Tangier', 'price' => 230, 'unit' => 'per_day', 'exp' => 7, 'rating' => 4.5, 'reviews' => 16],
            ['name' => 'Lubna Amrani', 'cat' => 'Masonry', 'city' => 'Casablanca', 'price' => 220, 'unit' => 'per_day', 'exp' => 15, 'rating' => 4.7, 'reviews' => 38],
            ['name' => 'Sami El Alami', 'cat' => 'Masonry', 'city' => 'Marrakech', 'price' => 190, 'unit' => 'per_day', 'exp' => 9, 'rating' => 4.5, 'reviews' => 20],
            ['name' => 'Nisrine Gharbi', 'cat' => 'Roofing', 'city' => 'Casablanca', 'price' => 320, 'unit' => 'per_day', 'exp' => 12, 'rating' => 4.7, 'reviews' => 30],
            ['name' => 'Adnane Bennis', 'cat' => 'Roofing', 'city' => 'Rabat', 'price' => 280, 'unit' => 'per_day', 'exp' => 7, 'rating' => 4.4, 'reviews' => 14],
            ['name' => 'Farah Idrissi', 'cat' => 'Pest Control', 'city' => 'Rabat', 'price' => 180, 'unit' => 'per_treatment', 'exp' => 6, 'rating' => 4.5, 'reviews' => 22],
            ['name' => 'Ayoub Tazi', 'cat' => 'Pest Control', 'city' => 'Marrakech', 'price' => 220, 'unit' => 'per_treatment', 'exp' => 5, 'rating' => 4.6, 'reviews' => 16],
            ['name' => 'Wiam Fassi', 'cat' => 'Locksmith', 'city' => 'Casablanca', 'price' => 140, 'unit' => 'per_service', 'exp' => 8, 'rating' => 4.6, 'reviews' => 35],
            ['name' => 'Achraf Chraibi', 'cat' => 'Locksmith', 'city' => 'Marrakech', 'price' => 160, 'unit' => 'per_service', 'exp' => 10, 'rating' => 4.8, 'reviews' => 42],
            ['name' => 'Sara Mouline', 'cat' => 'School Cook', 'city' => 'Tangier', 'price' => 32, 'unit' => 'per_child', 'exp' => 6, 'rating' => 4.6, 'reviews' => 28],
            ['name' => 'Yasser Benali', 'cat' => 'Moving Services', 'city' => 'Casablanca', 'price' => 450, 'unit' => 'per_move', 'exp' => 8, 'rating' => 4.6, 'reviews' => 32],
        ];

        $cities = ['Casablanca', 'Rabat', 'Marrakech', 'Fes', 'Tangier', 'Agadir', 'Meknes', 'Oujda', 'Kenitra', 'Tetouan'];

        foreach ($workers as $w) {
            $category = Category::where('name', $w['cat'])->first();
            if (!$category) continue;

            $email = strtolower(str_replace([' ', '\''], ['.', ''], $w['name'])) . '@mail.com';

            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $w['name'], 'password' => Hash::make('password'), 'role' => 'worker']
            );
            if (!$user->wasRecentlyCreated) continue;

            $profile = WorkerProfile::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'phone' => '+212 6' . rand(10, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
                'bio' => "Experienced {$category->name} professional serving {$w['city']} and surrounding areas. Quality work guaranteed.",
                'price_per_unit' => $w['price'],
                'price_unit' => $w['unit'],
                'city' => $w['city'],
                'experience_years' => $w['exp'],
                'is_available' => true,
                'is_verified' => $w['rating'] >= 4.6,
                'instant_booking' => $w['reviews'] > 20,
                'response_time' => ['< 1 hour', '< 2 hours', '< 4 hours', '< 1 day'][array_rand(['< 1 hour', '< 2 hours', '< 4 hours', '< 1 day'])],
                'badges' => $w['rating'] >= 4.8 ? ['top_rated', 'verified'] : ($w['rating'] >= 4.5 ? ['verified'] : []),
                'rating' => $w['rating'],
                'total_reviews' => $w['reviews'],
            ]);

            $clientEmail = 'client.' . strtolower(str_replace([' ', '\''], ['.', ''], $w['name'])) . '@mail.com';
            $client = User::firstOrCreate(
                ['email' => $clientEmail],
                ['name' => 'Client ' . $w['name'], 'password' => Hash::make('password'), 'role' => 'client']
            );

            Review::create([
                'user_id' => $client->id,
                'worker_profile_id' => $profile->id,
                'rating' => round($w['rating']),
                'comment' => ['Excellent work! Very professional.', 'Great service, highly recommend!', 'Very satisfied with the quality.', 'Professional and on time. Will hire again.', 'Good work at a fair price.'][array_rand([0,1,2,3,4])],
            ]);
        }

        $this->command->info('Fake workers seeded successfully!');
    }
}
