<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Controllers\Controller;

use App\Services\SearchService;

use App\Http\Resources\PropertyCollection;
use App\Http\Resources\ListingCollection;

use App\Repositories\PropertyDetailsRepository;
use App\Repositories\RenterInfoRepository;

use App\Models\PropertyInfo;
use App\Models\UserProperty;
use App\Models\Login;
use App\Models\Message;
use App\Models\AdminDetail;
use App\Models\Source;
use App\Models\RenterInfo;
use App\Models\ContactUs;
use App\Models\SliderManage;
use App\Models\Zone;
use App\Models\OurFeatures;
use App\Models\Counter;
use App\Models\SectionTitle;
use App\Models\ContactUsCMS;
use App\Models\ContactUsHanlding;
use App\Models\PropertyInquiry;
use App\Models\EqualHousingCMS;
use App\Models\termsCMS;
use App\Models\Notification;
use App\Models\NotifyDetail;






class HomeController extends Controller
{
    protected $searchService;
    protected $propertyDetailsRepository;
    protected $renterInfoRepository;

    public function __construct(SearchService $searchService, PropertyDetailsRepository $propertyDetailsRepository, RenterInfoRepository $renterInfoRepository)
    {
        $this->searchService = $searchService;
        $this->propertyDetailsRepository = $propertyDetailsRepository;
        $this->renterInfoRepository = $renterInfoRepository;
    }
    public function index()
    {
        try {
            $latestProperty = $this->propertyDetailsRepository->getLatestPropertiesforHome();
            $data = new ListingCollection($latestProperty ?? []);
            $propertyDetails = $data->toArray(request());

            // Get counts with fallback to 0
            $totalProperties = PropertyInfo::count();
            $totalAdmins = AdminDetail::count();
            $totalRenters = Login::where('user_type', 'C')->count();
            $totalManagers = Login::where('user_type', 'M')->count();

            $ourFeatures = OurFeatures::where('status', 1)->get();

            $featuredProperties = PropertyInfo::where('Featured', '1')
                ->where('Status', '1')
                ->with(['gallerytype.gallerydetail', 'city.state'])
                ->whereHas('gallerytype', function ($query) {
                    $query->whereNotNull('Id');
                })
                ->take(8)
                ->orderBy('Id', 'desc')
                ->get();

            $sliderImages = SliderManage::where('is_active', '1')->get();
            $zone = Zone::all();

            // Handle potential null values if tables are truncated
            $counter = Counter::first() ?? new Counter();
            $sectionTitle = SectionTitle::first() ?? new SectionTitle();

            return view('user.pages.home', [
                'propertyDetails' => $propertyDetails,
                'totalAdmins' => $totalAdmins,
                'totalProperties' => $totalProperties,
                'totalManagers' => $totalManagers,
                'totalRenters' => $totalRenters,
                'featuredProperties' => $featuredProperties,
                'sliderImages' => $sliderImages,
                'zones' => $zone,
                'ourFeatures' => $ourFeatures,
                'counter' => $counter,
                'sectionTitle' => $sectionTitle
            ]);
        } catch (\Exception $e) {
            Log::error('Home page error: ' . $e->getMessage());
            // Return basic view or error page if something goes critically wrong
            return view('user.pages.home', [
                'propertyDetails' => [],
                'totalAdmins' => 0,
                'totalProperties' => 0,
                'totalManagers' => 0,
                'totalRenters' => 0,
                'featuredProperties' => [],
                'sliderImages' => [],
                'zones' => [],
                'ourFeatures' => [],
                'counter' => new Counter(),
                'sectionTitle' => new SectionTitle()
            ]);
        }
    }

    public function dashboard()
    {
        $authuser = Auth::guard('renter')->user();
        if ($authuser->user_type == 'C') {
            $renterinfo = $this->renterInfoRepository->getRenterInfo();
            $source = Source::all();
            return view('user.dashboard', [
                'renterInfo' => $renterinfo,
                'source' => $source,
            ]);
        } else {
            $renterinfo = $this->renterInfoRepository->getManagerInfo();
            $source = Source::all();
            return view('user.dashboard', [
                'renterInfo' => $renterinfo,
                'source' => $source,
            ]);
        }

    }
    public function about()
    {
        return view('user.pages.about');
    }
    public function equalOpportunity()
    {
        $terms = EqualHousingCMS::where('status',1)->get();
        return view('user.pages.equalOpportunity',['terms' => $terms]);
    }

