<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateData;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
      $config['page_title'] = "Dashboard";
      $config['page_description'] = "Dashboard";
      $page_breadcrumbs = [
        ['page' => '/dashboard', 'title' => "Dashboard"],
      ];
      $totalUser = User::count();
      $totalTemplate = Template::count();
      $totalData = TemplateData::count();
      return view('backend.dashboard.index', compact('config', 'page_breadcrumbs', 'totalUser', 'totalTemplate', 'totalData'));
    }
}
