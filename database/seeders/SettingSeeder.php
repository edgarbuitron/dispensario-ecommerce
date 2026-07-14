<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'Dispensario Premium', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Tu tienda de confianza', 'group' => 'general'],
            ['key' => 'site_url', 'value' => 'https://dispensario.local', 'group' => 'general'],
            ['key' => 'support_email', 'value' => 'soporte@dispensario.com', 'group' => 'general'],
            ['key' => 'support_phone', 'value' => '5551234567', 'group' => 'general'],
            
            // Social Media
            ['key' => 'whatsapp', 'value' => '5551234567', 'group' => 'social'],
            ['key' => 'instagram', 'value' => '@dispensario_premium', 'group' => 'social'],
            ['key' => 'facebook', 'value' => 'dispensario.premium', 'group' => 'social'],
            ['key' => 'google_business_id', 'value' => '', 'group' => 'social'],
            
            // Email
            ['key' => 'mail_from_name', 'value' => 'Dispensario Premium', 'group' => 'email'],
            ['key' => 'mail_from_address', 'value' => 'noreply@dispensario.com', 'group' => 'email'],
            
            // Shipping
            ['key' => 'shipping_cost', 'value' => '50.00', 'group' => 'shipping'],
            ['key' => 'free_shipping_threshold', 'value' => '500.00', 'group' => 'shipping'],
            ['key' => 'shipping_days', 'value' => '3-5', 'group' => 'shipping'],
            
            // Tax
            ['key' => 'tax_percentage', 'value' => '16', 'group' => 'tax'],
            ['key' => 'tax_enabled', 'value' => '1', 'group' => 'tax'],
            
            // Store Hours
            ['key' => 'store_open_hour', 'value' => '09:00', 'group' => 'hours'],
            ['key' => 'store_close_hour', 'value' => '21:00', 'group' => 'hours'],
            
            // Privacy
            ['key' => 'minimum_age', 'value' => '18', 'group' => 'legal'],
            ['key' => 'terms_accepted', 'value' => '1', 'group' => 'legal'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
