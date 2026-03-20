<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Product and Variant names (configured here for easy updates)
     */
    protected $productName = 'Anisenso Foundation Fertilization Course';
    protected $variantName = '12 Months Subscription';
    protected $storeName = 'Ani-Senso';
    protected $promoPrice = 1999.00;
    protected $regularPrice = 8000.00;
    protected $timerDuration = 13 * 60; // 13 minutes in seconds
    protected $exitPromoPrice = 1500.00; // Exit intent price when promo is active
    protected $exitRegularPrice = 2499.00; // Exit intent price when promo ended

    /**
     * Check if promo is still active based on cookie timer
     */
    protected function isPromoActive()
    {
        // Read directly from $_COOKIE since it's a JavaScript-set cookie (not encrypted by Laravel)
        $timerCookie = $_COOKIE['anisenso_price_timer'] ?? null;

        if (!$timerCookie) {
            return true; // No cookie yet, promo is active
        }

        $startTime = (int) $timerCookie;
        $now = time();
        $elapsed = $now - $startTime;

        return $elapsed < $this->timerDuration;
    }

    /**
     * Get the current price based on promo status and exit intent
     */
    protected function getCurrentPrice($exitPrice = null)
    {
        // Check if this is an exit intent price
        if ($exitPrice !== null) {
            $validExitPrices = [$this->exitPromoPrice, $this->exitRegularPrice];
            if (in_array((float)$exitPrice, $validExitPrices)) {
                return (float)$exitPrice;
            }
        }

        return $this->isPromoActive() ? $this->promoPrice : $this->regularPrice;
    }

    /**
     * Get payment settings for the store
     * @return object|null Payment settings object with active methods
     */
    protected function getPaymentSettings()
    {
        // Find the store by name
        $store = DB::table('ecom_product_stores')
            ->where('storeName', $this->storeName)
            ->where('deleteStatus', 1)
            ->first();

        if (!$store) {
            Log::warning('Store not found for payment settings', ['storeName' => $this->storeName]);
            return null;
        }

        // Get payment settings for this store
        $settings = DB::table('ecom_store_payment_settings')
            ->where('storeId', $store->id)
            ->where('deleteStatus', 1)
            ->first();

        if (!$settings) {
            Log::info('No payment settings found for store', ['storeId' => $store->id]);
            return null;
        }

        // Build payment methods array with only active methods
        $paymentMethods = [];

        // Bank Transfer
        if ($settings->isBankActive && $settings->bankName && $settings->bankAccountName && $settings->bankAccountNumber) {
            $paymentMethods['bank'] = [
                'name' => 'Bank Transfer',
                'type' => 'bank',
                'icon' => 'bank',
                'bankName' => $settings->bankName,
                'accountName' => $settings->bankAccountName,
                'accountNumber' => $settings->bankAccountNumber,
                'qrCode' => $settings->bankQrCodeImage ? config('app.btc_check_url', 'http://localhost:8000') . '/' . $settings->bankQrCodeImage : null,
            ];
        }

        // GCash
        if ($settings->isGcashActive && $settings->gcashNumber && $settings->gcashAccountName) {
            $paymentMethods['gcash'] = [
                'name' => 'GCash',
                'type' => 'ewallet',
                'icon' => 'gcash',
                'number' => $settings->gcashNumber,
                'accountName' => $settings->gcashAccountName,
                'qrCode' => $settings->qrCodeImage ? config('app.btc_check_url', 'http://localhost:8000') . '/' . $settings->qrCodeImage : null,
            ];
        }

        // Maya
        if ($settings->isMayaActive && $settings->mayaNumber && $settings->mayaAccountName) {
            $paymentMethods['maya'] = [
                'name' => 'Maya',
                'type' => 'ewallet',
                'icon' => 'maya',
                'number' => $settings->mayaNumber,
                'accountName' => $settings->mayaAccountName,
                'qrCode' => $settings->mayaQrCodeImage ? config('app.btc_check_url', 'http://localhost:8000') . '/' . $settings->mayaQrCodeImage : null,
            ];
        }

        // PayPal
        if ($settings->isPaypalActive && $settings->paypalEmail) {
            $paymentMethods['paypal'] = [
                'name' => 'PayPal',
                'type' => 'international',
                'icon' => 'paypal',
                'email' => $settings->paypalEmail,
                'accountName' => $settings->paypalAccountName,
            ];
        }

        return (object) [
            'methods' => $paymentMethods,
            'instructions' => $settings->paymentInstructions,
            'hasAnyMethod' => count($paymentMethods) > 0,
        ];
    }

    /**
     * Main checkout entry point - redirects based on session state
     */
    public function index(Request $request)
    {
        // Check if user has completed step 1 (has order in progress)
        $orderId = session('checkout_order_id');
        $step1Complete = session('checkout_step1_complete');

        if ($orderId && $step1Complete) {
            // User has completed step 1, redirect to step 2
            return redirect()->route('checkout.step2.page');
        }

        // Otherwise start fresh at step 1
        return redirect()->route('checkout.step1.page');
    }

    /**
     * Show Step 1 - Account Information
     */
    public function stepOnePage(Request $request)
    {
        // Check if step 1 is already complete - redirect to step 2
        $orderId = session('checkout_order_id');
        $step1Complete = session('checkout_step1_complete');

        if ($orderId && $step1Complete) {
            return redirect()->route('checkout.step2.page');
        }

        // Clear previous checkout session to start fresh
        session()->forget([
            'checkout_order_id',
            'checkout_order_number',
            'checkout_purchaser',
            'checkout_variant_id',
            'checkout_client_id',
            'checkout_account_email',
            'checkout_account_phone',
            'checkout_account_type',
            'checkout_login_method',
            'checkout_step1_complete',
            'checkout_email',
            'checkout_email_exists',
        ]);

        $isPromoActive = $this->isPromoActive();
        $exitPrice = $request->query('exit_price');
        $currentPrice = $this->getCurrentPrice($exitPrice);

        // Determine if exit intent price is being used
        $isExitIntent = $exitPrice !== null && in_array((float)$exitPrice, [$this->exitPromoPrice, $this->exitRegularPrice]);

        // Get payment settings for the store
        $paymentSettings = $this->getPaymentSettings();

        return view('checkout.index', [
            'productName' => $this->productName,
            'variantName' => $this->variantName,
            'price' => $currentPrice,
            'isPromoActive' => $isPromoActive,
            'isExitIntent' => $isExitIntent,
            'promoPrice' => $this->promoPrice,
            'regularPrice' => $this->regularPrice,
            'exitPrice' => $exitPrice,
            'paymentSettings' => $paymentSettings,
            'serverStep' => 1,
        ]);
    }

    /**
     * Show Step 2 - Payment
     */
    public function stepTwoPage(Request $request)
    {
        // Check if step 1 is complete
        $orderId = session('checkout_order_id');
        $step1Complete = session('checkout_step1_complete');

        if (!$orderId || !$step1Complete) {
            // Step 1 not complete, redirect back
            return redirect()->route('checkout.step1.page');
        }

        // Get order data from session
        $purchaser = session('checkout_purchaser', []);
        $emailExists = session('checkout_email_exists', false);

        $isPromoActive = $this->isPromoActive();
        $exitPrice = $request->query('exit_price');
        $currentPrice = $this->getCurrentPrice($exitPrice);

        // Determine if exit intent price is being used
        $isExitIntent = $exitPrice !== null && in_array((float)$exitPrice, [$this->exitPromoPrice, $this->exitRegularPrice]);

        // Get payment settings for the store
        $paymentSettings = $this->getPaymentSettings();

        return view('checkout.index', [
            'productName' => $this->productName,
            'variantName' => $this->variantName,
            'price' => $currentPrice,
            'isPromoActive' => $isPromoActive,
            'isExitIntent' => $isExitIntent,
            'promoPrice' => $this->promoPrice,
            'regularPrice' => $this->regularPrice,
            'exitPrice' => $exitPrice,
            'paymentSettings' => $paymentSettings,
            'serverStep' => 2,
            'serverPurchaser' => $purchaser,
            'serverEmailExists' => $emailExists,
            'serverOrderNumber' => session('checkout_order_number'),
        ]);
    }

    /**
     * Reset checkout session and start fresh
     */
    public function resetCheckout()
    {
        session()->forget([
            'checkout_order_id',
            'checkout_order_number',
            'checkout_purchaser',
            'checkout_variant_id',
            'checkout_client_id',
            'checkout_account_email',
            'checkout_account_phone',
            'checkout_account_type',
            'checkout_login_method',
            'checkout_step1_complete',
            'checkout_email',
            'checkout_email_exists',
        ]);

        return redirect()->route('checkout.step1.page');
    }

    /**
     * Check if an email already exists as a user
     */
    public function checkEmailExists(Request $request)
    {
        $email = strtolower(trim($request->email));

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'exists' => false,
            ]);
        }

        $existingUser = DB::table('clients_access_login')
            ->where('clientEmailAddress', $email)
            ->where('productStore', $this->storeName)
            ->where('deleteStatus', 1)
            ->first();

        return response()->json([
            'exists' => (bool) $existingUser,
            'firstName' => $existingUser ? $existingUser->clientFirstName : null,
            'lastName' => $existingUser ? $existingUser->clientLastName : null,
        ]);
    }

    /**
     * Step 1: Save account info and create pending order
     * Handles both existing accounts (email only) and new accounts (full registration)
     * Triggers both shopping abandonment and special tag flows
     */
    public function stepOne(Request $request)
    {
        $emailExists = (bool) $request->emailExists;

        // Build validation rules based on whether email exists
        $rules = [
            'email' => 'required|email|max:255',
            'emailExists' => 'nullable|boolean',
        ];

        $messages = [
            'email.required' => 'Kailangan ang email address.',
            'email.email' => 'Invalid email format.',
        ];

        // For new accounts, validate registration fields
        if (!$emailExists) {
            $rules['firstName'] = 'required|string|max:100';
            $rules['lastName'] = 'required|string|max:100';
            $rules['phone'] = ['required', 'regex:/^(\+?63|0)?9\d{9}$/'];
            $rules['password'] = 'required|min:8|confirmed';

            $messages['firstName.required'] = 'Kailangan ang first name.';
            $messages['lastName.required'] = 'Kailangan ang last name.';
            $messages['phone.required'] = 'Kailangan ang phone number.';
            $messages['phone.regex'] = 'Invalid phone format. Use 09XXXXXXXXX format.';
            $messages['password.required'] = 'Kailangan ang password.';
            $messages['password.min'] = 'Ang password ay dapat may 8 characters o higit pa.';
            $messages['password.confirmed'] = 'Hindi tugma ang password confirmation.';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $email = strtolower(trim($request->email));

            // Check if existing account and get their details
            $existingClient = null;
            $firstName = '';
            $lastName = '';
            $phone = '';
            $hashedPassword = null;

            if ($emailExists) {
                // Existing account - get their details from database
                $existingClient = DB::table('clients_access_login')
                    ->where('clientEmailAddress', $email)
                    ->where('productStore', $this->storeName)
                    ->where('deleteStatus', 1)
                    ->first();

                if ($existingClient) {
                    $firstName = $existingClient->clientFirstName ?? '';
                    $lastName = $existingClient->clientLastName ?? '';
                    $phone = $existingClient->clientPhoneNumber ?? '';
                }
            } else {
                // New account - get registration details from request
                $firstName = trim($request->firstName);
                $lastName = trim($request->lastName);
                $phone = $this->normalizePhoneNumber($request->phone);
                $hashedPassword = Hash::make($request->password);

                // Check if phone already exists
                $existingPhone = DB::table('clients_access_login')
                    ->where('clientPhoneNumber', $phone)
                    ->where('productStore', $this->storeName)
                    ->where('deleteStatus', 1)
                    ->first();

                if ($existingPhone) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['phone' => ['Ang phone number na ito ay may existing account na.']],
                    ], 422);
                }

                // Double-check email doesn't exist
                $existingEmail = DB::table('clients_access_login')
                    ->where('clientEmailAddress', $email)
                    ->where('productStore', $this->storeName)
                    ->where('deleteStatus', 1)
                    ->first();

                if ($existingEmail) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ang email na ito ay may existing account na. Please refresh and try again.',
                    ], 422);
                }
            }

            // Get product and variant from btc-check database
            $product = DB::table('ecom_products')
                ->where('productName', $this->productName)
                ->where('deleteStatus', 1)
                ->where('isActive', 1)
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found. Please contact support.',
                ], 404);
            }

            $variant = DB::table('ecom_products_variants')
                ->where('ecomProductsId', $product->id)
                ->where('ecomVariantName', $this->variantName)
                ->where('deleteStatus', 1)
                ->where('isActive', 1)
                ->first();

            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variant not found. Please contact support.',
                ], 404);
            }

            // Get current price based on promo status and exit intent
            $exitPrice = $request->exitPrice;
            $currentPrice = $this->getCurrentPrice($exitPrice);
            $isPromoActive = $this->isPromoActive();
            $isExitIntent = $exitPrice !== null && in_array((float)$exitPrice, [$this->exitPromoPrice, $this->exitRegularPrice]);

            // Build price note
            if ($isExitIntent) {
                $priceNote = 'Exit intent price applied (₱' . number_format($currentPrice, 2) . ')';
            } elseif ($isPromoActive) {
                $priceNote = 'Promo price applied';
            } else {
                $priceNote = 'Regular price (promo ended)';
            }

            // Check if order already exists in session (user went back to step 1)
            $existingOrderId = session('checkout_order_id');
            $orderNumber = session('checkout_order_number');

            if ($existingOrderId) {
                // Update existing order instead of creating new one
                $updateData = [
                    'clientEmail' => $email,
                    'subtotal' => $currentPrice,
                    'grandTotal' => $currentPrice,
                    'netRevenue' => $currentPrice,
                    'orderNotes' => "Created from AniSenso Course checkout. {$priceNote} (Updated)",
                    'updated_at' => now(),
                ];

                // If existing client, update with their info
                if ($existingClient) {
                    $updateData['clientId'] = $existingClient->id;
                    $updateData['clientFirstName'] = $firstName;
                    $updateData['clientLastName'] = $lastName;
                    $updateData['clientPhone'] = $phone;
                }

                DB::table('ecom_orders')
                    ->where('id', $existingOrderId)
                    ->update($updateData);

                // Update order item
                $itemUpdateData = [
                    'unitPrice' => $currentPrice,
                    'subtotal' => $currentPrice,
                    'accessClientEmail' => $email,
                    'updated_at' => now(),
                ];

                if ($existingClient) {
                    $itemUpdateData['accessClientId'] = $existingClient->id;
                    $itemUpdateData['accessClientName'] = trim($firstName . ' ' . $lastName);
                    $itemUpdateData['accessClientPhone'] = $phone;
                }

                DB::table('ecom_order_items')
                    ->where('orderId', $existingOrderId)
                    ->update($itemUpdateData);

                $orderId = $existingOrderId;
            } else {
                // Generate new order number
                $orderNumber = $this->generateOrderNumber();

                // Generate recovery token for abandoned cart recovery
                $recoveryToken = Str::random(48);
                $recoveryExpiresAt = Carbon::now()->addDays(7);

                // Create pending order in ecom_orders
                $orderId = DB::table('ecom_orders')->insertGetId([
                    'usersId' => 1, // System user
                    'orderNumber' => $orderNumber,
                    'orderStatus' => 'pending',
                    'shippingStatus' => 'not_applicable',
                    'clientId' => $existingClient ? $existingClient->id : null,
                    'clientFirstName' => $firstName,
                    'clientMiddleName' => '',
                    'clientLastName' => $lastName,
                    'clientPhone' => $phone,
                    'clientEmail' => $email,
                    'shippingType' => null,
                    'subtotal' => $currentPrice,
                    'shippingTotal' => 0,
                    'discountTotal' => 0,
                    'grandTotal' => $currentPrice,
                    'affiliateCommissionTotal' => 0,
                    'netRevenue' => $currentPrice,
                    'orderNotes' => "Created from AniSenso Course checkout. {$priceNote}",
                    'isPackage' => 0,
                    'recoveryToken' => $recoveryToken,
                    'recoveryTokenExpiresAt' => $recoveryExpiresAt,
                    'deleteStatus' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create order item
                DB::table('ecom_order_items')->insert([
                    'orderId' => $orderId,
                    'productId' => $product->id,
                    'productName' => $product->productName,
                    'productStore' => $product->productStore ?? $this->storeName,
                    'productType' => 'access',
                    'variantId' => $variant->id,
                    'variantName' => $variant->ecomVariantName,
                    'variantSku' => $variant->variantSku ?? null,
                    'variantImage' => $variant->variantImage ?? null,
                    'unitPrice' => $currentPrice,
                    'quantity' => 1,
                    'subtotal' => $currentPrice,
                    'shippingMethodId' => null,
                    'shippingMethodName' => null,
                    'shippingCost' => 0,
                    'accessClientId' => $existingClient ? $existingClient->id : null,
                    'accessClientName' => trim($firstName . ' ' . $lastName),
                    'accessClientPhone' => $phone,
                    'accessClientEmail' => $email,
                    'deleteStatus' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Store order info in session for next steps
            session([
                'checkout_order_id' => $orderId,
                'checkout_order_number' => $orderNumber,
                'checkout_email' => $email,
                'checkout_email_exists' => $emailExists,
                'checkout_purchaser' => [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phone' => $phone,
                    'email' => $email,
                ],
                'checkout_variant_id' => $variant->id,
                'checkout_account_email' => $email,
                'checkout_account_phone' => $phone,
            ]);

            // If existing client, store their ID
            if ($existingClient) {
                session([
                    'checkout_client_id' => $existingClient->id,
                    'checkout_account_type' => 'existing',
                ]);
            } else {
                // For new accounts, store pending account info
                session([
                    'checkout_account_type' => 'manual',
                    'checkout_login_method' => 'email',
                ]);
            }

            // For new accounts, store pending account data in order notes
            if (!$emailExists && $hashedPassword) {
                $pendingAccountData = [
                    'pending_account' => true,
                    'first_name' => $firstName,
                    'middle_name' => '',
                    'last_name' => $lastName,
                    'phone' => $phone,
                    'email' => $email,
                    'password_hash' => $hashedPassword,
                    'login_method' => 'email',
                    'store' => $this->storeName,
                ];

                $existingNotes = DB::table('ecom_orders')->where('id', $orderId)->value('orderNotes') ?? '';
                $pendingAccountNotes = "\n\n" . str_repeat('-', 40) . "\n";
                $pendingAccountNotes .= "PENDING ACCOUNT CREATION\n";
                $pendingAccountNotes .= str_repeat('-', 40) . "\n";
                $pendingAccountNotes .= "Name: {$firstName} {$lastName}\n";
                $pendingAccountNotes .= "Email: {$email}\n";
                $pendingAccountNotes .= "Phone: {$phone}\n";
                $pendingAccountNotes .= "Store: {$this->storeName}\n";
                $pendingAccountNotes .= "Login Method: email\n";
                $pendingAccountNotes .= str_repeat('-', 40) . "\n";
                $pendingAccountNotes .= "[PENDING_ACCOUNT_JSON]\n";
                $pendingAccountNotes .= json_encode($pendingAccountData, JSON_PRETTY_PRINT);
                $updatedNotes = $existingNotes . $pendingAccountNotes;

                DB::table('ecom_orders')
                    ->where('id', $orderId)
                    ->update([
                        'clientFirstName' => $firstName,
                        'clientLastName' => $lastName,
                        'clientPhone' => $phone,
                        'orderNotes' => $updatedNotes,
                        'updated_at' => now(),
                    ]);
            }

            // Trigger Shopping Abandonment flows for this product/variant
            if (!$existingOrderId) {
                $clientName = trim($firstName . ' ' . $lastName) ?: $email;

                $contextData = [
                    'client_name' => $clientName,
                    'client_first_name' => $firstName ?: $email,
                    'client_last_name' => $lastName,
                    'client_email' => $email,
                    'client_phone' => $phone,
                    'order_id' => $orderId,
                    'order_number' => $orderNumber,
                    'order_total' => $currentPrice,
                    'order_status' => 'pending',
                    'product_id' => $product->id,
                    'product_name' => $product->productName,
                    'variant_id' => $variant->id,
                    'variant_name' => $variant->ecomVariantName,
                    'store_name' => $this->storeName,
                    'purchase_date' => now()->format('M j, Y'),
                    'is_existing_account' => $emailExists,
                ];

                $this->triggerShoppingAbandonmentFlows($product->id, $variant->id, $orderId, $contextData);

                // For new accounts, also trigger the special tag flow for account creation
                if (!$emailExists && $hashedPassword) {
                    $this->triggerSpecialTagFlow(
                        'anisenso_fertilization_course_create_basic_account',
                        null, // No client ID yet - will be created by trigger task
                        $orderId,
                        [
                            'client_name' => $clientName,
                            'client_first_name' => $firstName,
                            'client_last_name' => $lastName,
                            'client_email' => $email,
                            'client_phone' => $phone,
                            'client_password_hash' => $hashedPassword,
                            'order_id' => $orderId,
                            'order_number' => $orderNumber,
                            'product_name' => $this->productName,
                            'variant_name' => $this->variantName,
                            'store_name' => $this->storeName,
                            'login_method' => 'email',
                            'account_requested_at' => now()->format('M j, Y g:i A'),
                            'trigger_tag' => 'anisenso_fertilization_course_create_basic_account',
                        ]
                    );
                }
            }

            // Mark step 1 as complete in session
            session(['checkout_step1_complete' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Information saved successfully!',
                'orderNumber' => $orderNumber,
                'emailExists' => $emailExists,
                'redirectUrl' => route('checkout.step2.page'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating order: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Step 2: Complete registration for new accounts
     * Collects firstName, lastName, phone, password for new accounts
     * (Existing accounts skip this step and go directly to payment)
     */
    public function stepTwo(Request $request)
    {
        // Check if we have order info from step 1
        if (!session('checkout_order_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete step 1 first.',
            ], 400);
        }

        // If this is an existing account, they shouldn't be here
        if (session('checkout_email_exists')) {
            return response()->json([
                'success' => false,
                'message' => 'Existing accounts should proceed directly to payment.',
            ], 400);
        }

        // Validation for new account registration
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'phone' => ['required', 'regex:/^(\+?63|0)?9\d{9}$/'],
            'password' => 'required|min:8|confirmed',
        ], [
            'firstName.required' => 'Kailangan ang first name.',
            'lastName.required' => 'Kailangan ang last name.',
            'phone.required' => 'Kailangan ang phone number.',
            'phone.regex' => 'Invalid phone format. Use 09XXXXXXXXX format.',
            'password.required' => 'Kailangan ang password.',
            'password.min' => 'Ang password ay dapat may 8 characters o higit pa.',
            'password.confirmed' => 'Hindi tugma ang password confirmation.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $orderId = session('checkout_order_id');
            $email = session('checkout_email');

            // Normalize phone number
            $phone = $this->normalizePhoneNumber($request->phone);
            $firstName = trim($request->firstName);
            $lastName = trim($request->lastName);

            // Check if phone already exists
            $existingPhone = DB::table('clients_access_login')
                ->where('clientPhoneNumber', $phone)
                ->where('productStore', $this->storeName)
                ->where('deleteStatus', 1)
                ->first();

            if ($existingPhone) {
                return response()->json([
                    'success' => false,
                    'errors' => ['phone' => ['Ang phone number na ito ay may existing account na.']],
                ], 422);
            }

            // Double-check email doesn't exist (edge case protection)
            $existingEmail = DB::table('clients_access_login')
                ->where('clientEmailAddress', $email)
                ->where('productStore', $this->storeName)
                ->where('deleteStatus', 1)
                ->first();

            if ($existingEmail) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ang email na ito ay may existing account na. Please refresh and try again.',
                ], 422);
            }

            // Hash password for storage
            $hashedPassword = Hash::make($request->password);

            // Store pending account details in order for trigger flow to use
            $pendingAccountData = [
                'pending_account' => true,
                'first_name' => $firstName,
                'middle_name' => '',
                'last_name' => $lastName,
                'phone' => $phone,
                'email' => $email,
                'password_hash' => $hashedPassword,
                'login_method' => 'email', // Default to email login
                'store' => $this->storeName,
            ];

            // Update order with client details and pending account data
            $existingNotes = DB::table('ecom_orders')->where('id', $orderId)->value('orderNotes') ?? '';
            $pendingAccountNotes = "\n\n" . str_repeat('-', 40) . "\n";
            $pendingAccountNotes .= "PENDING ACCOUNT CREATION\n";
            $pendingAccountNotes .= str_repeat('-', 40) . "\n";
            $pendingAccountNotes .= "Name: {$firstName} {$lastName}\n";
            $pendingAccountNotes .= "Email: {$email}\n";
            $pendingAccountNotes .= "Phone: {$phone}\n";
            $pendingAccountNotes .= "Store: {$this->storeName}\n";
            $pendingAccountNotes .= "Login Method: email\n";
            $pendingAccountNotes .= str_repeat('-', 40) . "\n";
            $pendingAccountNotes .= "[PENDING_ACCOUNT_JSON]\n";
            $pendingAccountNotes .= json_encode($pendingAccountData, JSON_PRETTY_PRINT);
            $updatedNotes = $existingNotes . $pendingAccountNotes;

            DB::table('ecom_orders')
                ->where('id', $orderId)
                ->update([
                    'clientFirstName' => $firstName,
                    'clientLastName' => $lastName,
                    'clientPhone' => $phone,
                    'orderNotes' => $updatedNotes,
                    'updated_at' => now(),
                ]);

            // Update order item with client info
            DB::table('ecom_order_items')
                ->where('orderId', $orderId)
                ->update([
                    'accessClientName' => $firstName . ' ' . $lastName,
                    'accessClientPhone' => $phone,
                    'accessClientEmail' => $email,
                    'updated_at' => now(),
                ]);

            // Update session with complete purchaser info
            session([
                'checkout_purchaser' => [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'phone' => $phone,
                    'email' => $email,
                ],
                'checkout_account_email' => $email,
                'checkout_account_phone' => $phone,
                'checkout_account_type' => 'manual',
                'checkout_login_method' => 'email',
            ]);

            // Trigger special tag flow for account creation
            $this->triggerSpecialTagFlow(
                'anisenso_fertilization_course_create_basic_account',
                null, // No client ID yet - will be created by trigger task
                $orderId,
                [
                    'client_name' => $firstName . ' ' . $lastName,
                    'client_first_name' => $firstName,
                    'client_last_name' => $lastName,
                    'client_email' => $email,
                    'client_phone' => $phone,
                    'client_password_hash' => $hashedPassword,
                    'order_id' => $orderId,
                    'order_number' => session('checkout_order_number'),
                    'product_name' => $this->productName,
                    'variant_name' => $this->variantName,
                    'store_name' => $this->storeName,
                    'login_method' => 'email',
                    'account_requested_at' => now()->format('M j, Y g:i A'),
                    'trigger_tag' => 'anisenso_fertilization_course_create_basic_account',
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Account details saved! Your account will be created once payment is verified.',
                'loginIdentifier' => $email,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saving account details: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Login existing account during checkout
     */
    public function loginExistingAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'credential' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $credential = trim($request->credential);
        $password = $request->password;

        // Auto-detect if credential is email or phone
        $isEmail = str_contains($credential, '@');

        // Find the account - only for Ani-Senso store
        $query = DB::table('clients_access_login')
            ->where('deleteStatus', 1)
            ->where('isActive', 1)
            ->where('productStore', 'Ani-Senso');

        if ($isEmail) {
            $query->where('clientEmailAddress', $credential);
        } else {
            // Normalize phone number
            $phone = preg_replace('/[\s\-]/', '', $credential);
            if (preg_match('/^0/', $phone)) {
                $phone = '63' . substr($phone, 1);
            } elseif (preg_match('/^\+/', $phone)) {
                $phone = substr($phone, 1);
            }
            $query->where('clientPhoneNumber', $phone);
        }

        $client = $query->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ], 401);
        }

        // Verify password
        if (!Hash::check($password, $client->clientPassword)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password.',
            ], 401);
        }

        // Update the order with the client ID
        $orderId = session('checkout_order_id');
        if ($orderId) {
            DB::table('ecom_orders')
                ->where('id', $orderId)
                ->update([
                    'clientId' => $client->id,
                    'updated_at' => now(),
                ]);

            // Update the order item
            DB::table('ecom_order_items')
                ->where('orderId', $orderId)
                ->update([
                    'accessClientId' => $client->id,
                    'updated_at' => now(),
                ]);
        }

        // Store login info in session
        session([
            'checkout_client_id' => $client->id,
            'checkout_account_email' => $client->clientEmailAddress,
            'checkout_account_phone' => $client->clientPhoneNumber,
            'checkout_account_type' => 'existing',
            'checkout_login_method' => $isEmail ? 'email' : 'phone',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'clientName' => $client->clientFirstName . ' ' . $client->clientLastName,
        ]);
    }

    /**
     * Step 3: Submit payment details
     */
    public function stepThree(Request $request)
    {
        // Check if we have order info from previous steps
        if (!session('checkout_order_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete the previous steps first.',
            ], 400);
        }

        // Get the order to validate amount paid against order total
        $orderId = session('checkout_order_id');
        $order = DB::table('ecom_orders')->where('id', $orderId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        $orderTotal = $order->grandTotal;

        $validator = Validator::make($request->all(), [
            'paymentMethod' => 'required|in:bank,gcash,maya,paypal',
            'referenceNumber' => 'required_without:paymentScreenshot|nullable|string|max:100',
            'paymentScreenshot' => 'required_without:referenceNumber|nullable|image|max:5120', // 5MB max
            'senderName' => 'required|string|max:255',
            'amountPaid' => ['required', 'numeric', 'min:' . $orderTotal],
            // Optional bank details for Bank Transfer
            'bankName' => 'nullable|string|max:100',
            'bankAccountName' => 'nullable|string|max:255',
            'bankAccountNumber' => 'nullable|string|max:50',
            // Required e-wallet phone for GCash/Maya
            'ewalletPhone' => 'required_if:paymentMethod,gcash,maya|nullable|regex:/^(\+?63|0)?9\d{9}$/',
            // Optional payment notes
            'paymentNotes' => 'nullable|string|max:1000',
        ], [
            'paymentMethod.required' => 'Pumili ng payment method.',
            'referenceNumber.required_without' => 'Kailangan ang reference number o screenshot ng payment.',
            'paymentScreenshot.required_without' => 'Kailangan ang screenshot ng payment o reference number.',
            'paymentScreenshot.image' => 'Ang file ay dapat image (JPG, PNG, etc.).',
            'paymentScreenshot.max' => 'Ang image ay dapat hindi lalagpas sa 5MB.',
            'senderName.required' => 'Kailangan ang pangalan ng nagbayad.',
            'amountPaid.required' => 'Kailangan ang halaga ng binayaran.',
            'amountPaid.min' => 'Ang halaga ng binayaran ay dapat hindi bababa sa ₱' . number_format($orderTotal, 2) . '.',
            'ewalletPhone.required_if' => 'Kailangan ang GCash/Maya number na ginamit.',
            'ewalletPhone.regex' => 'Invalid phone format. Use 09XXXXXXXXX format.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $orderNumber = session('checkout_order_number');
            $purchaser = session('checkout_purchaser');
            $accountEmail = session('checkout_account_email') ?? $purchaser['email'];

            // Map frontend payment methods to database values (matching btc-check)
            $paymentMethodMap = [
                'bank' => 'manual_bank',
                'gcash' => 'manual_gcash',
                'maya' => 'manual_maya',
                'paypal' => 'manual_paypal',
            ];
            $dbPaymentMethod = $paymentMethodMap[$request->paymentMethod] ?? 'manual_other';

            // Handle screenshot upload - store in btc-check's public path so admin can view
            $screenshotPath = null;
            if ($request->hasFile('paymentScreenshot')) {
                $file = $request->file('paymentScreenshot');
                $filename = 'payment_' . $orderId . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store in btc-check's public folder so admin panel can access
                $btcCheckPath = 'C:\\xampp\\htdocs\\btc-check\\public\\images\\payment-screenshots';
                if (!file_exists($btcCheckPath)) {
                    mkdir($btcCheckPath, 0755, true);
                }

                $file->move($btcCheckPath, $filename);
                $screenshotPath = 'images/payment-screenshots/' . $filename;
            }

            // Update order with proper payment verification columns (matching btc-check structure)
            // Note: orderStatus stays 'pending' until admin verifies payment and sets it to 'paid'
            $updateData = [
                'paymentMethod' => $dbPaymentMethod,
                'paymentVerificationStatus' => 'pending',
                'paymentPayerName' => $request->senderName,
                'paymentAmountSent' => $request->amountPaid,
                'paymentReferenceNumber' => $request->referenceNumber,
                'paymentScreenshot' => $screenshotPath,
                'paymentNotes' => $request->paymentNotes,
                'updated_at' => now(),
            ];

            // Add e-wallet phone for GCash/Maya payments
            if (in_array($request->paymentMethod, ['gcash', 'maya']) && $request->ewalletPhone) {
                $updateData['paymentBankAccountNumber'] = $request->ewalletPhone; // Store phone as account identifier
            }

            // Add bank details for Bank Transfer payments
            if ($request->paymentMethod === 'bank') {
                $updateData['paymentBankName'] = $request->bankName;
                $updateData['paymentBankAccountName'] = $request->bankAccountName;
                $updateData['paymentBankAccountNumber'] = $request->bankAccountNumber;
            }

            DB::table('ecom_orders')
                ->where('id', $orderId)
                ->update($updateData);

            // Log audit trail for payment submission
            $clientName = $purchaser['firstName'] . ' ' . $purchaser['lastName'];
            $paymentMethodLabel = match($dbPaymentMethod) {
                'manual_gcash' => 'GCash',
                'manual_maya' => 'Maya',
                'manual_bank' => 'Bank Transfer',
                'manual_paypal' => 'PayPal',
                default => 'Manual Payment',
            };

            DB::table('ecom_order_audit_logs')->insert([
                'orderId' => $orderId,
                'orderNumber' => $orderNumber,
                'userId' => null, // Client, not admin user
                'userName' => $clientName . ' (Customer)',
                'actionType' => 'payment_details_submitted',
                'fieldChanged' => 'paymentMethod',
                'previousValue' => null,
                'newValue' => $dbPaymentMethod,
                'description' => "Customer submitted payment details via {$paymentMethodLabel}. Amount: ₱" . number_format($request->amountPaid, 2) . ($request->referenceNumber ? ". Ref: {$request->referenceNumber}" : "") . ($request->ewalletPhone ? ". Phone: {$request->ewalletPhone}" : ""),
                'ipAddress' => $request->ip(),
                'userAgent' => $request->userAgent(),
                'deleteStatus' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Generate a confirmation token for the unique confirmation page
            $confirmationToken = Str::random(32);

            DB::table('ecom_orders')
                ->where('id', $orderId)
                ->update([
                    'confirmationToken' => $confirmationToken,
                    'updated_at' => now(),
                ]);

            // Clear checkout session
            session()->forget([
                'checkout_order_id',
                'checkout_order_number',
                'checkout_purchaser',
                'checkout_variant_id',
                'checkout_client_id',
                'checkout_account_email',
                'checkout_account_phone',
                'checkout_account_type',
                'checkout_login_method',
                'checkout_email',
                'checkout_email_exists',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment details submitted successfully!',
                'orderNumber' => $orderNumber,
                'email' => $accountEmail,
                'redirectUrl' => route('checkout.confirmation', ['token' => $confirmationToken]),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting payment: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Normalize phone number to 09XXXXXXXXX format
     */
    protected function normalizePhoneNumber($phone)
    {
        // Remove all non-digit characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);

        // Handle different formats
        if (preg_match('/^\+63(\d{10})$/', $phone, $matches)) {
            return '0' . $matches[1];
        }
        if (preg_match('/^63(\d{10})$/', $phone, $matches)) {
            return '0' . $matches[1];
        }
        if (preg_match('/^9(\d{9})$/', $phone, $matches)) {
            return '09' . $matches[1];
        }
        if (preg_match('/^09(\d{9})$/', $phone)) {
            return $phone;
        }

        return $phone;
    }

    /**
     * Generate unique order number
     */
    protected function generateOrderNumber()
    {
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        $orderNumber = "ORD-{$date}-{$random}";

        // Check if exists and regenerate if needed
        while (DB::table('ecom_orders')->where('orderNumber', $orderNumber)->exists()) {
            $random = strtoupper(Str::random(4));
            $orderNumber = "ORD-{$date}-{$random}";
        }

        return $orderNumber;
    }

    /**
     * Trigger Shopping Abandonment flows for the given product/variant and order
     *
     * @param int $productId
     * @param int $variantId
     * @param int $orderId
     * @param array $contextData
     */
    protected function triggerShoppingAbandonmentFlows($productId, $variantId, $orderId, array $contextData)
    {
        try {
            // Find all active Shopping Abandonment flows
            $flows = DB::table('ecom_trigger_flows')
                ->where('flowType', 'shopping_abandonment')
                ->where('isActive', 1)
                ->where('deleteStatus', 1)
                ->get();

            foreach ($flows as $flow) {
                $flowData = json_decode($flow->flowData, true);

                if (!$flowData || empty($flowData['nodes'])) {
                    continue;
                }

                // Check if flow has a start node matching our product/variant
                $matchesProductVariant = $this->flowMatchesProductVariant($flowData, $productId, $variantId);

                if ($matchesProductVariant) {
                    // Check if there's already an active enrollment for this order
                    $existingEnrollment = DB::table('ecom_trigger_flow_enrollments')
                        ->where('flowId', $flow->id)
                        ->where('orderId', $orderId)
                        ->where('deleteStatus', 'active')
                        ->whereIn('status', ['active', 'paused'])
                        ->first();

                    if (!$existingEnrollment) {
                        $this->enrollInShoppingAbandonmentFlow($flow, $orderId, $contextData);
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error but don't fail the checkout
            Log::error('Shopping Abandonment trigger error: ' . $e->getMessage(), [
                'productId' => $productId,
                'variantId' => $variantId,
                'orderId' => $orderId,
            ]);
        }
    }

    /**
     * Check if a flow's start node matches the given product/variant
     *
     * @param array $flowData
     * @param int $productId
     * @param int $variantId
     * @return bool
     */
    protected function flowMatchesProductVariant(array $flowData, $productId, $variantId)
    {
        $nodes = $flowData['nodes'] ?? [];

        foreach ($nodes as $node) {
            // Check for product_variant_start nodes
            if ($node['type'] === 'product_variant_start') {
                $nodeData = $node['data'] ?? [];
                $nodeProductId = $nodeData['productId'] ?? null;
                $nodeVariantId = $nodeData['variantId'] ?? null;

                // If node specifies product/variant, check for match
                // Use loose comparison to handle string/int type differences
                if ($nodeProductId && $nodeProductId != $productId) {
                    continue;
                }
                if ($nodeVariantId && $nodeVariantId != $variantId) {
                    continue;
                }

                // Match found (either no restriction or matches our product/variant)
                return true;
            }

            // Also check for generic start nodes that might apply to all products
            if (in_array($node['type'], ['trigger_tag', 'special_tag_start'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Enroll in a Shopping Abandonment flow by creating enrollment and tasks
     *
     * @param object $flow
     * @param int $orderId
     * @param array $contextData
     */
    protected function enrollInShoppingAbandonmentFlow($flow, $orderId, array $contextData)
    {
        $flowData = json_decode($flow->flowData, true);
        $nodes = $flowData['nodes'] ?? [];
        $connections = $flowData['connections'] ?? [];

        if (empty($nodes)) {
            return;
        }

        // Create enrollment record
        $enrollmentId = DB::table('ecom_trigger_flow_enrollments')->insertGetId([
            'flowId' => $flow->id,
            'clientId' => null, // Client not created yet at Step 1
            'orderId' => $orderId,
            'triggerSource' => 'shopping_abandonment',
            'contextData' => json_encode($contextData),
            'status' => 'active',
            'totalTasks' => count($nodes),
            'completedTasks' => 0,
            'currentTaskOrder' => 0,
            'startedAt' => now(),
            'createdBy' => null, // System triggered
            'deleteStatus' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Build task order using BFS from start nodes
        $taskOrder = $this->buildTaskOrder($nodes, $connections);

        // Node type labels for tasks
        $nodeTypeLabels = [
            'trigger_tag' => 'Trigger Tag',
            'course_access_start' => 'Course Access Start',
            'course_tag_start' => 'Trigger Tag',
            'product_variant_start' => 'Product & Variant',
            'special_tag_start' => 'Special Tag',
            'order_status_start' => 'Order Status Change',
            'delay' => 'Delay / Wait',
            'schedule' => 'Schedule',
            'email' => 'Send Email',
            'send_sms' => 'Send SMS',
            'send_whatsapp' => 'Send WhatsApp',
            'if_else' => 'If / Else Condition',
            'y_flow' => 'Y Flow Split',
            'course_access' => 'Grant Course Access',
            'remove_access' => 'Remove Access',
            'add_as_affiliate' => 'Add as Affiliate',
            'add_login_access' => 'Grant Login Access',
            'course_subscription' => 'Course Subscription',
            'flow_action' => 'Flow Action',
            'ai_add_referral' => 'AI Add Referral',
        ];

        // Create tasks for each node
        foreach ($taskOrder as $index => $nodeId) {
            $node = collect($nodes)->firstWhere('id', $nodeId);

            if (!$node) {
                continue;
            }

            $nodeType = $node['type'];
            $nodeData = $node['data'] ?? [];

            // Calculate scheduled time for the first task (or if it's a delay node)
            $scheduledAt = null;
            $status = 'pending';

            if ($index === 0) {
                // First task is ready immediately
                $status = 'ready';
                $scheduledAt = now();
            }

            DB::table('ecom_trigger_flow_tasks')->insert([
                'enrollmentId' => $enrollmentId,
                'flowId' => $flow->id,
                'nodeId' => $node['id'],
                'nodeType' => $nodeType,
                'nodeLabel' => $nodeTypeLabels[$nodeType] ?? ucfirst(str_replace('_', ' ', $nodeType)),
                'nodeData' => json_encode($nodeData),
                'taskOrder' => $index + 1,
                'parentNodeId' => null,
                'branchType' => null,
                'status' => $status,
                'scheduledAt' => $scheduledAt,
                'startedAt' => null,
                'completedAt' => null,
                'resultData' => null,
                'errorMessage' => null,
                'retryCount' => 0,
                'maxRetries' => 3,
                'lastRetryAt' => null,
                'deleteStatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Log the enrollment creation
        DB::table('ecom_trigger_flow_logs')->insert([
            'enrollmentId' => $enrollmentId,
            'taskId' => null,
            'flowId' => $flow->id,
            'action' => 'enrollment_created',
            'nodeType' => null,
            'nodeLabel' => null,
            'logData' => json_encode([
                'orderId' => $orderId,
                'flowName' => $flow->flowName,
                'totalTasks' => count($nodes),
                'source' => 'anisenso_checkout_step1',
            ]),
            'message' => 'Shopping Abandonment enrollment created from Ani-Senso checkout',
            'logLevel' => 'info',
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
            'executedBy' => null,
            'executionSource' => 'shopping_abandonment',
            'executionTime' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Shopping Abandonment flow enrollment created', [
            'enrollmentId' => $enrollmentId,
            'flowId' => $flow->id,
            'flowName' => $flow->flowName,
            'orderId' => $orderId,
        ]);
    }

    /**
     * Build task order using BFS from start nodes
     *
     * @param array $nodes
     * @param array $connections
     * @return array
     */
    protected function buildTaskOrder(array $nodes, array $connections)
    {
        $startTypes = ['trigger_tag', 'course_access_start', 'course_tag_start', 'product_variant_start', 'special_tag_start', 'order_status_start'];

        // Find nodes with no incoming connections (start nodes)
        $incomingMap = [];
        foreach ($nodes as $node) {
            $incomingMap[$node['id']] = [];
        }
        foreach ($connections as $conn) {
            if (isset($incomingMap[$conn['target']])) {
                $incomingMap[$conn['target']][] = $conn['source'];
            }
        }

        $startNodes = [];
        foreach ($nodes as $node) {
            if (empty($incomingMap[$node['id']]) || in_array($node['type'], $startTypes)) {
                $startNodes[] = $node['id'];
            }
        }

        if (empty($startNodes) && !empty($nodes)) {
            $startNodes = [$nodes[0]['id']];
        }

        // Build outgoing map
        $outgoingMap = [];
        foreach ($nodes as $node) {
            $outgoingMap[$node['id']] = [];
        }
        foreach ($connections as $conn) {
            if (isset($outgoingMap[$conn['source']])) {
                $outgoingMap[$conn['source']][] = $conn['target'];
            }
        }

        // BFS to get order
        $order = [];
        $visited = [];
        $queue = $startNodes;

        while (!empty($queue)) {
            $nodeId = array_shift($queue);

            if (isset($visited[$nodeId])) {
                continue;
            }
            $visited[$nodeId] = true;
            $order[] = $nodeId;

            foreach ($outgoingMap[$nodeId] ?? [] as $targetId) {
                if (!isset($visited[$targetId])) {
                    $queue[] = $targetId;
                }
            }
        }

        // Add any unvisited nodes at the end
        foreach ($nodes as $node) {
            if (!isset($visited[$node['id']])) {
                $order[] = $node['id'];
            }
        }

        return $order;
    }

    /**
     * Trigger special tag flows when a specific tag event occurs
     *
     * @param string $tagValue The special tag value to match (e.g., 'anisenso_fertilization_course_create_basic_account')
     * @param int|null $clientId The client ID (if available)
     * @param int|null $orderId The order ID (if available)
     * @param array $contextData Context data for merge tags
     */
    protected function triggerSpecialTagFlow(string $tagValue, ?int $clientId, ?int $orderId, array $contextData)
    {
        try {
            // Find all active special_trigger flows
            $flows = DB::table('ecom_trigger_flows')
                ->where('flowType', 'special_trigger')
                ->where('isActive', 1)
                ->where('deleteStatus', 1)
                ->get();

            foreach ($flows as $flow) {
                $flowData = json_decode($flow->flowData, true);

                if (!$flowData || empty($flowData['nodes'])) {
                    continue;
                }

                // Check if flow has a special_tag_start node matching our tagValue
                $matchesTag = $this->flowMatchesSpecialTag($flowData, $tagValue);

                if ($matchesTag) {
                    // Check if there's already an active enrollment for this client/order combination
                    $existingQuery = DB::table('ecom_trigger_flow_enrollments')
                        ->where('flowId', $flow->id)
                        ->where('deleteStatus', 'active')
                        ->whereIn('status', ['active', 'paused']);

                    if ($clientId) {
                        $existingQuery->where('clientId', $clientId);
                    }
                    if ($orderId) {
                        $existingQuery->where('orderId', $orderId);
                    }

                    $existingEnrollment = $existingQuery->first();

                    if (!$existingEnrollment) {
                        $this->enrollInSpecialTagFlow($flow, $tagValue, $clientId, $orderId, $contextData);
                    }
                }
            }
        } catch (\Exception $e) {
            // Log error but don't fail the process
            Log::error('Special Tag trigger error: ' . $e->getMessage(), [
                'tagValue' => $tagValue,
                'clientId' => $clientId,
                'orderId' => $orderId,
            ]);
        }
    }

    /**
     * Check if a flow's start node matches the given special tag value
     *
     * @param array $flowData
     * @param string $tagValue
     * @return bool
     */
    protected function flowMatchesSpecialTag(array $flowData, string $tagValue): bool
    {
        $nodes = $flowData['nodes'] ?? [];

        foreach ($nodes as $node) {
            // Check for special_tag_start nodes
            if ($node['type'] === 'special_tag_start') {
                $nodeData = $node['data'] ?? [];
                $nodeTagValue = $nodeData['tagValue'] ?? null;

                // Match found if tagValue matches
                if ($nodeTagValue && $nodeTagValue === $tagValue) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Enroll in a Special Tag flow by creating enrollment and tasks
     *
     * @param object $flow
     * @param string $tagValue
     * @param int|null $clientId
     * @param int|null $orderId
     * @param array $contextData
     */
    protected function enrollInSpecialTagFlow($flow, string $tagValue, ?int $clientId, ?int $orderId, array $contextData)
    {
        $flowData = json_decode($flow->flowData, true);
        $nodes = $flowData['nodes'] ?? [];
        $connections = $flowData['connections'] ?? [];

        if (empty($nodes)) {
            return;
        }

        // Create enrollment record
        $enrollmentId = DB::table('ecom_trigger_flow_enrollments')->insertGetId([
            'flowId' => $flow->id,
            'clientId' => $clientId,
            'orderId' => $orderId,
            'triggerSource' => 'special_tag',
            'contextData' => json_encode($contextData),
            'status' => 'active',
            'totalTasks' => count($nodes),
            'completedTasks' => 0,
            'currentTaskOrder' => 0,
            'startedAt' => now(),
            'createdBy' => null, // System triggered
            'deleteStatus' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Build task order using BFS from start nodes
        $taskOrder = $this->buildTaskOrder($nodes, $connections);

        // Node type labels for tasks
        $nodeTypeLabels = [
            'trigger_tag' => 'Trigger Tag',
            'course_access_start' => 'Course Access Start',
            'course_tag_start' => 'Trigger Tag',
            'product_variant_start' => 'Product & Variant',
            'special_tag_start' => 'Special Tag',
            'order_status_start' => 'Order Status Change',
            'delay' => 'Delay / Wait',
            'schedule' => 'Schedule',
            'email' => 'Send Email',
            'send_sms' => 'Send SMS',
            'send_whatsapp' => 'Send WhatsApp',
            'if_else' => 'If / Else Condition',
            'y_flow' => 'Y Flow Split',
            'course_access' => 'Grant Course Access',
            'remove_access' => 'Remove Access',
            'add_as_affiliate' => 'Add as Affiliate',
            'add_login_access' => 'Grant Login Access',
            'course_subscription' => 'Course Subscription',
            'flow_action' => 'Flow Action',
            'ai_add_referral' => 'AI Add Referral',
        ];

        // Create tasks for each node
        foreach ($taskOrder as $index => $nodeId) {
            $node = collect($nodes)->firstWhere('id', $nodeId);

            if (!$node) {
                continue;
            }

            $nodeType = $node['type'];
            $nodeData = $node['data'] ?? [];

            // Calculate scheduled time for the first task
            $scheduledAt = null;
            $status = 'pending';

            if ($index === 0) {
                // First task is ready immediately
                $status = 'ready';
                $scheduledAt = now();
            }

            DB::table('ecom_trigger_flow_tasks')->insert([
                'enrollmentId' => $enrollmentId,
                'flowId' => $flow->id,
                'nodeId' => $node['id'],
                'nodeType' => $nodeType,
                'nodeLabel' => $nodeTypeLabels[$nodeType] ?? ucfirst(str_replace('_', ' ', $nodeType)),
                'nodeData' => json_encode($nodeData),
                'taskOrder' => $index + 1,
                'parentNodeId' => null,
                'branchType' => null,
                'status' => $status,
                'scheduledAt' => $scheduledAt,
                'startedAt' => null,
                'completedAt' => null,
                'resultData' => null,
                'errorMessage' => null,
                'retryCount' => 0,
                'maxRetries' => 3,
                'lastRetryAt' => null,
                'deleteStatus' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Log the enrollment creation
        DB::table('ecom_trigger_flow_logs')->insert([
            'enrollmentId' => $enrollmentId,
            'taskId' => null,
            'flowId' => $flow->id,
            'action' => 'enrollment_created',
            'nodeType' => null,
            'nodeLabel' => null,
            'logData' => json_encode([
                'clientId' => $clientId,
                'orderId' => $orderId,
                'flowName' => $flow->flowName,
                'tagValue' => $tagValue,
                'totalTasks' => count($nodes),
                'source' => 'anisenso_checkout_step2',
            ]),
            'message' => 'Special Tag flow enrollment created: ' . $tagValue,
            'logLevel' => 'info',
            'ipAddress' => request()->ip(),
            'userAgent' => request()->userAgent(),
            'executedBy' => null,
            'executionSource' => 'special_tag',
            'executionTime' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Special Tag flow enrollment created', [
            'enrollmentId' => $enrollmentId,
            'flowId' => $flow->id,
            'flowName' => $flow->flowName,
            'tagValue' => $tagValue,
            'clientId' => $clientId,
            'orderId' => $orderId,
        ]);
    }

    /**
     * Continue checkout from recovery link (abandoned cart)
     * Shows the checkout page with order data pre-filled based on order status
     *
     * @param string $token Recovery token
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function continueCheckout($token)
    {
        // Find order by recovery token
        $order = DB::table('ecom_orders')
            ->where('recoveryToken', $token)
            ->where('deleteStatus', 1)
            ->first();

        if (!$order) {
            return view('checkout.recovery-invalid', [
                'message' => 'Invalid or expired recovery link.',
                'reason' => 'not_found',
            ]);
        }

        // Check if token has expired
        if ($order->recoveryTokenExpiresAt && Carbon::parse($order->recoveryTokenExpiresAt)->isPast()) {
            return view('checkout.recovery-invalid', [
                'message' => 'This recovery link has expired.',
                'reason' => 'expired',
                'orderNumber' => $order->orderNumber,
            ]);
        }

        // Get order items
        $orderItem = DB::table('ecom_order_items')
            ->where('orderId', $order->id)
            ->where('deleteStatus', 1)
            ->first();

        // Check order status and payment verification status
        $orderStatus = $order->orderStatus;
        $paymentStatus = $order->paymentVerificationStatus;

        // If order is already paid/completed, show completion message
        if (in_array($orderStatus, ['paid', 'completed', 'processing', 'shipped', 'delivered'])) {
            return view('checkout.recovery-completed', [
                'order' => $order,
                'orderItem' => $orderItem,
                'productName' => $orderItem ? $orderItem->productName : $this->productName,
                'message' => 'Good news! This order has already been paid and processed.',
            ]);
        }

        // If payment is verified/confirmed
        if (in_array($paymentStatus, ['verified', 'confirmed', 'approved'])) {
            return view('checkout.recovery-completed', [
                'order' => $order,
                'orderItem' => $orderItem,
                'productName' => $orderItem ? $orderItem->productName : $this->productName,
                'message' => 'Your payment has been verified! Your order is being processed.',
            ]);
        }

        // If payment is pending verification (user already submitted payment details)
        if ($paymentStatus === 'pending' && $order->paymentMethod) {
            return view('checkout.recovery-pending', [
                'order' => $order,
                'orderItem' => $orderItem,
                'productName' => $orderItem ? $orderItem->productName : $this->productName,
                'message' => 'Your payment is currently being verified. Please wait for confirmation.',
            ]);
        }

        // Order is still pending payment - allow user to continue checkout
        // Store order info in session to continue checkout
        session([
            'checkout_order_id' => $order->id,
            'checkout_order_number' => $order->orderNumber,
            'checkout_email' => $order->clientEmail,
            'checkout_recovery_mode' => true,
            'checkout_purchaser' => [
                'firstName' => $order->clientFirstName,
                'lastName' => $order->clientLastName,
                'phone' => $order->clientPhone,
                'email' => $order->clientEmail,
            ],
        ]);

        // Check if client exists
        $existingClient = null;
        if ($order->clientId) {
            $existingClient = DB::table('clients_access_login')
                ->where('id', $order->clientId)
                ->where('deleteStatus', 1)
                ->first();
        } elseif ($order->clientEmail) {
            $existingClient = DB::table('clients_access_login')
                ->where('clientEmailAddress', $order->clientEmail)
                ->where('productStore', $this->storeName)
                ->where('deleteStatus', 1)
                ->first();
        }

        if ($existingClient) {
            session([
                'checkout_client_id' => $existingClient->id,
                'checkout_email_exists' => true,
                'checkout_account_type' => 'existing',
            ]);
        } else {
            session([
                'checkout_email_exists' => false,
                'checkout_account_type' => 'manual',
            ]);
        }

        // Get variant info
        if ($orderItem && $orderItem->variantId) {
            session(['checkout_variant_id' => $orderItem->variantId]);
        }

        // Get payment settings for the store
        $paymentSettings = $this->getPaymentSettings();

        // Return checkout view in recovery mode
        return view('checkout.index', [
            'productName' => $orderItem ? $orderItem->productName : $this->productName,
            'variantName' => $orderItem ? $orderItem->variantName : $this->variantName,
            'price' => $order->grandTotal,
            'isPromoActive' => false, // Don't show promo timer in recovery mode
            'isExitIntent' => false,
            'promoPrice' => $this->promoPrice,
            'regularPrice' => $this->regularPrice,
            'exitPrice' => null,
            'recoveryMode' => true,
            'recoveryOrder' => $order,
            'recoveryOrderItem' => $orderItem,
            'existingClient' => $existingClient,
            'paymentSettings' => $paymentSettings,
        ]);
    }

    /**
     * Get the recovery URL for an order
     *
     * @param int $orderId
     * @return string|null
     */
    public static function getRecoveryUrl($orderId)
    {
        $order = DB::table('ecom_orders')
            ->where('id', $orderId)
            ->where('deleteStatus', 1)
            ->first();

        if (!$order || !$order->recoveryToken) {
            return null;
        }

        // Use the anisenso-course app URL
        $baseUrl = config('app.url', 'http://localhost:8001');
        return $baseUrl . '/checkout/continue/' . $order->recoveryToken;
    }

    /**
     * Show the confirmation page after successful payment submission
     *
     * @param string $token Confirmation token
     * @return \Illuminate\View\View
     */
    public function showConfirmation($token)
    {
        // Find order by confirmation token
        $order = DB::table('ecom_orders')
            ->where('confirmationToken', $token)
            ->where('deleteStatus', 1)
            ->first();

        if (!$order) {
            // Invalid token - redirect to home with message
            return redirect()->route('home')->with('error', 'Invalid confirmation link.');
        }

        // Get order item for product details
        $orderItem = DB::table('ecom_order_items')
            ->where('orderId', $order->id)
            ->where('deleteStatus', 1)
            ->first();

        // Determine payment status message
        $paymentStatus = $order->paymentVerificationStatus ?? 'pending';
        $orderStatus = $order->orderStatus;

        $statusInfo = match(true) {
            in_array($orderStatus, ['paid', 'completed', 'processing']) => [
                'status' => 'verified',
                'icon' => 'check-circle',
                'color' => 'green',
                'title' => 'Payment Verified!',
                'message' => 'Ang iyong payment ay na-verify na. Maa-access mo na ang course!',
            ],
            $paymentStatus === 'verified' => [
                'status' => 'verified',
                'icon' => 'check-circle',
                'color' => 'green',
                'title' => 'Payment Verified!',
                'message' => 'Ang iyong payment ay na-verify na. Maa-access mo na ang course!',
            ],
            default => [
                'status' => 'pending',
                'icon' => 'clock',
                'color' => 'yellow',
                'title' => 'Payment Verification Pending',
                'message' => 'Ang iyong payment ay ive-verify namin within 24 hours.',
            ],
        };

        return view('checkout.confirmation', [
            'order' => $order,
            'orderItem' => $orderItem,
            'productName' => $orderItem->productName ?? $this->productName,
            'variantName' => $orderItem->variantName ?? $this->variantName,
            'price' => $order->grandTotal,
            'statusInfo' => $statusInfo,
            'confirmationToken' => $token,
        ]);
    }
}
