<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\ServiceArea;
use App\Models\SessionPlan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalMessages'  => ContactMessage::count(),
            'unreadMessages' => ContactMessage::unread()->count(),
            'recentMessages' => ContactMessage::recent()->limit(5)->get(),
            'totalFaqs'      => Faq::count(),
            'totalAreas'     => ServiceArea::count(),
            'totalPlans'     => SessionPlan::count(),
        ]);
    }
}
