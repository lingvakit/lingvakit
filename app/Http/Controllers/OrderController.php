<?php

namespace App\Http\Controllers;

use App\Mail\OrderPurchased;
use App\Mail\OrderPurchasedToAdmin;
use App\Models\LMS\Course;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use YooKassa\Client;

class OrderController extends Controller
{
    public function checkout(Course $course)
    {
        return view('site.orders.checkout', [
            'user' => Auth::user(),
            'course' => $course,
        ]);
    }

    public function notification(Course $course)
    {
        return view('site.orders.order-notification');
    }

    public function storeOrder(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $user = Auth::user();
        $order = false;
        $userOrders = Order::where('user_id', $user->id)->get();

        /* Create new Order */
        foreach ($userOrders as $userOrder) {
            foreach ($userOrder->details as $detail) {
                if ($detail->course_id === $course->id) {
                    $order = $userOrder;
                    $detail->update([
                        'price' => $course->price,
                        'quantity' => 1,
                        'discount' => $course->getDiscount(),
                        'total' => $course->getTotalPrice(),
                    ]);
                }
            }
        }

        /* Create or Update Order Details */
        if (!$order) {
            $order = Order::add($request->all(), $user);
            OrderDetail::add($order, $course);
        } else {
            $currentPromo = $request->input('promocode_applied');
            $promo = Promocode::where('code', $currentPromo)->first();
            $order->updateDiscount($promo);
        }

        $total = 0;
        if ($order->discount) {
            foreach ($order->details as $detail) {
                $total += $detail->price;
            }
            $total = $total - $order->discount;
        } else {
            foreach ($order->details as $detail) {
                $total += $detail->total;
            }
        }
        $order->update(['total' => $total]);
        $user->update($request->all());

        $paymentMethod = $request->input('payment_method');

        /* Check Payment Method */
        if ($paymentMethod === 'card_payment') {

            $client = new Client();
            // Рабочая касс lingvakit.ru
            $client->setAuth('751820', 'live_HKrA7o2lyLTqCkYQ4QNeF7qnrMAlubiijnZafBbCNKw');
            // Тест
            // $client->setAuth('785971', 'test_e31vp0OKw6pXDmAvCk7jvloxc6lWiHS8ZwBeVyAK9tc');

            $response = $client->createPayment(
                array(
                    'amount' => array(
                        'value' => $total,
                        'currency' => 'RUB',
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => route('orders.payment-info'),
                    ),
                    "receipt" => array(
                        "customer" => array(
                            "full_name" => $user->getFullName(),
                            "phone" => $user->formatPhoneNumber(),
                        ),
                        "items" => array(
                            array(
                                "description" => $course->title,
                                "quantity" => "1.00",
                                "amount" => array(
                                    "value" => $total,
                                    "currency" => "RUB"
                                ),
                                "vat_code" => "1",
                                "payment_mode" => "full_prepayment",
                                "payment_subject" => "service"
                            )
                        )
                    ),
                    'capture' => true,
                    'description' => 'Заказ №' . $order->id,
                ),
                uniqid('', true)
            );

            $paymentData = $response->jsonSerialize();
            $paymentUrl = $response->getConfirmation()->getConfirmationUrl();

            Payment::create([
                'payment_id' => $paymentData['id'],
                'order_id' => $order->id,
                'status' => $paymentData['status'],
                'amount' => $paymentData['amount']['value'],
                'date' => date('Y-m-d'),
            ]);

            return redirect($paymentUrl);

        } else {
            /* Another Payment Method */
            /*
             * TODO: Реализовать дальнейшие действия с пользователем и учителем
             */

            $onHolding = OrderStatus::where('title', 'on_holding')->first()->id;
            $order->update([ 'status_id' => $onHolding ]);

            /* Отправляем e-mail студенту */
            Mail::to($user->email)->send(new OrderPurchased($course, $order));

            /* Отправляем e-mail админу */
            Mail::to('info@lingva-kit.ru')->send(new OrderPurchasedToAdmin($course, $order));

            $message = __('Your order has been successfully completed. Our employee will contact you to clarify the details.');

            return redirect()->route('orders.noty', $course->id)->with('message', $message);
        }
    }

    public function paymentResult()
    {
        $client = new Client();
        // Рабочая касс lingvakit.ru
        $client->setAuth('751820', 'live_HKrA7o2lyLTqCkYQ4QNeF7qnrMAlubiijnZafBbCNKw');
        // Тест
        // $client->setAuth('785971', 'test_e31vp0OKw6pXDmAvCk7jvloxc6lWiHS8ZwBeVyAK9tc');

        $user = Auth::user();
        $order = $user->latestOrder();
        $payment = $order->getCurrentPayment();
        $paymentData = $client->getPaymentInfo($payment->payment_id)->jsonSerialize();

        /* Payment Info */
        $paymentId = $paymentData['id'];
        $paymentStatus = $paymentData['status'];
        $paymentPaid = $paymentData['paid'];
        $paymentAmount = $paymentData['amount']['value'];
        $paymentType = $paymentData['payment_method']['type'];
        $paymentCardFirst6 = getArrayData($paymentData, 'first6');
        $paymentCardLast4 = getArrayData($paymentData, 'last4');
        $paymentCardExpiryMonth = getArrayData($paymentData, 'expiry_month');
        $paymentCardExpiryYear = getArrayData($paymentData, 'expiry_year');
        $paymentCardType = getArrayData($paymentData, 'expiry_year');
        $paymentCardIssuerCountry = getArrayData($paymentData, 'issuer_country');

        $payment->update([
            'status' => $paymentStatus,
            'paid' => $paymentPaid,
            'amount' => $paymentAmount,
            'type' => $paymentType,
            'first6' => $paymentCardFirst6,
            'last4' => $paymentCardLast4,
            'expiry_month' => $paymentCardExpiryMonth,
            'expiry_year' => $paymentCardExpiryYear,
            'card_type' => $paymentCardType,
            'issuer_country' => $paymentCardIssuerCountry,
        ]);

        $course = Course::find($order->details()->first()->course_id);

        if ($payment->paid && !$user->courses->contains($course->id)) {
            /* прикрепляем курс к студенту */
            $user->courses()->attach($course->id);

            /* Отправляем e-mail студенту */
            Mail::to($user->email)->send(new OrderPurchased($course, $order));

            /* Отправляем e-mail админу */
            Mail::to('info@lingva-kit.ru')->send(new OrderPurchasedToAdmin($course, $order));
        }

        return view('site.orders.payment-result', [
            'order' => $order,
            'course' => $course,
        ]);
    }
}
