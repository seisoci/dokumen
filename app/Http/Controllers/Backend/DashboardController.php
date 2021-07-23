<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
      $config['page_title'] = "Dashboard";
      $config['page_description'] = "Dashboard";
      $page_breadcrumbs = [
        ['page' => '/dashboard', 'title' => "Dashboard"],
      ];
      $data = NULL;
      return view('backend.dashboard.index', compact('config', 'page_breadcrumbs', 'data'));
    }
}
