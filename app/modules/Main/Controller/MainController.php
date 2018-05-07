<?php
namespace Modules\Main\Controller;

use Modules\Controller;
use Modules\Main\Model\UserModel;
use App\Libraries\Auth;

class MainController extends Controller
{
    public function index()
    {
        $user = new UserModel;
        $this->render('index.html', array(
            'tes' => 'tes'
        ));
    }

    public function home()
    {
        $user = new UserModel;
        $this->render('index.html', array(
            'tes' => 'tes'
        ));
    }
}
