<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\dailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Js;
use Yajra\DataTables\Contracts\DataTable;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(dailyOfferDataTable $dataTable) : View|JsonResponse
    {
       return $dataTable->render('admin.daily-offer.index');
    }

    function productSearch(Request $request) : Response {
        $product = Product::select('id', 'name','thumb_image')->where('name', 'like', '%' .
        $request->search . '%')->get();
        return response($product);



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('admin.daily-offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required','integer'],
            'status' => ['required','boolean']
        ]);

        $offer = new DailyOffer();
        $offer->product_id = $request->product_id;
        $offer->status = $request->status;
        $offer->save();

        toastr()->success('Daily Offer added successfully');
        return redirect()->route('admin.daily-offer.index');


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dailyOffer = DailyOffer::with('product')->findOrFail($id);
        return view('admin.daily-offer.edit', compact('dailyOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $request->validate([
            'product_id' => ['required','integer'],
            'status' => ['required','boolean']
        ]);

        $offer = DailyOffer::findOrFail($id);
        $offer->product_id = $request->product_id;
        $offer->status = $request->status;
        $offer->save();

        toastr()->success('Daily Offer added successfully');
        return redirect()->route('admin.daily-offer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try{
         DailyOffer::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);

        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}
