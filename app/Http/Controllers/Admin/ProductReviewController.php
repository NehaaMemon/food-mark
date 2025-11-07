<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductRatingDataTable;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


use function Termwind\render;

class ProductReviewController extends Controller
{
   function index(ProductRatingDataTable $datatable) : View|JsonResponse {
        return $datatable->render('admin.product.product-review.index');
   }

   function updateStatus(Request $request) : Response {

      $review = ProductRating::findOrFail($request->id);
        $review->status = $request->status;
        $review->save();

        return response(['status' => 'success','message'=>'Status Updated Successflly!']);
   }
     function destroy(string $id) : Response{
             try {
            $review = ProductRating::FindOrFail($id);
            $review->Delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something Went Wrong']);
        }

    }
}
