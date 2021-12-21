<?php

namespace App\Http\Controllers;

use App\Helpers\PaginatorHelpers;
use App\Helpers\Parser;
use App\Models\Offers;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $helpers = new Parser();
        $pages = Pages::where('user_id', auth()->user()->id)->get();
        $minPrice = collect();
        foreach ($pages as $page) {
            if ($page->offer->count() > 0) {
                $minPrice->push($helpers->getOfferMinPrice($page->id));
            }
        }
        return view('task.index', ['minPrice' => PaginatorHelpers::paginate($minPrice, 12, ['path' => 'task'])]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|active_url',
            'url_type' => 'required',
        ]);

        Pages::create([
            'user_id' => auth()->user()->id,
            'url' => $request->url,
            'type' => $request->url_type,
        ]);

        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(Pages $page): View
    {
        $lastOffer = Offers::where('page_id', $page->id)->latest()->first();
        $helpers = new Parser();
        $graphData = $helpers->getDataForGraph($page->type, $page->id);
        $offerMinPrice = $helpers->getOfferMinPrice($page->id);
        $offers = Offers::where('page_id', $page->id)->sortable('name')->paginate(15);

        return view('task.show', ['page' => $page, 'price' => $graphData[0], 'data' => $graphData[1],
            'lastOffer' => $lastOffer, 'offerMinPrice' => $offerMinPrice, 'offers' => $offers]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Pages $page): \Illuminate\Http\RedirectResponse
    {
        $page->delete();
        return redirect()->route('task.index');
    }
}
