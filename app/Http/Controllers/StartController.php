<?php

namespace App\Http\Controllers;

use App\Events\NewEvent;
use Illuminate\Http\Request;
use App\Events;

class StartController extends Controller
{
    public function chartData() {
        return [
            'labels' => ['March', 'April', 'May', 'June'],
            'dataSets' => [
                [
                    'label' => 'Sells',
                    'backgroundColor' => '#51c120',
                    'data' => [15000, 5000, 10000, 30000]
                ]
            ]
        ];
    }
    public function chartRandom() {
        return [
            'labels' => ['March', 'April', 'May', 'June'],
            'dataSets' => [
                [
                    'label' => 'Sells',
                    'backgroundColor' => '#51c120',
                    'data' => [rand(0, 33000), rand(0, 33000), rand(0, 33000), rand(0, 30000)]
                ],
                [
                    'label' => 'Buy',
                    'backgroundColor' => '#ff0d0d',
                    'data' => [rand(0, 33000), rand(0, 33000), rand(0, 33000), rand(0, 33000)]
                ]
            ]
        ];
    }
    public function newEvent(Request $request) {


        $result = [
            'labels' => ['March', 'April', 'May', 'June'],
            'dataSets' => [
                [
                    'label' => 'Sells',
                    'bgc' => 'red',
                    'data' => [15000, 5000, 10000, 30000]
                ]
            ]
        ];

        if ($request->has('label')) {
            $result['labels'][] = $request->input('label');
            $result['dataSets'][0]['data'][] = (int)$request->input('sale');

            if($request->has('realtime')) {
                if (filter_var($request->input('realtime'), FILTER_VALIDATE_BOOL)) {
                    event(new NewEvent($result));
                }
            }
        }

        return $result;
    }
}
