<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        $query = $request->user()
            ->notifications()
            ->latest();

        if ($request->status === 'unread') {
            $query->whereNull('read_at');
        } elseif ($request->status === 'read') {
            $query->whereNotNull('read_at');
        }

        $perPage   = $request->input('per_page', 15);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'data'         => $paginated->map(fn($n) => $this->format($n)),
            'unread_count' => $request->user()->unreadNotifications()->count(),
            'total'        => $paginated->total(),
            'per_page'     => $paginated->perPage(),
            'current_page' => $paginated->currentPage(),
            'last_page'    => $paginated->lastPage(),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $notification = $this->findNotification($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return response()->json([
            'data' => $this->format($notification),
        ]);
    }

    public function markAsRead(string $id): JsonResponse
    {
        $notification = $this->findNotification($id);

        if ($notification->read_at) {
            return response()->json([
                'message' => 'Notification already marked as read.',
                'data'    => $this->format($notification),
            ]);
        }

        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marked as read.',
            'data'    => $this->format($notification),
        ]);
    }


    public function markAsUnread(string $id): JsonResponse
    {
        $notification = $this->findNotification($id);

        $notification->markAsUnread();

        return response()->json([
            'message' => 'Notification marked as unread.',
            'data'    => $this->format($notification),
        ]);
    }


    public function markAllAsRead(Request $request): JsonResponse
    {
        $unread = $request->user()->unreadNotifications;
        $count  = $unread->count();

        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'message'       => 'All notifications marked as read.',
            'updated_count' => $count,
        ]);
    }


    public function destroy(string $id): JsonResponse
    {
        $notification = $this->findNotification($id);
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted successfully.',
        ]);
    }

    public function destroyAll(Request $request): JsonResponse
    {
        $query = DatabaseNotification::where('notifiable_id',   $user->id)
            ->where('notifiable_type', get_class($user));

        if ($request->boolean('only_read')) {
            $query->whereNotNull('read_at');
        }

        $count = $query->count();
        $query->delete();

        return response()->json([
            'message'        => 'Notifications deleted successfully.',
            'deleted_count'  => $count,
        ]);
    }

    private function findNotification(string $id): DatabaseNotification
    {
        return DatabaseNotification::where('id', $id)
            ->where('notifiable_id',   auth()->id())
            ->where('notifiable_type', get_class(auth()->user()))
            ->firstOrFail();
    }

    private function format(DatabaseNotification $notification): array
    {
        $data = $notification->data;

        return [
            'id'              => $notification->id,
            'type'            => $data['type']            ?? null,
            'title'           => $data['title']           ?? null,
            'message'         => $data['message']         ?? null,
            'extra'           => $this->extractExtra($data),
            'is_read'         => ! is_null($notification->read_at),
            'read_at'         => $notification->read_at,
            'created_at'      => $notification->created_at,
        ];
    }

    private function extractExtra(array $data): array
    {
        $skip = ['type', 'title', 'message'];
        return array_diff_key($data, array_flip($skip));
    }
}
