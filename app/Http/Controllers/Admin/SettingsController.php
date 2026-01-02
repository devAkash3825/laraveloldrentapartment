<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderManage;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Models\Counter;
use App\Models\SectionTitle;
use File;
use Efectn\Menu\Models\Menus;
use App\Models\FooterInfos;
use App\Models\ContactUsCMS;
use App\Models\PropertyInfo;
use App\Models\Login;
use App\Models\Setting;
use App\Models\ContactUs;
use App\Models\ManagerTermsCMS;
use App\Models\AboutUsCMS;
use App\Models\EqualHousingCMS;
use App\Models\termsCMS;


use App\Models\OurFeatures;

class SettingsController extends Controller
{

    public function sectionManagement()
    {
        $ourFeatures = OurFeatures::all();
        $counter = Counter::first();
        $title = SectionTitle::first();
        $totalproperty = PropertyInfo::count();
        $activeProperty = PropertyInfo::where('Status', 1)->count();
        $inactiveProperty = PropertyInfo::where('Status', '!=', 1)->count();
        $totalUser = Login::count();

        return view('admin.settings.sectionManagement', [
            'ourFeatures' => $ourFeatures,
            'counter' => $counter,
            'title' => $title,
            'totalUser' => $totalUser,
            'inactiveProperty' => $inactiveProperty,
            'activeProperty' => $activeProperty,
            'totalproperty' => $totalproperty
        ]);
    }

    public function editOurFeatures($id)
    {
        $feature = OurFeatures::where('id', $id)->first();
        return view('admin.settings.editOurFeaturesPage', [
            'feature' => $feature
        ]);
    }

    public function updateFeatures(Request $request)
    {
        $featureId = $request->feature_id;
        if ($request->icon != '') {
            $update = OurFeatures::where('id', $featureId)->update([
                'icon' => $request->icon,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'status' => $request->status,
            ]);
        } else {
            $update = OurFeatures::where('id', $featureId)->update([
                'icon' => $request->icons,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'status' => $request->status,
            ]);
        }
        if ($update) {
            return response()->json([
                'success' => "Feature Updated",
            ]);
        } else {
            return response()->json([
                'error' => "Feature Not Updated",
            ]);
        }
    }

