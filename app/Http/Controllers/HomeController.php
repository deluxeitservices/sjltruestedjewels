<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PreownedSale; // Make sure you import the model
use App\Models\PreownedContact; // Make sure you import the model
use App\Models\PreownedNewsletter; // Make sure you import the model
use App\Models\ProductFrontImages; // Make sure you import the model
use Illuminate\Support\Facades\Storage; // Add this line
use App\Services\ProductApi; // <= add this at the top with other imports

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(ProductApi $api)
    {
        $base = config('app.backend_path'); // from config/app.php
        $products = [];
        /** Banner **/
        $lastBanner = DB::table('banner')->where('status', 1)->orderByDesc('id')->value('image');
        $bannerStyle = $lastBanner ? "background-image: url('{$base}/upload/banners/{$lastBanner}') !important": '';
        /** Services banner **/
        $result_home_services = DB::table('home_services')->orderBy('sort_order', 'asc')->get();
        
        /** process Banner **/
        $result_home_process = DB::table('home_features')->orderBy('sort_order', 'asc')->get();

        /** process Process **/
        $resulthome = DB::table('home_process')->orderBy('sort_order', 'desc')->first();

        /** process testimonials **/
        $testimonials = DB::table('testimonials')->orderBy('sort_order', 'desc')->get();

        $arrivalsRes  = $api->latestArrivals(7, null);
        $newArrivals  = $arrivalsRes['data'] ?? [];
        $apiError     = $arrivalsRes['error'] ?? null;

        $trendingRes  = $api->trending(7, null);
        $newtrending  = $trendingRes['data'] ?? [];
        $trendError     = $trendingRes['error'] ?? null;

        
        $favoritedIds = \App\Models\Favorite::where('user_id', auth()->id())
            ->pluck('external_id')
            ->toArray();

        return view('index', ['products' => $products,'bannerStyle' => $bannerStyle,'result_home_services' => $result_home_services,'base' => $base,'result_home_process' => $result_home_process,'resulthome' => $resulthome,'testimonials' => $testimonials,'newArrivals'=> $newArrivals,'apiError'=> $apiError,'favoritedIds'=>$favoritedIds,'newtrending' => $newtrending,'trendError' => $trendError]);
    }


        /**
     * Show the application About Us.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutus()
    {

        return view('about');
    }

        /**
     * Show the application Contact Us.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contactus()
    {
        return view('contact');        
    }


       /**
     * Show the application FAQ.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function faq()
    {
        return view('faq');        
    }

    //    /**
    //  * Show the application Return policy.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function returnPolicy()
    {
        return view('return-policy');        
    }

    //    /**
    //  * Show the application Terms and condition.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function termsCondition()
    {
        return view('terms-and-conditions');        
    }


    public function privacyPolicy()
    {
        return view('privacy');        
    }

    public function ourShowrooms()
    {
        return view('ourShowrooms');        
    }

    public function guide()
    {
        return view('guide');        
    }

    public function delivery()
    {
        return view('delivery');        
    }

    public function watchRepairs()
    {
        return view('watchRepairs');        
    }

    public function bookappointment()
    {
        return view('bookappointment');        
    }

     //    /**
    //  * Show the application Sell Watch
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function sellWatch()
    {
        return view('sell-watch');        
    }


    //    /**
    //  * Show the application Sell Watch Data Store
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function sellWatchStore(Request $request)
    {
          // Store the form data in the database
          $sale = new PreownedSale();
          $sale->first_name = $request->first_name;
          $sale->last_name = $request->last_name;
          $sale->email = $request->email;
          $sale->mobile_number = $request->mobile_number;
          $sale->modal_no = $request->modal_no;
          $sale->year_purchase = $request->year_purchase;
          $sale->condition = $request->condition;
          $sale->box_paper = $request->box_paper;
          $sale->expected_amount = $request->expected_amount;
          $sale->sell_type = 1;
          $sale->additional_info = $request->additional_info;

          $sale->save();


        if ($request->hasFile('form_file')) {
            $filePaths = []; // Array to store file paths
            $directoryPath = 'uploads/watch/' . $sale->id; // Create a directory with the last store ID
            if (!Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->makeDirectory($directoryPath);
            }
            foreach ($request->file('form_file') as $file) {
                $path = $file->store($directoryPath, 'public'); // Store the file
                $filePaths[] = $path; // Add path to the array
            }
            $sale->form_file = json_encode($filePaths); // Store paths as a JSON string
        }
  
        // Save the data
        $sale->save();



        // Email to user
        $userTo = $sale->email;
        $userSubject = 'Thank you for your watch sale inquiry!';
        $userContent = view('emails.user_watch_sale_confirmation', [
            'first_name' => $sale->first_name,
            'modal_no' => $sale->modal_no,
            'year_purchase' => $sale->year_purchase,
            'condition' => $sale->condition,
            'box_paper' => $sale->box_paper,
            'expected_amount' => $sale->expected_amount,
            'additional_info' => $sale->additional_info,
        ])->render();

        sendMailCommon($userTo, $userSubject, $userContent);

        // $adminTo = 'devanand.sinha90@gmail.com'; // Replace with actual admin email
        $adminTo= getAdminEmail();
        $adminSubject = 'New Watch Sale Inquiry';
        $adminContent = view('emails.admin_watch_sale_notification', [
            'first_name' => $sale->first_name,
            'last_name' => $sale->last_name,
            'email' => $sale->email,
            'mobile_number' => $sale->mobile_number,
            'modal_no' => $sale->modal_no,
            'year_purchase' => $sale->year_purchase,
            'condition' => $sale->condition,
            'box_paper' => $sale->box_paper,
            'expected_amount' => $sale->expected_amount,
            'additional_info' => $sale->additional_info,
        ])->render();

        sendMailCommon($adminTo, $adminSubject, $adminContent);
  
  
         /* // Store file if uploaded
          if ($request->hasFile('form_file')) {
              $path = $request->file('form_file')->store('uploads', 'public');
              $sale->form_file = $path;
          }*/

        //   <img src="{{ asset('storage/' . $imagePath) }}" alt="Uploaded Image" class="img-thumbnail" style="max-width: 150px; margin: 5px;">
        // http://your-domain/storage/uploads/u3lRhbrGzzoyVmU1iNy7I2HWZQzcK4SXyRLOf9vu.png
        // http://127.0.0.1:8000/storage/uploads/u3lRhbrGzzoyVmU1iNy7I2HWZQzcK4SXyRLOf9vu.png

        //   ["uploads\/u3lRhbrGzzoyVmU1iNy7I2HWZQzcK4SXyRLOf9vu.png","uploads\/GsmrKA66DaFkmFG7JwbsknFpGXH8MOs8VJnycYbI.jpg"]

        // Store files if uploaded
        
  

        // Return success response
        return response()->json(['success' => true, 'message' => 'Data saved successfully!']);            
    }



    //    /**
    //  * Show the application Sell Watch
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function sellJewellery()
    {
        return view('sell-jewellery');        
    }


    //    /**
    //  * Show the application Sell Watch Data Store
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function sellJewelleryStore(Request $request)
    {

          // Store the form data in the database
          $sale = new PreownedSale();
          $sale->first_name = $request->first_name;
          $sale->last_name = $request->last_name;
          $sale->email = $request->email;
          $sale->mobile_number = $request->mobile_number;
          $sale->year_purchase = $request->year_purchase;
          $sale->expected_amount = $request->expected_amount;
          $sale->sell_type = 2;
          $sale->additional_info = $request->additional_info;
          $sale->save();

  
        // Store files if uploaded
        if ($request->hasFile('form_file')) {
            $filePaths = []; // Array to store file paths
            $directoryPath = 'uploads/jewellery/' . $sale->id; // Create a directory with the last store ID
             // Create the directory if it doesn't exist
            if (!Storage::disk('public')->exists($directoryPath)) {
                Storage::disk('public')->makeDirectory($directoryPath);
            }
            foreach ($request->file('form_file') as $file) {
                // Store each file in the new directory
                $path = $file->store($directoryPath, 'public'); // Store the file
                $filePaths[] = $path; // Add path to the array
            }
            $sale->form_file = json_encode($filePaths); // Store paths as a JSON string
        }
  
          // Save the data
          $sale->save();


        // Email to user
        $userTo = $sale->email;
        $userSubject = 'Thank you for your Jewellery sale inquiry!';
        $userContent = view('emails.user_jewellery_sale_confirmation', [
            'first_name' => $sale->first_name,
            'email' => $sale->email,
            'year_purchase' => $sale->year_purchase,
            'expected_amount' => $sale->expected_amount,
            'additional_info' => $sale->additional_info,
        ])->render();

        sendMailCommon($userTo, $userSubject, $userContent);

        // Email to admin
        // $adminTo = 'admin@example.com'; // Replace with actual admin email
        // $adminTo = 'devanand.sinha90@gmail.com'; // Replace with actual admin email
        $adminTo= getAdminEmail();
        $adminSubject = 'New Jewellery Sale Inquiry';
        $adminContent = view('emails.admin_jewellery_sale_notification', [
            'first_name' => $sale->first_name,
            'last_name' => $sale->last_name,
            'email' => $sale->email,
            'mobile_number' => $sale->mobile_number,
            'year_purchase' => $sale->year_purchase,
            'expected_amount' => $sale->expected_amount,
            'additional_info' => $sale->additional_info,
        ])->render();

        sendMailCommon($adminTo, $adminSubject, $adminContent);
  

        // Return success response
        return response()->json(['success' => true, 'message' => 'Data saved successfully!']);            
    }
    


    //    /**
    //  * Show the application Sell Watch Data Store
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function contactusformsubmit(Request $request)
    {
          // Store the form data in the database
          $contactus = new PreownedContact();
          $contactus->full_name = $request->name;
          $contactus->email = $request->email;
          $contactus->phone = $request->phone;
          $contactus->message = $request->message;
          $contactus->save();

        // 1. Send email to the user
        $userTo = $request->email;
        $userSubject = 'Thank you for contacting us!';
        $userContent = view('emails.user_contact_confirmation', [
            'user_name' => $request->name,
            'message' => $request->message,
        ])->render();

        sendMailCommon($userTo, $userSubject, $userContent);

        // 2. Send email to the admin
        // $adminTo = 'devanand.sinha90@gmail.com'; // Replace with actual admin email
        $adminTo= getAdminEmail();
        $adminSubject = 'New Contact Us Inquiry';
        $adminContent = view('emails.admin_contact_notification', [
            'user_name' => $request->name,
            'user_email' => $request->email,
            'message' => $request->message,
        ])->render();

        sendMailCommon($adminTo, $adminSubject, $adminContent);

         /* // Store file if uploaded
          if ($request->hasFile('form_file')) {
              $path = $request->file('form_file')->store('uploads', 'public');
              $sale->form_file = $path;
          }*/

        //   <img src="{{ asset('storage/' . $imagePath) }}" alt="Uploaded Image" class="img-thumbnail" style="max-width: 150px; margin: 5px;">
        // http://your-domain/storage/uploads/u3lRhbrGzzoyVmU1iNy7I2HWZQzcK4SXyRLOf9vu.png
        // http://127.0.0.1:8000/storage/uploads/u3lRhbrGzzoyVmU1iNy7I2HWZQzcK4SXyRLOf9vu.png

        //   ["uploads\/u3lRhbrGzzoyVmU1iNy7I2HWZQzcK4SXyRLOf9vu.png","uploads\/GsmrKA66DaFkmFG7JwbsknFpGXH8MOs8VJnycYbI.jpg"]

        // Store files if uploaded
        
  

        // Return success response
        return response()->json(['success' => true, 'message' => 'Data saved successfully!']);            
    }


     //    /**
    //  * Show the application Sell Watch Data Store
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function storeEmailNewsletter(Request $request)
    {

        // Check if the email already exists in the database
        $existingEmail = PreownedNewsletter::where('email', $request->email)->first();

        if ($existingEmail) {
            // Return error response if email already exists
            return response()->json(['success' => 'alreadyAdded', 'message' => 'You are already registered in the system.']);
        }
        
        // Store the form data in the database
        $newsletter = new PreownedNewsletter();
        $newsletter->email = $request->email;
        $newsletter->save();

        
        $to = $request->email;
        $subject = 'Welcome to SJL Trusted Jewels Newsletter!';
        $content = view('emails.user_newsletter_email', [
            'user_name' => $request->email, // Optional, for personalizing the email
        ])->render();
        
        // Send email using sendMailCommon helper
        sendMailCommon($to, $subject, $content);


        // Define the admin email
        // $adminEmail = 'devanand.sinha90@gmail.com'; // Replace with actual admin email
        $adminEmail= getAdminEmail();
        // Define the subject for the admin email
        $adminSubject = 'New Newsletter Subscription Notification';
        // Render the email content for the admin using the Blade view
        $adminContent = view('emails.admin_newsletter_notification_email', [
            'user_email' => $request->email,
        ])->render();
        // Send email to the admin
        sendMailCommon($adminEmail, $adminSubject, $adminContent);

        // Return success response
        return response()->json(['success' => true, 'message' => 'Thank you for joining!']);            
    }



    public function productsSearch(Request $request)
    {
        // ORDER BY id ASC LIMIT 1
        $searchQuery  = $request->get('query');
        $products = DB::table('product')->leftJoin(DB::raw('(SELECT product_id, image_name, image_wasabi_status FROM product_front_images 
                        WHERE is_image_video = "0" and sorting = "1"  ) as pi'), 'product.id', '=', 'pi.product_id')
                        ->where(function ($query) use ($searchQuery) {
                           $query->where('sku', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('front_title', 'LIKE', '%' . $searchQuery . '%')
                                ->orWhere('front_description', 'LIKE', '%' . $searchQuery . '%');
                        })
                        ->whereIn('status', ['soldout', 'active'])
                        ->where('is_front_sow', '1')
                        ->where('retail_price','!=', 0)
                        ->where('retail_price','!=', '0')
                        ->where('delete_at','0')
                        // ->select('id', 'front_title')
                        ->select('product.id', 'product.front_title','pi.image_wasabi_status', 'pi.image_name as product_image','product.sku','product.front_slug','product.status')
                        ->orderByRaw("CASE 
                                WHEN status = 'active' THEN 1 
                                WHEN status = 'soldout' THEN 2 
                            END, sku ASC, front_title ASC, front_description DESC")
                        ->limit(5)
                        ->get();
        if ($products->isEmpty()) {
            return response()->json(['message' => 'No products found'], 404);
        }

        return response()->json($products);
    }
    
    
       //    /**
    //  * Show the application Sell Watch Data Store
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function updateishowitemsfront(Request $request)
    {

       DB::table('product')->where('id', $request->id)
    ->update([
        'is_front_sow' => $request->is_front_show,
    ]);

    }

    public function deleteFrontImages(Request $request)
    {
        

       $id =$request->id ;
       $pid = $request->pid ;

       $bool = ProductFrontImages::where('product_id', $pid)
                  ->where('id', $id)
                  ->delete();
       if($bool){
            echo json_encode(['message' => 'success']);
            die;
        }else{
            echo json_encode(['message' => 'false']);
                    die;
        }

    }
    
    public function frontUploadvideoImage(Request $request, $customPath = null)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $tempFile = $file->getPathname();
            $uploadError = $file->getError();
            $pid = $request->id;
            $sorting = $request->sorting;

            // Generate a unique image name using current time and PID
            $imageName = $pid . '_' . $sorting . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Define upload directory (using a custom path if provided)
            $uploadDir = $customPath ?? '/var/www/html/crm.webuydiamond.co.uk/upload/product/' . $pid;

            // Store the file

              $uploadFile = $uploadDir . '/' . $imageName;
            // Store the file in the public disk
            if (move_uploaded_file($tempFile, $uploadFile)) {
                // Insert record into the database using Eloquent
                $imageRecord = ProductFrontImages::create([
                    'product_id' => $pid,
                    'image_name' => $imageName,
                    'sorting' => '0',
                    'is_image_video' => '1',
                ]);
                $url = 'https://crm.webuydiamond.co.uk/'.'upload/product/' . $pid.'/'.$imageName;
                $response = [
                    'success' => true,
                    'fileUrl' => $url, // Generate public URL
                    'lastId' => $imageRecord->id,
                ];
            } else {
                $response = ['success' => false];
            }
        } else {
            $response = ['success' => false];
        }

        return response()->json($response);
    }

    public function frontUploadImage(Request $request,$customPath = null)
    {
        // Check for valid file
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $tempFile = $file->getPathname();
            $uploadError = $file->getError();
            $pid = $request->input('id');
            $sorting = $request->input('sorting', 0);  // Default to 0 if not provided

            // Generate a unique image name using current time and PID
            $imageName = $pid . '_' . $sorting . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Define the upload directory within the storage path
            $uploadDir = $customPath ?? '/var/www/html/crm.webuydiamond.co.uk/upload/product/' . $pid;
            //$uploadDir = 'upload/product/' . $pid;

            // Create the directory if it doesn't exist


            if (!file_exists($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true) && !is_dir($uploadDir)) {
                    
                }
            }

            $uploadFile = $uploadDir . '/' . $imageName;
            // Store the file in the public disk
            if (move_uploaded_file($tempFile, $uploadFile)) {
                // Insert record into the database using Eloquent
                $imageRecord = ProductFrontImages::create([
                    'product_id' => $pid,
                    'image_name' => $imageName,
                    'sorting' => $sorting,
                    'is_image_video' => '0',
                ]);
                $url = 'https://crm.webuydiamond.co.uk/'.'upload/product/' . $pid.'/'.$imageName;
                // Prepare response data
                $response = [
                    'success' => true,
                    'fileUrl' => $url,
                    'lastId' => $imageRecord->id,
                ];
            } else {
                $response = ['success' => false];
            }
        } else {
            $response = ['success' => false];
        }

        return response()->json($response);
    }   

    public function updateOrderFront(Request $request)
    {
        if ($request->has('order')) {
            $order = $request->input('order');

            foreach ($order as $position => $id) {
                ProductFrontImages::where('id', $id)->update(['sorting' => $position]);
            }

            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'No order data provided'], 400);
    }
}
