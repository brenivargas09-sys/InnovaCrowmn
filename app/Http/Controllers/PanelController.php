<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SiteSetting;
use App\Models\Promotion;
use App\Models\RoomType;
use App\Models\Service;

class PanelController extends Controller
{
    public function index()
    {
        $stats = [
            'room_types' => RoomType::count(),
            'services' => Service::count(),
            'promotions' => Promotion::count(),
            'gallery' => count(SiteSetting::getAll()),
        ];
        return view('panel.index', compact('stats'));
    }

    public function hero()
    {
        $settings = SiteSetting::getAll();
        return view('panel.hero', compact('settings'));
    }

    public function heroUpdate(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'nullable|string|max:200',
            'hero_subtitle' => 'nullable|string|max:200',
            'hero_description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('hero_image')) {
            $old = SiteSetting::get('hero_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('hero_image')->store('hero', 'public');
            $validated['hero_image'] = $path;
        }

        SiteSetting::setMany($validated);
        return redirect()->route('panel.hero')->with('success', 'Banner principal actualizado.');
    }

    public function gallery()
    {
        $images = SiteSetting::where('type', 'gallery')->get()->keyBy('key');
        return view('panel.gallery', compact('images'));
    }

    public function galleryUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:100',
        ]);

        $file = $request->file('image');
        $filename = 'gallery_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('gallery', $filename, 'public');

        $count = SiteSetting::where('type', 'gallery')->count();
        SiteSetting::create([
            'key' => 'gallery_' . ($count + 1),
            'value' => $path,
            'type' => 'gallery',
        ]);

        return redirect()->route('panel.gallery')->with('success', 'Imagen agregada a la galería.');
    }

    public function galleryDelete($id)
    {
        $image = SiteSetting::findOrFail($id);
        if ($image->value && Storage::disk('public')->exists($image->value)) {
            Storage::disk('public')->delete($image->value);
        }
        $image->delete();
        return redirect()->route('panel.gallery')->with('success', 'Imagen eliminada.');
    }

    public function info()
    {
        $settings = SiteSetting::getAll();
        return view('panel.info', compact('settings'));
    }

    public function infoUpdate(Request $request)
    {
        $validated = $request->validate([
            'hotel_name' => 'nullable|string|max:200',
            'hotel_subtitle' => 'nullable|string|max:200',
            'about_text' => 'nullable|string|max:3000',
            'mission' => 'nullable|string|max:1000',
            'vision' => 'nullable|string|max:1000',
            'values' => 'nullable|string|max:1000',
            'contact_address' => 'nullable|string|max:300',
            'contact_phone' => 'nullable|string|max:50',
            'contact_phone2' => 'nullable|string|max:50',
            'contact_email' => 'nullable|string|max:150',
            'contact_email2' => 'nullable|string|max:150',
            'schedule_weekdays' => 'nullable|string|max:100',
            'schedule_weekends' => 'nullable|string|max:100',
            'social_facebook' => 'nullable|string|max:300',
            'social_instagram' => 'nullable|string|max:300',
            'social_twitter' => 'nullable|string|max:300',
            'social_whatsapp' => 'nullable|string|max:300',
            'footer_text' => 'nullable|string|max:500',
            'map_latitude' => 'nullable|numeric|between:-90,90',
            'map_longitude' => 'nullable|numeric|between:-180,180',
            'map_zoom' => 'nullable|integer|min:1|max:21',
        ]);

        SiteSetting::setMany($validated);
        return redirect()->route('panel.info')->with('success', 'Información del hotel actualizada.');
    }

    public function promotions()
    {
        $promotions = Promotion::latest()->paginate(10);
        return view('panel.promotions', compact('promotions'));
    }

    public function promotionCreate()
    {
        return view('panel.promotion-form');
    }

    public function promotionStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        Promotion::create($validated);
        return redirect()->route('panel.promotions')->with('success', 'Promoción creada.');
    }

    public function promotionEdit(Promotion $promotion)
    {
        return view('panel.promotion-form', compact('promotion'));
    }

    public function promotionUpdate(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:activo,inactivo',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('image')) {
            if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
                Storage::disk('public')->delete($promotion->image);
            }
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        $promotion->update($validated);
        return redirect()->route('panel.promotions')->with('success', 'Promoción actualizada.');
    }

    public function promotionDelete(Promotion $promotion)
    {
        if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
            Storage::disk('public')->delete($promotion->image);
        }
        $promotion->delete();
        return redirect()->route('panel.promotions')->with('success', 'Promoción eliminada.');
    }

    public function servicesManage()
    {
        $services = Service::latest()->paginate(15);
        return view('panel.services-manage', compact('services'));
    }

    public function serviceStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
        ]);
        $validated['status'] = 'activo';
        Service::create($validated);
        return redirect()->route('panel.services')->with('success', 'Servicio creado.');
    }

    public function serviceUpdate(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:activo,inactivo',
        ]);
        $service->update($validated);
        return redirect()->route('panel.services')->with('success', 'Servicio actualizado.');
    }

    public function serviceDelete(Service $service)
    {
        $service->delete();
        return redirect()->route('panel.services')->with('success', 'Servicio eliminado.');
    }

    public function roomsManage()
    {
        $roomTypes = RoomType::withCount('rooms')->latest()->paginate(15);
        return view('panel.rooms-manage', compact('roomTypes'));
    }

    public function roomTypeStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('rooms', 'public');
        }

        RoomType::create($validated);
        return redirect()->route('panel.rooms')->with('success', 'Tipo de habitación creado.');
    }

    public function roomTypeUpdate(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string|max:500',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
                Storage::disk('public')->delete($roomType->image);
            }
            $validated['image'] = $request->file('image')->store('rooms', 'public');
        }

        $roomType->update($validated);
        return redirect()->route('panel.rooms')->with('success', 'Tipo de habitación actualizado.');
    }

    public function roomTypeDelete(RoomType $roomType)
    {
        if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
            Storage::disk('public')->delete($roomType->image);
        }
        $roomType->delete();
        return redirect()->route('panel.rooms')->with('success', 'Tipo de habitación eliminado.');
    }
}
