<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method POST
 * @param image[] Image Files
 */
class ImageController extends Controller
{
    public function uploadMultipleImage(Request $request)
    {
        $response = array('base_url' => url('/'), 'data' => array());

        if ($request->has('image')) {
            $images = $request->image;
            foreach ($images as $key => $image) {
                $nameFile = time() . $key . '.' . $image->getClientOriginalExtension();
                $path = public_path('upload/images');
                $isMoved = $image->move($path, $nameFile);

                if($isMoved){
                    $response['data'][] = array(
                        'image_path' => "/upload/images/$nameFile",
                        'status' => "Upload Success"
                    );
                }
            }
        }

        return response()->json($response, status: 201);
    }
}
