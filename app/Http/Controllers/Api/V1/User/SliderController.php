<?php


namespace App\Http\Controllers\Api\V1\User;


use App\Models\Slider;

class SliderController extends \App\Http\Controllers\Api\BaseController
{
    public function getSliders()
    {
        try {
            $sliders = Slider::all();
            $data = [];
            foreach ($sliders as $slider) {
                $data[$slider->id] = [
                    'id' => $slider->id,
                    'name' => $slider->name
                ];
                $data[$slider->id]['images'] = [];
                foreach ($slider->images as $image) {
                    $data[$slider->id]['images'][] = $image->getUrl();
                }
            }
            if (count($data)) {
                $result = ['status' => 1, 'response' => 'success', 'action' => 'fetched', 'data' => $data, 'message' => 'Sliders fetched successfully'];
            } else {
                $result = ['status' => 0, 'response' => 'error', 'action' => 'retry', 'message' => 'No slider found'];
            }
        } catch (\Exception $exception) {
            $result = ['status' => 0, 'response' => 'error', 'message' => $exception->getMessage()];
        }
        return response()->json($result, 200);
    }
}
