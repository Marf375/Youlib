<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserLibrary;
use App\Models\User; // не забудь подключить модель User

class StripeWebhookController extends Controller
{
public function handle(Request $request)
{
    $payload = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');
    $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

    try {
        $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        \Log::info('Webhook пришёл!');
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            \Log::info('Metadata получена:', (array) $session->metadata);
            $userId = $session->metadata->user_id ?? null;
            $cart = json_decode($session->metadata->cart ?? '[]', true);

            if ($userId && is_array($cart)) {
                $total = 0;
                foreach ($cart as $item) {
                    $total += floatval($item['bookPrice']);
                }

                $order = \App\Models\Order::create([
                    'user_id' => $userId,
                    'total_price' => $total,
                ]);

                foreach ($cart as $item) {
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'book_name' => $item['bookName'],
                        'book_price' => $item['bookPrice'],
                        'image' => $item['img'],
                    ]);

                    \App\Models\UserLibrary::updateOrCreate(
                        ['user_id' => $userId, 'book_name' => $item['bookName']],
                        ['image' => $item['img'], 'file_path' => $item['file_path']]
                    );
                }

                \Log::info("Заказ Stripe создан для пользователя $userId");
            } else {
                \Log::error('Stripe Webhook: не удалось получить user_id или cart');
            }
        }

        return response('Webhook processed', 200);
    } catch (\Exception $e) {
        \Log::error('Stripe Webhook error: ' . $e->getMessage());
        return response('Webhook error', 400);
    }
}

}




