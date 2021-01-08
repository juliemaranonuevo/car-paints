<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $page = [
            'title' => 'New Paint Job',
        ];

        return view('car.index', compact('page'));
    }

    public function store(Request $request)
    {
        $isPlateNoExist = Car::where('plate_no', $request->plateNo)
            ->first();

        if ($isPlateNoExist) {

            return response()->json([
                'error' => "Sorry, plate number ".$isPlateNoExist->plate_no." already exist."
            ]);

        } else {

            if ($request->currentColor == $request->targetColor) {

                return response()->json([
                    'error' => "Invalid! Current and target color must not be the same."
                ]);

            } else {

                $car = new Car();
                $car->plate_no = $request->plateNo;
                $car->current_color = $request->currentColor;
                $car->target_color = $request->targetColor;
                $car->save();

                return response()->json([
                    'success' => 'New car added successfully.'
                ]);

            }
            
        }
    }

    public function show(Request $request)
    {
        $page = [
            'title' => 'Paint Jobs',
        ];

        $cars = Car::all();

        return view('car.show', compact('page', 'cars'));
    }

    public function update(Request $request)
    {
        $car = Car::find($request->carId);
        $car->status = 1;
        $car->save();

        return response()->json([
            'success' => 'Car has been completed successfully!'
        ]);
    }
}
