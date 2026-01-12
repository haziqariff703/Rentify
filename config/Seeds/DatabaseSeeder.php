<?php

declare(strict_types=1);

use Migrations\BaseSeed;
use App\Factory\UserFactory;
use App\Factory\CarCategoryFactory;
use App\Factory\CarFactory;
use App\Factory\BookingFactory;
use App\Factory\InvoiceFactory;
use App\Factory\PaymentFactory;
use App\Factory\MaintenanceFactory;
use App\Factory\ReviewFactory;

/**
 * Database Seeder
 *
 * Generates a complete fake database using FakerPHP factories.
 * This seeder creates a realistic dataset for development and testing.
 *
 * Usage:
 *   bin/cake migrations seed --seed DatabaseSeeder
 *
 * Data Generated:
 *   - 1 Admin user
 *   - 15 Customer users
 *   - 7 Car Categories (Economy, Compact, Standard, SUV, Luxury, Sports, MPV)
 *   - 25 Cars across all categories
 *   - 40 Bookings with varied statuses
 *   - Invoices for approved/completed bookings
 *   - Payments for some invoices
 *   - 15 Maintenance records
 *   - 30 Reviews for completed bookings
 */
class DatabaseSeeder extends BaseSeed
{
    /**
     * Run Method.
     *
     * Generates complete fake data for all tables.
     *
     * @return void
     */
    public function run(): void
    {
        $this->output('Starting database seeding with FakerPHP factories...');
        $this->output('');

        // Track created entities for relationships
        $users = [];
        $categories = [];
        $cars = [];
        $bookings = [];

        // ============================================================
        // 1. CREATE USERS
        // ============================================================
        $this->output('Creating users...');
        $userFactory = new UserFactory();

        // Create admin user
        $admin = $userFactory->createAdmin([
            'name' => 'Super Admin',
            'email' => 'admin@rentify.com',
            'ic_number' => '850101-01-1234',
            'role' => 'admin',
        ]);
        $this->output('  ✓ Created admin: admin@rentify.com');

        // Create 15 customers
        for ($i = 0; $i < 15; $i++) {
            $users[] = $userFactory->createCustomer();
        }
        $this->output('  ✓ Created 15 customer accounts');
        $this->output('');

        // ============================================================
        // 2. CREATE CAR CATEGORIES
        // ============================================================
        $this->output('Creating car categories...');
        $categoryFactory = new CarCategoryFactory();

        // Create all predefined categories
        $categories = $categoryFactory->createAllPredefined();
        $this->output('  ✓ Created ' . count($categories) . ' car categories');
        $this->output('');

        // ============================================================
        // 3. CREATE CARS
        // ============================================================
        $this->output('Creating cars...');
        $carFactory = new CarFactory();

        // Distribute cars across categories
        $carsPerCategory = [
            'Economy' => 5,
            'Compact' => 4,
            'Standard' => 4,
            'SUV' => 3,
            'Luxury' => 3,
            'Sports' => 2,
            'MPV' => 4,
        ];

        foreach ($categories as $category) {
            $count = $carsPerCategory[$category->name] ?? 3;

            for ($i = 0; $i < $count; $i++) {
                $car = $carFactory->create(['category_id' => $category->id]);
                $cars[] = $car;
            }
            $this->output("  ✓ Created {$count} cars in {$category->name} category");
        }
        $this->output('');

        // ============================================================
        // 4. CREATE BOOKINGS
        // ============================================================
        $this->output('Creating bookings...');
        $bookingFactory = new BookingFactory();

        // Create variety of booking statuses
        $bookingCounts = [
            'completed' => 15,
            'approved' => 8,
            'pending' => 6,
            'ongoing' => 4,
            'cancelled' => 4,
            'rejected' => 3,
        ];

        foreach ($bookingCounts as $status => $count) {
            for ($i = 0; $i < $count; $i++) {
                $user = $users[array_rand($users)];
                $car = $cars[array_rand($cars)];

                switch ($status) {
                    case 'completed':
                        $booking = $bookingFactory->createCompleted($user->id, $car->id);
                        break;
                    case 'approved':
                        $booking = $bookingFactory->createApproved($user->id, $car->id);
                        break;
                    case 'pending':
                        $booking = $bookingFactory->createPending($user->id, $car->id);
                        break;
                    case 'ongoing':
                        $booking = $bookingFactory->createOngoing($user->id, $car->id);
                        break;
                    case 'cancelled':
                        $booking = $bookingFactory->createCancelled($user->id, $car->id);
                        break;
                    case 'rejected':
                        $booking = $bookingFactory->create([
                            'user_id' => $user->id,
                            'car_id' => $car->id,
                            'booking_status' => 'rejected',
                        ]);
                        break;
                    default:
                        $booking = $bookingFactory->create([
                            'user_id' => $user->id,
                            'car_id' => $car->id,
                        ]);
                }

                $bookings[$status][] = $booking;
            }
            $this->output("  ✓ Created {$count} {$status} bookings");
        }
        $this->output('');

        // ============================================================
        // 5. CREATE INVOICES
        // ============================================================
        $this->output('Creating invoices...');
        $invoiceFactory = new InvoiceFactory();
        $invoiceCount = 0;

        // Create invoices for completed and approved bookings
        $invoiceableStatuses = ['completed', 'approved', 'ongoing'];
        foreach ($invoiceableStatuses as $status) {
            if (!isset($bookings[$status]))
                continue;

            foreach ($bookings[$status] as $booking) {
                // Skip if booking doesn't have a valid total_price
                if (empty($booking->total_price) || $booking->total_price <= 0) {
                    continue;
                }

                $amount = (float) $booking->total_price;

                if ($status === 'completed') {
                    $invoiceFactory->createPaid($booking->id, $amount);
                } else {
                    $invoiceFactory->createUnpaid($booking->id, $amount);
                }
                $invoiceCount++;
            }
        }
        $this->output("  ✓ Created {$invoiceCount} invoices");
        $this->output('');

        // ============================================================
        // 6. CREATE PAYMENTS
        // ============================================================
        $this->output('Creating payments...');
        $paymentFactory = new PaymentFactory();
        $paymentCount = 0;

        // Create payments for completed bookings
        if (isset($bookings['completed'])) {
            foreach ($bookings['completed'] as $booking) {
                if (!empty($booking->total_price) && $booking->total_price > 0) {
                    $paymentFactory->createPaid($booking->id, (float) $booking->total_price);
                    $paymentCount++;
                }
            }
        }

        // Create some partial payments for approved bookings
        if (isset($bookings['approved'])) {
            foreach (array_slice($bookings['approved'], 0, 3) as $booking) {
                if (!empty($booking->total_price) && $booking->total_price > 0) {
                    $partialAmount = (float) ($booking->total_price * 0.5);
                    $paymentFactory->createPaid($booking->id, $partialAmount);
                    $paymentCount++;
                }
            }
        }
        $this->output("  ✓ Created {$paymentCount} payments");
        $this->output('');

        // ============================================================
        // 7. CREATE MAINTENANCES
        // ============================================================
        $this->output('Creating maintenance records...');
        $maintenanceFactory = new MaintenanceFactory();

        // Create scheduled maintenances
        for ($i = 0; $i < 5; $i++) {
            $car = $cars[array_rand($cars)];
            $maintenanceFactory->createScheduled($car->id);
        }
        $this->output('  ✓ Created 5 scheduled maintenances');

        // Create in-progress maintenances
        for ($i = 0; $i < 3; $i++) {
            $car = $cars[array_rand($cars)];
            $maintenanceFactory->createInProgress($car->id);
        }
        $this->output('  ✓ Created 3 in-progress maintenances');

        // Create completed maintenances
        for ($i = 0; $i < 7; $i++) {
            $car = $cars[array_rand($cars)];
            $maintenanceFactory->createCompleted($car->id);
        }
        $this->output('  ✓ Created 7 completed maintenances');
        $this->output('');

        // ============================================================
        // 8. CREATE REVIEWS
        // ============================================================
        $this->output('Creating reviews...');
        $reviewFactory = new ReviewFactory();
        $reviewCount = 0;

        // Create reviews for completed bookings
        if (isset($bookings['completed'])) {
            foreach ($bookings['completed'] as $booking) {
                // 80% chance of having a review
                if (rand(1, 100) <= 80) {
                    $rand = rand(1, 100);
                    if ($rand <= 60) {
                        $reviewFactory->createPositive($booking->user_id, $booking->car_id, $booking->id);
                    } elseif ($rand <= 85) {
                        $reviewFactory->createNeutral($booking->user_id, $booking->car_id, $booking->id);
                    } else {
                        $reviewFactory->createNegative($booking->user_id, $booking->car_id, $booking->id);
                    }
                    $reviewCount++;
                }
            }
        }

        // Create some additional reviews without booking reference
        for ($i = 0; $i < 5; $i++) {
            $user = $users[array_rand($users)];
            $car = $cars[array_rand($cars)];
            $reviewFactory->create([
                'user_id' => $user->id,
                'car_id' => $car->id,
            ]);
            $reviewCount++;
        }
        $this->output("  ✓ Created {$reviewCount} reviews");
        $this->output('');

        // ============================================================
        // SUMMARY
        // ============================================================
        $this->output('========================================');
        $this->output('Database seeding completed successfully!');
        $this->output('========================================');
        $this->output('');
        $this->output('Summary:');
        $this->output('  • 1 Admin user (admin@rentify.com / password123)');
        $this->output('  • 15 Customer users (password: password123)');
        $this->output('  • ' . count($categories) . ' Car categories');
        $this->output('  • ' . count($cars) . ' Cars');
        $this->output('  • ' . array_sum(array_map('count', $bookings)) . ' Bookings');
        $this->output('  • ' . $invoiceCount . ' Invoices');
        $this->output('  • ' . $paymentCount . ' Payments');
        $this->output('  • 15 Maintenance records');
        $this->output('  • ' . $reviewCount . ' Reviews');
        $this->output('');
    }

    /**
     * Helper method to output text during seeding
     *
     * @param string $text Text to output
     * @return void
     */
    protected function output(string $text): void
    {
        if (PHP_SAPI === 'cli') {
            echo $text . PHP_EOL;
        }
    }
}
