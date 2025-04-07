<?php

namespace App\Http\Controllers;

class DashboardController
{
    public function route() {
        return redirect()->route("dashboard.item");
    }
}
