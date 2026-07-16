<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SiteSetting;
use App\Models\Promotion;
use App\Models\RoomType;
use App\Models\Service;
use App\Http\Requests\HeroUpdateRequest;
use App\Http\Requests\InfoUpdateRequest;
use App\Http\Requests\GalleryUploadRequest;
use App\Http\Requests\PromotionStoreRequest;
use App\Http\Requests\PromotionUpdateRequest;
use App\Http\Requests\PanelServiceRequest;
use App\Http\Requests\PanelRoomTypeRequest;

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

    public function heroUpdate(HeroUpdateRequest $request)
    {
        $validated = $request->validated();

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

    public function galleryUpload(GalleryUploadRequest $request)
    {
        $request->validated();

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

    public function infoUpdate(InfoUpdateRequest $request)
    {
        $validated = $request->validated();

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

    public function promotionStore(PromotionStoreRequest $request)
    {
        $validated = $request->validated();

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

    public function promotionUpdate(PromotionUpdateRequest $request, Promotion $promotion)
    {
        $validated = $request->validated();

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

    public function serviceStore(PanelServiceRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'activo';
        Service::create($validated);
        return redirect()->route('panel.services')->with('success', 'Servicio creado.');
    }

    public function serviceUpdate(PanelServiceRequest $request, Service $service)
    {
        $validated = $request->validated();
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

    public function roomTypeStore(PanelRoomTypeRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('rooms', 'public');
        }

        RoomType::create($validated);
        return redirect()->route('panel.rooms')->with('success', 'Tipo de habitación creado.');
    }

    public function roomTypeUpdate(PanelRoomTypeRequest $request, RoomType $roomType)
    {
        $validated = $request->validated();

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
