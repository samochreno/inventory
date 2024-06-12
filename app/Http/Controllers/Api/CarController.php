<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    private function query($request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'filter' => 'nullable|string|in:registered,unregistered',
        ]);

        $query = Car::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query = $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%");
            });
        }

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $query = $query->where('is_registered', $filter == 'registered');
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function index(Request $request)
    {
        return CarResource::collection($this->query($request)->paginate(20));
    }

    public function create(Request $request)
    {
        $car = $this->save($request);

        $isVisible = $this->query($request)
            ->paginate(20)
            ->where('id', $car->id)
            ->count() > 0;

        if (!$isVisible) {
            return response()->noContent();
        }

        return new CarResource($car);
    }

    public function update(Request $request, Car $car)
    {
        return new CarResource($this->save($request, $car));
    }

    public function save(Request $request, ?Car $car = null)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:255',
            'registration_number' => 'required_if:is_registered,true|string|max:255',
            'is_registered'       => 'required|boolean',
        ]);

        if (!$data['is_registered']) {
            $data['registration_number'] = null;
        }

        if (!$car) {
            return Car::create($data);
        }

        $car->update($data);
        return $car;
    }

    public function delete(Car $car)
    {
        $car->delete();
        return response()->noContent();
    }

    public function search(Request $request)
    {
        $search = $request['q'] ?? '';
        if (!$search) {
            return response()->json([]);
        }

        $cars = Car::query()
            ->where('name', 'like', "%{$search}%")
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json($cars->map(function ($car) {
            return [
                'value' => $car->uuid,
                'label' => $car->name,
            ];
        }));
    }
}
