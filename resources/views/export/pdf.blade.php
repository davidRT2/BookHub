<!DOCTYPE html>
<html>

<head>
    <title>Books List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
            height: auto;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            text-align: center;
        }

        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/detik.png') }}" alt="Detik Logo">
        <h1>Book Hub by detik.com</h1>
    </div>
    <h2>Books List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Cover Image</th>
                <th>Category</th>
                @if (Auth::user()->role === 'Admin')
                    <th>Created By</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->description }}</td>
                    <td>{{ $book->quantity }}</td>
                    <td>
                        @if ($book->cover_image && Storage::exists($book->cover_image))
                            <img src="{{ storage_path(basename($book->cover_image)) }}" alt="Cover Image"
                                class="w-24 h-auto">
                        @else
                            No Image
                        @endif
                    </td>


                    <td>{{ $book->category->name }}</td>
                    @if (Auth::user()->role === 'Admin')
                        <td>{{ $book->user->name ?? 'Unknown' }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
