<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        return view("guest.welcome");
    }

    public function solution($entity)
    {
        switch ($entity)
        {
                case "farmer":
                default:
                $view = "guest.solution.farmer";
                break;
            case "small-business":
                $view ="guest.solution.business";
                break;
            case "institutions":
                $view ="guest.solution.institution";
                break;
        }

        return view($view);
    }

    public function career()
    {
        return view("guest.company.career");
    }

    public function services()
    {
        return view("guest.company.services");
    }

    public function about()
    {
        $contents = ContentPage::whereHas('categories', function (Builder $query) {
            $query->where('name', 'about');
        })->get();
        $siteSetting = SiteSetting::first();
        return view("guest.company.about",compact("contents", 'siteSetting'));
    }
    public function contact()
    {
        return view("guest.company.contact");
    }


    public function terms()
    {
        $contents = ContentPage::whereHas('categories', function (Builder $query) {
            $query->where('name', 'terms');
        })->get();
        $siteSetting = SiteSetting::first();
        return view("guest.company.terms",compact("contents", 'siteSetting'));

    }

    public function privacy()
    {
        $contents = ContentPage::whereHas('categories', function (Builder $query) {
            $query->where('name', 'privacy');
        })->get();
        $siteSetting = SiteSetting::first();
        return view("guest.company.privacy",compact("contents", 'siteSetting'));

    }

    public function webViewTerms()
    {
        $contents = ContentPage::whereHas('categories', function (Builder $query) {
            $query->where('name', 'terms');
        })->get();
        $siteSetting = SiteSetting::first();
        return view("guest.company.webViewTerms",compact("contents", 'siteSetting'));
    }

    public function webViewAbout()
    {
        $contents = ContentPage::whereHas('categories', function (Builder $query) {
            $query->where('name', 'terms');
        })->get();
        $siteSetting = SiteSetting::first();
        return view("guest.company.webViewAbout",compact("contents", 'siteSetting'));
    }

    public function webViewPrivacyPolicy()
    {
        $contents = ContentPage::whereHas('categories', function (Builder $query) {
            $query->where('name', 'terms');
        })->get();
        $siteSetting = SiteSetting::first();
        return view("guest.company.webViewPrivacyPolicy",compact("contents", 'siteSetting'));
    }
}
