<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Resource::create(['name' => 'Ground Worker']);
        Resource::create(['name' => 'Equipment Operator']);
        Resource::create(['name' => 'Climber']);
        Resource::create(['name' => '30-59 Ton (Tree-Mek)']);
        Resource::create(['name' => '60-110 Ton (Tree-Mek)']);
        Resource::create(['name' => '111 Ton And Bigger (Tree-Mek)']);
        Resource::create(['name' => 'Mek Grapple-Saw-Head']);
        Resource::create(['name' => '20-35 Ton (Stick Crane)']);
        Resource::create(['name' => '36-75 Ton (Stick Crane)']);
        Resource::create(['name' => '76 Ton Or Bigger (Stick Crane)']);
        Resource::create(['name' => 'Merlo Roto']);
        Resource::create(['name' => 'Sennabogin']);
        Resource::create(['name' => 'Crane Cribbing']);
        Resource::create(['name' => 'Turf Matts']);
        Resource::create(['name' => 'Chipper Truck']);
        Resource::create(['name' => 'Chipper']);
        Resource::create(['name' => 'Skid Steer']);
        Resource::create(['name' => 'Skid Steer Dangle Grapple']);
        Resource::create(['name' => 'Skid Steer Bucket/Root Grapple']);
        Resource::create(['name' => 'Mini Skid Steer']);
        Resource::create(['name' => 'Mini Dangle Grapple']);
        Resource::create(['name' => 'Mini Bucket/Root Grapple']);
        Resource::create(['name' => 'Equipment Trailer']);
        Resource::create(['name' => 'Chainsaw']);
        Resource::create(['name' => 'Leaf Blower']);
        Resource::create(['name' => 'Hand Tools']);
        Resource::create(['name' => 'Emergency Lights/Generator']);
        Resource::create(['name' => 'Spider/Man Lift']);
        Resource::create(['name' => 'Bucket Truck']);
        Resource::create(['name' => 'Support Truck (Straight Truck)']);
        Resource::create(['name' => 'Support Truck (Semi)']);
        Resource::create(['name' => 'Log Truck']);
        Resource::create(['name' => 'Tarp Per Square Foot']);
        Resource::create(['name' => 'Traffic Control']);
        Resource::create(['name' => 'Traffic Cones & Signage']);
    }
}
