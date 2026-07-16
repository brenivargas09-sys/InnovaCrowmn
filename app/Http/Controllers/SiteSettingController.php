<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    private array $sections = [
        'hero' => [
            'label' => 'Sección Hero (Página Principal)',
            'fields' => [
                'hero_title' => ['label' => 'Título Principal', 'type' => 'text'],
                'hero_subtitle' => ['label' => 'Subtítulo', 'type' => 'text'],
                'hero_description' => ['label' => 'Descripción', 'type' => 'textarea'],
                'hero_image' => ['label' => 'Imagen de Fondo (URL o ruta)', 'type' => 'text'],
            ],
        ],
        'about' => [
            'label' => 'Sección Nosotros',
            'fields' => [
                'about_text' => ['label' => 'Texto Descriptivo', 'type' => 'textarea'],
            ],
        ],
        'gallery' => [
            'label' => 'Galería de Imágenes',
            'fields' => [
                'gallery_1' => ['label' => 'Imagen 1 (ruta)', 'type' => 'text'],
                'gallery_2' => ['label' => 'Imagen 2 (ruta)', 'type' => 'text'],
                'gallery_3' => ['label' => 'Imagen 3 (ruta)', 'type' => 'text'],
            ],
        ],
        'contact' => [
            'label' => 'Información de Contacto',
            'fields' => [
                'contact_address' => ['label' => 'Dirección', 'type' => 'text'],
                'contact_phone' => ['label' => 'Teléfono', 'type' => 'text'],
                'contact_email' => ['label' => 'Email', 'type' => 'text'],
            ],
        ],
        'footer' => [
            'label' => 'Pie de Página',
            'fields' => [
                'footer_text' => ['label' => 'Texto del Footer', 'type' => 'textarea'],
            ],
        ],
    ];

    public function index()
    {
        $settings = SiteSetting::getAll();
        return view('settings.index', compact('settings'));
    }

    public function edit(string $section)
    {
        if (!isset($this->sections[$section])) {
            abort(404);
        }

        $sectionData = $this->sections[$section];
        $settings = SiteSetting::getAll();

        return view('settings.edit', compact('section', 'sectionData', 'settings'));
    }

    public function update(Request $request, string $section)
    {
        if (!isset($this->sections[$section])) {
            abort(404);
        }

        $sectionData = $this->sections[$section];
        $rules = [];
        foreach ($sectionData['fields'] as $key => $field) {
            $rules[$key] = 'nullable|string|max:500';
        }

        $validated = $request->validate($rules);

        SiteSetting::setMany($validated);

        return redirect()->route('settings.index')->with('success', "Sección '{$sectionData['label']}' actualizada.");
    }
}
