<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Book; 
class Revibook extends Controller
{
    /**
     * Получение отзывов для конкретной книги с пагинацией
     */
    public function getBookReviews($bookId, Request $request)
{
    try {
        // Валидация ID книги
        if (!is_numeric($bookId) || $bookId <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Неверный ID книги'
            ], 400);
        }

        // Проверка существования книги
        if (!Book::where('id', $bookId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Книга не найдена'
            ], 404);
        }

        // Пагинация
        $perPage = $request->get('per_page', 5);
        $reviews = Review::with(['user' => function($query) {
                $query->select('id', 'name');
            }])
            ->where('book_id', $bookId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $reviews->items(),
            'current_page' => $reviews->currentPage(),
            'last_page' => $reviews->lastPage(),
            'per_page' => $reviews->perPage(),
            'total' => $reviews->total()
        ]);

    } catch (\Exception $e) {
        // Логирование ошибки
        \Log::error('Ошибка при получении отзывов: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Внутренняя ошибка сервера',
            'error' => env('APP_DEBUG') ? $e->getMessage() : null
        ], 500);
    }
}

    /**
     * Получение имени пользователя по ID
     */
    public function getUserName($userId)
    {
        // Валидация ID пользователя
        if (!is_numeric($userId) || $userId <= 0) {
            return response()->json(['error' => 'Invalid user ID'], 400);
        }

        $user = User::select('id', 'name')->find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['name' => $user->name]);
    }

    /**
     * Создание нового отзыва
     */
    public function storeReview(Request $request)
    {
        // Валидация входных данных
        $validated = $request->validate([
            'book_id' => 'required|integer|min:1|exists:books,id',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Создание отзыва
        $review = Review::create([
            'user_id' => Auth::id(),
            'book_id' => $validated['book_id'],
            'content' => $validated['content'],
            'rating' => $validated['rating']
        ]);

        // Загружаем связанные данные пользователя
        $review->load('user:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully',
            'review' => $review
        ], 201);
    }
}