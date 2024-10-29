<?php

namespace DotMike\NmsWidgetAlertRules\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class PluginAdminController extends Controller
{

    // show plugin main page
    // GET /plugins/nmswidgetalertrules
    public function index()
    {
        Gate::authorize('admin');

        return view('nmswidgetalertrules::main');
    }
}
