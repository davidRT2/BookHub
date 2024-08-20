<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = Auth::user();
        $role = $user->role; // Assuming the role is stored in the `role` attribute

        $currentPage = $request->input('page', 1);
        $perPage = 5; // Number of items per page
        $categories = Category::all(); // Fetch all categories

        $categoryFilter = $request->query('category'); // Get category filter from query parameters

        // Initialize the query builder
        $query = Book::query();

        if ($role == 'Admin') {
            // For Admins, filter books by category and paginate
            if ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            }
            $items = $query->paginate($perPage);

            return view('admin.index', [
                'books' => $items,
                'categories' => $categories,
                'currentPage' => $currentPage,
                'totalPages' => $items->lastPage(),
                'totalItems' => $items->total(),
                'start' => ($items->currentPage() - 1) * $perPage + 1,
                'end' => min($items->currentPage() * $perPage, $items->total())
            ]);
        } else if ($role == 'User') {
            // For Users, filter books by their user_id
            $userID = $user->id;

            // Add user_id filter
            $query->where('user_id', $userID);

            if ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            }

            $items = $query->paginate($perPage);

            return view('admin.index', [ // Assuming a different view for users
                'books' => $items,
                'categories' => $categories,
                'currentPage' => $currentPage,
                'totalPages' => $items->lastPage(),
                'totalItems' => $items->total(),
                'start' => ($items->currentPage() - 1) * $perPage + 1,
                'end' => min($items->currentPage() * $perPage, $items->total())
            ]);
        } else {
            // Handle cases where the role is neither Admin nor User
            abort(403, 'Unauthorized action.');
        }
    }
}