    public function addFeatures(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'our_feature_title' => 'required',
            'our_feature_sub_title' => 'required',
            'status' => 'required'
        ]);

        $create = OurFeatures::create([
            'icon' => $request->icon,
            'title' => $request->our_feature_title,
            'short_description' => $request->our_feature_sub_title,
            'status' => $request->status,
        ]);
        if ($create) {
            return response()->json([
                'success' => "Feature Updated",
            ]);
        } else {
            return response()->json([
                'error' => "Feature Not Updated",
            ]);
        }
    }

    public function deleteFeature($id)
    {
        try {
            $feature = OurFeatures::findOrFail($id);
            $feature->delete();

            return response()->json(['success' => true, 'message' => 'Feature deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete feature.']);
        }
    }

    public function updateCounter(Request $request)
    {

        $request->validate([
            'counter_one' => 'required',
            'counter_title_one' => 'required',
            'counter_two' => 'required',
            'counter_title_two' => 'required',
            'counter_three' => 'required',
            'counter_title_three' => 'required',
            'counter_four' => 'required',
            'counter_title_four' => 'required',
        ]);
        try {
            $image = $request->background;
            $imagePath = $this->uploadImage($request, 'background', $request->old_background);

            $counterUpdate = Counter::updateOrCreate(
                ['id' => 1],
                [
                    'background' => !empty($imagePath) ? $imagePath : $request->old_background,
                    'counter_one' => $request->counter_one,
                    'counter_title_one' => $request->counter_title_one,
                    'counter_two' => $request->counter_two,
                    'counter_title_two' => $request->counter_title_two,
                    'counter_three' => $request->counter_three,
                    'counter_title_three' => $request->counter_title_three,
                    'counter_four' => $request->counter_four,
                    'counter_title_four' => $request->counter_title_four
                ]
            );
            return response()->json([
                'success' => true,
                'message' => 'Feature deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete feature.'
            ]);
        }
    }

    public function updateTitle(Request $request)
    {
        $request->validate([
            'our_feature_title' => 'required',
            'our_feature_sub_title' => 'required',
            'our_categories_title' => 'required',
            'our_categories_sub_title' => 'required',
            'our_location_title' => 'required',
            'our_location_sub_title' => 'required',
            'our_featured_listing_title' => 'required',
            'our_featured_listing_sub_title' => 'required',
            'our_our_pricing_title' => 'required',
            'our_our_pricing_sub_title' => 'required',
            'our_testimonial_title' => 'required',
            'our_testimonial_sub_title' => 'required',
            'our_blog_title' => 'required',
            'our_blog_sub_title' => 'required'
        ]);
        try {
            $update = SectionTitle::updateOrCreate(
                ['id' => 1],
                [
                    'our_feature_title' => $request->our_feature_title,
                    'our_feature_sub_title' => $request->our_feature_sub_title,
                    'our_categories_title' => $request->our_categories_title,
                    'our_categories_sub_title' => $request->our_categories_sub_title,
                    'our_location_title' => $request->our_location_title,
                    'our_location_sub_title' => $request->our_location_sub_title,
                    'our_featured_listing_title' => $request->our_featured_listing_title,
                    'our_featured_listing_sub_title' => $request->our_featured_listing_sub_title,
                    'our_our_pricing_title' => $request->our_our_pricing_title,
                    'our_our_pricing_sub_title' => $request->our_our_pricing_sub_title,
                    'our_testimonial_title' => $request->our_testimonial_title,
                    'our_testimonial_sub_title' => $request->our_testimonial_sub_title,
                    'our_blog_title' => $request->our_blog_title,
                    'our_blog_sub_title' => $request->our_blog_sub_title,
                ]
            );
            return response()->json([
                'success' => true,
                'message' => 'Updated Successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Not Updated'
            ]);
        }
    }

    public function sliderManagerPage()
    {
        $sliderImages = SliderManage::all();
        return view('admin.settings.sliderManagement', ['sliderImages' => $sliderImages]);
    }

    public function addSliderImage(Request $request)
    {
        return view('admin.settings.addSliderImage');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image')->store('Slider/slider_images', 's3');

        $imageUrl = Storage::disk('s3')->url($imagePath);

        SliderManage::create([
            'image_path' => $imageUrl,
            'alt_text' => $request->input('alt_text'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->back()->with('success', 'Slider image added successfully.');
    }

    public function changeStatus(Request $request, $id)
    {
        try {
            $sliderId = SliderManage::where('Id', $id)->update([
                'is_active' => $request->is_active,
            ]);
            return response()->json(['success' => 'Status Changed Successfully '], 200);
        } catch (Exception $e) {
            \Log::error('Error updating property additional details: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update Status'], 500);
        }
    }

    public function footerManagement()
    {
        $footerInfo = FooterInfos::first();
        return view('admin.settings.footerManagement', ['footerInfo' => $footerInfo]);
    }

    public function uploadImage(Request $request, string $inputName, ?string $oldPath = null, string $path = 'site_images/'): ?string
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            $image->move(public_path($path), $imageName);

            $exculudedFolder = '/default';

            if ($oldPath && File::exists(public_path($oldPath)) && strpos($oldPath, $exculudedFolder) !== 0) {
                File::delete(public_path($oldPath));
            }

            return $path . '/' . $imageName;
        }
        return null;
    }

    public function manuManagement()
    {
        $menu = Menus::all();
        return view('admin.settings.menuManagement');
    }

    public function generalSettings()
    {
        return view('admin.settings.generalSettings');
    }

    public function pagesManagement()
    {
        $contact = ContactUs::first();
        $managerterms = ManagerTermsCMS::where('status', 1)->get();
        $aboutus = AboutUsCMS::where('status', 1)->first();
        $equalhousing = EqualHousingCMS::where('status', 1)->get();
        $terms = termsCMS::where('status', 1)->get();

        return view('admin.settings.pagesManagement', [
            'contact' => $contact,
            'managerterms' => $managerterms,
            'aboutus' => $aboutus,
            'equalhousing' => $equalhousing,
            'terms' => $terms
        ]);
    }

    public function updateManagerTerms(Request $request)
    {
        $update = ManagerTermsCMS::where('id', $request->index + 1)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Manager terms Update Successfully'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Manager terms Not Update'
            ]);
        }
    }

    public function updateTerms(Request $request)
    {
        $update = termsCMS::where('id', $request->index + 1)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Terma & Conditions Update Successfully'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Terms & Conditions Not Update'
            ]);
        }
    }

    public function updateEqualHousing(Request $request)
    {
        $update = EqualHousingCMS::where('id', $request->index + 1)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Equal Housing Update Successfully'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Equal Housing Not Update'
            ]);
        }
    }

    public function contactUsUpdate(Request $request)
    {
        ContactUsCMS::updateOrCreate(
            ['id' => 1],
            [
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'map_link' => $request->map_link
            ]
        );

        return redirect()->back();
    }

    public function updateSectionTitle(Request $request)
    {
        $sectionId = SectionTitle::first();
        $title = SectionTitle::where('id', $sectionId->id)->update([
            'our_feature_title' => $request->our_feature_title,
            'our_feature_sub_title' => $request->our_feature_sub_title,
            'our_featured_listing_title' => $request->our_featured_listing_title,
            'our_featured_listing_sub_title' => $request->our_featured_listing_sub_title,
        ]);
        if ($title) {
            return response()->json(['message' => 'Section Updated Successfully']);
        } else {
            return response()->json(['error' => 'Not Updated Please Try Again Later']);
        }
    }

    public function updateAppearence(Request $request)
    {
        $sitecolor = Setting::where('key', 'site_default_color')->update([
            'value' => $request->site_default_color,
        ]);
        $btnColor = Setting::where('key', 'site_btn_color')->update([
            'value' => $request->site_btn_color,
        ]);
        if ($sitecolor && $btnColor) {
            return response()->json(['message' => 'Site Color Updated Successfully']);
        } else {
            return response()->json(['error' => 'Not Updated Please Try Again Later']);
        }
    }

    public function updateSiteName(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => ['required', 'max:255'],
            'site_email' => ['required', 'max:255', 'email'],
            'site_phone' => ['required', 'max:255'],
            'site_timezone' => ['required', 'max:255'],
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return response()->json([
            'message' => "Updated Successfully",
        ]);
    }

    public function updateLogo(Request $request)
    {
        dd($request->all());
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            // Save $logoPath in DB
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            // Save $faviconPath in DB
        }

        return response()->json(['message' => 'Logo and Favicon updated successfully']);
    }


    public function updateContactUsCMS(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'map_link' => 'required|string',
        ]);

        $contact = ContactUs::first();
        $contact->updateOrCreate(
            ['id' => $contact?->id],
            [
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'map_link' => $request->map_link,
            ]
        );

        return response()->json(['message' => 'Contact information updated successfully!']);
    }

    public function updateAboutUs(Request $request)
    {
        if ($request->hasFile('background') && $request->file('background')->isValid()) {
            // Retrieve the file
            $file = $request->file('background');
            $fileExtension = $file->getClientOriginalExtension();

            // Ensure the file extension is not empty
            if (empty($fileExtension)) {
                return response()->json(['error' => 'Invalid file extension'], 400);
            }

            // Create a unique filename for the uploaded image
            $savedImageName = 'aboutimage_' . time() . '.' . $fileExtension;

            // Upload the image to S3
            try {
                $imagePath = $file->storeAs('CMS/Images', $savedImageName, 's3');

                if (empty($imagePath)) {
                    return response()->json(['error' => 'Failed to upload image to S3'], 400);
                }

                $imageUrl = Storage::disk('s3')->url($imagePath);
            } catch (\Exception $e) {
                // Log the exception message to help diagnose the issue
                \Log::error('S3 Upload Error: ' . $e->getMessage());

                return response()->json([
                    'error' => 'Error uploading image to S3: ' . $e->getMessage()
                ], 500);
            }

            // Handle the AboutUsCMS record
            $aboutUs = AboutUsCMS::first();
            if (!$aboutUs) {
                $aboutUs = new AboutUsCMS();
            }

            // Save data
            $aboutUs->title = $request->input('title');
            $aboutUs->heading = $request->input('heading');
            $aboutUs->description = $request->input('aboutdescription');
            $aboutUs->image = $imageUrl;
            $aboutUs->save();

            return response()->json([
                'message' => 'About Us section updated successfully!',
                'data' => $aboutUs
            ]);
        } else {
            return response()->json(['error' => 'Invalid or no file uploaded'], 400);
        }
    }

    public function addHousing()
    {
        return view('admin.settings.addEqualHousing');
    }

    public function createHousing(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        EqualHousingCMS::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Housing information added successfully.'
        ]);
    }

    public function addTerms(Request $request)
    {
        return view('admin.settings.addTermsCMS');
    }

    public function createTerms(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        termsCMS::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Terms & Conditions added successfully.'
        ]);
    }

    public function addManagerTerms(Request $request)
    {
        return view('admin.settings.addManagerTermsCMS');
    }

    public function createManagerterms(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        ManagerTermsCMS::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Terms & Conditions added successfully.'
        ]);
    }
}
