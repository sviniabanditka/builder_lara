<?php namespace Vis\Builder;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class TBController extends Controller
{

    public function showDashboard()
    {
       return Redirect::to("/admin/tree");
    } // end showDashboard

    public function doChangeSkin()
    {
        $skin = Input::get('skin');
        Cookie::queue('skin', $skin, "100000");
    }
    public function doChangeLangAdmin()
    {
        $lang = Input::get('lang');
        Cookie::queue('lang_admin', $lang, "100000000");

        return Redirect::back();
    }

    public function doSaveMenuPreference()
    {
        $option = Input::get('option');
        $cookie = Cookie::forever('tb-misc-body_class', $option);
        
        $data = array(
            'status' => true
        );
        $response = Response::json($data);
        $response->headers->setCookie($cookie);
        
        return $response;
    } // end doSaveMenuPreference

    public static function returnError($exception, $code)
    {

        $message = $exception->getMessage();

        if (!$message) {
            $message = "404 error";
        }

        $data = array(
                "status" => "error",
                "code" => $code,
                "message" => $message
            );
        return Response::json($data, $code);
    }
}