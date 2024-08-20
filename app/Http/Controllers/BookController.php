<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BookController extends Controller
{
    //
    public function index(Request $request)
    {
        // Get the current page from query parameters
        $userID = auth::user()->id;
        $currentPage = $request->input('page', 1);

        // Define the number of items per page
        $perPage = 5;

        // Fetch all categories
        $categories = Category::all();

        // Get category filter and search term from query parameters
        $categoryFilter = $request->query('category');
        $searchTerm = $request->query('search');

        // Build the query
        $query = Book::where('user_id', $userID); // Filter books by user_id

        // Apply category filter if present
        if ($categoryFilter) {
            $query->where('category_id', $categoryFilter);
        }

        // Apply search filter by ID if present
        if ($searchTerm) {
            $query->where('id', $searchTerm);
        }

        // Fetch paginated items
        $items = $query->paginate($perPage);

        // Pass pagination and categories data to the view
        return view('user.index', [
            'books' => $items,
            'categories' => $categories,
            'currentPage' => $currentPage,
            'totalPages' => $items->lastPage(),
            'totalItems' => $items->total(),
            'start' => ($items->currentPage() - 1) * $perPage + 1,
            'end' => min($items->currentPage() * $perPage, $items->total())
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'pdf_file' => 'nullable|file|mimes:pdf',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'category_id' => 'required|exists:categories,id',
        ]);

        $bookData = $request->except(['pdf_file', 'cover_image']);

        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfFileName = 'pdf_' . time() . '.' . $pdfFile->getClientOriginalExtension();
            $bookData['pdf_file'] = $pdfFile->storeAs('public/pdfs', $pdfFileName);
        }

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageName = 'cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $bookData['cover_image'] = $coverImage->storeAs('public/images', $coverImageName);
        }

        $bookData['user_id'] = auth::user()->id;

        Book::create($bookData);

        return redirect()->route('admin')->with('success', 'Book created successfully.');
    }
    public function exportPdf()
    {
        $user = Auth::user(); // Get the currently authenticated user
        if ($user->role === 'Admin') {
            // If the user is an admin, get all books with their categories and users
            $books = Book::with('category', 'user')->get();
        } else {
            // If the user is not an admin, get books associated with this user
            $books = Book::with('category', 'user')->where('user_id', $user->id)->get();
        }
        $pdf = Pdf::loadView('export.pdf', compact('books'));
        return $pdf->download('books_list.pdf');
    }
    public function exportExcel()
    {
        // Ambil data buku beserta kategori dan pengguna
        $user = Auth::user(); // Get the currently authenticated user
        if ($user->role === 'Admin') {
            // If the user is an admin, get all books with their categories and users
            $books = Book::with('category', 'user')->get();
        } else {
            // If the user is not an admin, get books associated with this user
            $books = Book::with('category', 'user')->where('user_id', $user->id)->get();
        }
        // Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menulis header
        $header = ['Title', 'Quantity', 'Category', 'User'];
        $column = 'A';
        foreach ($header as $headerItem) {
            $sheet->setCellValue($column . '1', $headerItem);
            $column++;
        }

        // Menulis data
        $rowNumber = 2;
        foreach ($books as $book) {
            $sheet->setCellValue('A' . $rowNumber, $book->title);
            $sheet->setCellValue('B' . $rowNumber, $book->quantity);
            $sheet->setCellValue('C' . $rowNumber, $book->category->name ?? 'N/A');
            $sheet->setCellValue('D' . $rowNumber, $book->user->name ?? 'N/A');
            $rowNumber++;
        }

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'books_list.xlsx';

        // Output sebagai download
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:20480', // 20MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // 2MB max
        ]);

        // Update data
        $book->title = $request->input('title');
        $book->quantity = $request->input('quantity');
        $book->category_id = $request->input('category_id');
        $book->description = $request->input('description');

        // Handle PDF file
        if ($request->hasFile('pdf_file')) {
            // Remove old PDF if exists
            if ($book->pdf_file) {
                Storage::delete($book->pdf_file);
            }
            // Generate unique name and save new PDF file
            $pdfFile = $request->file('pdf_file');
            $pdfFileName = 'pdf_' . time() . '.' . $pdfFile->getClientOriginalExtension();
            $book->pdf_file = $pdfFile->storeAs('public/pdfs', $pdfFileName);
        }

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            // Remove old image if exists
            if ($book->cover_image) {
                Storage::delete($book->cover_image);
            }
            // Generate unique name and save new cover image
            $coverImage = $request->file('cover_image');
            $coverImageName = 'cover_' . time() . '.' . $coverImage->getClientOriginalExtension();
            $book->cover_image = $coverImage->storeAs('public/images', $coverImageName);
        }

        $book->save();

        return redirect()->route('admin')->with('success', 'Book updated successfully.');
    }


    public function destroy(Book $book)
    {
        if ($book->pdf_file) {
            Storage::delete($book->pdf_file);
        }
        if ($book->cover_image) {
            Storage::delete($book->cover_image);
        }
        $book->delete();

        return redirect()->route('admin')->with('success', 'Book deleted successfully.');
    }

    // public function export()
    // {
    //     $books = Book::all();
    //     $filename = 'books_list.xlsx';

    //     $headers = array(
    //         "Content-type" => "application/vnd.ms-excel",
    //         "Content-Disposition" => "attachment; filename=$filename",
    //         "Pragma" => "no-cache",
    //         "Cache-Control" => "must-revalidate, post-check=0, pre-check=0"
    //     );

    //     $handle = fopen('php://output', 'w+');

    //     // Add header row
    //     fputcsv($handle, [
    //         'ID',
    //         'Title',
    //         'Description',
    //         'Quantity',
    //         'PDF File',
    //         'Cover Image',
    //         'Category',
    //         'Created By'
    //     ]);

    //     foreach ($books as $book) {
    //         fputcsv($handle, [
    //             $book->id,
    //             $book->title,
    //             $book->description,
    //             $book->quantity,
    //             $book->pdf_file ? basename($book->pdf_file) : 'No File',
    //             $book->cover_image ? 'Image Available' : 'No Image',
    //             $book->category->name,
    //             $book->user->name ?? 'Unknown'
    //         ]);
    //     }

    //     fclose($handle);

    //     return response()->stream(
    //         function () use ($handle) {
    //             fclose($handle);
    //         },
    //         200,
    //         $headers
    //     );
    // }
}
