<?php

namespace App\Http\Controllers\Admin;
use App\Services\SettingsService;

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
                    'background' => $imagePath,
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
                'message' => 'Counter updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update counter.'
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
            $slider = SliderManage::findOrFail($id);
            $slider->update([
                'is_active' => $request->is_active,
            ]);
            return response()->json(['success' => true, 'message' => 'Status Changed Successfully'], 200);
        } catch (Exception $e) {
            \Log::error('Error updating slider status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update Status'], 500);
        }
    }

    public function editSliderImage($id)
    {
        $sliderImage = SliderManage::findOrFail($id);
        return view('admin.settings.editSliderImage', compact('sliderImage'));
    }

    public function updateSliderImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        try {
            $slider = SliderManage::findOrFail($id);
            
            if ($request->hasFile('image')) {
                // Delete old image if it exists on S3
                if ($slider->image_path) {
                    $oldPath = parse_url($slider->image_path, PHP_URL_PATH);
                    // Remove leading slash for S3 delete
                    $oldPath = ltrim($oldPath, '/');
                    // Only try to delete if it's an S3 link (heuristic)
                    if (strpos($slider->image_path, 'amazonaws.com') !== false) {
                        Storage::disk('s3')->delete($oldPath);
                    }
                }

                $imagePath = $request->file('image')->store('Slider/slider_images', 's3');
                $slider->image_path = Storage::disk('s3')->url($imagePath);
            }

            $slider->alt_text = $request->alt_text;
            $slider->is_active = $request->is_active;
            $slider->save();

            return redirect()->route('admin-slider-management')->with('success', 'Slider image updated successfully.');
        } catch (Exception $e) {
            \Log::error('Error updating slider: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update slider image.');
        }
    }

    public function deleteSliderImage($id)
    {
        try {
            $slider = SliderManage::findOrFail($id);
            
            // Delete image from S3
            if ($slider->image_path) {
                $oldPath = parse_url($slider->image_path, PHP_URL_PATH);
                $oldPath = ltrim($oldPath, '/');
                if (strpos($slider->image_path, 'amazonaws.com') !== false) {
                    Storage::disk('s3')->delete($oldPath);
                }
            }

            $slider->delete();

            return response()->json(['success' => true, 'message' => 'Slider image deleted successfully.']);
        } catch (Exception $e) {
            \Log::error('Error deleting slider: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete slider image.']);
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
        $managerterms = ManagerTermsCMS::where('status', 1)->get();
        $equalhousing = EqualHousingCMS::where('status', 1)->get();
        $terms = termsCMS::where('status', 1)->get();
        $privacypromise = \App\Models\PrivacyPromiseCMS::all();

        return view('admin.settings.pagesManagement', [
            'managerterms' => $managerterms,
            'equalhousing' => $equalhousing,
            'terms' => $terms,
            'privacypromise' => $privacypromise
        ]);
    }

    public function updateManagerTerms(Request $request)
    {
        $update = ManagerTermsCMS::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            (new SettingsService())->clearCachedSettings();
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
        $update = termsCMS::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            (new SettingsService())->clearCachedSettings();
            return response()->json([
                'success' => true,
                'message' => 'Terms & Conditions Update Successfully'
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
        $update = EqualHousingCMS::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            (new SettingsService())->clearCachedSettings();
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
        try {
            SectionTitle::updateOrCreate(
                ['id' => 1],
                [
                    'our_feature_title' => $request->our_feature_title,
                    'our_feature_sub_title' => $request->our_feature_sub_title,
                    'our_featured_listing_title' => $request->our_featured_listing_title,
                    'our_featured_listing_sub_title' => $request->our_featured_listing_sub_title,
                ]
            );
            return response()->json(['message' => 'Section Updated Successfully']);
        } catch (\Exception $e) {
            \Log::error('Update Section Title Error: ' . $e->getMessage());
            return response()->json(['error' => 'Not Updated Please Try Again Later'], 500);
        }
    }

    public function updateAppearence(Request $request)
    {
        try {
            Setting::updateOrCreate(['key' => 'site_default_color'], ['value' => $request->site_default_color]);
            Setting::updateOrCreate(['key' => 'site_btn_color'], ['value' => $request->site_btn_color]);
            Setting::updateOrCreate(['key' => 'site_gradient_color'], ['value' => $request->site_gradient_color]);

            (new SettingsService())->clearCachedSettings();
            return response()->json(['message' => 'Site Colors and Appearance Updated Successfully']);
        } catch (\Exception $e) {
            \Log::error('Update Appearance Error: ' . $e->getMessage());
            return response()->json(['error' => 'Not Updated Please Try Again Later'], 500);
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
        (new SettingsService())->clearCachedSettings();
        return response()->json([
            'message' => "Updated Successfully",
        ]);
    }

    public function updateLogo(Request $request)
    {
        if ($request->hasFile('logo')) {
            $logoPath = $this->uploadImage($request, 'logo', Setting::where('key', 'logo')->value('value'));
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $logoPath]);
        }

        if ($request->hasFile('favicon')) {
            $faviconPath = $this->uploadImage($request, 'favicon', Setting::where('key', 'favicon')->value('value'));
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $faviconPath]);
        }
        
        (new SettingsService())->clearCachedSettings();

        return response()->json(['message' => 'Logo and Favicon updated successfully']);
    }

    public function updateMailSettings(Request $request)
    {
        $validatedData = $request->validate([
            'mail_driver' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|string',
            'mail_username' => 'required|string',
            'mail_password' => 'required|string',
            'mail_encryption' => 'required|string',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        (new SettingsService())->clearCachedSettings();

        return response()->json(['message' => 'Mail Settings Updated Successfully']);
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
        $aboutUs = AboutUsCMS::first();
        if (!$aboutUs) {
            $aboutUs = new AboutUsCMS();
        }

        if ($request->hasFile('background') && $request->file('background')->isValid()) {
            $file = $request->file('background');
            $fileExtension = $file->getClientOriginalExtension();

            if (empty($fileExtension)) {
                return response()->json(['error' => 'Invalid file extension'], 400);
            }

            $savedImageName = 'aboutimage_' . time() . '.' . $fileExtension;

            try {
                $imagePath = $file->storeAs('CMS/Images', $savedImageName, 's3');

                if (empty($imagePath)) {
                    return response()->json(['error' => 'Failed to upload image to S3'], 400);
                }

                $imageUrl = Storage::disk('s3')->url($imagePath);
                $aboutUs->image = $imageUrl;
            } catch (\Exception $e) {
                \Log::error('S3 Upload Error: ' . $e->getMessage());
                return response()->json([
                    'error' => 'Error uploading image to S3: ' . $e->getMessage()
                ], 500);
            }
        }

        // Save data
        $aboutUs->title = $request->input('title');
        $aboutUs->heading = $request->input('heading');
        $aboutUs->description = $request->input('aboutdescription');
        $aboutUs->save();

        return response()->json([
            'message' => 'About Us section updated successfully!',
            'data' => $aboutUs
        ]);
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
        (new SettingsService())->clearCachedSettings();
        return response()->json([
            'success' => true,
            'message' => 'Terms & Conditions added successfully.'
        ]);
    }

    public function deleteManagerTerms($id)
    {
        $delete = ManagerTermsCMS::findOrFail($id)->delete();
        if ($delete) {
            (new SettingsService())->clearCachedSettings();
            return response()->json(['success' => true, 'message' => 'Manager terms deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to delete manager terms']);
    }

    public function deleteTerms($id)
    {
        $delete = termsCMS::findOrFail($id)->delete();
        if ($delete) {
            (new SettingsService())->clearCachedSettings();
            return response()->json(['success' => true, 'message' => 'Terms deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to delete terms']);
    }

    public function deleteEqualHousing($id)
    {
        $delete = EqualHousingCMS::findOrFail($id)->delete();
        if ($delete) {
            (new SettingsService())->clearCachedSettings();
            return response()->json(['success' => true, 'message' => 'Equal housing deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to delete equal housing']);
    }

    // Privacy Promise Methods
    public function addPrivacyPromise(Request $request)
    {
        return view('admin.settings.addPrivacyPromiseCMS');
    }

    public function createPrivacyPromise(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        \App\Models\PrivacyPromiseCMS::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        (new SettingsService())->clearCachedSettings();
        return response()->json([
            'success' => true,
            'message' => 'Privacy Promise added successfully.'
        ]);
    }

    public function updatePrivacyPromise(Request $request)
    {
        $update = \App\Models\PrivacyPromiseCMS::where('id', $request->id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        if ($update) {
            (new SettingsService())->clearCachedSettings();
            return response()->json([
                'success' => true,
                'message' => 'Privacy Promise Update Successfully'
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Privacy Promise Not Update'
            ]);
        }
    }

    public function deletePrivacyPromise($id)
    {
        $delete = \App\Models\PrivacyPromiseCMS::findOrFail($id)->delete();
        if ($delete) {
            (new SettingsService())->clearCachedSettings();
            return response()->json(['success' => true, 'message' => 'Privacy Promise deleted successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Failed to delete Privacy Promise']);
    }
}
