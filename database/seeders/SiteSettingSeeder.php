<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'hero_title' => 'Bienvenido a',
            'hero_subtitle' => 'InnovaCrown',
            'hero_description' => 'Disfruta de una experiencia de hospedaje de lujo en el corazón de la ciudad. Habitaciones elegantes, servicio excepcional y atención personalizada.',
            'hero_image' => '',
            'hotel_name' => 'InnovaCrown',
            'hotel_subtitle' => 'Hotel de Lujo',
            'about_text' => 'InnovaCrown es un hotel de lujo que combina elegancia moderna con atención personalizada. Desde nuestra apertura, nos hemos comprometido a ofrecer una experiencia única a cada huésped, con instalaciones de primer nivel y un equipo dedicado a superar sus expectativas.',
            'mission' => 'Brindar a nuestros huéspedes una experiencia de hospedaje excepcional, superando sus expectativas a través de un servicio personalizado, instalaciones de primera calidad y un ambiente de confort y elegancia.',
            'vision' => 'Ser reconocidos como el hotel de lujo preferido en la región, destacando por nuestra innovación constante, compromiso con la excelencia y atención al detalle que nos diferencia.',
            'values' => 'Excelencia, integridad, hospitalidad, innovación y compromiso con la satisfacción de nuestros huéspedes.',
            'contact_address' => 'Av. Principal 123, Col. Centro, Ciudad de México, CP 06000',
            'contact_phone' => '+52 55 1234 5678',
            'contact_phone2' => '+52 55 8765 4321',
            'contact_email' => 'reservaciones@innovacrown.com',
            'contact_email2' => 'info@innovacrown.com',
            'schedule_weekdays' => '24 horas',
            'schedule_weekends' => '24 horas',
            'social_facebook' => '',
            'social_instagram' => '',
            'social_twitter' => '',
            'social_whatsapp' => '525512345678',
            'footer_text' => 'Hotel de lujo en el corazón de la ciudad. Tu confort es nuestra prioridad. Disfruta de nuestras habitaciones de ensueño, restaurantes gourmet y servicios exclusivos.',
            'map_latitude' => '16.5155694',
            'map_longitude' => '-90.6524524',
            'map_zoom' => '17',
        ];

        SiteSetting::setMany($defaults);
    }
}