    public function customerFeedback()
    {
        return view('user.pages.customerFeedback');
    }

    public function searchProperty(Request $request)
    {
        $searchtext = $request->quicksearch;
        $properties = $this->searchService->searchProperty($searchtext);
        $searchedresponse = new PropertyCollection($properties);
        $transformeddata = $searchedresponse->toArray(request());
        return view('user.property.searchProperty', ['data' => $transformeddata]);
    }

    public function contactUs()
    {
        $contact = ContactUs::first();
        return view('user.pages.contactUs', ['contact' => $contact]);
    }

    public function submitContactUs(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validated) {
            ContactUsHanlding::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message,
                'subject' => $request->subject,
            ]);

            // Notify Admin about new contact inquiry
            Notification::create([
                'from_id' => 0, // Guest
                'form_user_type' => 'G',
                'to_id' => 1, // Super Admin
                'to_user_type' => 'A',
                'message' => "New Contact Us inquiry from <strong>{$request->name}</strong> subject: <strong>{$request->subject}</strong>",
                'seen' => 0,
                'CreatedOn' => now(),
            ]);

            return response()->json(['message' => 'Form Submitted Successfully']);
        } else {
            return response()->json(['error' => 'There is Some error Please Try Again']);
        }
    }

    public function privacyPromise()
    {
        $data = termsCMS::all();
        $pagetitle = "Terms & Condition";
        return view('user.pages.privacyPromise',['data' => $data, 'pagetitle' => $pagetitle]);
    }

    public function equalHousing()
    {
        return view('user.pages.equalOpportunity');
    }

    public function recentlyVisited(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $recentproperties = UserProperty::where('userId', $userid)
            ->whereRaw('DATEDIFF(now(), lastviewed) <= 110')
            ->orderBy('lastviewed', 'desc')
            ->limit(100)
            ->with('propertyinfo')
            ->get();

        $perPage = 5;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $currentPageItems = $recentproperties->slice($offset, $perPage);

        $paginatedRecords = new LengthAwarePaginator(
            $currentPageItems,
            $recentproperties->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('user.pages.recentlyVisited', compact('paginatedRecords'));
    }


    public function addToRecent(Request $request)
    {
        $userid = Auth::guard('renter')->user()->Id;
        $pid = $request->propertyId;

        $existingRecord = UserProperty::where('userId', $userid)->where('propertyId', $pid)->first();
        try {
            if ($existingRecord) {
                $existingRecord->lastviewed = now();
                $existingRecord->save();
                return response()->json(['success' => 'Last viewed time updated successfully.']);
            } else {
                UserProperty::create([
                    'userId' => $userid,
                    'propertyId' => $pid,
                    'lastviewed' => now(),
                ]);
                return response()->json(['success' => 'Property added to recent successfully.']);
            }
        } catch (Exception $e) {
            Log::error('Addtorecent error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while trying to log in. Please try again later.']);
        }
    }

    public function reportLease()
    {
        return view('user.pages.reportLease');
    }

    public function updateUser(Request $request)
    {
        try {
            $authUser = Auth::guard('renter')->user();
            $authUserId = $authUser->Id;
            $renterInfo = Login::findOrFail($authUserId);
            $filename = $renterInfo->profile_pic;

            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'about_me' => 'nullable|string',
                'managerprofile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'renterprofile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($authUser->user_type == 'M' && $request->hasFile('managerprofile_pic')) {
                $file = $request->file('managerprofile_pic');
                $filename = 'manager_' . $authUserId . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profile_pics'), $filename);
            }

            if ($authUser->user_type != 'M' && $request->hasFile('renterprofile_pic')) {
                $file = $request->file('renterprofile_pic');
                $filename = 'renter_' . $authUserId . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/profile_pics'), $filename);
            }

                $renterInfo->update([
                    'UserName' => $request->username,
                    'Email' => $request->email,
                    'profile_pic' => $filename,
                    'about_me' => $request->about_me,
                ]);

            Auth::guard('renter')->loginUsingId($authUserId);

            if ($authUser->user_type != 'M') {
                RenterInfo::where('Login_ID', $authUserId)->update([
                    'Firstname' => $request->firstname,
                    'Lastname' => $request->lastname,
                    'zipcode' => $request->zipcode,
                    'phone' => $request->cell,
                    'Evening_phone' => $request->other_phone,
                    'Cityid' => $request->editcity,
                    'Emove_date' => $request->earliest_move_date,
                    'Lmove_date' => $request->latest_move_date,
                    'bedroom' => $request->num_bedrooms,
                    'Area_move' => $request->moving_to,
                    'Hearabout' => $request->hear_about,
                    'Rent_start_range' => $request->rent_range_from,
                    'Rent_end_range' => $request->rent_range_to,
                ]);
            }

            return response()->json(['success' => 'User updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating the user: ' . $e->getMessage()], 500);
        }
    }

    public function referredRenter()
    {
        $authuserId = Auth::guard('renter')->user()->Id;
        
        // Use the new scope defined in NotifyDetail model
        $getRec = NotifyDetail::forManager($authuserId)
            ->with(['loginrenter.renterinfo', 'propertyinfo'])
            ->orderBy('send_time', 'desc')
            ->get();

        return view('user.referredRenter', ['rec' => $getRec]);
    }



    public function testFile()
    {
        return view('test.app');
    }

    public function managerTerms()
    {
        return view('user.pages.managerTerms');
    }

    public function requestQuote(Request $request)
    {
        $authuserId = Auth::guard('renter')->user()->Id;
        $validated = $request->validate([
            'propertyId' => 'required',
            'firstname' => 'required|email',
            'lastname' => 'required',
            'email' => 'required',
        ]);
        $username = $request->firstname . $request->lastname;
        if ($validated) {
            PropertyInquiry::create([
                'PropertyId' => $request->propertyId,
                'UserId' => $authuserId,
                'UserName' => $username,
                'Email' => $request->email,
                'MoveDate' => $request->movedate,
                'Message' => $request->comments,
            ]);

            // Notify Manager and Admin
            $property = PropertyInfo::where('Id', $request->propertyId)->first();
            $notifMsg = "New Property Inquiry from <strong>{$request->firstname} {$request->lastname}</strong> for <strong>" . ($property->PropertyName ?? 'Property') . "</strong>";
            
            // Notify Manager
            if ($property && $property->UserId) {
                Notification::create([
                    'from_id' => $authuserId,
                    'form_user_type' => 'R',
                    'to_id' => $property->UserId,
                    'to_user_type' => 'M',
                    'property_id' => $request->propertyId,
                    'message' => $notifMsg,
                    'seen' => 0,
                    'CreatedOn' => now(),
                ]);
            }

            // Notify Admin
            Notification::create([
                'from_id' => $authuserId,
                'form_user_type' => 'R',
                'to_id' => 1, // Super Admin
                'to_user_type' => 'A',
                'property_id' => $request->propertyId,
                'message' => $notifMsg,
                'seen' => 0,
                'CreatedOn' => now(),
            ]);

            return response()->json(['message' => 'Form Submitted Successfully']);
        } else {
            return response()->json(['error' => 'There is Some error Please Try Again']);
        }
    }

    public function advanceSearchPage(Request $request){
        $pagetitle = "Advance Search";
        return view('user.advanceSearch',[
            'pagetitle' => $pagetitle
        ]);
    }

    public function submitReportLease(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required', // Name on lease
            'email' => 'required|email',
            'movedate' => 'required|date',
            'rentamount' => 'required',
            'zipcode' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'assisted_by' => 'required',
        ]);

        try {
            $user = Auth::guard('renter')->user();
            $renterId = $user->Id;
            
            // In accordance with the system flow:
            // 1. The data is NOT immediately stored in the database.
            // 2. The "Request" effectively lives in the Admin's Email Inbox.

            // Create In-App Notification for Admin (to track that a request was sent)
            Notification::create([
                'from_id' => $renterId,
                'form_user_type' => 'R',
                'to_id' => 1, // Super Admin
                'to_user_type' => 'A',
                'property_id' => null,
                'message' => "Renter <strong>{$user->UserName}</strong> has submitted a Lease Report request.",
                'seen' => 0,
                'CreatedOn' => now(),
            ]);

            // Send Email to Admin (The primary "Request" storage)
            try {
                $settings = \App\Models\Setting::pluck('value', 'key');
                $adminEmail = $settings['site_email'] ?? 'admin@crmrent.com';
                \Illuminate\Support\Facades\Mail::to($adminEmail)->send(new \App\Mail\LeaseReportMail($request->all(), $user));
            } catch (\Exception $e) {
                Log::error('Lease Report Email Error: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to send email report. Please try again.']);
            }
            
            return response()->json(['success' => true, 'message' => 'Lease report submitted successfully! Our team will review it and update your records.']);

        } catch (\Exception $e) {
            Log::error('Lease Report Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.']);
        }
    }

}
