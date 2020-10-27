<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller {

    public function index() {
        (is_cli()) ? eval(\Psy\sh()) : null;
        if (is_post()) {
            if (isset($_FILES['foto'])) {
                jquery('#ft')->show();
                $img = base64_encode(file_get_contents($_FILES['foto']['tmp_name']));
                jquery('#ft')->attr('src', "data:image;base64,$img");
            }
            die;
        }
        return view('welcome_message');
    }

    //--------------------------------------------------------------------
}
