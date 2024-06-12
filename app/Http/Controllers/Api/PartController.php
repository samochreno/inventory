<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PartResource;
use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    private function query($request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'filter' => 'nullable|string|in:registered,unregistered',
        ]);

        $query = Part::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query = $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('serialnumber', 'like', "%{$search}%");
            })->orWhereHas('car', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function index(Request $request)
    {
        return PartResource::collection($this->query($request)->paginate(20));
    }

    public function create(Request $request)
    {
        $part = $this->save($request);

        $isVisible = $this->query($request)
            ->paginate(20)
            ->where('id', $part->id)
            ->count() > 0;

        if (!$isVisible) {
            return response()->noContent();
        }

        return new PartResource($part);
    }

    public function update(Request $request, Part $part)
    {
        return new PartResource($this->save($request, $part));
    }

    public function save(Request $request, ?Part $part = null)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'serialnumber' => 'required|string|max:255',
            'car_uuid'     => 'required|exists:cars,uuid',
        ]);

        $data['car_id'] = Car::where('uuid', $data['car_uuid'])->first()->id;
        unset($data['car_uuid']);

        if (!$part) {
            return Part::create($data);
        }

        $part->update($data);
        return $part;
    }

    public function delete(Part $part)
    {
        $part->delete();
        return response()->noContent();
    }
}
