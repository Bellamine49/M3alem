<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\WorkerProfile;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Painting', 'slug' => 'painting', 'description' => 'Professional house and wall painting services', 'icon' => '🎨'],
            ['name' => 'Plumbing', 'slug' => 'plumbing', 'description' => 'Water pipe repair, installation and maintenance', 'icon' => '🔧'],
            ['name' => 'Electrical', 'slug' => 'electrical', 'description' => 'Electrical wiring, installation and repair', 'icon' => '⚡'],
            ['name' => 'Carpentry', 'slug' => 'carpentry', 'description' => 'Wood work, furniture and door repairs', 'icon' => ''],
            ['name' => 'Cleaning', 'slug' => 'cleaning', 'description' => 'House and office cleaning services', 'icon' => '🧹'],
            ['name' => 'Gardening', 'slug' => 'gardening', 'description' => 'Garden maintenance and landscaping', 'icon' => '🌿'],
            ['name' => 'Tiling', 'slug' => 'tiling', 'description' => 'Floor and wall tiling services', 'icon' => '🔲'],
            ['name' => 'AC Repair', 'slug' => 'ac-repair', 'description' => 'Air conditioning installation and repair', 'icon' => '❄️'],
            ['name' => 'Makeup Artist', 'slug' => 'makeup-artist', 'description' => 'Professional makeup for weddings, events and photoshoots', 'icon' => '💄'],
            ['name' => 'School Cook', 'slug' => 'school-cook', 'description' => 'Healthy meals for children during school breaks', 'icon' => '🍳'],
            ['name' => 'Photography', 'slug' => 'photography', 'description' => 'Event, portrait and product photography', 'icon' => '📷'],
            ['name' => 'Auto Mechanic', 'slug' => 'auto-mechanic', 'description' => 'Car repair, maintenance and diagnostics', 'icon' => ''],
            ['name' => 'Moving Services', 'slug' => 'moving-services', 'description' => 'Home and office moving with packing', 'icon' => '📦'],
            ['name' => 'Interior Design', 'slug' => 'interior-design', 'description' => 'Home decoration and space planning', 'icon' => '️'],
            ['name' => 'Tailoring', 'slug' => 'tailoring', 'description' => 'Clothing alterations and custom sewing', 'icon' => '🧵'],
            ['name' => 'Computer Repair', 'slug' => 'computer-repair', 'description' => 'PC and laptop repair and maintenance', 'icon' => '💻'],
            ['name' => 'Tutoring', 'slug' => 'tutoring', 'description' => 'Private lessons for all subjects and levels', 'icon' => '📚'],
            ['name' => 'Pet Care', 'slug' => 'pet-care', 'description' => 'Pet grooming, walking and sitting services', 'icon' => '🐾'],
            ['name' => 'Security Guard', 'slug' => 'security-guard', 'description' => 'Event and property security services', 'icon' => '🛡️'],
            ['name' => 'Driver', 'slug' => 'driver', 'description' => 'Personal driver and chauffeur services', 'icon' => ''],
            ['name' => 'Welding', 'slug' => 'welding', 'description' => 'Metal welding and fabrication work', 'icon' => '🔩'],
            ['name' => 'Masonry', 'slug' => 'masonry', 'description' => 'Brick, stone and concrete construction', 'icon' => ''],
            ['name' => 'Roofing', 'slug' => 'roofing', 'description' => 'Roof repair, installation and waterproofing', 'icon' => '🏠'],
            ['name' => 'Pest Control', 'slug' => 'pest-control', 'description' => 'Insect and rodent removal services', 'icon' => '🐜'],
            ['name' => 'Locksmith', 'slug' => 'locksmith', 'description' => 'Lock repair, key duplication and emergency opening', 'icon' => ''],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $workers = [
            ['name' => 'Ahmed Benali', 'email' => 'ahmed@mail.com', 'category' => 'Painting', 'phone' => '+212 661 123 456', 'bio' => 'Expert painter with 10 years of experience. Specialized in interior and exterior house painting.', 'price' => 150, 'unit' => 'per_day', 'city' => 'Casablanca', 'experience' => 10, 'rating' => 4.8, 'reviews' => 24],
            ['name' => 'Youssef Amrani', 'email' => 'youssef@mail.com', 'category' => 'Plumbing', 'phone' => '+212 662 234 567', 'bio' => 'Licensed plumber. Emergency repairs, installations, and maintenance.', 'price' => 200, 'unit' => 'per_day', 'city' => 'Rabat', 'experience' => 8, 'rating' => 4.5, 'reviews' => 18],
            ['name' => 'Karim Tazi', 'email' => 'karim@mail.com', 'category' => 'Electrical', 'phone' => '+212 663 345 678', 'bio' => 'Certified electrician. Home wiring, panel upgrades, and fixture installation.', 'price' => 250, 'unit' => 'per_day', 'city' => 'Marrakech', 'experience' => 12, 'rating' => 4.9, 'reviews' => 32],
            ['name' => 'Hassan Fassi', 'email' => 'hassan@mail.com', 'category' => 'Carpentry', 'phone' => '+212 664 456 789', 'bio' => 'Skilled carpenter specializing in custom furniture and door installations.', 'price' => 180, 'unit' => 'per_day', 'city' => 'Fes', 'experience' => 15, 'rating' => 4.7, 'reviews' => 21],
            ['name' => 'Mohammed Alaoui', 'email' => 'mohammed@mail.com', 'category' => 'Cleaning', 'phone' => '+212 665 567 890', 'bio' => 'Professional cleaning service for homes and offices. Eco-friendly products.', 'price' => 100, 'unit' => 'per_day', 'city' => 'Tangier', 'experience' => 5, 'rating' => 4.3, 'reviews' => 15],
            ['name' => 'Omar Chraibi', 'email' => 'omar@mail.com', 'category' => 'Gardening', 'phone' => '+212 666 678 901', 'bio' => 'Landscaping and garden maintenance. Tree trimming and lawn care.', 'price' => 120, 'unit' => 'per_day', 'city' => 'Agadir', 'experience' => 7, 'rating' => 4.6, 'reviews' => 12],
            ['name' => 'Rachid Berrada', 'email' => 'rachid@mail.com', 'category' => 'Tiling', 'phone' => '+212 667 789 012', 'bio' => 'Expert tiler with attention to detail. Kitchen, bathroom, and floor tiling.', 'price' => 180, 'unit' => 'per_square_meter', 'city' => 'Meknes', 'experience' => 9, 'rating' => 4.4, 'reviews' => 16],
            ['name' => 'Said El Amrani', 'email' => 'said@mail.com', 'category' => 'AC Repair', 'phone' => '+212 668 890 123', 'bio' => 'AC installation, maintenance and repair. All brands serviced.', 'price' => 300, 'unit' => 'per_project', 'city' => 'Casablanca', 'experience' => 6, 'rating' => 4.2, 'reviews' => 9],
            ['name' => 'Fatima Zahra', 'email' => 'fatima@mail.com', 'category' => 'Cleaning', 'phone' => '+212 669 901 234', 'bio' => 'Deep cleaning specialist. Move-in/move-out cleaning and post-construction cleanup.', 'price' => 150, 'unit' => 'per_day', 'city' => 'Rabat', 'experience' => 4, 'rating' => 4.8, 'reviews' => 20],
            ['name' => 'Ibrahim Mansouri', 'email' => 'ibrahim@mail.com', 'category' => 'Painting', 'phone' => '+212 670 012 345', 'bio' => 'Decorative painting, faux finishes, and wallpaper installation.', 'price' => 200, 'unit' => 'per_day', 'city' => 'Marrakech', 'experience' => 11, 'rating' => 4.6, 'reviews' => 28],
            ['name' => 'Ali Ouazzani', 'email' => 'ali@mail.com', 'category' => 'Plumbing', 'phone' => '+212 671 123 456', 'bio' => 'Emergency plumbing services available 24/7. Leak detection and repair.', 'price' => 150, 'unit' => 'per_hour', 'city' => 'Casablanca', 'experience' => 14, 'rating' => 4.9, 'reviews' => 45],
            ['name' => 'Hamid Kabbaj', 'email' => 'hamid@mail.com', 'category' => 'Electrical', 'phone' => '+212 672 234 567', 'bio' => 'Residential and commercial electrical work. Smart home installations.', 'price' => 200, 'unit' => 'per_day', 'city' => 'Rabat', 'experience' => 8, 'rating' => 4.4, 'reviews' => 14],
            ['name' => 'Amina Bennani', 'email' => 'amina@mail.com', 'category' => 'Makeup Artist', 'phone' => '+212 673 345 678', 'bio' => 'Professional makeup artist for weddings, events and photoshoots. 8 years experience.', 'price' => 500, 'unit' => 'per_session', 'city' => 'Casablanca', 'experience' => 8, 'rating' => 4.9, 'reviews' => 56],
            ['name' => 'Salma Idrissi', 'email' => 'salma@mail.com', 'category' => 'Makeup Artist', 'phone' => '+212 674 456 789', 'bio' => 'Bridal makeup specialist. Natural and glamorous looks for your special day.', 'price' => 400, 'unit' => 'per_session', 'city' => 'Marrakech', 'experience' => 6, 'rating' => 4.7, 'reviews' => 38],
            ['name' => 'Nadia El Fassi', 'email' => 'nadia@mail.com', 'category' => 'Makeup Artist', 'phone' => '+212 675 567 890', 'bio' => 'Celebrity makeup artist. High fashion and editorial looks.', 'price' => 800, 'unit' => 'per_session', 'city' => 'Rabat', 'experience' => 12, 'rating' => 5.0, 'reviews' => 72],
            ['name' => 'Khadija Mouline', 'email' => 'khadija@mail.com', 'category' => 'School Cook', 'phone' => '+212 676 678 901', 'bio' => 'Healthy and delicious meals for children. Special diets accommodated.', 'price' => 30, 'unit' => 'per_child', 'city' => 'Casablanca', 'experience' => 10, 'rating' => 4.8, 'reviews' => 45],
            ['name' => 'Zineb Alaoui', 'email' => 'zineb@mail.com', 'category' => 'School Cook', 'phone' => '+212 677 789 012', 'bio' => 'Nutritionist and cook. Balanced meals for school lunch programs.', 'price' => 25, 'unit' => 'per_child', 'city' => 'Rabat', 'experience' => 7, 'rating' => 4.6, 'reviews' => 32],
            ['name' => 'Hajar Benjelloun', 'email' => 'hajar@mail.com', 'category' => 'School Cook', 'phone' => '+212 678 890 123', 'bio' => 'Traditional Moroccan cuisine for kids. Allergen-free options available.', 'price' => 35, 'unit' => 'per_child', 'city' => 'Fes', 'experience' => 15, 'rating' => 4.9, 'reviews' => 67],
            ['name' => 'Yassine Tazi', 'email' => 'yassine@mail.com', 'category' => 'Photography', 'phone' => '+212 679 901 234', 'bio' => 'Wedding and event photographer. Professional editing included.', 'price' => 1500, 'unit' => 'per_event', 'city' => 'Marrakech', 'experience' => 9, 'rating' => 4.8, 'reviews' => 41],
            ['name' => 'Mehdi Chraibi', 'email' => 'mehdi@mail.com', 'category' => 'Photography', 'phone' => '+212 680 012 345', 'bio' => 'Portrait and product photography. Studio and on-location shoots.', 'price' => 300, 'unit' => 'per_hour', 'city' => 'Casablanca', 'experience' => 5, 'rating' => 4.5, 'reviews' => 23],
            ['name' => 'Othmane Berrada', 'email' => 'othmane@mail.com', 'category' => 'Auto Mechanic', 'phone' => '+212 681 123 456', 'bio' => 'Certified mechanic. All car brands. Diagnostics and repairs.', 'price' => 200, 'unit' => 'per_hour', 'city' => 'Tangier', 'experience' => 18, 'rating' => 4.7, 'reviews' => 89],
            ['name' => 'Reda Amrani', 'email' => 'reda@mail.com', 'category' => 'Auto Mechanic', 'phone' => '+212 682 234 567', 'bio' => 'Specialist in European cars. Engine overhaul and transmission repair.', 'price' => 250, 'unit' => 'per_hour', 'city' => 'Casablanca', 'experience' => 12, 'rating' => 4.6, 'reviews' => 54],
            ['name' => 'Mustapha Kabbaj', 'email' => 'mustapha@mail.com', 'category' => 'Moving Services', 'phone' => '+212 683 345 678', 'bio' => 'Professional moving company. Packing, transport and unpacking included.', 'price' => 500, 'unit' => 'per_move', 'city' => 'Rabat', 'experience' => 10, 'rating' => 4.4, 'reviews' => 36],
            ['name' => 'Abdellah Fassi', 'email' => 'abdellah@mail.com', 'category' => 'Moving Services', 'phone' => '+212 684 456 789', 'bio' => 'Affordable moving services. Small and large moves. Insurance included.', 'price' => 350, 'unit' => 'per_move', 'city' => 'Meknes', 'experience' => 6, 'rating' => 4.3, 'reviews' => 28],
            ['name' => 'Laila Mansouri', 'email' => 'laila@mail.com', 'category' => 'Interior Design', 'phone' => '+212 685 567 890', 'bio' => 'Modern interior design. Space planning and furniture selection.', 'price' => 2000, 'unit' => 'per_project', 'city' => 'Casablanca', 'experience' => 11, 'rating' => 4.9, 'reviews' => 47],
            ['name' => 'Sara Ouazzani', 'email' => 'sara@mail.com', 'category' => 'Interior Design', 'phone' => '+212 686 678 901', 'bio' => 'Minimalist and contemporary design. 3D visualization included.', 'price' => 1500, 'unit' => 'per_project', 'city' => 'Marrakech', 'experience' => 8, 'rating' => 4.7, 'reviews' => 33],
            ['name' => 'Naima El Amrani', 'email' => 'naima@mail.com', 'category' => 'Tailoring', 'phone' => '+212 687 789 012', 'bio' => 'Expert seamstress. Custom dresses, alterations and traditional caftans.', 'price' => 100, 'unit' => 'per_piece', 'city' => 'Fes', 'experience' => 20, 'rating' => 4.8, 'reviews' => 95],
            ['name' => 'Rkia Tazi', 'email' => 'rkia@mail.com', 'category' => 'Tailoring', 'phone' => '+212 688 890 123', 'bio' => 'Modern tailoring. Suits, dresses and everyday wear alterations.', 'price' => 80, 'unit' => 'per_piece', 'city' => 'Rabat', 'experience' => 12, 'rating' => 4.5, 'reviews' => 62],
            ['name' => 'Brahim Alaoui', 'email' => 'brahim@mail.com', 'category' => 'Computer Repair', 'phone' => '+212 689 901 234', 'bio' => 'PC and laptop repair. Data recovery and virus removal.', 'price' => 150, 'unit' => 'per_hour', 'city' => 'Casablanca', 'experience' => 9, 'rating' => 4.6, 'reviews' => 44],
            ['name' => 'Driss Benali', 'email' => 'driss@mail.com', 'category' => 'Computer Repair', 'phone' => '+212 690 012 345', 'bio' => 'IT support specialist. Network setup and software installation.', 'price' => 120, 'unit' => 'per_hour', 'city' => 'Tangier', 'experience' => 7, 'rating' => 4.4, 'reviews' => 31],
            ['name' => 'Fatima Berrada', 'email' => 'fatima.b@mail.com', 'category' => 'Tutoring', 'phone' => '+212 691 123 456', 'bio' => 'Math and physics tutor. All levels from primary to university.', 'price' => 100, 'unit' => 'per_hour', 'city' => 'Rabat', 'experience' => 15, 'rating' => 4.9, 'reviews' => 78],
            ['name' => 'Hassan Chraibi', 'email' => 'hassan.c@mail.com', 'category' => 'Tutoring', 'phone' => '+212 692 234 567', 'bio' => 'English and French language tutor. Conversational and exam prep.', 'price' => 80, 'unit' => 'per_hour', 'city' => 'Casablanca', 'experience' => 10, 'rating' => 4.7, 'reviews' => 56],
            ['name' => 'Aicha Mansouri', 'email' => 'aicha@mail.com', 'category' => 'Pet Care', 'phone' => '+212 693 345 678', 'bio' => 'Professional pet groomer. Dogs and cats. Home visits available.', 'price' => 150, 'unit' => 'per_session', 'city' => 'Marrakech', 'experience' => 6, 'rating' => 4.8, 'reviews' => 42],
            ['name' => 'Mohamed El Fassi', 'email' => 'mohamed.ef@mail.com', 'category' => 'Security Guard', 'phone' => '+212 694 456 789', 'bio' => 'Licensed security guard. Events, properties and personal protection.', 'price' => 200, 'unit' => 'per_day', 'city' => 'Casablanca', 'experience' => 14, 'rating' => 4.5, 'reviews' => 38],
            ['name' => 'Abdelhak Kabbaj', 'email' => 'abdelhak@mail.com', 'category' => 'Driver', 'phone' => '+212 695 567 890', 'bio' => 'Professional chauffeur. Airport transfers and city tours.', 'price' => 300, 'unit' => 'per_day', 'city' => 'Marrakech', 'experience' => 11, 'rating' => 4.7, 'reviews' => 52],
            ['name' => 'Rachid Amrani', 'email' => 'rachid.a@mail.com', 'category' => 'Driver', 'phone' => '+212 696 678 901', 'bio' => 'Experienced driver. Luxury vehicles available. Corporate clients welcome.', 'price' => 400, 'unit' => 'per_day', 'city' => 'Rabat', 'experience' => 16, 'rating' => 4.9, 'reviews' => 67],
            ['name' => 'Khalid Tazi', 'email' => 'khalid@mail.com', 'category' => 'Welding', 'phone' => '+212 697 789 012', 'bio' => 'Certified welder. Steel, aluminum and stainless steel work.', 'price' => 250, 'unit' => 'per_day', 'city' => 'Fes', 'experience' => 13, 'rating' => 4.6, 'reviews' => 29],
            ['name' => 'Saad Ouazzani', 'email' => 'saad@mail.com', 'category' => 'Masonry', 'phone' => '+212 698 890 123', 'bio' => 'Expert mason. Walls, foundations and decorative stonework.', 'price' => 200, 'unit' => 'per_day', 'city' => 'Meknes', 'experience' => 18, 'rating' => 4.5, 'reviews' => 41],
            ['name' => 'Younes Benjelloun', 'email' => 'younes@mail.com', 'category' => 'Roofing', 'phone' => '+212 699 901 234', 'bio' => 'Roofing specialist. Repair, installation and waterproofing.', 'price' => 300, 'unit' => 'per_day', 'city' => 'Tangier', 'experience' => 10, 'rating' => 4.4, 'reviews' => 25],
            ['name' => 'Nabil Alaoui', 'email' => 'nabil@mail.com', 'category' => 'Pest Control', 'phone' => '+212 600 012 345', 'bio' => 'Professional pest control. Safe for children and pets.', 'price' => 200, 'unit' => 'per_treatment', 'city' => 'Casablanca', 'experience' => 8, 'rating' => 4.7, 'reviews' => 34],
            ['name' => 'Tarik Fassi', 'email' => 'tarik@mail.com', 'category' => 'Locksmith', 'phone' => '+212 601 123 456', 'bio' => 'Emergency locksmith. 24/7 service. Lock installation and repair.', 'price' => 150, 'unit' => 'per_service', 'city' => 'Rabat', 'experience' => 12, 'rating' => 4.8, 'reviews' => 58],
            ['name' => 'Imane Chraibi', 'email' => 'imane@mail.com', 'category' => 'Makeup Artist', 'phone' => '+212 602 234 567', 'bio' => 'Natural makeup specialist. Perfect for everyday looks and events.', 'price' => 350, 'unit' => 'per_session', 'city' => 'Agadir', 'experience' => 5, 'rating' => 4.6, 'reviews' => 27],
            ['name' => 'Souad Mansouri', 'email' => 'souad@mail.com', 'category' => 'School Cook', 'phone' => '+212 603 345 678', 'bio' => 'International cuisine for kids. Healthy snacks and balanced meals.', 'price' => 28, 'unit' => 'per_child', 'city' => 'Marrakech', 'experience' => 9, 'rating' => 4.7, 'reviews' => 41],
            ['name' => 'Ayoub Tazi', 'email' => 'ayoub@mail.com', 'category' => 'Photography', 'phone' => '+212 604 456 789', 'bio' => 'Drone photography and videography. Aerial shots for events.', 'price' => 2000, 'unit' => 'per_event', 'city' => 'Casablanca', 'experience' => 7, 'rating' => 4.8, 'reviews' => 35],
            ['name' => 'Zakaria Amrani', 'email' => 'zakaria@mail.com', 'category' => 'Auto Mechanic', 'phone' => '+212 605 567 890', 'bio' => 'Japanese car specialist. Toyota, Honda, Nissan expert.', 'price' => 180, 'unit' => 'per_hour', 'city' => 'Fes', 'experience' => 11, 'rating' => 4.5, 'reviews' => 48],
            ['name' => 'Meryem Kabbaj', 'email' => 'meryem@mail.com', 'category' => 'Interior Design', 'phone' => '+212 606 678 901', 'bio' => 'Bohemian and Moroccan fusion design. Unique spaces.', 'price' => 1800, 'unit' => 'per_project', 'city' => 'Marrakech', 'experience' => 9, 'rating' => 4.8, 'reviews' => 39],
            ['name' => 'Anas Berrada', 'email' => 'anas@mail.com', 'category' => 'Computer Repair', 'phone' => '+212 607 789 012', 'bio' => 'Mac and PC specialist. Hardware upgrades and troubleshooting.', 'price' => 130, 'unit' => 'per_hour', 'city' => 'Rabat', 'experience' => 6, 'rating' => 4.4, 'reviews' => 22],
            ['name' => 'Leila El Amrani', 'email' => 'leila@mail.com', 'category' => 'Tutoring', 'phone' => '+212 608 890 123', 'bio' => 'Science tutor. Biology, chemistry and physics for high school.', 'price' => 90, 'unit' => 'per_hour', 'city' => 'Casablanca', 'experience' => 8, 'rating' => 4.6, 'reviews' => 44],
            ['name' => 'Hamza Ouazzani', 'email' => 'hamza@mail.com', 'category' => 'Pet Care', 'phone' => '+212 609 901 234', 'bio' => 'Dog walker and pet sitter. Daily walks and overnight care.', 'price' => 50, 'unit' => 'per_visit', 'city' => 'Tangier', 'experience' => 4, 'rating' => 4.7, 'reviews' => 31],
            ['name' => 'Sanaa Benali', 'email' => 'sanaa@mail.com', 'category' => 'Tailoring', 'phone' => '+212 610 012 345', 'bio' => 'Traditional Moroccan embroidery and modern tailoring.', 'price' => 120, 'unit' => 'per_piece', 'city' => 'Fes', 'experience' => 16, 'rating' => 4.9, 'reviews' => 73],
        ];

        foreach ($workers as $w) {
            $category = Category::where('name', $w['category'])->first();
            
            $user = User::create([
                'name' => $w['name'],
                'email' => $w['email'],
                'password' => Hash::make('password'),
                'role' => 'worker',
            ]);

            $profile = WorkerProfile::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'phone' => $w['phone'],
                'bio' => $w['bio'],
                'price_per_unit' => $w['price'],
                'price_unit' => $w['unit'],
                'city' => $w['city'],
                'experience_years' => $w['experience'],
                'is_available' => true,
                'is_verified' => $w['rating'] >= 4.7,
                'instant_booking' => $w['reviews'] > 20,
                'response_time' => ['< 1 hour', '< 2 hours', '< 4 hours', '< 1 day'][rand(0, 3)],
                'badges' => $w['rating'] >= 4.8 ? ['top_rated', 'verified'] : ($w['rating'] >= 4.5 ? ['verified'] : []),
                'rating' => $w['rating'],
                'total_reviews' => $w['reviews'],
            ]);

            $client = User::create([
                'name' => 'Client ' . $w['name'],
                'email' => 'client.' . $w['email'],
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);

            Review::create([
                'user_id' => $client->id,
                'worker_profile_id' => $profile->id,
                'rating' => round($w['rating']),
                'comment' => 'Great service! Very professional and reliable.',
            ]);
        }

        User::firstOrCreate(
            ['email' => 'client@test.com'],
            ['name' => 'Test Client', 'password' => Hash::make('password'), 'role' => 'client']
        );

        $this->call(FakeWorkerSeeder::class);
    }
}
