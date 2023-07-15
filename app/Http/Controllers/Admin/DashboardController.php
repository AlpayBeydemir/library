<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\BorrowProduct;
use App\Models\EventModel;
use App\Models\EventParticipantsModel;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $startDate           = Carbon::now()->startOfMonth();
        $endDate             = Carbon::now()->endOfMonth();
        $countUser           = User::count();
        $countProduct        = Product::where('is_active', 0)->count();
        $countEvent          = EventModel::where('deleted', 0)->count();
        $countParticipants   = EventParticipantsModel::where('status', 1)->count();
        $countAuthors        = Author::count();
        $countBorrow = BorrowProduct::whereBetween('issued_date', [$startDate, $endDate])->count();

        $data = [
            "user"            => $countUser,
            "product"         => $countProduct,
            "event"           => $countEvent,
            "participants"    => $countParticipants,
            "authors"         => $countAuthors,
            "borrow"          => $countBorrow,
        ];

        return view('admin.dashboard', $data);
    }
}
